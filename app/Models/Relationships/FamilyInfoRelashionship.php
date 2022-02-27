<?php


namespace App\Models\Relationships;


use App\Constants\Attributes;
use App\Constants\Tables;
use App\Models\FamilyInfoQuestion;
use App\Models\User;

/**
 * Trait TypeRelationship
 * @package App\Models\Relationships
 */
trait FamilyInfoRelashionship
{
    public function user()
    {
        return $this->belongsTo(User::Class, Attributes::USER_ID);
    }
    public function question()
    {
        return $this->belongsTo(FamilyInfoQuestion::Class, Attributes::QUESTION_ID);
    }
}
