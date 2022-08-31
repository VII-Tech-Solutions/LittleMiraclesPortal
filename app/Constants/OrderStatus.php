<?php

namespace App\Constants;

class OrderStatus extends CustomEnum
{
    const PAID = 1;
    const MAGIC_MAKING = 2;
    const READY = 3;
    const COLLECTED = 4;
    const CANCELLED = 5;

}
