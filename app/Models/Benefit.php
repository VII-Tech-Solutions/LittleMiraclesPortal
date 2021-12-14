<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ImageTrait;
use App\Traits\ModelTrait;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Benefit
 *
 * @property int session_status
 * @property int gender
 * @property int relationship
 */
class Benefit extends CustomModel
{
    use ModelTrait, ImageTrait;

    protected $table = Tables::BENEFITS;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::ICON,
        Attributes::TITLE,
        Attributes::DESCRIPTION,
        Attributes::STATUS
    ];

    protected $casts = [
        Attributes::ANSWER => CastingTypes::STRING,
        Attributes::ICON => CastingTypes::STRING,
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
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


    /**
     * Relationships: packages
     * @return mixed
     */
    public function packages()
    {
        return $this->belongsToMany(Package::class, Tables::PACKAGE_BENEFITS, Attributes::BENEFIT_ID, Attributes::PACKAGE_ID);
    }

}


