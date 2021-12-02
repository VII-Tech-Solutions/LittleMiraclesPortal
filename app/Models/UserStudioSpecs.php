<?php


namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ModelTrait;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Family Information
 * @property int session_status
 * @property int gender
 * @property int relationship
 */
class UserStudioSpecs extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::USER_STUDIO_SPECS;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::USER_ID,
        Attributes::FAMILY_ID,
        Attributes::STUDIO_PACKAGE_ID,
        Attributes::STUDIO_SPECS_ID,
        Attributes::STATUS
    ];


    protected $casts = [

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



}
