<?php

namespace App\Models;

use App\API\Transformers\BenefitTransformer;
use App\Constants\Attributes;
use App\Constants\SessionPackageTypes;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ImageTrait;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Session Package
 * @property integer package_id
 * @property integer sub_package_id
 */
class PackageSubPackage extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::SUB_PACKAGES;
    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::SUB_PACKAGE_ID,
        Attributes::PACKAGE_ID
    ];



}

