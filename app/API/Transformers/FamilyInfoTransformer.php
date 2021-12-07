<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class FamilyInfoTransformer
 * @package App\API\Transformers
 */
class FamilyInfoTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::USER_ID,
        Attributes::FAMILY_ID,
        Attributes::QUESTION_ID,
        Attributes::ANSWER,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];
}
