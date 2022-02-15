<?php

namespace App\Models;

use App\API\Transformers\FamilyInfoTransformer;
use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ModelTrait;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Family Information
 * @property int session_status
 * @property int gender
 * @property int relationship
 */
class FamilyInfo extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::FAMILY_INFO;
    const TRANSFORMER_NAME = FamilyInfoTransformer::class;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::FAMILY_ID,
        Attributes::USER_ID,
        Attributes::QUESTION_ID,
        Attributes::ANSWER,
        Attributes::STATUS
    ];


    protected $casts = [
        Attributes::ANSWER => CastingTypes::STRING,
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
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


}


