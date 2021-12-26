<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Tables;
use App\Helpers;

/**
 * CakeCategory
 *
 * @property string name
 */
class CakeCategory extends CustomModel
{

    protected $table = Tables::CAKE_CATEGORIES;
    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::NAME,
        Attributes::STATUS,
    ];


    protected $appends = [
        Attributes::STATUS_NAME
    ];

    /**
     * Get Attribute: status_name
     * @param $value
     * @return string
     */
    public function getStatusNameAttribute($value)
    {
        $text = Status::getKey($this->status);
        return Helpers::readableText($text);
    }
}
