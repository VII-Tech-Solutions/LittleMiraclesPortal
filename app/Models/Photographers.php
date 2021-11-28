<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use VIITech\Helpers\Constants\CastingTypes;
use Illuminate\Database\Eloquent\SoftDeletes;


class Photographers extends Model
{
    //
    use SoftDeletes, CrudTrait;
    protected $table = Tables::PHOTOGRAPHERS;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::NAME, Attributes::IMAGE, Attributes::STATUS,
    ];

    protected $casts = [
        Attributes::NAME => CastingTypes::STRING,
        Attributes::STATUS => CastingTypes::INTEGER,
    ];

}
