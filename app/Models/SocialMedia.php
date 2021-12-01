<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ModelTrait;

/**
 * SocialMedia
 *
 * @property string title
 * @property string icon
 * @property string link
 * @property int status
 */
class SocialMedia extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::SOCIAL_MEDIA;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::TITLE,
        Attributes::ICON,
        Attributes::LINK,
        Attributes::STATUS,
    ];

    protected $appends = [
        Attributes::STATUS_NAME
    ];

    /**
     * Get status_name Attribute
     * @param $value
     * @return string
     */
    public function getStatusNameAttribute($value)
    {
        return $this->getStatusName($value);
    }
}
