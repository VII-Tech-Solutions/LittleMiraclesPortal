<?php

namespace App;

use App\Constants\Attributes;
use App\Constants\EnvVariables;
use App\Constants\MediaType;
use App\Constants\Status;
use App\Models\Benefit;
use App\Models\Media;
use App\Models\Package;
use App\Models\PackageMedia;
use App\Models\Session;
use App\Models\SessionMedia;
use App\Models\StudioPackage;
use App\Models\StudioPackageMedia;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Google\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Sentry\State\Scope;
use Throwable;
use VIITech\Helpers\Constants\DebuggerLevels;
use VIITech\Helpers\GlobalHelpers;
use function Sentry\captureException;
use function Sentry\configureScope;

/**
 * Helpers
 */
class Helpers
{

    /**
     * Default Migration
     * @param Blueprint $table
     * @param int $default_status
     * @return void
     */
    static function defaultMigration(Blueprint $table, int $default_status = Status::ACTIVE){
        $table->bigIncrements(Attributes::ID);
        $table->integer(Attributes::STATUS)->default($default_status);
        $table->timestamps();
        $table->softDeletes();
    }

    /**
     * User Topic
     * @param $user_id
     * @return string
     */
    static function userTopic($user_id){
        return "user_" . str_replace("user_", "", $user_id);
    }

    /**
     * Generate Random Code
     * @param $length
     * @return string
     */
    static function generateCode($length = 9) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Formatted Price
     * @param $price
     * @param string $format
     * @return string
     */
    static function formattedPrice($price, $format = '%0.1f'){
        return sprintf($format, $price);
    }

    /**
     * Nullable Collection
     * @param $collection
     * @return Collection
     */
    static function nullableCollection($collection): Collection
    {
        if(is_null($collection)){
            return collect();
        }
        return $collection;
    }

    /**
     * Capture Exception
     * @param $exception
     */
    static function captureException($exception){
        if(GlobalHelpers::isDevelopmentEnv()){
            dd($exception);
        }
        $level = DebuggerLevels::INFO;
        if (!is_null($exception) && is_a($exception, Throwable::class)) {
            if (env(EnvVariables::SENTRY_ENABLED, false)) {
                $user_id = self::resolveUserID();
                if(!is_null($user_id)){
                    configureScope(function (Scope $scope) use($user_id): void {
                        $scope->setUser([Attributes::USER_ID => $user_id]);
                    });
                }
                captureException($exception);
            }
            $level = DebuggerLevels::ERROR;
        }
        GlobalHelpers::debugger($exception, $level);
    }

    /**
     * Get The Latest Only In Collection
     * @param $collection
     * @param $last_update
     * @return mixed
     */
    static function getLatestOnlyInCollection($collection, $last_update){
        return $collection->filter(function($item) use($last_update){
            if(is_null($last_update)){
                return is_null($item->deleted_at);
            }else{
                return Carbon::parse($item->updated_at)->greaterThanOrEqualTo($last_update);
            }
        });
    }

    /**
     * Return Response
     * @param $data
     * @return JsonResponse
     */
    static function returnResponse($data): JsonResponse
    {
        return response()->json([
            Attributes::DATA => $data,
        ]);
    }

