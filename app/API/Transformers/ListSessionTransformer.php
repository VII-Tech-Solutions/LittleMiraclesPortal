<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListSessionTransformer
 * @package App\API\Transformers
 */
class ListSessionTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::TITLE,
        Attributes::USER_ID,
        Attributes::FAMILY_ID,
        Attributes::PACKAGE_ID,
        Attributes::CUSTOM_BACKDROP,
        Attributes::CUSTOM_CAKE,
        Attributes::COMMENTS,
        Attributes::TOTAL_PRICE,
        Attributes::BENEFITS_IDS,
        Attributes::REVIEWS_IDS,
        Attributes::MEDIA_IDS,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];

    protected $defaultIncludes = [
        Attributes::BENEFITS_IDS => Attributes::BENEFITS_IDS,
        Attributes::REVIEWS_IDS => Attributes::REVIEWS_IDS,
        Attributes::MEDIA_IDS => Attributes::MEDIA_IDS,
    ];
}