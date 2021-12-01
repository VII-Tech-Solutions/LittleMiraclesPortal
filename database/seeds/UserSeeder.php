<?php
use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Gender;
use App\Models\User;

use Illuminate\Database\Seeder;

class UserSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            User::createOrUpdate([
                Attributes::FIRST_NAME =>"Hamad",
                Attributes::LAST_NAME =>"Jumaan",
                Attributes::EMAIL =>"Hamad_Jumman@gmail.com",
                Attributes::PHONE_NUMBER =>"33954625",
                Attributes::COUNTRY_CODE =>"00973",
                Attributes::GENDER =>Gender::MALE,
                Attributes::FAMILY_ID => 1,
                Attributes::BIRTH_DATE => "1996-10-04",
                Attributes::PROVIDER => "Hamad_Jumaan",
                Attributes::AVATAR =>"https://i.picsum.photos/id/684/200/200.jpg?hmac=Al0pymCRQr_mB6OlD9xW3UsgmSKDgnNPq2JLj3_CfUY",
                Attributes::PAST_EXPERIENCE =>"Nothing",
                Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::EMAIL ,Attributes::FAMILY_ID,
        ]);
    }
}
