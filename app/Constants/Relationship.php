<?php


namespace App\Constants;

use App\Helpers;
use BenSampo\Enum\Enum;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionException;

class Relationship extends CustomEnum
{
    const PARTNER = 1;
    const CHILDREN = 2;
}
