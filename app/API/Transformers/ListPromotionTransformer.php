<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListPromotionTransformer
 * @package App\API\Transformers
 */
class ListPromotionTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::TITLE,
        Attributes::OFFER,
        Attributes::TYPE,
        Attributes::DATE,
        Attributes::CONTENT,
        Attributes::CODE,
        Attributes::IMAGE,
        Attributes::STATUS,
        Attributes::UPDATED_AT
    ];
}
