<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class FeedbackQuestionOptionTransformer
 * @package App\API\Transformers
 */
class FeedbackQuestionOptionTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::VALUE
    ];
}
