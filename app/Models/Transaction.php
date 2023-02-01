<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\PaymentMethods;
use App\Constants\PaymentStatus;
use App\Constants\Tables;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Transaction
 * @package App\Models
 *
 * @property integer id
 * @property string transaction_id
 * @property integer user_id
 * @property integer order_id
 * @property integer session_id
 * @property double amount
 * @property string currency
 * @property string gateway
 * @property string success_indicator
 * @property string success_url
 * @property string error_url
 * @property string description
 * @property string error_message
 * @property string session_version
 * @property string uid
 * @property string payment_id
 * @property integer payment_method
 * @property integer status
 * @property Order order
 * @property Session session
 */
class Transaction extends CustomModel
{
    use CrudTrait;

    protected $table = Tables::TRANSACTIONS;
    protected $fillable = [
        Attributes::TRANSACTION_ID,
        Attributes::AMOUNT,
        Attributes::ORDER_ID,
        Attributes::CURRENCY,
        Attributes::SESSION_ID,
        Attributes::GATEWAY,
        Attributes::PAYMENT_METHOD,
        Attributes::SUCCESS_INDICATOR,
        Attributes::SUCCESS_URL,
        Attributes::ERROR_URL,
        Attributes::DESCRIPTION,
        Attributes::ERROR_MESSAGE,
        Attributes::SESSION_VERSION,
        Attributes::UID,
        Attributes::PAYMENT_ID,
        Attributes::STATUS
    ];

    protected $appends = [
        Attributes::PAYMENT_METHOD_NAME
    ];

    /**
     * Attribute: status name
     * @return string
     */
    function getStatusNameAttribute(): string
    {
        $text = PaymentStatus::getKey($this->status);
        return Helpers::readableText($text);
    }

    /**
     * Attribute: payment method name
     * @return string
     */
    function getPaymentMethodNameAttribute(): string
    {
        $text = PaymentMethods::getKey($this->payment_method);
        return Helpers::readableText($text);
    }

    /**
     * Relationship: session
     * @return BelongsTo
     */
    function session(): BelongsTo
    {
        return $this->belongsTo(Session::class, Attributes::SESSION_ID, Attributes::ID)
            ->where(Attributes::STATUS, PaymentStatus::CONFIRMED);
    }

    /**
     * Relationship: order
     * @return BelongsTo
     */
    function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, Attributes::ORDER_ID, Attributes::ID);
    }
}
