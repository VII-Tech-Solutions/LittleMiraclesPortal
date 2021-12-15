<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Models\Workshop;
use Illuminate\Database\Seeder;

class WorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Workshop::createOrUpdate([
            Attributes::IMAGE => "",
            Attributes::TITLE => "Family Photoshoot Workshop",
            Attributes::POSTED_AT => "2021-08-01",
            Attributes::CONTENT => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Venenatis urna cursus eget nunc scelerisque viverra mauris in. Viverra suspendisse potenti nullam ac tortor vitae. Nibh tellus molestie nunc non. posuere urna nec. Nibh tortor id aliquet lectus proin nibh. Nullam ac tortor vitae purus faucibus ornare. Leo integer malesuada nunc vel risus commodo viverra maecenas accumsan. Tincidunt eget nullam non nisi est sit amet.
                                    Feugiat nibh sed pulvinar proin. Dolor magna eget est lorem. Suscipit tellus mauris a diam. Porttitor leo a diam sollicitudin tempor id eu. Amet massa vitae tortor condimentum lacinia quis vel eros donec.",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE
        ]);
    }
}
