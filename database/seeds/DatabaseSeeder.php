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
         $this->call(UserSeeder::class);
         $this->call(FaqSeeder::class);
         $this->call(SocialMediaSeeder::class);
         $this->call(PageSeeder::class);
         $this->call(FamilyMemberSeeder::class);
         $this->call(FamilyInfoQuestionSeeder::class);
         $this->call(FamilyInfoSeeder::class);
         $this->call(SessionPackageSeeder::class);
         $this->call(SessionSeeder::class);
         $this->call(ReviewSeeder::class);
         $this->call(OnboardingSeeder::class);
         $this->call(PhotographerSeeder::class);
         $this->call(CakeCategorySeeder::class);
         $this->call(CakeSeeder::class);
         $this->call(DailyTipSeeder::class);
         $this->call(BackdropCategorySeeder::class);
         $this->call(BackdropsSeeder::class);
         $this->call(PromotionSeeder::class);
         $this->call(FeedbackQuestionSeeder::class);
         $this->call(WorkshopSeeder::class);
         $this->call(TagSeeder::class);
         $this->call(SectionSeeder::class);
         $this->call(PaymentMethodSeeder::class);
    }
}
