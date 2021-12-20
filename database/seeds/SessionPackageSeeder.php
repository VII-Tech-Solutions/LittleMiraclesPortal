<?php
use App\Constants\Attributes;
use App\Constants\IsPopular;
use App\Constants\MediaType;
use App\Constants\SessionPackageTypes;
use App\Constants\Status;
use App\Models\Package;
use App\Models\Media;



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
        $TwinklePackage=Package::createOrUpdate([
            Attributes::IMAGE =>'assets/packages/Twinkle.jpeg',
            Attributes::TITLE =>"Twinkle",
            Attributes::TAG =>"Portrait Studio Session",
            Attributes::PRICE => 160,
            Attributes::IS_POPULAR =>IsPopular::YES,
            Attributes::TYPE =>SessionPackageTypes::NORMAL_SESSION,
            Attributes::CONTENT =>"Maternity, baby at least 6 months sitters or cakesmash",
            Attributes::LOCATION_TEXT =>"Villa 2178, Road 4565, Block 545, Saar Central Al Qurayyah",
            Attributes::LOCATION_LINK =>"https://goo.gl/maps/hsnjmaH44YCbHQceA",
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::TITLE]
        );
        $this->imageExample($TwinklePackage);


        //Sparkle Package
        $SparklePackage=Package::createOrUpdate([
            Attributes::IMAGE =>'assets/packages/Sparkle.jpeg',
            Attributes::TITLE =>"Sparkle",
            Attributes::TAG =>"Family Portrait Studio Session",
            Attributes::PRICE => 260,
            Attributes::IS_POPULAR =>IsPopular::NO,
            Attributes::TYPE =>SessionPackageTypes::NORMAL_SESSION,
            Attributes::CONTENT =>"Maternity, baby at least 3 months or 6 months sitters or cakesmash",
            Attributes::LOCATION_TEXT =>"Villa 2178, Road 4565, Block 545, Saar Central Al Qurayyah",
            Attributes::LOCATION_LINK =>"https://goo.gl/maps/hsnjmaH44YCbHQceA",
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::TITLE]
        );
        $this->imageExample($SparklePackage);


        //Glimmer Package
        $GlimmerPackage=Package::createOrUpdate([
            Attributes::IMAGE =>'assets/packages/Glimmer.jpeg',
            Attributes::TITLE =>"Glimmer",
            Attributes::TAG =>"Newborn Studio Session",
            Attributes::PRICE => 360,
            Attributes::IS_POPULAR =>IsPopular::NO,
            Attributes::TYPE =>SessionPackageTypes::NORMAL_SESSION,
            Attributes::CONTENT =>"Baby less than 2 weeks or up to two months",
            Attributes::LOCATION_TEXT =>"Villa 2178, Road 4565, Block 545, Saar Central Al Qurayyah",
            Attributes::LOCATION_LINK =>"https://goo.gl/maps/hsnjmaH44YCbHQceA",
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::TITLE]
        );
        $this->imageExample($GlimmerPackage);

        //Shimmer Package
        $ShimmerPackage=Package::createOrUpdate([
            Attributes::IMAGE =>'assets/packages/Shimmer.jpeg',
            Attributes::TITLE =>"Shimmer",
            Attributes::TAG =>"Studio/Outdoor Session",
            Attributes::PRICE => 310,
            Attributes::IS_POPULAR =>IsPopular::NO,
            Attributes::TYPE =>SessionPackageTypes::NORMAL_SESSION,
            Attributes::CONTENT => null,
            Attributes::LOCATION_TEXT =>"Villa 2178, Road 4565, Block 545, Saar Central Al Qurayyah",
            Attributes::LOCATION_LINK =>"https://goo.gl/maps/hsnjmaH44YCbHQceA",
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::TITLE]
        );
        $this->imageExample($ShimmerPackage);


        //Baby Plan Package
        $BabyPackage=Package::createOrUpdate([
            Attributes::IMAGE =>'assets/packages/BabyPlan.jpeg',
            Attributes::TITLE =>"Baby Plan",
            Attributes::TAG =>"4 memorable milestone sessions",
            Attributes::PRICE => 650,
            Attributes::IS_POPULAR =>IsPopular::NO,
            Attributes::TYPE =>SessionPackageTypes::MULTIPLE_SESSIONS,
            Attributes::CONTENT => "Includes 4 memorable milestone sessions:",
            Attributes::LOCATION_TEXT =>"Villa 2178, Road 4565, Block 545, Saar Central Al Qurayyah",
            Attributes::LOCATION_LINK =>"https://goo.gl/maps/hsnjmaH44YCbHQceA",
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::TITLE]
        );
        $this->imageExample($BabyPackage);


        //Mini Session Package
        $Minipackage=Package::createOrUpdate([
            Attributes::IMAGE =>'assets/packages/MiniSession.jpeg',
            Attributes::TITLE =>"Mini Session",
            Attributes::TAG =>"Monthly Promotion",
            Attributes::PRICE => 80,
            Attributes::IS_POPULAR =>IsPopular::NO,
            Attributes::TYPE =>SessionPackageTypes::MINI_SESSION,
            Attributes::CONTENT => null,
            Attributes::LOCATION_TEXT =>"Villa 2178, Road 4565, Block 545, Saar Central Al Qurayyah",
            Attributes::LOCATION_LINK =>"https://goo.gl/maps/hsnjmaH44YCbHQceA",
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::TITLE]
        );

        $this->imageExample($Minipackage);


    }


    function imageExample($package){

        Media::createOrUpdate([
            Attributes::URL =>'assets/media/media.jpeg',
            Attributes::TYPE =>MediaType::IMAGE,
            Attributes::PACKAGE_ID => $package->id,
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::URL,Attributes::PACKAGE_ID]
        );

        Media::createOrUpdate([
            Attributes::URL =>'assets/media/media2.jpeg',
            Attributes::TYPE =>MediaType::IMAGE,
            Attributes::PACKAGE_ID => $package->id,
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::URL,Attributes::PACKAGE_ID]
        );

        Media::createOrUpdate([
            Attributes::URL =>'assets/media/media3.jpeg',
            Attributes::TYPE =>MediaType::IMAGE,
            Attributes::PACKAGE_ID => $package->id,
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::URL,Attributes::PACKAGE_ID]
        );

        Media::createOrUpdate([
            Attributes::URL =>'assets/media/media4.jpeg',
            Attributes::TYPE =>MediaType::IMAGE,
            Attributes::PACKAGE_ID => $package->id,
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::URL,Attributes::PACKAGE_ID]
        );
    }

}
