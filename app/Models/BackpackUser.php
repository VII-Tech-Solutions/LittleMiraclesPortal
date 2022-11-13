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
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class BackpackUser extends CustomModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Notifiable, Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail, HasApiTokens, CrudTrait;

    protected $table = Tables::ADMIN_USERS;

    protected $fillable = [
        Attributes::NAME,
        Attributes::EMAIL,
        Attributes::PASSWORD,
        Attributes::PHOTOGRAPHER_ID
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
     * Set Password Attribute
     * @param $value
     */
    function setPasswordAttribute($value){
        if(!empty($value) && Hash::needsRehash($value)){
            $this->attributes[Attributes::PASSWORD] = Hash::make($value);
        }
    }
}
