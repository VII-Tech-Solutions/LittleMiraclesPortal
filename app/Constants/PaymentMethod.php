<?php

namespace App\Constants;

class PaymentMethod extends CustomEnum
{
    const PAYPAL = 1;
    const APPLE_PAY = 2;
    const DEBIT_CARD = 3;
    const CREDIT_CARD = 4;
}
