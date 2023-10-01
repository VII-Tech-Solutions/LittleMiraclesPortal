<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\OrderStatus;
use App\Constants\PaymentStatus;
use App\Constants\Tables;
use App\Traits\ModelTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use phpDocumentor\Reflection\Types\Collection;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class Order
 * @package Order
 *
 * @property string promo_code
 * @property double total_price
 * @property double discount_price
 * @property double subtotal
 * @property double vat_amount
 * @property integer status
 * @property integer user_id
 * @property integer session_id
 * @property integer promo_id
 * @property integer booking_type
 * @property Collection orderItems
 * @property User user
 * @property Transaction transaction
 * @property Session session
 * @property CartItem items
 */
class Order extends CustomModel
{
    use CrudTrait, ModelTrait;

    protected $table = Tables::ORDERS;
    protected $fillable = [
        Attributes::PROMO_CODE,
        Attributes::TOTAL_PRICE,
        Attributes::DISCOUNT_PRICE,
        Attributes::VAT_AMOUNT,
        Attributes::SUBTOTAL,
        Attributes::STATUS,
        Attributes::USER_ID,
        Attributes::BOOKING_TYPE,
        Attributes::SESSION_ID,
        Attributes::PROMO_ID
    ];

    /**
     * Relationship: Order Items
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orderItems()
    {
        return $this->belongsToMany(CartItem::class, Tables::ORDER_ITEMS, Attributes::ORDER_ID, Attributes::ITEM_ID);
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
        return $this->belongsTo(User::class, Attributes::USER_ID)->withTrashed();
    }

    /**
     * Relationship: transactions
     * @return BelongsTo
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, Attributes::ID, Attributes::ORDER_ID)
            ->where(Attributes::STATUS, PaymentStatus::CONFIRMED);
    }

    /**
     * Relationship: session
     * @return BelongsTo
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class, Attributes::SESSION_ID, Attributes::ID);
    }

    /**
     * Relationship: items
     * @return HasManyThrough
     */
    public function items(): HasManyThrough
    {
        return $this->hasManyThrough(CartItem::class, OrderItems::class, Attributes::ORDER_ID, Attributes::ID, Attributes::ID, Attributes::ITEM_ID);
    }

    /**
     * Attribute: user name
     * @return string|null
     */
    public function getUserNameAttribute()
    {
        $user = $this->user;
        if (is_null($user)) {
            return null;
        }
        return $user->first_name . ' ' . $user->last_name;
    }
}
