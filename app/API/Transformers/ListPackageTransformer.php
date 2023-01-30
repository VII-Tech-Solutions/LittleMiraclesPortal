<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListPackageTransformer
 * @package App\API\Transformers
 */
class ListPackageTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::IMAGE,
        Attributes::TITLE,
        Attributes::TAG,
        Attributes::PRICE,
        Attributes::IS_POPULAR,
        Attributes::TYPE,
        Attributes::CONTENT,
        Attributes::LOCATION_TEXT,
        Attributes::LOCATION_LINK,
        Attributes::BENEFITS_IDS,
        Attributes::SUB_PACKAGES_IDS,
        Attributes::REVIEWS_IDS,
        Attributes::MEDIA_IDS,
        Attributes::TOTAL_REVIEWS,
        Attributes::RATING,
        Attributes::MIN_BACKDROP,
        Attributes::BACKDROP_ALLOWED,
        Attributes::CAKE_ALLOWED,
        Attributes::OUTDOOR_ALLOWED,
        Attributes::HAS_GUIDELINE,
        Attributes::INDOOR_ALLOWED,
        Attributes::OUTDOOR_ALLOWED,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
    ];

    public $extra_fields = [
        Attributes::BENEFITS_IDS => Attributes::BENEFITS_IDS,
        Attributes::SUB_PACKAGES_IDS => Attributes::SUB_PACKAGES_IDS,
        Attributes::REVIEWS_IDS => Attributes::REVIEWS_IDS,
        Attributes::MEDIA_IDS => Attributes::MEDIA_IDS,
    ];
}
