<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Feedback
 *
 * @property Session session
 * @property User user
 */
class Feedback extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::FEEDBACK;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::QUESTION_ID,
        Attributes::USER_ID,
        Attributes::FAMILY_ID,
        Attributes::PACKAGE_ID,
        Attributes::SESSION_ID,
        Attributes::ANSWER,
        Attributes::STATUS
    ];

    protected $casts = [
        Attributes::QUESTION_ID => CastingTypes::INTEGER,
        Attributes::USER_ID => CastingTypes::INTEGER,
        Attributes::FAMILY_ID => CastingTypes::INTEGER,
        Attributes::PACKAGE_ID => CastingTypes::INTEGER,
        Attributes::SESSION_ID => CastingTypes::INTEGER,
        Attributes::ANSWER => CastingTypes::STRING,
        Attributes::STATUS => CastingTypes::INTEGER,
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
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
     * Get session_name Attribute
     * @return null
     */
    public function getSessionNameAttribute(){
        $session = $this->session;
        if(is_null($session)){
            return "-";
        }
        return $session->title;
    }

    /**
     * Relationship: Session
     * @return BelongsTo
     */
    function session(): BelongsTo
    {
        return $this->belongsTo(Session::class, Attributes::SESSION_ID);
    }

    /**
     * Relationship: User
     * @return BelongsTo
     */
    function user(): BelongsTo
    {
        return $this->belongsTo(User::class, Attributes::USER_ID);
    }
}
