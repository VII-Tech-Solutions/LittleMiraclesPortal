<?php


namespace App\Constants;

use App\Helpers;
use BenSampo\Enum\Enum;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionException;

class Gender extends CustomEnum
{
    const MALE = 1;
    const FEMALE = 2;
}
