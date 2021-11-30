<?php


namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\SessionStatus;
use App\Constants\Tables;
use App\Helpers;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Session
 * @property int session_status
 */
class Session extends CustomModel
{
    protected $table = Tables::SESSIONS;
    public const DIRECTORY = "uploads/photographers";

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
        $text = Status::getKey($this->status);
        return Helpers::readableText($text);
    }

    /**
     * Get Attribute: session SESSION_STATUS_NAME
     * @param $value
     * @return string
     */
    public function getSessionStatusNameAttribute($value)
    {
        $text = SessionStatus::getKey($this->session_status);
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

}
