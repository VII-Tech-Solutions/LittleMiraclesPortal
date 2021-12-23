<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Backdrop
 */
class Backdrop extends CustomModel
{

    use ImageTrait;

    public const DIRECTORY = "uploads/backdrops";
    protected $table = Tables::BACKDROP;
    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::TITLE,
        Attributes::CATEGORY_ID,
        Attributes::IMAGE,
        Attributes::STATUS,
    ];

    protected $casts = [
        Attributes::TITLE => CastingTypes::STRING,
        Attributes::CATEGORY_ID => CastingTypes::INTEGER,
        Attributes::STATUS => CastingTypes::INTEGER,
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

    /**
     * Relationship: Category
     * @return BelongsTo
     */
    function category(): BelongsTo
    {
        return $this->belongsTo(BackdropCategory::class, Attributes::CATEGORY_ID);
    }
}
