<?php

namespace App\Constants;

/**
 * Class PaymentStatus
 * @package App\Constants
 */
class PaymentStatus extends CustomEnum
{
    const AWAITING_PAYMENT = 0;
    const PENDING_CONFIRMATION = 1;
    const CONFIRMED = 2;
    const REJECTED = 3;
    const REFUNDED = 4;
}
