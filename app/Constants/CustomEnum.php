<?php

namespace App\Constants;

use App\Helpers;
use BenSampo\Enum\Enum;

/**
 * Class CustomEnum
 * @package App\Constants
 */
class CustomEnum extends Enum
{

    /**
     * All
     * @return array
     */
    static function all()
    {
        $collection = collect();
        $array = static::toArray();
        $array = array_flip($array);
        foreach ($array as $key => $item){
            $collection->put($key, Helpers::readableText($item));
        }
        return $collection->toArray();
    }

    /**
     * Readable Array
     * @return array
     */
    static function readableArray()
    {
        $result = collect();
        $constants = self::toArray();
        foreach ($constants as $key => $value) {
            $result->add([
                Attributes::ID => $value,
                Attributes::TITLE => Helpers::readableText($key)
            ]);
        }
        return $result->toArray();
    }
}
