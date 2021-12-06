<?php

namespace App\Models;

use App\API\Transformers\UserTransformer;
use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ImageTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * User
 * @property string first_name
 * @property string last_name
 * @property string avatar
 * @property int gender
 *
 */
class User extends CustomModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Notifiable, Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail, HasApiTokens, CrudTrait,ImageTrait;

    protected $table = Tables::USERS;
    public const DIRECTORY = "uploads/users";
    const TRANSFORMER_NAME = UserTransformer::class;

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
        Attributes::COUNTRY_CODE,
        Attributes::BIRTH_DATE,
        Attributes::PROVIDER,
        Attributes::AVATAR,
        Attributes::FAMILY_ID,
        Attributes::PROVIDER_ID,
        Attributes::PROVIDER,
        Attributes::USERNAME,
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
        Attributes::PROVIDER => CastingTypes::STRING,
        Attributes::AVATAR => CastingTypes::STRING,
        Attributes::PAST_EXPERIENCE => CastingTypes::STRING,
        Attributes::FAMILY_ID => CastingTypes::INTEGER,
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
        Attributes::GENDER_NAME
    ];

    /**
     * Get Attribute: status_name
     * @param $value
     * @return string
     */
    public function getStatusNameAttribute($value)
    {
        $text = Status::getKey($this->status);
        return Helpers::readableText($text);
    }

    /**
     * Get Attribute: gender_name
     * @param $value
     * @return string
     */
    public function getGenderNameAttribute($value)
    {
        if($this->gender === 1){
            return "Male";
        }
        else{
            return "Female";
        }
    }

    /**
     * Get avatar Attribute
     * @param $value
     * @return string|null
     */
    function getAvatarAttribute($value){
        return $this->getImage($value);
    }

    /**
     * Set Attribute: Avatar
     * @param $value
     */
    public function setAvatarAttribute($value)
    {
        if(Str::startsWith($value, "http")){
            $this->attributes[Attributes::AVATAR] = $value;
            return;
        }
        if(!is_null($value)){
            $path = Helpers::uploadFile($this, $value, Attributes::AVATAR, self::DIRECTORY, true, false, true);
            $this->attributes[Attributes::AVATAR] = "storage/" . $path;
        }else{
            $this->attributes[Attributes::AVATAR] = null;
        }
    }
}
