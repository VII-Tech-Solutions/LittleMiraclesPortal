<?php

use App\Constants\Attributes;
use App\Models\SocialMedia;
use App\Constants\Status;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SocialMedia::createOrUpdate([
            Attributes::TITLE => "Instagram",
            Attributes::LINK => "https://www.instagram.com/littlemiraclesbys/",
            Attributes::IMAGE => "https://i.picsum.photos/id/684/200/200.jpg?hmac=Al0pymCRQr_mB6OlD9xW3UsgmSKDgnNPq2JLj3_CfUY",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::LINK
        ]);

        SocialMedia::createOrUpdate([
            Attributes::TITLE => "Facebook",
            Attributes::LINK => "https://www.facebook.com/littlemiraclesbys/",
            Attributes::IMAGE => "https://i.picsum.photos/id/684/200/200.jpg?hmac=Al0pymCRQr_mB6OlD9xW3UsgmSKDgnNPq2JLj3_CfUY",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::LINK
        ]);

        SocialMedia::createOrUpdate([
            Attributes::TITLE => "Twitter",
            Attributes::LINK => "https://twitter.com/littlemiracless",
            Attributes::IMAGE => "https://i.picsum.photos/id/684/200/200.jpg?hmac=Al0pymCRQr_mB6OlD9xW3UsgmSKDgnNPq2JLj3_CfUY",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::LINK
        ]);

        SocialMedia::createOrUpdate([
            Attributes::TITLE => "Pinterest",
            Attributes::LINK => "https://www.pinterest.com/littlemiraclesbys/",
            Attributes::IMAGE => "https://i.picsum.photos/id/684/200/200.jpg?hmac=Al0pymCRQr_mB6OlD9xW3UsgmSKDgnNPq2JLj3_CfUY",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::LINK
        ]);

        SocialMedia::createOrUpdate([
            Attributes::TITLE => "Youtube",
            Attributes::LINK => "https://www.youtube.com/channel/UCK2M5iUpBDotM7qO329GHHQ",
            Attributes::IMAGE => "https://i.picsum.photos/id/684/200/200.jpg?hmac=Al0pymCRQr_mB6OlD9xW3UsgmSKDgnNPq2JLj3_CfUY",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::LINK
        ]);

        SocialMedia::createOrUpdate([
            Attributes::TITLE => "Snapchat",
            Attributes::LINK => "https://www.snapchat.com/add/little.miracles",
            Attributes::IMAGE => "https://i.picsum.photos/id/684/200/200.jpg?hmac=Al0pymCRQr_mB6OlD9xW3UsgmSKDgnNPq2JLj3_CfUY",
            Attributes::STATUS => Status::ACTIVE,
        ], [
            Attributes::TITLE,Attributes::LINK
        ]);
    }
}
