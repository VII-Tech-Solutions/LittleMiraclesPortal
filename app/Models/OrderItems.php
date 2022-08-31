<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;

/**
 * Class OrderItems
 * @package App\Models
 *
 * @property integer order_id
 * @property integer item_id
 * @property integer user_id
 */
class OrderItems extends CustomModel
{
    protected $table = Tables::ORDER_ITEMS;
    protected $fillable = [
        Attributes::ORDER_ID,
        Attributes::ITEM_ID,
        Attributes::USER_ID
    ];
}
