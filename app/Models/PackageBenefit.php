<?php


namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ModelTrait;
use App\Traits\ImageTrait;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Family Information
 * @property int session_status
 * @property int gender
 * @property int relationship
 */
class PackageBenefit extends CustomModel
{
    use ModelTrait, ImageTrait;

    protected $table = Tables::PACKAGE_BENEFITS;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::ICON,
        Attributes::TITLE,
        Attributes::STATUS
    ];


    protected $casts = [
        Attributes::ANSWER =>CastingTypes::STRING,
        Attributes::ICON =>CastingTypes::STRING,
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

}


