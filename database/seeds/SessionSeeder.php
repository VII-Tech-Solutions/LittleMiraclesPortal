<?php
use App\Constants\Attributes;
use App\Constants\IsPopular;
use App\Constants\SessionPackageTypes;
use App\Constants\SessionStatus;
use App\Constants\Status;
use App\Models\SessionPackage;


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



        //Twinkle Package
        SessionPackage::createOrUpdate([
            Attributes::SESSION_STATUS => SessionStatus::BOOKED,
            Attributes::TITLE => " ",
            Attributes::USER_ID => ,
            Attributes::FAMILY_ID => ,
            Attributes::PACKAGE_ID => ,
            Attributes::CUSTOM_BACKDROP => ,
            Attributes::CUSTOM_CAKE => ,
            Attributes::COMMENTS => ,
            Attributes::TOTAL_PRICE => ,
            Attributes::STATUS => Status::ACTIVE,
        ]);


    }
}
