<?php


namespace App\Models\Relationships;


use App\Constants\Attributes;
use App\Constants\Tables;
use App\Models\FamilyInfoQuestion;
use App\Models\StudioPackage;
use App\Models\User;

/**
 * Trait TypeRelationship
 * @package App\Models\Relationships
 */
trait UserStudioSpecsRelationship
{
    public function user()
    {
        return $this->belongsTo(User::Class, Attributes::USER_ID)->withTrashed();
    }
    public function studio_package()
    {
        return $this->belongsTo(StudioPackage::Class, Attributes::STUDIO_PACKAGE_ID);
    }
}
