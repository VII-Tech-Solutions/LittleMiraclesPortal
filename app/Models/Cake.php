<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ImageTrait;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Cake
 */
class Cake extends CustomModel
{

    use ModelTrait, ImageTrait;

    public const DIRECTORY = "uploads/photographers";
    protected $table = Tables::CAKES;
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
     * Relationship: Category
     * @return BelongsTo
     */
    function category(): BelongsTo
    {
        return $this->belongsTo(CakeCategory::class, Attributes::CATEGORY_ID);
    }
}
