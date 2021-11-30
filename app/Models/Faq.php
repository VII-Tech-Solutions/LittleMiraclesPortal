<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Tables;
use App\Helpers;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Onboarding
 *
 * @property string question
 * @property string answer
 * @property string created_at
 * @property string updated_at
 * @property int status
 */
class Faq extends CustomModel
{
    protected $table = Tables::FAQS;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::QUESTION,
        Attributes::ANSWER,
        Attributes::CREATED_AT,
        Attributes::UPDATED_AT,
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
        $text = Status::getKey($this->status);
        return Helpers::readableText($text);
    }
}
