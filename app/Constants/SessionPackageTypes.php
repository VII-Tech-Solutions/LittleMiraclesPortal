<?php


namespace App\Constants;
use App\Helpers;
use BenSampo\Enum\Enum;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionException;

class SessionPackageTypes extends CustomEnum
{
    const NORMAL_SESSION = 1;
    const MULTIPLE_SESSIONS = 2;
    const MINI_SESSION = 3;

}
