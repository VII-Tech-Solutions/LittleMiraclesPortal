<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Roles;
use App\Constants\Tables;
use App\Traits\ImageTrait;
use App\Traits\ModelTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Photographer
 *
 * @property string name
 * @property string email
 * @property string password
 * @property integer role
 * @property int additional_charge
 * @property int priority
 * @property string image
 * @property string firebase_id
 * @property string device_token
 */
class Photographer extends CustomModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use ModelTrait, ImageTrait, Authenticatable, Authorizable, HasApiTokens, CanResetPassword, MustVerifyEmail;

    public const DIRECTORY = "uploads/photographers";
    protected $table = Tables::PHOTOGRAPHERS;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::NAME,
        Attributes::EMAIL,
        Attributes::PASSWORD,
        Attributes::ROLE,
        Attributes::IMAGE,
        Attributes::ACCESS_TOKEN,
        Attributes::STATUS,
        Attributes::PRIORITY,
        Attributes::ADDITIONAL_CHARGE,
        Attributes::FIREBASE_ID,
        Attributes::DEVICE_TOKEN
    ];

    protected $casts = [
        Attributes::NAME => CastingTypes::STRING,
        Attributes::STATUS => CastingTypes::INTEGER,
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
        Attributes::ROLE_NAME
    ];

    protected $hidden = [
        Attributes::PASSWORD,
        Attributes::ACCESS_TOKEN
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
     * Get Attribute: image
     * @param $value
     * @return string|null
     */
    function getImageAttribute($value)
    {
        return $this->getImage($value);
    }

    /**
     * Set Attribute: image
     * @param $value
     */
    public function setImageAttribute($value)
    {
        $this->setImage($value);
    }

    /**
     * Attribute: role name
     * @param $value
     * @return string
     */
    function getRoleNameAttribute($value) {
        $role_name = Roles::getKey($this->role);
        return Helpers::readableText($role_name);
    }

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
