<?php


namespace App\Constants;

use App\Helpers;
use BenSampo\Enum\Enum;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionException;
class QuestionType extends CustomEnum
{
    const TEXT = 1;
    const MULTIPLE = 2;
}


