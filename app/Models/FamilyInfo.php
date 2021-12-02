<?php


namespace App\Models;

use App\Constants\Attributes;
use App\Constants\SessionStatus;
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
class FamilyInfo extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::FAMILY_INFO;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::ANSWER,
        Attributes::STATUS
    ];


    protected $casts = [
        Attributes::ANSWER =>CastingTypes::STRING,
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


