<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListSubSessionTransformer
 * @package App\API\Transformers
 */
class ListSubSessionTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::TITLE,
        Attributes::USER_ID,
        Attributes::FAMILY_ID,
        Attributes::PACKAGE_ID,
        Attributes::SUB_PACKAGE_ID,
        Attributes::FEATURED_IMAGE,
        Attributes::CUSTOM_BACKDROP,
        Attributes::CUSTOM_CAKE,
        Attributes::TOTAL_PRICE,
        Attributes::REVIEWS_IDS,
        Attributes::MEDIA_IDS,
        Attributes::INCLUDE_ME,
        Attributes::DATE,
        Attributes::FORMATTED_DATE,
        Attributes::TIME,
        Attributes::FORMATTED_PEOPLE,
        Attributes::FORMATTED_BACKDROP,
        Attributes::FORMATTED_CAKE,
        Attributes::LOCATION_TEXT,
        Attributes::LOCATION_LINK,
        Attributes::IS_OUTDOOR,
        Attributes::PHOTOGRAPHER_NAME,
        Attributes::HAS_GUIDELINE,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
        Attributes::STATUS
    ];
}
