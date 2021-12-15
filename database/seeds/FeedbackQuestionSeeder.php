<?php

use App\Constants\Attributes;
use App\Constants\QuestionType;
use App\Constants\Status;
use App\Models\FeedbackQuestion;
use Illuminate\Database\Seeder;

class FeedbackQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FeedbackQuestion::createOrUpdate([
            Attributes::QUESTION => "Name",
            Attributes::QUESTION_TYPE => QuestionType::TEXT,
            Attributes::OPTIONS => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::QUESTION
        ]);

        FeedbackQuestion::createOrUpdate([
            Attributes::QUESTION => "What did you enjoy most about working with Little Miracles by Sherin?",
            Attributes::QUESTION_TYPE => QuestionType::TEXT,
            Attributes::OPTIONS => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::QUESTION
        ]);

        FeedbackQuestion::createOrUpdate([
            Attributes::QUESTION => "What was your reason for visiting us?",
            Attributes::QUESTION_TYPE => QuestionType::MULTIPLE,
            Attributes::OPTIONS => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::QUESTION
        ]);

        FeedbackQuestion::createOrUpdate([
            Attributes::QUESTION => "How was your overall experience?",
            Attributes::QUESTION_TYPE => QuestionType::TEXT,
            Attributes::OPTIONS => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::QUESTION
        ]);

        FeedbackQuestion::createOrUpdate([
            Attributes::QUESTION => "Did the image quality meet your expectations? If not, please explain.",
            Attributes::QUESTION_TYPE => QuestionType::TEXT,
            Attributes::OPTIONS => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::QUESTION
        ]);

        FeedbackQuestion::createOrUpdate([
            Attributes::QUESTION => "How was communication throughout the sessions and were we able to answer all of your questions thoroughly?",
            Attributes::QUESTION_TYPE => QuestionType::TEXT,
            Attributes::OPTIONS => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::QUESTION
        ]);

        FeedbackQuestion::createOrUpdate([
            Attributes::QUESTION => "Were you comfortable working with us? If not, please explain.",
            Attributes::QUESTION_TYPE => QuestionType::TEXT,
            Attributes::OPTIONS => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::QUESTION
        ]);

        FeedbackQuestion::createOrUpdate([
            Attributes::QUESTION => "Would you recommend Little Miracles to a friend?",
            Attributes::QUESTION_TYPE => QuestionType::MULTIPLE,
            Attributes::OPTIONS => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::QUESTION
        ]);

        FeedbackQuestion::createOrUpdate([
            Attributes::QUESTION => "We welcome any suggestions you may have, so please let us know if there is anything we can do to enhance your future visits:",
            Attributes::QUESTION_TYPE => QuestionType::TEXT,
            Attributes::OPTIONS => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::QUESTION
        ]);
    }
}
