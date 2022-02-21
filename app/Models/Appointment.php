<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ModelTrait;

/**
 * Appointment
 *
 * @property integer session_id
 * @property integer user_id
 * @property string date
 * @property string time
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


}
