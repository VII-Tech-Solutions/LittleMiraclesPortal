<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ModelTrait;

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
    use ModelTrait;

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
        return $this->getStatusName($value);
    }
}
