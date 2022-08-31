<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;

/**
 * Class CartItem
 * @package App\Models
 *
 * @property integer package_id
 * @property integer package_type
 * @property string title
 * @property string description
 * @property integer display_image
 * @property string media_ids
 * @property integer album_size
 * @property integer spreads
 * @property integer paper_type
 * @property integer cover_type
 * @property integer canvas_size
 * @property integer canvas_type
 * @property integer quantity
 * @property integer print_type
 * @property integer paper_size
 * @property string additional_comments
 * @property integer status
 * @property double total_price
 * @property integer user_id
 */
class CartItem extends CustomModel
{
    protected $table = Tables::CART_ITEMS;
    protected $fillable = [
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
        Attributes::USER_ID
    ];
}
