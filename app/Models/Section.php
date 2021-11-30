<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\SectionTypes;
use App\Constants\Status;
use App\Constants\Tables;
use App\Helpers;

/**
 * Class Notification
 * @package App\Models
 *
 * @property integer id
 * @property integer image
 * @property integer title
 * @property integer content
 * @property string type
 * @property integer action_text
 * @property integer go_to
 * @property integer status
 */
class Section extends CustomModel
{

    protected $table = Tables::SECTIONS;
    public const DIRECTORY = "uploads/sections";


    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::IMAGE,
        Attributes::TITLE,
        Attributes::CONTENT,
        Attributes::TYPE,
        Attributes::ACTION_TEXT,
        Attributes::GO_TO,
        Attributes::STATUS,
    ];

    protected $appends = [
        Attributes::TYPE_NAME,
        Attributes::STATUS_NAME
    ];

    /**
     * Get Attribute: status_name
     * @param $value
     * @return string
     */
    public function getStatusNameAttribute($value)
    {
        $text = Status::getKey($this->status);
        return Helpers::readableText($text);
    }

    /**
     * Get image Attribute
     * @param $value
     * @return string|null
     */
    function getImageAttribute($value){
        if(empty($value)){
            return null;
        }
        return url($value);
    }

    /**
     * Set Attribute: Image
     * @param $value
     */
    public function setImageAttribute($value)
    {
        if(!is_null($value)){
            $path = Helpers::uploadFile($this, $value, Attributes::IMAGE, self::DIRECTORY, true, false, true);
            $this->attributes[Attributes::IMAGE] = "storage/" . $path;
        }else{
            $this->attributes[Attributes::IMAGE] = null;
        }
    }

    /**
     * Get Attribute: type_name
     * @return string
     */
    function getTypeNameAttribute()
    {
        return Helpers::readableText(SectionTypes::getKey($this->type));
    }
}
