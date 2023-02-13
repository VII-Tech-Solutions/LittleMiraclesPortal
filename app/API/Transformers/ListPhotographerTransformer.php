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
        Attributes::EMAIL,
        Attributes::ROLE,
        Attributes::IMAGE,
        Attributes::STATUS,
        Attributes::ADDITIONAL_CHARGE,
        Attributes::PRIORITY,
        Attributes::FIREBASE_ID,
        Attributes::DEVICE_TOKEN,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
    ];
}
