<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Tables;
use App\Exceptions\Handler;
use App\Helpers;


/**
 * Onboarding
 *
 * @property string title
 * @property string content
 * @property int order
 * @property string image
 * @property int status
 */
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
        Attributes::STATUS,
    ];

    protected $appends = [
        Attributes::STATUS_NAME
    ];

    public function getStatusNameAttribute($value)
    {
        $text = Status::getKey( $this->status);
        return Helpers::readableText($text);
    }

    /**
     * Set Attribute: Image
     * @param $value
     */
    public function setImageAttribute($value)
    {
        if(!is_null($value)){
            $path = Helpers::uploadFile($this, $value, Attributes::IMAGE, "uploads/onboarding", true, false, true);
            $this->attributes[Attributes::IMAGE] = $path;
        }else{
            $this->attributes[Attributes::IMAGE] = null;
        }
    }
}

