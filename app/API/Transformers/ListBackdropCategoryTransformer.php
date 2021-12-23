<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListBackdropCategoryTransformer
 * @package App\API\Transformers
 */
class ListBackdropCategoryTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::NAME,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
    ];
}
