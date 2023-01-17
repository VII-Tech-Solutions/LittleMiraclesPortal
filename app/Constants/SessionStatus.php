<?php

namespace App\Constants;

class SessionStatus extends CustomEnum
{
    const UNPAID = 0;
    const BOOKED = 1;
    const PHOTOSHOOT_DAY = 2;
    const MAGIC_MAKING = 3;
    const GETTING_IN_ORDER = 4;
    const READY = 5;
}
