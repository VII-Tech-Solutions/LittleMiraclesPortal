<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Models\Backdrop;
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
        Backdrop::createOrUpdate([
            Attributes::TITLE => "Balloons",
            Attributes::CATEGORY_ID => 1,
            Attributes::IMAGE => "storage/uploads/backdrops/yGpG1bAZGdredW6P.png",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

        Backdrop::createOrUpdate([
            Attributes::TITLE => "Blue Confetti",
            Attributes::CATEGORY_ID => 1,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

        Backdrop::createOrUpdate([
            Attributes::TITLE => "Marble",
            Attributes::CATEGORY_ID => 1,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

        Backdrop::createOrUpdate([
            Attributes::TITLE => "Clouds",
            Attributes::CATEGORY_ID => 2,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

        Backdrop::createOrUpdate([
            Attributes::TITLE => "Pastel Rainbow",
            Attributes::CATEGORY_ID => 2,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

        Backdrop::createOrUpdate([
            Attributes::TITLE => "Pink Sparkles",
            Attributes::CATEGORY_ID => 2,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

        Backdrop::createOrUpdate([
            Attributes::TITLE => "Halloween",
            Attributes::CATEGORY_ID => 3,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

        Backdrop::createOrUpdate([
            Attributes::TITLE => "Peaceful Meadow",
            Attributes::CATEGORY_ID => 3,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

        Backdrop::createOrUpdate([
            Attributes::TITLE => "Yellow House",
            Attributes::CATEGORY_ID => 3,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

    }
}
