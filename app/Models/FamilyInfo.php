<?php

namespace App\Models;

use App\API\Transformers\FamilyInfoTransformer;
use App\Constants\Attributes;
use App\Constants\Tables;
use App\Models\Relationships\FamilyInfoRelashionship;
use App\Traits\ModelTrait;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Family Information
 * @property int session_status
 * @property int gender
 * @property int relationship
 * @property string answer
 */
class FamilyInfo extends CustomModel
{
    use ModelTrait, FamilyInfoRelashionship;

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
        Attributes::ANSWER_TEXT
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
     * Attribute: Answer Text
     * @param $value
     * @return string|null
     */
    function getAnswerTextAttribute($value)
    {
        $answer = $this->answer;
        $answer_text = null;
        if (preg_match("/[a-z]/i", $answer)) {
            return $answer;
        }

        $answer_options = explode(",",$answer);
        foreach ($answer_options as $option) {
            /** @var FamilyInfoQuestionOption $option_text */
            $option_text = FamilyInfoQuestionOption::find(trim($option)) ?? null;
            if (!is_null($answer_text) && !is_null($option_text)) {
                $answer_text .= ", ";
            }
            $answer_text .= $option_text->value ?? (trim($option));
        }

        // return answer text
        return $answer_text;
    }
}


