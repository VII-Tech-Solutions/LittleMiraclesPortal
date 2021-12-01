<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\SessionPackageTypes;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ImageTrait;
use App\Traits\ModelTrait;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Session Package
 * @property int type
 * @property int is_popular
 *
 */
class SessionPackage extends CustomModel
{
    use ImageTrait, ModelTrait;

    public const DIRECTORY = "uploads/packages";
    protected $table = Tables::SESSION_PACKAGES;
    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::IMAGE,
        Attributes::TITLE,
        Attributes::TAG,
        Attributes::PRICE,
        Attributes::IS_POPULAR,
        Attributes::TYPE,
        Attributes::CONTENT,
        Attributes::LOCATION_TEXT,
        Attributes::LOCATION_LINK,
        Attributes::STATUS,
    ];


    protected $casts = [
        Attributes::IMAGE => CastingTypes::STRING,
        Attributes::TITLE => CastingTypes::STRING,
        Attributes::TAG => CastingTypes::STRING,
        Attributes::CONTENT => CastingTypes::STRING,
        Attributes::LOCATION_TEXT => CastingTypes::STRING,
        Attributes::LOCATION_LINK => CastingTypes::STRING,
        Attributes::PRICE => 'decimal:3',
        Attributes::IS_POPULAR => CastingTypes::BOOLEAN,
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
        Attributes::IS_POPULAR_NAME,
        Attributes::TYPE_NAME

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
     * Get Attribute: type_name
     * @param $value
     * @return string
     */
    public function getTypeNameAttribute($value)
    {
        $text = SessionPackageTypes::getKey($this->type);
        return Helpers::readableText($text);
    }

    /**
     * Get Attribute: is_popular_name
     * @param $value
     * @return string
     */
    public function getIsPopularNameAttribute($value)
    {
        return Helpers::readableBoolean($this->is_popular);
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
