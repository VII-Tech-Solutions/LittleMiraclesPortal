<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Models\Onboarding;
use Illuminate\Database\Seeder;

class BackdropsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Backdrop::createOrUpdate([
            Attributes::TITLE => "Balloons",
            Attributes::CATEGORY_ID => "Boy",
            Attributes::IMAGE => "storage/uploads/backdrops/yGpG1bAZGdredW6P.png",
            Attributes::STATUS => Status::ACTIVE,
        ]);


    }
}
