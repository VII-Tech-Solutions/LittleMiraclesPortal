<?php

namespace App\Models;

use App\Constants\Tables;
use App\Constants\Attributes;

/**
 * Class Transaction
 * @package App\Models
 *
 * @property integer id
 * @property string transaction_id
 * @property integer user_id
 * @property integer order_id
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
 */
class Transaction extends CustomModel
{
    protected $table = Tables::TRANSACTIONS;
    protected $fillable = [
        Attributes::TRANSACTION_ID,
        Attributes::AMOUNT,
        Attributes::ORDER_ID,
        Attributes::CURRENCY,
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
}
