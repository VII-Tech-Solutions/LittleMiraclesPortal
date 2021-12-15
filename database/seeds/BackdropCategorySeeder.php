<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Models\BackdropCategory;
use Illuminate\Database\Seeder;

class BackdropCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BackdropCategory::createOrUpdate([
            Attributes::NAME => "Backdrop type 1 - Boy",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::NAME
        ]);

        BackdropCategory::createOrUpdate([
            Attributes::NAME => "Backdrop type 2 - Girl",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::NAME
        ]);

        BackdropCategory::createOrUpdate([
            Attributes::NAME => "Backdrop type 3 - Neutral",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::NAME
        ]);
    }
}
