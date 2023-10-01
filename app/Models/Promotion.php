<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\PromotionStatus;
use App\Constants\Tables;
use App\Traits\ImageTrait;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Promotion
 *
 * @property string offer
 * @property string valid_until
 * @property integer package_id
 * @property integer type
 * @property string promo_code
 * @property string to
 * @property string from
 * @property boolean redeemed
 * @property string message
 * @property User user
 * @property Package package
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
        Attributes::AVAILABLE_UNTIL,
        Attributes::DAYS_OF_VALIDITY,
        Attributes::TO,
        Attributes::FROM,
        Attributes::MESSAGE,
        Attributes::REDEEMED
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
        Attributes::STATUS_NAME,
        Attributes::DAYS_OF_VALIDITY_TEXT,
        Attributes::PACKAGE_IMAGE,
        Attributes::PACKAGE_TITLE,
        Attributes::PACKAGE_TAG,
    ];

    /**
     * Get Attribute: status_name
     * @param $value
     * @return string
     */
    public function getStatusNameAttribute($value)
    {
        $text = PromotionStatus::getKey($this->status);
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
     * Get Days of validity text
     * @param $value
     * @return string|null
     */
    function getDaysOfValidityTextAttribute($value)
    {
        if(empty($this->days_of_validity)){
            return null;
        }

        return $this->days_of_validity . " Days";
    }


    /**
     * Get title
     * @param $value
     * @return string|null
     */
    function getTitleAttribute($value)
    {
        if(!is_null($value)){
            return $value;
        }

        return $this->package()->first()->title ?? null;
    }

    /**
     * Get package title
     * @param $value
     * @return string|null
     */
    function getPackageTitleAttribute($value)
    {
        if(!is_null($value)){
            return $value;
        }

        return $this->package()->first()->title ?? null;
    }

    /**
     * Get package image
     * @param $value
     * @return string|null
     */
    function getPackageImageAttribute($value)
    {
        if(!is_null($value)){
            return $value;
        }

        return $this->package()->first()->image ?? null;
    }


    /**
     * Get package tag
     * @param $value
     * @return string|null
     */
    function getPackageTagAttribute($value)
    {
        if(!is_null($value)){
            return $value;
        }

        return $this->package()->first()->tag ?? null;
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

    /**
     * Relationships: user
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, Attributes::USER_ID)->withTrashed();
    }


    /**
     * gift Activate
     */
    public function giftActivation(): string
    {
        if($this->status == PromotionStatus::ACTIVE){
            return '<a href="' . backpack_url("gifts/$this->id/de-activate") . '" class="btn btn-sm btn-link" style="color:gray ;font-weight: 900" data-button-type="DeActivate"><i class="la la-low-vision"></i> DeActivate</a>';
        }else{
            return '<a href="' . backpack_url("gifts/$this->id/activate") . '" class="btn btn-sm btn-link" style="color:green; font-weight: 900" data-button-type="Activate"><i  class="la la-check"></i> Activate</a>';

        }

    }




}
