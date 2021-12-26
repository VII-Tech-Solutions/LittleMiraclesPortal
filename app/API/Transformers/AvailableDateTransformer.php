<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class AvailableDateTransformer
 * @package App\API\Transformers
 */
class AvailableDateTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::DATE,
        Attributes::TIMINGS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];
}
