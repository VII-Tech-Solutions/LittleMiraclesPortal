<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListPackagePhotographersTransformer
 * @package App\API\Transformers
 */
class ListPackagePhotographersTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::PACKAGE_ID,
        Attributes::SUB_PACKAGE_ID,
        Attributes::PHOTOGRAPHER_ID,
        Attributes::ADDITIONAL_CHARGE,
        Attributes::PHOTOGRAPHER_NAME,
        Attributes::PHOTOGRAPHER_IMAGE,
        Attributes::STATUS,
        Attributes::CREATED_AT,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];
}
