<?php
use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Gender;
use App\Constants\Relationship;
use App\Models\FamilyMember;

use Illuminate\Database\Seeder;

class FamilyMemberSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FamilyMember::createOrUpdate([
            Attributes::FIRST_NAME =>"Hanan",
            Attributes::LAST_NAME =>"Baseem",
            Attributes::GENDER =>Gender::FEMALE,
            Attributes::USER_ID => 1,
            Attributes::FAMILY_ID => 1,
            Attributes::BIRTH_DATE => "1999-12-30",
            Attributes::RELATIONSHIP=> Relationship::PARTNER,
            Attributes::STATUS => Status::ACTIVE,
        ]);
        FamilyMember::createOrUpdate([
            Attributes::FIRST_NAME =>"Hamad",
            Attributes::LAST_NAME =>"Jumaan",
            Attributes::GENDER =>Gender::MALE,
            Attributes::USER_ID => 1,
            Attributes::FAMILY_ID => 1,
            Attributes::BIRTH_DATE => "2020-02-20",
            Attributes::RELATIONSHIP=> Relationship::CHILDREN,
            Attributes::STATUS => Status::ACTIVE,
        ]);
        FamilyMember::createOrUpdate([
            Attributes::FIRST_NAME =>"Haleena",
            Attributes::LAST_NAME =>"Jumaan",
            Attributes::GENDER =>Gender::FEMALE,
            Attributes::USER_ID => 1,
            Attributes::FAMILY_ID => 1,
            Attributes::BIRTH_DATE => "2021-11-21",
            Attributes::RELATIONSHIP=> Relationship::CHILDREN,
            Attributes::STATUS => Status::ACTIVE,
        ]);
    }
}
