<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Roles;
use App\Constants\Tables;
use App\Traits\ImageTrait;
use App\Traits\ModelTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Laravel\Passport\HasApiTokens;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Photographer
 *
 * @property string name
 * @property string email
 * @property integer role
 * @property int additional_charge
 */
class Photographer extends CustomModel implements AuthenticatableContract, AuthorizableContract
{
    use ModelTrait, ImageTrait, Authenticatable, Authorizable, HasApiTokens;

    public const DIRECTORY = "uploads/photographers";
    protected $table = Tables::PHOTOGRAPHERS;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::NAME,
        Attributes::EMAIL,
        Attributes::ROLE,
        Attributes::IMAGE,
        Attributes::STATUS,
        Attributes::ADDITIONAL_CHARGE
    ];

    protected $casts = [
        Attributes::NAME => CastingTypes::STRING,
        Attributes::STATUS => CastingTypes::INTEGER,
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
        Attributes::ROLE_NAME
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

}
