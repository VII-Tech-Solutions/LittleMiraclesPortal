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

    public const DIRECTORY = "uploads/reviews";
    protected $table = Tables::REVIEWS;
    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::RATING,
        Attributes::COMMENT,
        Attributes::USER_ID,
        Attributes::SESSION_ID,
        Attributes::PACKAGE_ID,
        Attributes::USER_IMAGE,
        Attributes::USER_NAME,
        Attributes::STATUS,
    ];

    protected $casts = [
        Attributes::COMMENT => CastingTypes::STRING,
        Attributes::STATUS => CastingTypes::INTEGER,
        Attributes::USER_NAME => CastingTypes::STRING,
        Attributes::USER_IMAGE => CastingTypes::STRING,
        Attributes::USER_ID => CastingTypes::INTEGER,
        Attributes::PACKAGE_ID => CastingTypes::INTEGER,
        Attributes::SESSION_ID => CastingTypes::INTEGER,
        Attributes::RATING => 'decimal:1',
    ];

    protected $appends = [
        Attributes::STATUS_NAME
    ];

    /**
     * Create or Update Item
     * @param array $data
     * @param $find_by
     * @return Review|null
     */
    public static function createOrUpdate(array $data, $find_by = null)
    {
        return parent::createOrUpdate($data, [
            Attributes::SESSION_ID, Attributes::USER_ID, Attributes::PACKAGE_ID
        ]);
    }

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
     * Get image Attribute
     * @param $value
     * @return string|null
     */
    function getUserNameAttribute($value)
    {
        if(empty($value)){
            return null;
        }
        return $value;
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
