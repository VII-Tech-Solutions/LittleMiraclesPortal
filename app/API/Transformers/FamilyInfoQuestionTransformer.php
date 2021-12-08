<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class FamilyInfoQuestionTransformer
 * @package App\API\Transformers
 */
class FamilyInfoQuestionTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::QUESTION,
        Attributes::QUESTION_TYPE,
        Attributes::OPTIONS_ARRAY,
        Attributes::ORDER,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];
}
