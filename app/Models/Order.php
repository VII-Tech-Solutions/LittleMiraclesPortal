<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;

/**
 * Class Order
 * @package Order
 *
 * @property string promo_code
 * @property double total_price
 * @property double discount_price
 * @property integer status
 * @property integer user_id
 */
class Order extends CustomModel
{
    protected $table = Tables::ORDERS;
    protected $fillable = [
        Attributes::PROMO_CODE,
        Attributes::TOTAL_PRICE,
        Attributes::DISCOUNT_PRICE,
        Attributes::STATUS,
        Attributes::USER_ID
    ];
}
