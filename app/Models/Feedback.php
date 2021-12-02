<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ModelTrait;
use VIITech\Helpers\Constants\CastingTypes;

class Feedback extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::FEEDBACK;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::ANSWER,
        Attributes::STATUS
    ];


    protected $casts = [
        Attributes::ANSWER =>CastingTypes::STRING,
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
    ];

    /**
     * Get Attribute: status_name
     * @param $value
     * @return string
     */
    public function getStatusNameAttribute($value)
    {
        return $this->getStatusName($value);
    }
}
