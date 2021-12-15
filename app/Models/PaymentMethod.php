<?php

namespace App\Models;
use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ModelTrait;

/**
 * PaymentMethod
 *
 * @property string title
 * @property int status
 */

class PaymentMethod extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::PAYMENT_METHOD;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::TITLE,
        Attributes::STATUS,
    ];

    protected $appends = [
        Attributes::STATUS_NAME
    ];

    /**
     * Get status_name Attribute
     * @param $value
     * @return string
     */
    public function getStatusNameAttribute($value)
    {
        return $this->getStatusName($value);
    }
}
