<?php
use App\Constants\Attributes;
use App\Constants\IsPopular;
use App\Constants\SessionPackageTypes;
use App\Constants\Status;
use App\Models\SessionPackage;


use Illuminate\Database\Seeder;

class SessionPackageSeeder  extends Seeder
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
            Attributes::IMAGE =>"",
            Attributes::TITLE =>"Twinkle",
            Attributes::TAG =>"Portrait Studio Session",
            Attributes::PRICE => 160,
            Attributes::IS_POPULAR =>IsPopular::YES,
            Attributes::TYPE =>SessionPackageTypes::NORMAL_SESSION,
            Attributes::CONTENT =>"Maternity, baby at least 6 months sitters or cakesmash",
            Attributes::LOCATION_TEXT =>"Villa 2178, Road 4565, Block 545, Saar Central Al Qurayyah",
            Attributes::LOCATION_LINK =>"https://goo.gl/maps/hsnjmaH44YCbHQceA",
            Attributes::STATUS => Status::ACTIVE,
        ]);

        //Sparkle Package
        SessionPackage::createOrUpdate([
            Attributes::IMAGE =>"",
            Attributes::TITLE =>"Sparkle",
            Attributes::TAG =>"Family Portrait Studio Session",
            Attributes::PRICE => 260,
            Attributes::IS_POPULAR =>IsPopular::NO,
            Attributes::TYPE =>SessionPackageTypes::NORMAL_SESSION,
            Attributes::CONTENT =>"Maternity, baby at least 3 months or 6 months sitters or cakesmash",
            Attributes::LOCATION_TEXT =>"Villa 2178, Road 4565, Block 545, Saar Central Al Qurayyah",
            Attributes::LOCATION_LINK =>"https://goo.gl/maps/hsnjmaH44YCbHQceA",
            Attributes::STATUS => Status::ACTIVE,
        ]);

        //Glimmer Package
        SessionPackage::createOrUpdate([
            Attributes::IMAGE =>"",
            Attributes::TITLE =>"Glimmer",
            Attributes::TAG =>"Newborn Studio Session",
            Attributes::PRICE => 360,
            Attributes::IS_POPULAR =>IsPopular::NO,
            Attributes::TYPE =>SessionPackageTypes::NORMAL_SESSION,
            Attributes::CONTENT =>"Baby less than 2 weeks or up to two months",
            Attributes::LOCATION_TEXT =>"Villa 2178, Road 4565, Block 545, Saar Central Al Qurayyah",
            Attributes::LOCATION_LINK =>"https://goo.gl/maps/hsnjmaH44YCbHQceA",
            Attributes::STATUS => Status::ACTIVE,
        ]);

        //Shimmer Package
        SessionPackage::createOrUpdate([
            Attributes::IMAGE =>"",
            Attributes::TITLE =>"Shimmer",
            Attributes::TAG =>"Studio/Outdoor Session",
            Attributes::PRICE => 310,
            Attributes::IS_POPULAR =>IsPopular::NO,
            Attributes::TYPE =>SessionPackageTypes::NORMAL_SESSION,
            Attributes::CONTENT => null,
            Attributes::LOCATION_TEXT =>"Villa 2178, Road 4565, Block 545, Saar Central Al Qurayyah",
            Attributes::LOCATION_LINK =>"https://goo.gl/maps/hsnjmaH44YCbHQceA",
            Attributes::STATUS => Status::ACTIVE,
        ]);

        //Baby Plan Package
        SessionPackage::createOrUpdate([
            Attributes::IMAGE =>"",
            Attributes::TITLE =>"Baby Plan",
            Attributes::TAG =>"4 memorable milestone sessions",
            Attributes::PRICE => 650,
            Attributes::IS_POPULAR =>IsPopular::NO,
            Attributes::TYPE =>SessionPackageTypes::MULTIPLE_SESSIONS,
            Attributes::CONTENT => "Includes 4 memorable milestone sessions:",
            Attributes::LOCATION_TEXT =>"Villa 2178, Road 4565, Block 545, Saar Central Al Qurayyah",
            Attributes::LOCATION_LINK =>"https://goo.gl/maps/hsnjmaH44YCbHQceA",
            Attributes::STATUS => Status::ACTIVE,
        ]);

        //Mini Session Package
        SessionPackage::createOrUpdate([
            Attributes::IMAGE =>"",
            Attributes::TITLE =>"Mini Session",
            Attributes::TAG =>"Monthly Promotion",
            Attributes::PRICE => 80,
            Attributes::IS_POPULAR =>IsPopular::NO,
            Attributes::TYPE =>SessionPackageTypes::MINI_SESSION,
            Attributes::CONTENT => null,
            Attributes::LOCATION_TEXT =>"Villa 2178, Road 4565, Block 545, Saar Central Al Qurayyah",
            Attributes::LOCATION_LINK =>"https://goo.gl/maps/hsnjmaH44YCbHQceA",
            Attributes::STATUS => Status::ACTIVE,
        ]);


    }
}
