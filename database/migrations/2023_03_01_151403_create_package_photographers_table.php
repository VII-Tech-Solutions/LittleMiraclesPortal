<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagePhotographersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::PACKAGE_PHOTOGRAPHERS, function (Blueprint $table) {
            $table->bigIncrements(Attributes::ID);
            $table->integer(Attributes::PACKAGE_ID)->nullable();
            $table->integer(Attributes::SUB_PACKAGE_ID)->nullable();
            $table->integer(Attributes::PHOTOGRAPHER_ID)->nullable();
            $table->double(Attributes::ADDITIONAL_CHARGE)->nullable();
            $table->integer(Attributes::STATUS)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Tables::PACKAGE_PHOTOGRAPHERS);
    }
}
