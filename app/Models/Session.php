<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\SessionStatus;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ModelTrait;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Session
 * @property int session_status
 */
class Session extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::SESSIONS;
    public const DIRECTORY = "uploads/sessions";

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::SESSION_STATUS,
        Attributes::TITLE,
        Attributes::CUSTOM_BACKDROP,
        Attributes::CUSTOM_CAKE,
        Attributes::COMMENTS,
        Attributes::TOTAL_PRICE,
        Attributes::STATUS,
    ];


    protected $casts = [
        Attributes::TITLE =>CastingTypes::STRING,
        Attributes::USER_ID => CastingTypes::INTEGER,
        Attributes::PACKAGE_ID => CastingTypes::INTEGER,
        Attributes::FAMILY_ID => CastingTypes::INTEGER,
        Attributes::CUSTOM_BACKDROP =>CastingTypes::STRING,
        Attributes::CUSTOM_CAKE =>CastingTypes::STRING,
        Attributes::COMMENTS =>CastingTypes::STRING,
        Attributes::TOTAL_PRICE => 'decimal:3',
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
        Attributes::SESSION_STATUS_NAME,
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
     * Get Attribute: session status name
     * @param $value
     * @return string
     */
    public function getSessionStatusNameAttribute($value)
    {
        $text = SessionStatus::getKey($this->session_status);
        return Helpers::readableText($text);
    }
}
