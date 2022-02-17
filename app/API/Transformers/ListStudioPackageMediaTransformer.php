<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListStudioPackageMediaTransformer
 * @package App\API\Transformers
 */
class ListStudioPackageMediaTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::URL,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
    ];
}
