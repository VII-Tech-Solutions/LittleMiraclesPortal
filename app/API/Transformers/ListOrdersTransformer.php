<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListOrdersTransformer
 * @package App\API\Transformers
 */
class ListOrdersTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::PROMO_CODE,
        Attributes::TOTAL_PRICE,
        Attributes::DISCOUNT_PRICE,
        Attributes::STATUS,
    ];
}
