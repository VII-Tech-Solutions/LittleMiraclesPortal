<?php
use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnboardingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable(Tables::ONBOARDING)) {
            Schema::create(Tables::ONBOARDING, function (Blueprint $table) {
                // Generic Attributes
                $table->bigIncrements(Attributes::ID);
                $table->integer(Attributes::STATUS)->default(Status::ACTIVE);
                $table->timestamps();
                $table->softDeletes();

                // Specific Attributes
                $table->string(Attributes::TITLE)->nullable();
                $table->text(Attributes::CONTENT)->nullable();
                $table->string(Attributes::IMAGE)->nullable();
                $table->integer(Attributes::ORDER)->nullable()->default(1);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Tables::ONBOARDING);
    }
}
