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
        Attributes::ID,
        Attributes::AVAILABLE_DATE_ID,
        Attributes::DAY,
        Attributes::DAY_ID,
        Attributes::FROM,
        Attributes::TO,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];
}