    /**
     * Resolve User
     * @return User
     */
    static function resolveUser(){
        try {
            $user =  resolve(Attributes::USER);
            if(is_null($user)){
                $user = Auth::guard("api")->user();
            }
            if(is_null($user)){
                $user = Auth::guard("web")->user();
            }
            return $user;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Resolve User ID
     * @return string
     */
    static function resolveUserID(){
        try {
            $user_id = resolve(Attributes::USER_ID);
            if(is_null($user_id)){
                $user = self::resolveUser();
                if(!is_null($user)){
                    $user_id = $user->id;
                }
            }
            return $user_id;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Readable Text
     * @param $text
     * @return string
     */
    static function readableText($text){
        return ucwords(strtolower(str_replace("_", " ", $text)));
    }

    /**
     * Get New Family ID
     * @return int
     */
    static function getNewFamilyID(){
        /** @var User $user */
        $family_id = 1;
        $user = User::orderBy(Attributes::FAMILY_ID, "DESC")->take(1)->first();
        if(!is_null($user)){
            $family_id = $user->family_id + 1;
        }
        return $family_id;
    }

    /**
     * Validate Value in Collection
     * @param $collection
     * @param $new_collection
     * @param $field
     * @return void
     */
    public static function validateValueInCollection(&$collection, &$new_collection, $field){
        $value = $collection->get($field);
        if(!is_null($value)){
            $new_collection->put($field, $value);
        }
    }

    /**
     * Upload File
     * @param $static
     * @param $image
     * @param $attribute_name
     * @param $destination_path
     * @param bool $return_path
     * @param bool $add_to_media
     * @return string|null
     */
    public static function uploadFile($static, $image, $attribute_name, $destination_path, $return_path = true, $add_to_media = true, $generate_name = true, $session_id = null)
    {


        $disk = "public";

        // if a base64 was sent, store it in the db
        if (Str::startsWith($image, 'data:image') || is_a($image, UploadedFile::class) || is_a($image, \Intervention\Image\Image::class)) {

            $allowed_types = ["jpg", "jpeg", "png"];

            $extension = 'jpg';
            if (is_a($image, UploadedFile::class)) {
                $extension = $image->extension();
            } else if (is_a($image, \Intervention\Image\Image::class)) {
                $extension = $image->extension;
            }else if(Str::contains($image, "data:image/png;base64")){
                $extension = "png";
            }
            if (!in_array($extension, $allowed_types)) {
                return null;
            }

            // 0. Make the image
            // 1. Generate a filename.
            if (!is_a($image, \Intervention\Image\Image::class) && $generate_name) {
                $image = Image::make($image)->encode($extension, 90);
                $filename = $image->filename;
                if(empty($filename)){
                    $filename = Str::random();
                }
                $filename = $filename . ".$extension";
            } else {
                $filename = $image->getClientOriginalName();
                $image = Image::make($image)->encode($extension, 90);
            }

            // 2. Store the image on disk.
            $stored = Storage::disk($disk)->put($destination_path . '/' . $filename, $image->stream(), 'public');

            // 3. Delete the previous image, if there was one.
            if (!is_null($static) && !is_null($attribute_name)) {
                Storage::disk($disk)->delete($static->{$attribute_name});
            }

            // 4. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it
            // from the root folder; that way, what gets saved in the db
            // is the public URL (everything that comes after the domain name)
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);

            /** @var Media $media */
            if ($add_to_media) {
                $media = Media::findOrCreate($filename, MediaType::IMAGE, "$public_destination_path/$filename", $extension, $session_id);
            }

            if ($return_path) {
                return "$public_destination_path/$filename";
            }

            return $media;

        }

        if ($return_path) {
            return $image;
        }

        return Media::where(Attributes::URL, $image)->first();
    }

    /**
     * Readable Boolean
     * @param boolean $boolean
     * @return string
     */
    public static function readableBoolean($boolean)
    {
        if($boolean === true || $boolean === 1){
            return "Yes";
        } else{
            return "No";
        }
    }

    /**
     * Get Related benefits
     * @param $paginator
     * @param bool $pluck_id
     * @return Collection
     */
    static function getRelatedBenefits($paginator, $pluck_id = false)
    {
        if (is_a($paginator, LengthAwarePaginator::class)) {
            $benefits = collect($paginator->items())->map->benefits;
        } else if (is_a($paginator, Benefit::class)) {
            $benefits = $paginator->items->map->benefits();
        }else if(is_a($paginator, \Illuminate\Database\Eloquent\Collection::class) || is_a($paginator, Collection::class)){
            $benefits = $paginator->map->benefits;
        }
        if(!isset($benefits)){
            return collect();
        }
        $benefits = $benefits->flatten()->unique(Attributes::ID);
        if ($pluck_id) {
            return $benefits->pluck(Attributes::ID);
        }
        return $benefits;
    }

    /**
     * To Custom Array
     * @return array
     */
    static function toCustomArray($collection , $value_name){
        $collect = collect();
        foreach ($collection as $value){
            $collect[$value['id']] = $value[$value_name];
        }
        return $collect->toArray();
    }

    /**
     * Get Model
     * @param $type
     * @return string|null
     */
    static function getModel($type)
    {
        if ($type == 'studio-packages') {
            return StudioPackage::class;
        }else if ($type == 'packages') {
            return Package::class;
        }else  if ($type == 'sessions') {
            return Session::class;
        } else {
            return null;
        }
    }


    /**
     * Clear Cache
     * @param string $model
     */
    static public function clearCache($model)
    {
        try {
            Artisan::call("cache:clear");
            Artisan::call("view:clear");
            Artisan::call("modelCache:clear", ["model" => "\\" . addslashes($model)]);
        } catch (Exception $e) {
            GlobalHelpers::debugger($e, DebuggerLevels::ERROR);
        }
    }

    /**
     * Get Model Primary Column
     * @param $type
     * @return string|null
     */
    static function getModelPrimaryColumn($type)
    {
        if ($type == 'studio-packages') {
            return Attributes::STUDIO_PACKAGE_ID;
        }else  if ($type == 'packages') {
            return Attributes::PACKAGE_ID;
        }else  if ($type == 'sessions') {
            return Attributes::SESSION_ID;
        } else {
            return null;
        }
    }

    /**
     * Get Model Relationship
     * @param $type
     * @return string|null
     */
    static function getModelRelationship($type)
    {
        if ($type == 'studio-packages') {
            return StudioPackageMedia::class;
        }else  if ($type == 'packages') {
            return  PackageMedia::class;
        } else  if ($type == 'sessions') {
            return  SessionMedia::class;
        } else {
            return null;
        }
    }

    /**
     * Get Model Primary Column
     * @param $name
     * @return string|null
     */
    static function getModelByEntityName($name)
    {
        if ($name == 'Session') {
            return Session::class;
        } else {
            return null;
        }
    }


}
