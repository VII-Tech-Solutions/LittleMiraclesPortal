<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\QuestionType;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ModelTrait;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Feedback Questions
 * @property string question
 * @property int session_status
 * @property int question_type
 */
class FeedbackQuestion extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::FEEDBACK_QUESTION;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::QUESTION,
        Attributes::QUESTION_TYPE,
        Attributes::OPTIONS,
        Attributes::STATUS
    ];


    protected $casts = [
        Attributes::QUESTION => CastingTypes::STRING,
        Attributes::OPTIONS => CastingTypes::STRING,
    ];

    protected $appends = [
        Attributes::STATUS_NAME,
        Attributes::QUESTION_TYPE_NAME,
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
}
