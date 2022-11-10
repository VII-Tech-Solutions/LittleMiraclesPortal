<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotographerIdToAvailableDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::AVAILABLE_DATES, function (Blueprint $table) {
            $table->integer(Attributes::PHOTOGRAPHER_ID)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Tables::AVAILABLE_DATES, function (Blueprint $table) {
            $table->dropColumn(Attributes::PHOTOGRAPHER_ID);
        });
    }
}
