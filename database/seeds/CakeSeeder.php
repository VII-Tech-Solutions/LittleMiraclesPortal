<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Models\Cake;
use Illuminate\Database\Seeder;

class CakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cake::createOrUpdate([
            Attributes::TITLE => "Blue",
            Attributes::CATEGORY_ID => 1,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

        Cake::createOrUpdate([
            Attributes::TITLE => "Pink",
            Attributes::CATEGORY_ID => 1,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

        Cake::createOrUpdate([
            Attributes::TITLE => "White",
            Attributes::CATEGORY_ID => 1,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

        Cake::createOrUpdate([
            Attributes::TITLE => "Blue Petals",
            Attributes::CATEGORY_ID => 2,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

        Cake::createOrUpdate([
            Attributes::TITLE => "Pink Petals",
            Attributes::CATEGORY_ID => 2,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

        Cake::createOrUpdate([
            Attributes::TITLE => "Yellow Petals",
            Attributes::CATEGORY_ID => 2,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

        Cake::createOrUpdate([
            Attributes::TITLE => "Blue Rosette",
            Attributes::CATEGORY_ID => 3,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

        Cake::createOrUpdate([
            Attributes::TITLE => "Pink Rosette",
            Attributes::CATEGORY_ID => 3,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

        Cake::createOrUpdate([
            Attributes::TITLE => "Purple Rosette",
            Attributes::CATEGORY_ID => 3,
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::CATEGORY_ID
        ]);

    }
}
