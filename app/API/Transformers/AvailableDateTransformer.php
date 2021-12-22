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
        Attributes::ID,
        Attributes::START_DATE,
        Attributes::END_DATE,
        Attributes::TYPE,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];

    protected $defaultIncludes = [
        Attributes::HOURS
    ];
}
