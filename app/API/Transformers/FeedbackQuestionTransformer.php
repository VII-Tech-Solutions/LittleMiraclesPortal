<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class FeedbackQuestionTransformer
 * @package App\API\Transformers
 */
class FeedbackQuestionTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::QUESTION,
        Attributes::QUESTION_TYPE,
        Attributes::OPTIONS,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];
}
