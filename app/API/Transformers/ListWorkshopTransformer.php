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
//        Attributes::DATE,
        Attributes::CONTENT,
        Attributes::PRICE,
        Attributes::IMAGE,
        Attributes::STATUS,
        Attributes::UPDATED_AT
    ];
}
