<?php

namespace App\Constants;

use App\Models\Helpers;
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

    /**
     * To Custom Array
     * @return array
     */
    static function toCustomArray(){
        $collect = collect();
        $all = static::toArray();
        foreach ($all as $value => $key){
            $collect->add([
                Attributes::ID => $key,
                Attributes::VALUE => Helpers::readableText($value)
            ]);
        }
        return $collect->toArray();
    }

    /**
     * Only
     * @param $keys
     * @return array
     */
    static function only($keys)
    {
        return collect(self::all())->only($keys)->toArray();
    }
}
