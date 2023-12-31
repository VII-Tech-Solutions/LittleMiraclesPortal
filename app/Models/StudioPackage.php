<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\StudioPackageTypes;
use App\Constants\Tables;
use App\Traits\ImageTrait;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Class StudioMetadata
 * @package App\Models
 *
 * @property integer id
 * @property integer title
 * @property integer image
 * @property integer description
 * @property string category
 * @property float starting_price
 * @property integer status
 */
class StudioPackage extends CustomModel
{
    use ImageTrait, ModelTrait;

    public const DIRECTORY = "uploads/studio_packages";
    protected $table = Tables::STUDIO_PACKAGES;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::TITLE,
        Attributes::STARTING_PRICE,
        Attributes::IMAGE,
        Attributes::STATUS,
        Attributes::TYPE,
    ];

    protected $casts = [
        Attributes::TITLE => CastingTypes::STRING,
        Attributes::STARTING_PRICE => 'decimal:3',
        Attributes::IMAGE => CastingTypes::STRING,
        Attributes::STATUS => CastingTypes::INTEGER,
        Attributes::TYPE => CastingTypes::INTEGER,
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
        Attributes::MEDIA_IDS,
        Attributes::BENEFITS_IDS,
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
     * Get Attribute: Type_name
     * @param $value
     * @return string
     */
    public function getTypeNameAttribute($value)
    {
        $text = StudioPackageTypes::getKey($this->type);
        return Helpers::readableText($text);
    }

    /**
     * Get image Attribute
     * @param $value
     * @return string|null
     */
    function getImageAttribute($value)
    {
        return $this->getImage($value);
    }

    /**
     * Set Attribute: Image
     * @param $value
     */
    public function setImageAttribute($value)
    {
        $this->setImage($value);
    }

    /**
     * Relationships: Media
     * @return mixed
     */
    public function media()
    {
        return $this->belongsToMany(Media::class, Tables::STUDIO_PACKAGE_MEDIA, Attributes::STUDIO_PACKAGE_ID, Attributes::MEDIA_ID);
    }

    /**
     * Attribute: media_ids
     * @return string
     */
    public function getMediaIdsAttribute(){
        $array = $this->media()->pluck(Tables::MEDIA . "." . Attributes::ID)->toArray();
        $array = implode(",", $array);
        if(empty($array)){
            return null;
        }
        return $array;
    }


    /**
     * Relationships: Package Benefits
     * @return BelongsToMany
     */
    public function benefits()
    {
        return $this->belongsToMany(Benefit::class, Tables::STUDIO_PACKAGE_BENEFITS, Attributes::STUDIO_PACKAGE_ID, Attributes::BENEFIT_ID);
    }

    /**
     * Attribute: benefits_ids
     * @return string
     */
    public function getBenefitsIdsAttribute(){
        $array = $this->benefits()->pluck(Tables::BENEFITS . "." . Attributes::ID)->toArray();
        $array = implode(",", $array);
        if(empty($array)){
            return null;
        }
        return $array;
    }

}
