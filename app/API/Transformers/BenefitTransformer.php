<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class BenefitTransformer
 * @package App\API\Transformers
 */
class BenefitTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::ICON,
        Attributes::TITLE,
        Attributes::DESCRIPTION,
    ];
}
