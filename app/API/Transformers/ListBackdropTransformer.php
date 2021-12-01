<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListBackdropTransformer
 * @package App\API\Transformers
 */
class ListBackdropTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::TITLE,
        Attributes::CATEGORY,
        Attributes::IMAGE,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
    ];
}
