<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ModelTrait;

/**
 * Session Package
 * @property integer package_id
 * @property integer sub_package_id
 */
class PackageSubPackage extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::PACKAGE_SUB_PACKAGES;
    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::SUB_PACKAGE_ID,
        Attributes::PACKAGE_ID
    ];
}

