<?php

namespace App\Constants;
use App\Helpers;
use BenSampo\Enum\Enum;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionException;

class Status extends CustomEnum
{
    const ACTIVE = 1;
    const DRAFT = 2;
}
