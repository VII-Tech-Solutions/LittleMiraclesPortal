<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ModelTrait;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Session Package
 * @property string title
 * @property string description
 * @property int backdrop_allowed
 * @property int cake_allowed
 */
class SubPackage extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::SUB_PACKAGES;
    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::TITLE,
        Attributes::DESCRIPTION,
        Attributes::CAKE_ALLOWED,
        Attributes::BACKDROP_ALLOWED,
        Attributes::PACKAGE_ID,
    ];

    protected $casts = [
        Attributes::DESCRIPTION => CastingTypes::STRING,
        Attributes::TITLE => CastingTypes::STRING,
        Attributes::CAKE_ALLOWED => CastingTypes::INTEGER,
        Attributes::BACKDROP_ALLOWED => CastingTypes::INTEGER,
    ];


}

