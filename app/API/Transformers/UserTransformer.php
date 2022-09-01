<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class UserTransformer
 * @package App\API\Transformers
 */
class UserTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::FIRST_NAME,
        Attributes::LAST_NAME,
        Attributes::PHONE_NUMBER,
        Attributes::EMAIL,
        Attributes::COUNTRY_CODE,
        Attributes::GENDER,
        Attributes::BIRTH_DATE,
        Attributes::PROVIDER,
        Attributes::AVATAR,
        Attributes::PAST_EXPERIENCE,
        Attributes::FAMILY_ID,
        Attributes::USERNAME,
        Attributes::PROVIDER_ID,
        Attributes::STATUS,
        Attributes::CHAT_WITH_EVERYONE,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT
    ];
}
