<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListCakeCategoryTransformer
 * @package App\API\Transformers
 */
class ListCakeCategoryTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::NAME,
        Attributes::IMAGE,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
    ];
}
