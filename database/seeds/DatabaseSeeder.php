<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AdminSeeder::class);
         $this->call(StudioMetadataSeeder::class);
         $this->call(FaqSeeder::class);
         $this->call(SocialMediaSeeder::class);
    }
}
