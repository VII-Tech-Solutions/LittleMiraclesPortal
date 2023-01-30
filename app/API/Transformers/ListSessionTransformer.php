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
        Attributes::FEATURED_IMAGE,
        Attributes::CUSTOM_BACKDROP,
        Attributes::CUSTOM_CAKE,
        Attributes::COMMENTS,
        Attributes::TOTAL_PRICE,
        Attributes::BENEFITS_IDS,
        Attributes::SUB_SESSIONS_IDS,
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
        Attributes::PHOTOGRAPHER_EMAIL,
        Attributes::PHOTOGRAPHER,
        Attributes::HAS_GUIDELINE,
        Attributes::GIFT_CLAIMED,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
        Attributes::BOOKING_TEXT,
        Attributes::EXTRA_PEOPLE
    ];
}
