<?php


namespace App\Models;

use App\Constants\Attributes;
use App\Constants\QuestionType;
use App\Constants\SessionStatus;
use App\Constants\Tables;
use App\Helpers;
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
     * Get Attribute: question_type
     * @param $value
     * @return string
     */
    public function getQuestionTypeNameAttribute($value)
    {
        if($this->question_type === 1){
            return "Text";
        }
        else{
            return "Multiple Select";
        }
    }

    /**
     * Get Attribute: options array
     * @param $value
     * @return array
     */
    public function getOptionsArrayAttribute()
    {
        $options = json_decode($this->options);

        if(empty($options) || $this->question_type == QuestionType::TEXT){
            return null;
        }

       $array = [

       [    "id"=> 1,
        "value"=> "Text"],

           [    "id"=> 2,
               "value"=> "Text"],

           [    "id"=> 3,
               "value"=> "Text"]
       ];

        return $array;

    }




}

