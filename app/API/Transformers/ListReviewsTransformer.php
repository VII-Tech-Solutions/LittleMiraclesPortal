<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListReviewsTransformer
 * @package App\API\Transformers
 */
class ListReviewsTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::RATING,
        Attributes::USER_NAME,
        Attributes::USER_IMAGE,
        Attributes::USER_ID,
        Attributes::PACKAGE_ID,
        Attributes::SESSION_ID,
        Attributes::COMMENT,
        Attributes::POSTED_AT,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];
}
