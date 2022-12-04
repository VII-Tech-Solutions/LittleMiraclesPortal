<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListCartItemsTransformer
 * @package App\API\Transformers
 */
class ListCartItemsTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::PACKAGE_ID,
        Attributes::PACKAGE_TYPE,
        Attributes::TITLE,
        Attributes::DESCRIPTION,
        Attributes::DISPLAY_IMAGE,
        Attributes::MEDIA_IDS,
        Attributes::ALBUM_SIZE,
        Attributes::SPREADS,
        Attributes::PAPER_TYPE,
        Attributes::COVER_TYPE,
        Attributes::CANVAS_SIZE,
        Attributes::CANVAS_TYPE,
        Attributes::QUANTITY,
        Attributes::PRINT_TYPE,
        Attributes::PAPER_SIZE,
        Attributes::ADDITIONAL_COMMENTS,
        Attributes::STATUS,
        Attributes::TOTAL_PRICE,
        Attributes::SUBTOTAL,
        Attributes::ALBUM_TITLE
    ];
}
