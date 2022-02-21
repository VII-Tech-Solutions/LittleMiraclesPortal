<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ImageTrait;
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

    use ImageTrait;

    protected $table = Tables::MEDIA;
    public const DIRECTORY = "assets/studio";
    protected $guarded = [
        Attributes::ID
    ];
    protected $fillable = [
        Attributes::NAME,
        Attributes::SESSION_ID,
        Attributes::URL,
        Attributes::STATUS_NAME,
        Attributes::TYPE,
        Attributes::THUMBNAIL,
        Attributes::PACKAGE_ID,
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
    public static function findOrCreate($name, $type, $url, $extension = null, $session_id = null)
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
            Attributes::SESSION_ID => $session_id,
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

    /**
     * Get url Attribute
     * @param $value
     * @return string|null
     */
    function getUrlAttribute($value)
    {
        return $this->getImage($value);
    }

    /**
     * Set Attribute: Url
     * @param $value
     */
    public function setUrlAttribute($value)
    {
        $this->setUrl($value);
    }

}
