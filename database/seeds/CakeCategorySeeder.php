<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Models\CakeCategory;
use Illuminate\Database\Seeder;

class CakeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CakeCategory::createOrUpdate([
            Attributes::NAME => "Naked Cake",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::NAME
        ]);

        CakeCategory::createOrUpdate([
            Attributes::NAME => "Petals Cake",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::NAME
        ]);

        CakeCategory::createOrUpdate([
            Attributes::NAME => "Rosette Cake",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::NAME
        ]);
    }
}
