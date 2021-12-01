<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListFAQsTransformer
 * @package App\API\Transformers
 */
class ListFAQsTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::QUESTION,
        Attributes::ANSWER,
        Attributes::CREATED_AT,
        Attributes::UPDATED_AT,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];
}
