<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Promotion::createOrUpdate([
            Attributes::TITLE => "Your First Photoshoot",
            Attributes::OFFER => "",
            Attributes::TYPE => "",
            Attributes::POSTED_AT => "2021-08-01",
            Attributes::VALID_UNTIL => "2021-12-21",
            Attributes::CONTENT => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Venenatis urna cursus eget nunc scelerisque viverra mauris in. ",
            Attributes::PROMO_CODE => "MINIME123",
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE
        ]);
    }
}
