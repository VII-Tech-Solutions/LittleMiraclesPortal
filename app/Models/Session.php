<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\SessionDetailsType;
use App\Constants\SessionStatus;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
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
 * @property int user_id
 * @property int family_id
 * @property Collection reviews
 */
class Session extends CustomModel
{
    use ModelTrait;

    public const DIRECTORY = "uploads/sessions";
    protected $table = Tables::SESSIONS;
    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::TITLE,
        Attributes::CUSTOM_BACKDROP,
        Attributes::CUSTOM_CAKE,
        Attributes::COMMENTS,
        Attributes::TOTAL_PRICE,
        Attributes::STATUS,
        Attributes::USER_ID,
        Attributes::FAMILY_ID,
        Attributes::PACKAGE_ID,
        Attributes::DATE,
        Attributes::TIME,
        Attributes::PAYMENT_METHOD,
        Attributes::PHOTOGRAPHER,
        Attributes::INCLUDE_ME,
        Attributes::PROMO_ID,
    ];

    protected $casts = [
        Attributes::TITLE => CastingTypes::STRING,
        Attributes::USER_ID => CastingTypes::INTEGER,
        Attributes::PACKAGE_ID => CastingTypes::INTEGER,
        Attributes::FAMILY_ID => CastingTypes::INTEGER,
        Attributes::CUSTOM_BACKDROP => CastingTypes::STRING,
        Attributes::CUSTOM_CAKE => CastingTypes::STRING,
        Attributes::COMMENTS => CastingTypes::STRING,
        Attributes::TOTAL_PRICE => 'decimal:3',
        Attributes::INCLUDE_ME => CastingTypes::BOOLEAN
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
    ];

    /**
     * Create or Update
     * @param array $data
     * @param $find_by
     * @return Session|null
     */
    public static function createOrUpdate(array $data, $find_by = null)
    {
        return parent::createOrUpdate($data, [
            Attributes::USER_ID, Attributes::PACKAGE_ID,
            Attributes::DATE, Attributes::TIME, Attributes::STATUS
        ]);
    }

    /**
     * Get Attribute: session_status_name
     * @param $value
     * @return string
     */
    public function getStatusNameAttribute($value)
    {
        $text = SessionStatus::getKey($this->status);
        return Helpers::readableText($text);
    }

    /**
     * Attribute: package_name
     * @return string
     */
    public function getPackageNameAttribute()
    {
        $package = $this->package;
        if (is_null($package)) {
            return "-";
        }
        return $package->title;
    }

    /**
     * Relationship: User
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, Attributes::USER_ID);
    }

    /**
     * Relationship: Package
     * @return BelongsTo
     */
    public function package()
    {
        return $this->belongsTo(Package::class, Attributes::PACKAGE_ID);
    }

    /**
     * Relationships: Reviews
     * @return HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, Attributes::SESSION_ID, Attributes::ID);
    }

    /**
     * Relationships: Backdrops
     * @return BelongsToMany
     */
    public function backdrops()
    {
        return $this->belongsToMany(Backdrop::class, Tables::SESSION_DETAILS, null, Attributes::VALUE, Attributes::ID)
            ->where(Tables::SESSION_DETAILS . "." . Attributes::TYPE, SessionDetailsType::BACKDROP);
    }

    /**
     * Relationships: People
     * @return BelongsToMany
     */
    public function people()
    {
        return $this->belongsToMany(User::class, Tables::SESSION_DETAILS, null, Attributes::VALUE, Attributes::ID)
            ->where(Tables::SESSION_DETAILS . "." . Attributes::TYPE, SessionDetailsType::PEOPLE);
    }


    /**
     * Relationships: Cakes
     * @return BelongsToMany
     */
    public function cakes()
    {
        return $this->belongsToMany(Cake::class, Tables::SESSION_DETAILS, null, Attributes::VALUE, Attributes::ID)
            ->where(Tables::SESSION_DETAILS . "." . Attributes::TYPE, SessionDetailsType::CAKE);
    }

    /**
     * Relationships: Additions
     * @return BelongsToMany
     */
    public function additions()
    {
        return $this->belongsToMany(StudioPackage::class, Tables::SESSION_DETAILS, null, Attributes::VALUE, Attributes::ID)
            ->where(Tables::SESSION_DETAILS . "." . Attributes::TYPE, SessionDetailsType::ADDITIONS);
    }
}
