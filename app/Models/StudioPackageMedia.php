<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Class Studio Package Media
 * @package App\Models
 *
 * @property integer studio_package_id
 * @property integer media_id
 * @property string status
 * @property integer order
 */
class StudioPackageMedia extends CustomModel
{

    use ImageTrait;

    protected $table = Tables::STUDIO_PACKAGE_MEDIA;
    protected $guarded = [
        Attributes::ID
    ];
    protected $fillable = [
        Attributes::STUDIO_PACKAGE_ID,
        Attributes::MEDIA_ID,
        Attributes::STATUS,
        Attributes::ORDER,
    ];


    /**
     * Relationship: Media
     * @return BelongsTo
     */
    function media(){
        return $this->belongsTo(Media::class, Attributes::MEDIA_ID);
    }


    /**
     * Create or Update
     * @param array $data
     * @param array|null $find_by
     * @return static|null
     */
    public static function createOrUpdate(array $data, $find_by = null)
    {
//        dd($data);
        $data = array_map('intval', $data);
        $studio_package_media = static::where(Attributes::STUDIO_PACKAGE_ID, $data[Attributes::STUDIO_PACKAGE_ID])
            ->where(Attributes::MEDIA_ID, $data[Attributes::MEDIA_ID])->first();
        if (is_null($studio_package_media)) {
            $studio_package_media = new static();
        }
        if(!array_key_exists(Attributes::ORDER, $data)) {
            $data[Attributes::ORDER] = 1;
        }
        $studio_package_media->fill($data);
        if($studio_package_media->save()) {
            return $studio_package_media;
        }
        return $studio_package_media;
    }
}
