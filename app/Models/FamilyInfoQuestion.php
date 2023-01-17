<?php


namespace App\Models;

use App\API\Transformers\FamilyInfoQuestionOptionTransformer;
use App\Constants\Attributes;
use App\Constants\QuestionType;
use App\Constants\Tables;
use App\Traits\ModelTrait;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Family Info Questions
 * @property int session_status
 * @property int question_type
 */
class FamilyInfoQuestion extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::FAMILY_INFO_QUESTIONS;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::QUESTION,
        Attributes::QUESTION_TYPE,
        Attributes::OPTIONS,
        Attributes::ORDER,
        Attributes::STATUS
    ];


    protected $casts = [
        Attributes::QUESTION =>CastingTypes::STRING,
        Attributes::OPTIONS =>CastingTypes::STRING,
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
        Attributes::QUESTION_TYPE_NAME,
        Attributes::OPTIONS_ARRAY,
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
     * Get Attribute: question_type_name
     * @return string
     */
    public function getQuestionTypeNameAttribute()
    {
        $text = QuestionType::getKey($this->question_type);
        return Helpers::readableText($text);
    }

    /**
     * Get Attribute: options array
     * @param $value
     * @return array
     */
    public function getOptionsArrayAttribute()
    {
        $options = $this->answers()->get();

        if(empty($options) || $this->question_type == QuestionType::TEXT){
            return null;
        }


        return self::returnTransformedItems($options, FamilyInfoQuestionOptionTransformer::class);

    }

    /**
     * Relationships: Answers
     * @return mixed
     */
    public function answers()
    {
        return $this->hasMany(FamilyInfoQuestionOption::class, Attributes::QUESTION_ID, Attributes::ID);
    }

}

