<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use phpDocumentor\Reflection\Types\Collection;

/**
 * Class Order
 * @package Order
 *
 * @property string promo_code
 * @property double total_price
 * @property double discount_price
 * @property integer status
 * @property integer user_id
 * @property Collection orderItems
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

    /**
     * Relationship: Order Items
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orderItems() {
        return $this->belongsToMany(CartItem::class, Tables::ORDER_ITEMS,  Attributes::ORDER_ID, Attributes::ITEM_ID);
    }
}
