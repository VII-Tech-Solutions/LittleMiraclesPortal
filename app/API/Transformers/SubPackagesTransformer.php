<?php

namespace App\API\Transformers;

use App\Constants\Attributes;

/**
 * Class SubPackagesTransformer
 * @package App\API\Transformers
 */
class SubPackagesTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::TITLE,
        Attributes::DESCRIPTION,
        Attributes::BACKDROP_ALLOWED,
        Attributes::CAKE_ALLOWED,
    ];
}
