<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;

/**
 * Session Detail
 */
class SessionDetail extends CustomModel
{

    protected $table = Tables::SESSION_DETAILS;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::TYPE,
        Attributes::VALUE,
        Attributes::SESSION_ID,
        Attributes::PACKAGE_ID,
        Attributes::USER_ID,
        Attributes::FAMILY_ID,
        Attributes::STATUS,
    ];
}


