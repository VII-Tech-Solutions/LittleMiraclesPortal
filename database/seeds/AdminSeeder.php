<?php

use App\Constants\Attributes;
use App\Models\BackpackUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BackpackUser::createOrUpdate([
            Attributes::EMAIL => "webmaster@viitech.net",
            Attributes::PASSWORD => "123abC--",
            Attributes::NAME => "VII Tech Admin"
        ], [
            Attributes::EMAIL
        ]);
    }
}
