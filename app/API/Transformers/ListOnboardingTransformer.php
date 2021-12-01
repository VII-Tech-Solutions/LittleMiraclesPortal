<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListOnboardingTransformer
 * @package App\API\Transformers
 */
class ListOnboardingTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::TITLE,
        Attributes::CONTENT,
        Attributes::IMAGE,
        Attributes::ORDER,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
    ];
}
