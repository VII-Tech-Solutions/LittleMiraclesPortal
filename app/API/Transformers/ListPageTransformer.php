<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListPageTransformer
 * @package App\API\Transformers
 */
class ListPageTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::TITLE,
        Attributes::CONTENT,
        Attributes::SLUG,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
    ];
}
