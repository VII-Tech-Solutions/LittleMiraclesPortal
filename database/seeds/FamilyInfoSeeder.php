<?php
use App\Constants\Attributes;
use App\Constants\Status;
use App\Models\FamilyInfo;


use Illuminate\Database\Seeder;

class FamilyInfoSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Question 1
        FamilyInfo::createOrUpdate([
            Attributes::USER_ID => 1,
            Attributes::FAMILY_ID => 1,
            Attributes::QUESTION_ID =>1,
            Attributes::ANSWER => "Siblings Together",
            Attributes::STATUS => Status::ACTIVE,
        ]);

        //Question 2
        FamilyInfo::createOrUpdate([
            Attributes::USER_ID => 1,
            Attributes::FAMILY_ID => 1,
            Attributes::QUESTION_ID =>2,
            Attributes::ANSWER => "Have an outdoor breakfast on the beach then build sand castles",
            Attributes::STATUS => Status::ACTIVE,
        ]);

        //Question 3
        FamilyInfo::createOrUpdate([
            Attributes::USER_ID => 1,
            Attributes::FAMILY_ID => 1,
            Attributes::QUESTION_ID =>3,
            Attributes::ANSWER => "Color Photos",
            Attributes::STATUS => Status::ACTIVE,
        ]);

        //Question 4
        FamilyInfo::createOrUpdate([
            Attributes::USER_ID => 1,
            Attributes::FAMILY_ID => 1,
            Attributes::QUESTION_ID =>4,
            Attributes::ANSWER => "Large Display Portraits,Session Album or Book",
            Attributes::STATUS => Status::ACTIVE,
        ]);

        //Question 5
        FamilyInfo::createOrUpdate([
            Attributes::USER_ID => 1,
            Attributes::FAMILY_ID => 1,
            Attributes::QUESTION_ID =>5,
            Attributes::ANSWER => "Bedroom and Leaving room",
            Attributes::STATUS => Status::ACTIVE,
        ]);

        //Question 6
        FamilyInfo::createOrUpdate([
            Attributes::USER_ID => 1,
            Attributes::FAMILY_ID => 1,
            Attributes::QUESTION_ID =>6,
            Attributes::ANSWER => "Family is the most portions gift a person can get",
            Attributes::STATUS => Status::ACTIVE,
        ]);


    }
}
