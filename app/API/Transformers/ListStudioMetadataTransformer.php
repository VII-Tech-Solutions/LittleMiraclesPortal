<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListStudioMetadataTransformer
 * @package App\API\Transformers
 */
class ListStudioMetadataTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::TITLE,
        Attributes::DESCRIPTION,
        Attributes::IMAGE,
        Attributes::CATEGORY,
        Attributes::STATUS,
        Attributes::TYPE,
        Attributes::BENEFITS_IDS,
        Attributes::STARTING_PRICE,
        Attributes::MEDIA_IDS,
        Attributes::PRICE,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];
}
