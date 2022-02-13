<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\GiftStatus;
use App\Constants\PromotionStatus;
use App\Constants\PromotionType;
use App\Constants\Status;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ImageTrait;
use App\Traits\ModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use VIITech\Helpers\Constants\CastingTypes;
use VIITech\Helpers\GlobalHelpers;

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
        Attributes::AVAILABLE_UNTIL,
        Attributes::DAYS_OF_VALIDITY,
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
        Attributes::DAYS_OF_VALIDITY_TEXT
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
