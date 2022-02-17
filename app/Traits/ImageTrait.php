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
        $image = trim($value);

        if(Str::startsWith($image, "http")){
            $this->attributes[Attributes::IMAGE] = $image;
            return;
        }
        if(!empty($image)){
            $path = Helpers::uploadFile($this, $image, Attributes::IMAGE, self::DIRECTORY, true, false, true);
            $this->attributes[Attributes::IMAGE] = "storage/" . $path;
        }else{
            $this->attributes[Attributes::IMAGE] = null;
        }
    }

    /**
     * Set Attribute: Url
     * @param $value
     */
    public function setUrl($value)
    {
        $image = trim($value);

        if(Str::startsWith($image, "http")){
            $this->attributes[Attributes::URL] = $image;
            return;
        }
        if(!empty($image)){
            $path = Helpers::uploadFile($this, $image, Attributes::URL, self::DIRECTORY, true, false, true);
            $this->attributes[Attributes::URL] = "storage/" . $path;
        }else{
            $this->attributes[Attributes::URL] = null;
        }
    }

}
