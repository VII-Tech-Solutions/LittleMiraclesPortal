<?php


namespace App\Models;

use App\Constants\Attributes;
use App\Constants\QuestionType;
use App\Constants\SessionStatus;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ModelTrait;
use phpseclib\Math\BigInteger;
use VIITech\Helpers\Constants\CastingTypes;

/**
 * Family Info FamilyInfoQuestionOption
 * @property BigInteger id
 * @property string value
 * @property integer order
 * @property BigInteger question_id
 */
class FamilyInfoQuestionOption extends CustomModel
{
    use ModelTrait;

    protected $table = Tables::FAMILY_INFO_QUESTION_OPTIONS;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::VALUE,
        Attributes::QUESTION_ID
    ];

}

