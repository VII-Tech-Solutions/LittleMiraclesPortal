<?php

use App\Constants\Attributes;
use App\Constants\GoToAction;
use App\Constants\IsFeatured;
use App\Constants\SectionTypes;
use App\Constants\Status;
use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Section::createOrUpdate([
            Attributes::TITLE => "Welcome to Little Miracles",
            Attributes::IMAGE => "storage/uploads/sections/difTmJLiwLxuhv1D.jpg",
            Attributes::CONTENT => "Check out our photo session packages to get you started",
            Attributes::TYPE => SectionTypes::HEADER,
            Attributes::ACTION_TEXT => "Unicorn",
            Attributes::GO_TO => GoToAction::LOGIN,
            Attributes::IS_FEATURED => IsFeatured::FALSE,
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::TITLE ]
        );

        Section::createOrUpdate([
            Attributes::TITLE => "Made for you",
            Attributes::IMAGE => "https://littlemiracles.viitech.net/storage/uploads/sections/XlDRktUAx2fq1ZBf.jpg",
            Attributes::CONTENT => "Browse our packages and find the perfect fit for you and your little miracles",
            Attributes::TYPE => SectionTypes::CARD,
            Attributes::ACTION_TEXT => "See Packages",
            Attributes::GO_TO => GoToAction::PACKAGES,
            Attributes::IS_FEATURED => IsFeatured::TRUE,
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::TITLE]
        );

        Section::createOrUpdate([
            Attributes::TITLE => "Make it memorable",
            Attributes::IMAGE => "https://littlemiracles.viitech.net/storage/uploads/sections/yPaW6gf9bKbFMMIZ.jpg",
            Attributes::CONTENT => "Get a customized photo album or prints to go with your sessions",
            Attributes::TYPE => SectionTypes::CARD,
            Attributes::ACTION_TEXT => "See Prints",
            Attributes::GO_TO => GoToAction::STUDIO,
            Attributes::IS_FEATURED => IsFeatured::FALSE,
            Attributes::STATUS => Status::ACTIVE,
        ],
            [Attributes::TITLE]
        );
    }
}
