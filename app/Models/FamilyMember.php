<?php

namespace App\Models;

use App\API\Transformers\FamilyMemberTransformer;
use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ModelTrait;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Family Member
 * @property int session_status
 * @property int gender
 * @property int relationship
 */
class FamilyMember extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::FAMILY_MEMBERS;
    const TRANSFORMER_NAME = FamilyMemberTransformer::class;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::FIRST_NAME,
        Attributes::LAST_NAME,
        Attributes::GENDER,
        Attributes::BIRTH_DATE,
        Attributes::RELATIONSHIP,
        Attributes::FAMILY_ID,
        Attributes::USER_ID,
        Attributes::STATUS
    ];

    protected $casts = [
        Attributes::FIRST_NAME =>CastingTypes::STRING,
        Attributes::LAST_NAME =>CastingTypes::STRING,
        Attributes::USER_ID => CastingTypes::INTEGER,
        Attributes::FAMILY_ID => CastingTypes::INTEGER,
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
        Attributes::GENDER_NAME,
        Attributes::RELATIONSHIP_NAME
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
     * Get Attribute: relationship_name
     * @param $value
     * @return string
     */
    public function getRelationshipNameAttribute($value)
    {
        if($this->relationship === 1){
            return "Partner";
        }
        else{
            return "Children";
        }
    }


}
