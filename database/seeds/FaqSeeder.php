<?php

use App\Constants\Attributes;
use App\Models\Faq;
use App\Constants\Status;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Faq::createOrUpdate([
            Attributes::QUESTION => "When To Book Your Maternity Session?",
            Attributes::ANSWER => "Maternity Shoots Are Scheduled Close To Your 30-week Mark, Once The Baby Bump Starts To Show :)",
            Attributes::CREATED_AT => "2021-12-1",
            Attributes::UPDATED_AT => "2021-12-1",
            Attributes::STATUS => Status::ACTIVE,
            ]);

        Faq::createOrUpdate([
            Attributes::QUESTION => "When To Book Your Newborn Session?",
            Attributes::ANSWER => "The best time to schedule is while you are still pregnant so that we can set the date when the baby would be under 2 weeks of age. The best time to capture sleepy, curly newborn portraits is from 1-10 days of life under two weeks of age,",
            Attributes::CREATED_AT => "2021-12-1",
            Attributes::UPDATED_AT => "2021-12-1",
            Attributes::STATUS => Status::ACTIVE,
            ]);

        Faq::createOrUpdate([
            Attributes::QUESTION => "What Is The Best Time For Baby Portraits?",
            Attributes::ANSWER => "6-10 months is the best age to capture your baby’s big personality as they’re sitting up and smiling.",
            Attributes::CREATED_AT => "2021-12-1",
            Attributes::UPDATED_AT => "2021-12-1",
            Attributes::STATUS => Status::ACTIVE,
            ]);

        Faq::createOrUpdate([
            Attributes::QUESTION => "How Long Will Your Session Take?",
            Attributes::ANSWER => "Maternity sessions usually are 30 minutes to an hour. Newborn sessions can take up to 3 hours, allowing enough time for feeding and comforting. Babies, children, and family are from 30 minutes to 1.5 hours.",
            Attributes::CREATED_AT => "2021-12-1",
            Attributes::UPDATED_AT => "2021-12-1",
            Attributes::STATUS => Status::ACTIVE,
            ]);

        Faq::createOrUpdate([
            Attributes::QUESTION => "What Is The Booking Process?",
            Attributes::ANSWER => "1. Complete the questionnaire for first time clients
                                   2. Sign the contract before every session
                                   3. Make the session fee payment
                                   4. Schedule the pre-session consultation - go over all the details!",
            Attributes::CREATED_AT => "2021-12-1",
            Attributes::UPDATED_AT => "2021-12-1",
            Attributes::STATUS => Status::ACTIVE,
            ]);

        Faq::createOrUpdate([
            Attributes::QUESTION => "What To Wear?",
            Attributes::ANSWER => "Every client is encouraged to bring any type of clothing they feel comfortable in, or welcome to browse through the studio collection. Our style lends itself to a soft color palette of whites, creams, and hues of soft pink and blue. You will find a variety of soft and delivate sleepers, rompers, dresses, headbands, and beautiful baby wraps. This is discussed in more details during the pre-session consultation at our studio or over the phone. We will discuss your ideas for the shoot, the best wardrobe to compliment your ideas, and how to prepare for the session.",
            Attributes::CREATED_AT => "2021-12-1",
            Attributes::UPDATED_AT => "2021-12-1",
            Attributes::STATUS => Status::ACTIVE,
            ]);

        Faq::createOrUpdate([
            Attributes::QUESTION => "How Do I Download My Files?",
            Attributes::ANSWER => "Once you have completed a session with us, it will show up on your home feed. Select the session you would like to see the photos of and click on download.",
            Attributes::CREATED_AT => "2021-12-1",
            Attributes::UPDATED_AT => "2021-12-1",
            Attributes::STATUS => Status::ACTIVE,
            ]);

        Faq::createOrUpdate([
            Attributes::QUESTION => "Do You Offer A Gift Registry?",
            Attributes::ANSWER => "Yes, gift certificates are the perfect present for expecting families! Please contact us for more info.",
            Attributes::CREATED_AT => "2021-12-1",
            Attributes::UPDATED_AT => "2021-12-1",
            Attributes::STATUS => Status::ACTIVE,
            ]);
    }
}
