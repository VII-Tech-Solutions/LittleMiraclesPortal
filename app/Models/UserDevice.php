<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class User Device
 * @package App\Models
 *
 * @property int user_id
 * @property string platform
 * @property string app_version
 * @property User user
 */
class UserDevice extends CustomModel
{

    protected $table = Tables::USER_DEVICES;
    protected $fillable = [
        Attributes::USER_ID,
        Attributes::PLATFORM,
        Attributes::APP_VERSION,
        Attributes::TOKEN
    ];

    /**
     * Relationship: User
     * @return BelongsTo
     */
    function user(){
        return $this->belongsTo(User::class, Attributes::USER_ID);
    }
}
