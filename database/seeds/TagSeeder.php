<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::createOrUpdate([
            Attributes::TITLE => "TIPS & TRICKS",
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::TITLE ]
        );

        Tag::createOrUpdate([
            Attributes::TITLE => "PROMOTIONS",
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::TITLE ]
        );

    }
}
