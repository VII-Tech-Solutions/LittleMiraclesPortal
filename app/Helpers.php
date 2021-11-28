<?php

namespace App;

use App\Constants\Attributes;
use App\Constants\EnvVariables;
use App\Models\Media;
use App\Models\User;
use Exception;
use Illuminate\Http\UploadedFile;
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

class Helpers
{

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

    static function readableText($text){
        return ucwords(strtolower(str_replace("_", " ", $text)));
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
    public static function uploadFile($static, $image, $attribute_name, $destination_path, $return_path = true, $add_to_media = true, $generate_name = true)
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
                $media = Media::findOrCreate($filename, MediaType::IMAGE, "$public_destination_path/$filename", $extension);
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

}
