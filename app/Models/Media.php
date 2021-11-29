<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Support\Str;

/**
 * Class Media
 * @package App\Models
 *
 * @property string name
 * @property string url
 * @property string thumbnail
 * @property string path
 * @property integer type
 * @property integer status
 * @property boolean is_compressed
 */
class Media extends CustomModel
{
    protected $table = Tables::MEDIA;
    protected $guarded = [
        Attributes::ID
    ];
    protected $fillable = [
        Attributes::NAME,
        Attributes::URL,
        Attributes::STATUS_NAME,
        Attributes::TYPE,
        Attributes::THUMBNAIL,
        Attributes::IS_COMPRESSED,
        Attributes::STATUS,
    ];

    /**
     * Create or Update
     * @param $name
     * @param $type
     * @param $url
     * @param $extension
     * @return static|null
     */
    public static function findOrCreate($name, $type, $url, $extension = null)
    {

        if(!is_null($extension)){
            $name = Str::replaceFirst(".$extension", '', $name);
        }

        /** @var Media $media */
        $media = Media::where(Attributes::NAME, $name)->where(Attributes::TYPE, $type)->first();
        if(!is_null($media)){
            return $media;
        }

        return Media::createOrUpdate([
            Attributes::NAME => $name,
            Attributes::TYPE => $type,
            Attributes::URL => $url,
        ]);
    }

    /**
     * Get Name from URL
     * @param $url
     * @param $extension
     * @return string
     */
    static function getNameFromURL($url, $extension){
        return Str::replaceFirst(".$extension", '', basename($url));
    }

}