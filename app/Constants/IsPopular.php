<?php


namespace App\Constants;

use App\Helpers;
use BenSampo\Enum\Enum;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionException;
class IsPopular extends CustomEnum
{
    const NO = 0;
    const YES = 1;
}
