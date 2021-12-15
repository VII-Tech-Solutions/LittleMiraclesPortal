<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::createOrUpdate([
            Attributes::TITLE => "Paypal",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE
        ]);

        PaymentMethod::createOrUpdate([
            Attributes::TITLE => "Apple pay",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE
        ]);

        PaymentMethod::createOrUpdate([
            Attributes::TITLE => "Debit card",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE
        ]);

        PaymentMethod::createOrUpdate([
            Attributes::TITLE => "Credit card",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE
        ]);
    }
}
