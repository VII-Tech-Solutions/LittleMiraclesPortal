<?php

namespace App\Constants;

use Carbon\Carbon;

class GiftValidityDays extends CustomEnum
{

    static function all(){
        return  [
            90 => '3 months',
            180 => '6 months',
            270 => '9 months',
            365 => '1 Year'
        ];
    }
}
