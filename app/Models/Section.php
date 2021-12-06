<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\GoToAction;
use App\Constants\SectionTypes;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ImageTrait;
use App\Traits\ModelTrait;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Class Notification
 * @package App\Models
 *
 * @property integer id
 * @property integer image
 * @property integer title
 * @property integer content
 * @property string type
 * @property string is_featured
 * @property integer action_text
 * @property integer go_to
 * @property integer status
 * @property string go_to_name
 */
class Section extends CustomModel
{

    use ModelTrait, ImageTrait;

    public const DIRECTORY = "uploads/sections";
    protected $table = Tables::SECTIONS;
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
        Attributes::IS_FEATURED,
    ];

    protected $appends = [
        Attributes::TYPE_NAME,
        Attributes::STATUS_NAME,
        Attributes::IS_FEATURED_NAME,
        Attributes::GO_TO_NAME
    ];

    protected $casts = [
        Attributes::IS_FEATURED => CastingTypes::BOOLEAN,
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

    /**
     * Get Attribute: type_name
     * @return string
     */
    function getTypeNameAttribute()
    {
        return Helpers::readableText(SectionTypes::getKey($this->type));
    }

    /**
     * Get Attribute: is_featured_name
     * @param $value
     * @return string
     */
    public function getIsFeaturedNameAttribute($value)
    {
        return Helpers::readableBoolean($this->is_featured);
    }

    /**
     * Get Attribute: go_to_name
     * @param $value
     * @return string
     */
    public function getGoToNameAttribute($value)
    {
        $text = GoToAction::getKey($this->go_to);
        return Helpers::readableText($text);
    }
}
