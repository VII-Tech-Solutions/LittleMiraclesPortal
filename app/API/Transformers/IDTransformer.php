<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class IDTransformer
 * @package App\API\Transformers
 */
class IDTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID
    ];
}
