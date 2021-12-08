<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class FamilyInfoQuestionOptionTransformer
 * @package App\API\Transformers
 */
class FamilyInfoQuestionOptionTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::VALUE
    ];
}
