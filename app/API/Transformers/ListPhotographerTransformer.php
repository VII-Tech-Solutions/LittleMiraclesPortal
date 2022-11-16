<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListPhotographerTransformer
 * @package App\API\Transformers
 */
class ListPhotographerTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::NAME,
        Attributes::IMAGE,
        Attributes::STATUS,
        Attributes::ADDITIONAL_CHARGE,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
    ];
}
