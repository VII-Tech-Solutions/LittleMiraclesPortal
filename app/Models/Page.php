<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;

/**
 * Pages
 *
 * @property string title
 * @property string content
 * @property string slug
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

    ];
}
