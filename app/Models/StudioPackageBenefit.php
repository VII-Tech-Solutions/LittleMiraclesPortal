<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ModelTrait;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Studio Package Benefit
 */
class StudioPackageBenefit extends CustomModel
{

    protected $table = Tables::PACKAGE_BENEFITS;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::STUDIO_PACKAGE_ID,
        Attributes::BENEFIT_ID,
        Attributes::STATUS
    ];

}


