<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ImageTrait;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Promotion
 *
 * @property string offer
 * @property string valid_until
 */
class Promotion extends CustomModel
{

    use ImageTrait, ModelTrait;

    public const DIRECTORY = "uploads/promotions";
    protected $table = Tables::PROMOTIONS;
    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::TITLE,
        Attributes::OFFER,
        Attributes::TYPE,
        Attributes::POSTED_AT,
        Attributes::VALID_UNTIL,
        Attributes::CONTENT,
        Attributes::PROMO_CODE,
        Attributes::IMAGE,
        Attributes::STATUS,
        Attributes::USER_ID,
        Attributes::PACKAGE_ID,
        Attributes::SESSION_ID,
        Attributes::AVAILABLE_FROM,
    ];

    protected $casts = [
        Attributes::TITLE => CastingTypes::STRING,
        Attributes::OFFER => CastingTypes::STRING,
        Attributes::TYPE => CastingTypes::INTEGER,
        Attributes::CODE => CastingTypes::STRING,
        Attributes::CONTENT => CastingTypes::STRING,
        Attributes::STATUS => CastingTypes::INTEGER,
        Attributes::PACKAGE_ID => CastingTypes::INTEGER,
        Attributes::SESSION_ID => CastingTypes::INTEGER,
        Attributes::USER_ID => CastingTypes::INTEGER,
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
     * Relationships: package
     * @return BelongsTo
     */
    public function package(): BelongsTo
    {
        return $this->BelongsTo(Package::class, Attributes::PACKAGE_ID);
    }
}
