<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class FamilyMemberTransformer
 * @package App\API\Transformers
 */
class FamilyMemberTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::FIRST_NAME,
        Attributes::LAST_NAME,
        Attributes::GENDER,
        Attributes::COUNTRY_CODE,
        Attributes::PHONE_NUMBER,
        Attributes::PERSONALITY,
        Attributes::BIRTH_DATE,
        Attributes::RELATIONSHIP,
        Attributes::FAMILY_ID,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];
}
