<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\OrderStatus;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use phpDocumentor\Reflection\Types\Collection;
use \Backpack\CRUD\app\Models\Traits\CrudTrait;

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
 * @property User user
 */
class Order extends CustomModel
{
    use CrudTrait, ModelTrait;

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

    /**
     * Get Attribute: status_name
     * @param $value
     * @return string
     */
    public function getStatusNameAttribute($value)
    {
        $text = OrderStatus::getKey($this->status);
        return Helpers::readableText($text);
    }

    /**
     * Relationship: User
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, Attributes::USER_ID);
    }


}
