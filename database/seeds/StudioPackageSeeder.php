<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Models\StudioPackage;
use Illuminate\Database\Seeder;

class StudioPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudioPackage::createOrUpdate([
            Attributes::TITLE => "photo Albums",
            Attributes::IMAGE => "https://i.picsum.photos/id/684/200/200.jpg?hmac=Al0pymCRQr_mB6OlD9xW3UsgmSKDgnNPq2JLj3_CfUY",
            Attributes::STARTING_PRICE => 100,
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::TITLE ]
        );

        StudioPackage::createOrUpdate([
            Attributes::TITLE => "Canvas Prints",
            Attributes::IMAGE => "https://i.picsum.photos/id/684/200/200.jpg?hmac=Al0pymCRQr_mB6OlD9xW3UsgmSKDgnNPq2JLj3_CfUY",
            Attributes::STARTING_PRICE => 12,
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::TITLE ]
        );

        StudioPackage::createOrUpdate([
            Attributes::TITLE => "Photo Paper",
            Attributes::IMAGE => "https://i.picsum.photos/id/684/200/200.jpg?hmac=Al0pymCRQr_mB6OlD9xW3UsgmSKDgnNPq2JLj3_CfUY",
            Attributes::STARTING_PRICE => 10,
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::TITLE ]
        );

    }
}
