<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class AvailableHourTransformer
 * @package App\API\Transformers
 */
class AvailableHourTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::DAY,
        Attributes::DAY_ID,
        Attributes::FROM,
        Attributes::TO,
    ];
}
