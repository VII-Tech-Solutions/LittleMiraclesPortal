<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\StudioCategory;
use App\Constants\Tables;
use App\Helpers;
use VIITech\Helpers\Constants\CastingTypes;


/**
 * Class StudioMetadata
 * @package App\Models
 *
 * @property integer id
 * @property integer title
 * @property integer image
 * @property integer description
 * @property string category
 * @property integer status
 */

class StudioMetadata extends CustomModel
{
    protected $table = Tables::STUDIO_METADATA;
    public const DIRECTORY = "uploads/studiometadata";

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::TITLE,
        Attributes::DESCRIPTION,
        Attributes::IMAGE,
        Attributes::CATEGORY,
        Attributes::STATUS,
    ];

    protected $casts = [
        Attributes::TITLE => CastingTypes::STRING,
        Attributes::DESCRIPTION => CastingTypes::STRING,
        Attributes::CATEGORY => CastingTypes::INTEGER,
        Attributes::STATUS => CastingTypes::INTEGER,
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
        Attributes::CATEGORY_NAME,
    ];

    /**
     * Get Attribute: status_name
     * @param $value
     * @return string
     */
    public function getStatusNameAttribute($value)
    {
        $text = Status::getKey($this->status);
        return Helpers::readableText($text);
    }

    /**
     * Get Attribute: Studio Category
     *  @param $value
     * @return string
     */
    function getCategoryNameAttribute($value)
    {
        return Helpers::readableText(StudioCategory::getKey($this->category));
    }

    /**
     * Get image Attribute
     * @param $value
     * @return string|null
     */
    function getImageAttribute($value){
        if(empty($value)){
            return null;
        }
        return url($value);
    }

    /**
     * Set Attribute: Image
     * @param $value
     */
    public function setImageAttribute($value)
    {
        if(!is_null($value)){
            $path = Helpers::uploadFile($this, $value, Attributes::IMAGE, self::DIRECTORY, true, false, true);
            $this->attributes[Attributes::IMAGE] = "storage/" . $path;
        }else{
            $this->attributes[Attributes::IMAGE] = null;
        }
    }
}
