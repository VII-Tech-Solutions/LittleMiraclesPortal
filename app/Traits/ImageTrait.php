<?php

namespace App\Traits;

use App\Constants\Attributes;
use App\Helpers;
use Illuminate\Support\Str;

/**
 * Image Trait
 */
trait ImageTrait
{

    /**
     * Get image Attribute
     * @param $value
     * @return string|null
     */
    function getImage($value){
        if(empty($value)){
            return null;
        }
        if(Str::startsWith($value, "http")){
            return $value;
        }
        return url($value);
    }

    /**
     * Set Attribute: Image
     * @param $value
     */
    public function setImage($value)
    {
        if(Str::startsWith($value, "http")){
            $this->attributes[Attributes::IMAGE] = $value;
            return;
        }
        if(!is_null($value)){
            $path = Helpers::uploadFile($this, $value, Attributes::IMAGE, self::DIRECTORY, true, false, true);
            $this->attributes[Attributes::IMAGE] = "storage/" . $path;
        }else{
            $this->attributes[Attributes::IMAGE] = null;
        }
    }

}
