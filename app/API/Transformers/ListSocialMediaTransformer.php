<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListSocialMediaTransformer
 * @package App\API\Transformers
 */
class ListSocialMediaTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::TITLE,
        Attributes::ICON,
        Attributes::LINK,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
    ];
}
