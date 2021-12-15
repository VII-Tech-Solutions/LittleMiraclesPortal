<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Models\Photographer;
use Illuminate\Database\Seeder;

class PhotographerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Photographer::createOrUpdate([
            Attributes::NAME => "Sherin",
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::NAME
        ]);

        Photographer::createOrUpdate([
            Attributes::NAME => "Noni",
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::NAME
        ]);

        Photographer::createOrUpdate([
            Attributes::NAME => "Zahra",
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::NAME
        ]);

        Photographer::createOrUpdate([
            Attributes::NAME => "Marjan",
            Attributes::IMAGE => "",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::NAME
        ]);
    }
}
