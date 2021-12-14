<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ModelTrait;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Package Benefit
 */
class PackageBenefit extends CustomModel
{

    protected $table = Tables::PACKAGE_BENEFITS;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::PACKAGE_ID,
        Attributes::BENEFIT_ID,
        Attributes::STATUS
    ];

}


