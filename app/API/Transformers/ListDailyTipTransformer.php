<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListDailyTipTransformer
 * @package App\API\Transformers
 */
class ListDailyTipTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::IMAGE,
        Attributes::TITLE,
        Attributes::POSTED_AT,
        Attributes::CONTENT,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
    ];
}
