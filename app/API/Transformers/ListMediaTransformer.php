<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListMediaTransformer
 * @package App\API\Transformers
 */
class ListMediaTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::NAME,
        Attributes::URL,
        Attributes::TYPE,
        Attributes::PACKAGE_ID,
        Attributes::SESSION_ID,
        Attributes::FAMILY_ID,
        Attributes::USER_ID,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
    ];
}
