<?php
use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\QuestionType;
use App\Models\FamilyInfoQuestion;

use Illuminate\Database\Seeder;

class FamilyInfoQuestionSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Question 1
        FamilyInfoQuestion::createOrUpdate([
            Attributes::QUESTION =>"What types of images are most important to you?",
            Attributes::QUESTION_TYPE =>QuestionType::MULTIPLE,
            Attributes::OPTIONS =>"Individuals,Siblings Together,Family,Interaction",
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::QUESTION]
        );

        //Question 2
        FamilyInfoQuestion::createOrUpdate([
            Attributes::QUESTION =>"What is your favorite thing to do as a family?",
            Attributes::QUESTION_TYPE =>QuestionType::TEXT,
            Attributes::OPTIONS => null,
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::QUESTION]
        );

        //Question 3
        FamilyInfoQuestion::createOrUpdate([
            Attributes::QUESTION =>"Would you say that you prefer color, b/w, or both?",
            Attributes::QUESTION_TYPE =>QuestionType::MULTIPLE,
            Attributes::OPTIONS => "Color Photos,Black & White Photos",
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::QUESTION]
        );

        //Question 4
        FamilyInfoQuestion::createOrUpdate([
            Attributes::QUESTION =>"What types of images are most important to you?",
            Attributes::QUESTION_TYPE =>QuestionType::MULTIPLE,
            Attributes::OPTIONS => "Large Display Portraits,Wall Galleries With a Series of Portraits,Small Gift Prints (8x10 and Under),Session Album or Book,Custom Cards or Announcements",
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::QUESTION]
        );

        //Question 5
        FamilyInfoQuestion::createOrUpdate([
            Attributes::QUESTION =>"What room(s) are you interested in hanging a wall portrait or portrait display?",
            Attributes::QUESTION_TYPE =>QuestionType::TEXT,
            Attributes::OPTIONS => null,
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::QUESTION]
        );

        //Question 6
        FamilyInfoQuestion::createOrUpdate([
            Attributes::QUESTION =>"What do you hope to convey to your children through these images?",
            Attributes::QUESTION_TYPE =>QuestionType::TEXT,
            Attributes::OPTIONS => null,
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::QUESTION]
        );

        //Question 7
        FamilyInfoQuestion::createOrUpdate([
            Attributes::QUESTION =>"Additional Comments:",
            Attributes::QUESTION_TYPE =>QuestionType::TEXT,
            Attributes::OPTIONS => null,
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::QUESTION]
        );

    }
}
