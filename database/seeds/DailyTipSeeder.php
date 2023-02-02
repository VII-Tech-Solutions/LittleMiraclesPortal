<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Models\DailyTip;
use Illuminate\Database\Seeder;

class DailyTipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DailyTip::createOrUpdate([
            Attributes::IMAGE => "",
            Attributes::TITLE => "Welcome to Little Miracles",
            Attributes::POSTED_AT => "2021-08-01",
            Attributes::CONTENT => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Venenatis urna cursus eget nunc scelerisque viverra mauris in. Viverra suspendisse potenti nullam ac tortor vitae. Nibh tellus molestie nunc non. Urna et pharetra pharetra massa massa ultricies mi. Id interdum velit laoreet id donec. Amet nisl purus in mollis. Gravida in fermentum et sollicitudin ac orci phasellus egestas. Hendrerit dolor magna eget est lorem ipsum dolor sit amet. Fringilla phasellus faucibus scelerisque eleifend donec. Dictumst quisque sagittis purus sit amet volutpat consequat. Nibh sit amet commodo nulla facilisi. Ut venenatis tellus in metus. Posuere urna nec tincidunt praesent semper feugiat nibh sed. In eu mi bibendum neque egestas. Felis imperdiet proin fermentum leo vel. Id leo in vitae turpis massa sed elementum tempus. Erat nam at lectus urna duis convallis. Pulvinar elementum integer enim neque volutpat ac tincidunt vitae semper.
                                    Elementum sagittis vitae et leo duis ut. Cum sociis natoque penatibus et magnis. Volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque. Commodo odio aenean sed adipiscing diam donec adipiscing tristique risus. Id neque aliquam vestibulum morbi blandit cursus risus at ultrices. Tristique risus nec feugiat in fermentum posuere urna nec. Nibh tortor id aliquet lectus proin nibh. Nullam ac tortor vitae purus faucibus ornare. Leo integer malesuada nunc vel risus commodo viverra maecenas accumsan. Tincidunt eget nullam non nisi est sit amet.
                                    Feugiat nibh sed pulvinar proin. Dolor magna eget est lorem. Suscipit tellus mauris a diam. Porttitor leo a diam sollicitudin tempor id eu. Amet massa vitae tortor condimentum lacinia quis vel eros donec. Vitae sapien pellentesque habitant morbi tristique senectus. Tempor nec feugiat nisl pretium fusce id velit ut. Tincidunt augue interdum velit euismod in pellentesque. Facilisis sed odio morbi quis commodo odio aenean sed. Venenatis urna cursus eget nunc. Est velit egestas dui id. Congue mauris rhoncus aenean vel elit scelerisque mauris.",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE
        ]);
    }
}
