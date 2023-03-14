<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PackagePhotographer
 * @package App\Models
 *
 * @property int id
 * @property int package_id
 * @property int sub_package_id
 * @property int photographer_id
 * @property double additional_charge
 * @property int status
 * @property Package package
 * @property SubPackage subpackage
 * @property Photographer photographer
 */
class PackagePhotographer extends CustomModel
{
    protected $table = Tables::PACKAGE_PHOTOGRAPHERS;
    protected $fillable = [
        Attributes::PACKAGE_ID,
        Attributes::SUB_PACKAGE_ID,
        Attributes::PHOTOGRAPHER_ID,
        Attributes::ADDITIONAL_CHARGE,
        Attributes::STATUS
    ];
    protected $appends = [
        Attributes::PHOTOGRAPHER_NAME,
        Attributes::PHOTOGRAPHER_IMAGE
    ];

    /**
     * Relationships: package
     * @return BelongsTo
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, Attributes::PACKAGE_ID, Attributes::ID);
    }

    /**
     * Relationships: sub package
     * @return BelongsTo
     */
    public function subpackage(): BelongsTo
    {
        return $this->belongsTo(SubPackage::class, Attributes::SUB_PACKAGE_ID, Attributes::ID);
    }

    /**
     * Relationships: photographer
     * @return BelongsTo
     */
    public function photographer(): BelongsTo
    {
        return $this->belongsTo(Photographer::class, Attributes::PHOTOGRAPHER_ID, Attributes::ID);
    }


    /**
     * Attribute: photographer name
     * @return string|null
     */
    public function getPhotographerNameAttribute()
    {
        /** @var Photographer $photographer */
        $photographer = $this->photographer()->first();
        if (is_null($photographer)) {
            return null;
        }
        return $photographer->name;
    }

    /**
     * Attribute: photographer name
     * @return string|null
     */
    public function getPhotographerImageAttribute()
    {
        /** @var Photographer $photographer */
        $photographer = $this->photographer()->first();
        if (is_null($photographer)) {
            return null;
        }
        return $photographer->image;
    }
}
