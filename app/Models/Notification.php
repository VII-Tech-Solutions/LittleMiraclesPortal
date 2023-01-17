<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\NotificationTypes;
use App\Constants\Tables;

/**
 * Class Notification
 * @package App\Models
 *
 * @property integer id
 * @property integer title
 * @property integer message
 * @property integer type
 * @property string type_name
 * @property integer go_to
 * @property integer status
 */
class Notification extends CustomModel
{

    protected $table = Tables::NOTIFICATIONS;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::TITLE,
        Attributes::MESSAGE,
        Attributes::TYPE,
        Attributes::GO_TO,
        Attributes::STATUS,
    ];

    protected $appends = [
        Attributes::TYPE_NAME
    ];

    /**
     * Get Attribute: type_name
     * @return string
     */
    function getTypeNameAttribute()
    {
        return Helpers::readableText(NotificationTypes::getKey($this->type));
    }
}
