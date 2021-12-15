<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\SessionStatus;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Session
 * @property int session_status
 * @property int rating
 * @property string comment
 * @property User user
 * @property string package_name
 * @property string user_name
 * @property Package package
 * @property int package_id
 * @property int session_id
 */
class Session extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::SESSIONS;
    public const DIRECTORY = "uploads/sessions";

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::SESSION_STATUS,
        Attributes::TITLE,
        Attributes::CUSTOM_BACKDROP,
        Attributes::CUSTOM_CAKE,
        Attributes::COMMENTS,
        Attributes::TOTAL_PRICE,
        Attributes::STATUS,
    ];


    protected $casts = [
        Attributes::TITLE =>CastingTypes::STRING,
        Attributes::USER_ID => CastingTypes::INTEGER,
        Attributes::PACKAGE_ID => CastingTypes::INTEGER,
        Attributes::FAMILY_ID => CastingTypes::INTEGER,
        Attributes::CUSTOM_BACKDROP =>CastingTypes::STRING,
        Attributes::CUSTOM_CAKE =>CastingTypes::STRING,
        Attributes::COMMENTS =>CastingTypes::STRING,
        Attributes::TOTAL_PRICE => 'decimal:3',
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
        Attributes::SESSION_STATUS_NAME,
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
     * Get Attribute: session_status_name
     * @param $value
     * @return string
     */
    public function getSessionStatusNameAttribute($value)
    {
        $text = SessionStatus::getKey($this->status);
        return Helpers::readableText($text);
    }

    /**
     * Attribute: package_name
     * @return string
     */
    public function getPackageNameAttribute(){
        $package = $this->package;
        if(is_null($package)){
            return "-";
        }
        return $package->title;
    }

    /**
     * Relationship: User
     * @return BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class, Attributes::USER_ID);
    }

    /**
     * Relationship: Package
     * @return BelongsTo
     */
    public function package(){
        return $this->belongsTo(Package::class, Attributes::PACKAGE_ID);
    }

    /**
     * Relationships: Reviews
     * @return mixed
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, Attributes::SESSION_ID);
    }
}
