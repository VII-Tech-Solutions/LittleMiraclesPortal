<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ImageTrait;
use App\Traits\ModelTrait;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Review
 */
class Review extends CustomModel
{
    use ModelTrait, ImageTrait;

    public const DIRECTORY = "uploads/photographers";
    protected $table = Tables::REVIEWS;
    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::RATING,
        Attributes::COMMENT,
        Attributes::POSTED_AT,
        Attributes::STATUS,
    ];


    protected $casts = [
        Attributes::RATING => CastingTypes::FLOAT,
        Attributes::COMMENT => CastingTypes::STRING,
        Attributes::STATUS => CastingTypes::INTEGER,
        Attributes::USER_NAME => CastingTypes::STRING,
        Attributes::USER_IMAGE => CastingTypes::STRING,
        Attributes::USER_ID => CastingTypes::INTEGER,
        Attributes::PACKAGE_ID => CastingTypes::INTEGER,
        Attributes::SESSION_ID => CastingTypes::INTEGER,

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
