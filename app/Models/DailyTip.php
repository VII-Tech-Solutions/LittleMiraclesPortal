<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ImageTrait;
use App\Traits\ModelTrait;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Daily Tip
 */
class DailyTip extends CustomModel
{

    use ImageTrait, ModelTrait;

    public const DIRECTORY = "uploads/daily-tips";
    protected $table = Tables::DAILY_TIP;
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
        return $this->getStatusName($value);
    }

    /**
     * Get image Attribute
     * @param $value
     * @return string|null
     */
    function getImageAttribute($value)
    {
        return $this->getImage($value);
    }

    /**
     * Set Attribute: Image
     * @param $value
     */
    public function setImageAttribute($value)
    {
        $this->setImage($value);
    }
}
