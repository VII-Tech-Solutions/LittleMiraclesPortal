<?php

use App\Constants\Attributes;
use App\Models\Page;
use App\Constants\Status;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::createOrUpdate([
            Attributes::TITLE => "About Us",
            Attributes::CONTENT => "Hello!

                        Our photography takes a colorful and whimsical approach to capturing your little miracles. From all of those special firsts to those adorable little moments that make you smile, we at Little Miracles capture the milestones of life.

                        It is an honor and a joy to meet you and we can’t wait to capture your little miracles.


                        XOXO,
                        LMS Team",
            Attributes::SLUG => "about-us",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE
        ]);

        Page::createOrUpdate([
            Attributes::TITLE => "Terms",
            Attributes::CONTENT => "Terms!",
            Attributes::SLUG => "terms",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE
        ]);

        Page::createOrUpdate([
            Attributes::TITLE => "Privacy",
            Attributes::CONTENT => "Privacy!",
            Attributes::SLUG => "privacy",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE
        ]);
    }
}
