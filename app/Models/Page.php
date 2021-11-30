<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Tables;
use App\Helpers;

/**
 * Pages
 *
 * @property string title
 * @property string content
 * @property string slug
 * @property int status

 */

class Page extends CustomModel
{
    protected $table = Tables::PAGES;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::TITLE,
        Attributes::CONTENT,
        Attributes::SLUG,
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
