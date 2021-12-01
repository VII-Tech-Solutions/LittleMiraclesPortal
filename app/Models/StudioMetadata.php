<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\StudioCategory;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ImageTrait;
use App\Traits\ModelTrait;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Class StudioMetadata
 * @package App\Models
 *
 * @property integer id
 * @property integer title
 * @property integer image
 * @property integer description
 * @property string category
 * @property integer status
 */
class StudioMetadata extends CustomModel
{
    use ImageTrait, ModelTrait;

    public const DIRECTORY = "uploads/studiometadata";
    protected $table = Tables::STUDIO_METADATA;
    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::TITLE,
        Attributes::DESCRIPTION,
        Attributes::IMAGE,
        Attributes::CATEGORY,
        Attributes::STATUS,
    ];

    protected $casts = [
        Attributes::TITLE => CastingTypes::STRING,
        Attributes::DESCRIPTION => CastingTypes::STRING,
        Attributes::CATEGORY => CastingTypes::INTEGER,
        Attributes::STATUS => CastingTypes::INTEGER,
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
        Attributes::CATEGORY_NAME,
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
     * Get Attribute: Studio Category
     * @param $value
     * @return string
     */
    function getCategoryNameAttribute($value)
    {
        return Helpers::readableText(StudioCategory::getKey($this->category));
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
