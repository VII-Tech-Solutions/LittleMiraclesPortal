<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Relationship;
use App\Constants\SessionDetailsType;
use App\Constants\SessionStatus;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Session
 *
 * @property string title
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
 * @property string date
 * @property string time
 * @property boolean include_me
 * @property string formatted_cake
 * @property string formatted_backdrop
 * @property int promo_id
 * @property int total_price
 * @property int photographer
 * @property string photographer_name
 * @property array benefits_ids
 * @property array media_ids
 * @property array reviews_ids
 * @property string featured_image
 *
 * @method static Builder sortByLatest()
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
        Attributes::LOCATION_LINK,
        Attributes::LOCATION_TEXT,
        Attributes::IS_OUTDOOR
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
        Attributes::INCLUDE_ME => CastingTypes::BOOLEAN,
        Attributes::IS_OUTDOOR => CastingTypes::BOOLEAN,
        Attributes::LOCATION_LINK => CastingTypes::STRING,
        Attributes::LOCATION_TEXT => CastingTypes::STRING,
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
        Attributes::FORMATTED_DATE,
        Attributes::FORMATTED_PEOPLE,
        Attributes::FORMATTED_BACKDROP,
        Attributes::FORMATTED_CAKE,
        Attributes::PHOTOGRAPHER_NAME,
        Attributes::HAS_GUIDELINE,
        Attributes::REVIEWS_IDS,
        Attributes::MEDIA_IDS,
        Attributes::BENEFITS_IDS,
        Attributes::FEATURED_IMAGE,
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
     * Attribute: featured_image
     * @return string
     */
    function getFeaturedImageAttribute(){
        return $this->package->image;
    }

    /**
     * Attribute: has_guideline
     * @return boolean
     */
    function getHasGuidelineAttribute(){
        return $this->package->has_guideline;
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
     * Attribute: formatted_date
     * @return string
     */
    public function getFormattedDateAttribute()
    {
        $date = $this->date;
        if(is_null($date)){
            return null;
        }
        return Carbon::parse($date)->format("jS, F Y");
    }

    /**
     * Attribute: photographer_name
     * @return string
     */
    public function getPhotographerNameAttribute()
    {
        $photographer = Photographer::find($this->photographer);
        if(is_null($photographer)){
            return null;
        }
        return $photographer->name;
    }

    /**
     * Attribute: formatted_people
     * @return string
     */
    public function getFormattedPeopleAttribute()
    {
        $include_me = $this->include_me;
        $people = $this->people()->get([Attributes::RELATIONSHIP]);
        $adults = 0;
        if($include_me){
            $adults = $adults + 1;
        }
        $adults = $adults + $people->where(Attributes::RELATIONSHIP, Relationship::PARTNER)->count();
        $children = $people->where(Attributes::RELATIONSHIP, Relationship::CHILDREN)->count();
        if($adults == 1){
            $adults = $adults . " adult";
        }else {
            $adults = $adults . " adults";
        }
        if($children == 1){
            $children = $children . " baby";
        }else {
            $children = $children . " babies";
        }
        return "$children, $adults";
    }

    /**
     * Attribute: people_ids
     * @return string
     */
    public function getPeopleIdsAttribute(){
        $array = $this->people()->pluck(Tables::FAMILY_MEMBERS . "." . Attributes::ID)->toArray();
        if(empty($array)){
            return null;
        }
        return implode(", ", $array);
    }

    /**
     * Attribute: media_ids
     * @return string
     */
    public function getMediaIdsAttribute(){
        $array = $this->media()->pluck(Attributes::ID)->toArray();
        if(empty($array)){
            return null;
        }
        return implode(", ", $array);
    }

    /**
     * Attribute: benefits_ids
     * @return string
     */
    public function getBenefitsIdsAttribute(){
        return $this->package->benefits_ids;
    }

    /**
     * Attribute: reviews_ids
     * @return string
     */
    public function getReviewsIdsAttribute(){
        $array = $this->reviews()->pluck(Attributes::ID)->toArray();
        if(empty($array)){
            return null;
        }
        return implode(", ", $array);
    }

    /**
     * Attribute: formatted_cake
     * @return string
     */
    public function getFormattedCakeAttribute()
    {
        $cakes = $this->cakes()->get();
        $array = null;
        foreach ($cakes as $cake){
            $array[] = $cake->category_name . " - " . $cake->title;
        }
        if(empty($array)){
            return null;
        }
        return implode(", ", $array);
    }

    /**
     * Attribute: formatted_backdrop
     * @return string
     */
    public function getFormattedBackdropAttribute()
    {
        $backdrops = $this->backdrops()->get();
        $array = null;
        foreach ($backdrops as $backdrop) {
            $array[] = $backdrop->title . " backdrop";
        }
        if(empty($array)){
            return null;
        }
        return implode(", ", $array);
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
     * Scope: Sort By Latest
     * @param Builder $q
     * @return Builder
     */
    public function scopeSortByLatest($q){
        return $q->orderBy(Attributes::DATE)->orderBy(Attributes::TIME);
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
     * Relationships: Media
     * @return HasMany
     */
    public function media()
    {
        return $this->hasMany(Media::class, Attributes::SESSION_ID, Attributes::ID);
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
        return $this->belongsToMany(FamilyMember::class, Tables::SESSION_DETAILS, null, Attributes::VALUE, Attributes::ID)
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
