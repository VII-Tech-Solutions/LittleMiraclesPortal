<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Models\Onboarding;
use Illuminate\Database\Seeder;

class OnboardingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Onboarding::createOrUpdate([
            Attributes::TITLE => "Capture Special Moments",
            Attributes::CONTENT => "Get professional portraits and capture those special moments with your little miracles. They’re only little for a little while.",
            Attributes::ORDER => 1,
            Attributes::IMAGE => "storage/uploads/onboarding/xD51Z2hSVJxBalRd.jpg",
            Attributes::STATUS => Status::ACTIVE,
        ]);

        Onboarding::createOrUpdate([
            Attributes::TITLE => "The right milestones",
            Attributes::CONTENT => "Make every milestone count. From maternity, to welcoming your newborn, to their 1st birthday. Find the right package to capture these milestones.",
            Attributes::ORDER => 2,
            Attributes::IMAGE => "storage/uploads/onboarding/78S7cvoejRfIhFhs.jpg",
            Attributes::STATUS => Status::ACTIVE,
        ]);

        Onboarding::createOrUpdate([
            Attributes::TITLE => "Book in seconds",
            Attributes::CONTENT => "We’ll stay in touch with you as your due date approaches to fit you in at the perfect time. Book your session in advance and we’ll take care of the rest.",
            Attributes::ORDER => 3,
            Attributes::IMAGE => "storage/uploads/onboarding/5rh9mWr4oT4idBEk.jpg",
            Attributes::STATUS => Status::ACTIVE,
        ]);
    }
}
