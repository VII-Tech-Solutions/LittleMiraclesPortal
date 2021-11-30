<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Tables;
use App\Helpers;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Promotion
 */
class Promotion extends CustomModel
{
    protected $table = Tables::PROMOTIONS;
    public const DIRECTORY = "uploads/promotions";

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::TITLE,
        Attributes::OFFER,
        Attributes::TYPE,
        Attributes::POSTED_AT,
        Attributes::VALID_UNTIL,
        Attributes::CONTENT,
        Attributes::CODE,
        Attributes::IMAGE,
        Attributes::STATUS,
    ];

    protected $casts = [
        Attributes::TITLE => CastingTypes::STRING,
        Attributes::OFFER => CastingTypes::STRING,
        Attributes::TYPE => CastingTypes::STRING,
        Attributes::CODE => CastingTypes::STRING,
        Attributes::CONTENT => CastingTypes::STRING,
        Attributes::STATUS => CastingTypes::INTEGER,
    ];

    protected $appends = [
        Attributes::STATUS_NAME
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
