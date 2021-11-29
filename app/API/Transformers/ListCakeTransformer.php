<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListCakeTransformer
 * @package App\API\Transformers
 */
class ListCakeTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::TITLE,
        Attributes::CATEGORY,
        Attributes::IMAGE,
        Attributes::STATUS,
        Attributes::UPDATED_AT
    ];
}