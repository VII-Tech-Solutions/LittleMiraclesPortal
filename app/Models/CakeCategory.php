<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Tables;
use App\Traits\ImageTrait;
use App\Traits\ModelTrait;

/**
 * CakeCategory
 *
 * @property string name
 */
class CakeCategory extends CustomModel
{

    use ModelTrait, ImageTrait;

    public const DIRECTORY = "uploads/photographers";
    protected $table = Tables::CAKE_CATEGORIES;
    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::NAME,
        Attributes::IMAGE,
        Attributes::STATUS,
    ];


    protected $appends = [
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
    function getImageAttribute($value)
    {
        return $this->getImage($value);
    }

    /**
     * Set Attribute: Image
     * @param $value
     */
    public function setImageAttribute($value)
    {
        $this->setImage($value);
    }
}
