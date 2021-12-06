<?php
use App\Constants\Attributes;
use App\Constants\SessionStatus;
use App\Constants\Status;
use App\Models\Session;



use Illuminate\Database\Seeder;

class SessionSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Session::createOrUpdate([
            Attributes::SESSION_STATUS => SessionStatus::BOOKED,
            Attributes::TITLE => "Baby Plan",
            Attributes::USER_ID => 1,
            Attributes::FAMILY_ID =>1,
            Attributes::PACKAGE_ID => 5,
            Attributes::CUSTOM_BACKDROP => "Unicorn",
            Attributes::CUSTOM_CAKE => "Unicorn pink color cake ",
            Attributes::COMMENTS => "The session theme should be having only pink and white color for the baby after being born",
            Attributes::TOTAL_PRICE => 650,
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::PACKAGE_ID ,Attributes::USER_ID]
        );

    }
}
