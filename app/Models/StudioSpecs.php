<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\StudioSpecsTypes;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ImageTrait;
use App\Traits\ModelTrait;

class StudioSpecs extends CustomModel
{
    use ImageTrait, ModelTrait;

    public const DIRECTORY = "uploads/studiospecs";
    protected $table = Tables::STUDIO_SPECS;
    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::STUDIO_PRINT_ID,
        Attributes::STUDIO_PACKAGE_ID,
        Attributes::TITLE,
        Attributes::IMAGE,
        Attributes::TYPE,
        Attributes::STATUS,
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
        Attributes::TYPE_NAME,
    ];

    /**
     * Get Attribute: status_name
     * @param $value
     * @return string
     */
    public function getStatusNameAttribute($value)
    {
        return $this->getStatusName($value);
    }


    /**
     *
     * @param $value
     * @return string
     */
    function getTypeNameAttribute($value)
    {
        return Helpers::readableText(StudioSpecsTypes::getKey($this->type));
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
