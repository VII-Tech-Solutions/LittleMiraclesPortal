<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class ListNotificationsTransformer
 * @package App\API\Transformers
 */
class ListNotificationsTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::TITLE,
        Attributes::MESSAGE,
        Attributes::TYPE,
        Attributes::GO_TO,
        Attributes::STATUS,
        Attributes::CREATED_AT,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];
}
