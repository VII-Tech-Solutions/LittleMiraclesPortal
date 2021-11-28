<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Helpers;

class Onboarding extends CustomModel
{

    protected $table = Tables::ONBOARDING;

    protected $guarded = [
        Attributes::ID
    ];
    protected $fillable = [
        Attributes::TITLE,
        Attributes::CONTENT,
        Attributes::ORDER,
        Attributes::IMAGE,
    ];

//    /**
//     * Set Attribute: Image
//     * @param $value
//     */
//    public function setImageAttribute($value)
//    {
//        if(!is_null($value)){
//            $path = Helpers::uploadFile($this, $value, Attributes::IMAGE, "uploads/onboarding", true, false);
//            $this->attributes[Attributes::IMAGE] = $path;
//        }else{
//            $this->attributes[Attributes::IMAGE] = null;
//        }
//    }
//
//    /**
//     * Get Attribute: image
//     * @param $value
//     * @return string|null
//     */
//    public function getImageAttribute($value)
//    {
//        return Helpers::getCDNLink($value);
//    }
}

