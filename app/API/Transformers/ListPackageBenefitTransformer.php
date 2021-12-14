<?php

namespace App\API\Transformers;

use App\Constants\Attributes;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Class ListPackageBenefitTransformer
 * @package App\API\Transformers
 */
class ListPackageBenefitTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::TITLE,
        Attributes::ICON,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
    ];

}
