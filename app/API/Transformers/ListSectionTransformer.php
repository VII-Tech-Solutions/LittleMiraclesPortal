<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListSectionTransformer
 * @package App\API\Transformers
 */
class ListSectionTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::IMAGE,
        Attributes::TITLE,
        Attributes::CONTENT,
        Attributes::TYPE,
        Attributes::ACTION_TEXT,
        Attributes::GO_TO,
        Attributes::IS_FEATURED,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
    ];
}
