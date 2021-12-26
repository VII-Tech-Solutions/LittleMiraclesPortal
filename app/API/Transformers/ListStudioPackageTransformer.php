<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListStudioPackageTransformer
 * @package App\API\Transformers
 */
class ListStudioPackageTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::TITLE,
        Attributes::IMAGE,
        Attributes::STARTING_PRICE,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];
}
