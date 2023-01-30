<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Appointment
 *
 * @property integer session_id
 * @property integer user_id
 * @property string date
 * @property string time
 * @property Session session
 * @property User user
 */
class Appointment extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::APPOINTMENTS;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::SESSION_ID,
        Attributes::DATE,
        Attributes::TIME,
        Attributes::USER_ID,
    ];

    /**
     * Relationship: session
     * @return BelongsTo
     */
    function session(): BelongsTo
    {
        return $this->belongsTo(Session::class, Attributes::SESSION_ID, Attributes::ID);
    }

    /**
     * Relationship: user
     * @return BelongsTo
     */
    function user(): BelongsTo
    {
        return $this->belongsTo(User::class, Attributes::USER_ID, Attributes::ID);
    }
}
