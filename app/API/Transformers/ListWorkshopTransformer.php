<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListWorkshopTransformer
 * @package App\API\Transformers
 */
class ListWorkshopTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::TITLE,
        Attributes::CONTENT,
        Attributes::PRICE,
        Attributes::IMAGE,
        Attributes::POSTED_AT,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];
}
