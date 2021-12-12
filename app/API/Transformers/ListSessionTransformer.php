<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListSessionTransformer
 * @package App\API\Transformers
 */
class ListSessionTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,

        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];
}
