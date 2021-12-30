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
        Attributes::POSTED_AT,
        Attributes::VALID_UNTIL,
        Attributes::CONTENT,
        Attributes::PROMO_CODE,
        Attributes::IMAGE,
        Attributes::USER_ID,
        Attributes::SESSION_ID,
        Attributes::PACKAGE_ID,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
    ];
}
