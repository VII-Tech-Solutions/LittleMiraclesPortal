<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Tables;
use App\Traits\ImageTrait;

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

    use ImageTrait;

    public const DIRECTORY = "uploads/onboarding";
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

    /**
     * Get status_name Attribute
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

