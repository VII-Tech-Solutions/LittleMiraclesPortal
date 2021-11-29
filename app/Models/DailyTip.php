<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Tables;
use App\Helpers;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Daily Tip
 */
class DailyTip extends CustomModel
{

    protected $table = Tables::DAILY_TIP;
    public const DIRECTORY = "uploads/daily-tips";

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::IMAGE,
        Attributes::TITLE,
        Attributes::POSTED_AT,
        Attributes::CONTENT,
        Attributes::STATUS,
    ];

    protected $casts = [
        Attributes::TITLE => CastingTypes::STRING,
        Attributes::POSTED_AT => CastingTypes::STRING,
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
