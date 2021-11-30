<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use VIITech\Helpers\Constants\CastingTypes;

class User extends CustomModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Notifiable, Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail, HasApiTokens, CrudTrait;

    protected $table = Tables::USERS;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        Attributes::FIRST_NAME,
        Attributes::LAST_NAME,
        Attributes::PASSWORD,
        Attributes::EMAIL,
        Attributes::PHONE_NUMBER,
        Attributes::GENDER,
        Attributes::USER_ID,
        Attributes::COUNTRY_CODE,
        Attributes::GENDER,
        Attributes::BIRTH_DATE,
        Attributes::PROVIDE,
        Attributes::AVATAR,
        Attributes::PAST_EXPERIENCE,
        Attributes::STATUS
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        Attributes::PASSWORD, Attributes::REMEMBER_TOKEN,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    protected $casts = [
        Attributes::VERIFIED_AT => 'datetime',
        Attributes::USER_ID => CastingTypes::INTEGER,
        Attributes::COUNTRY_CODE => CastingTypes::INTEGER,
        Attributes::GENDER => CastingTypes::STRING,
        Attributes::BIRTH_DATE => CastingTypes::STRING,
        Attributes::PROVIDE => CastingTypes::STRING,
        Attributes::AVATAR => CastingTypes::STRING,
        Attributes::PAST_EXPERIENCE => CastingTypes::STRING,
        Attributes::FAMILY_ID => CastingTypes::INTEGER,
    ];
}
