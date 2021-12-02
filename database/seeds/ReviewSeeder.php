<?php
use App\Constants\Attributes;
use App\Constants\SessionStatus;
use App\Constants\Status;
use App\Models\Review;



use Illuminate\Database\Seeder;

class ReviewSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Review::createOrUpdate([
            Attributes::RATING => 5,
            Attributes::USER_NAME => "Hamad Jumaan",
            Attributes::USER_IMAGE => "https://i.picsum.photos/id/684/200/200.jpg?hmac=Al0pymCRQr_mB6OlD9xW3UsgmSKDgnNPq2JLj3_CfUY",
            Attributes::USER_ID => 1,
            Attributes::PACKAGE_ID => 5,
            Attributes::SESSION_ID => 1,
            Attributes::COMMENT => "My wife's maternity shoot was amazing, cant wait for the rest sessions",
            Attributes::POSTED_AT => "2022-10-20",
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::USER_ID ,Attributes::SESSION_ID]
        );

    }
}
