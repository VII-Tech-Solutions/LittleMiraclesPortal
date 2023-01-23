<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExperienceColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::USERS, function (Blueprint $table) {
            $table->boolean(Attributes::PRO_PAST_EXPERIENCE)->nullable();
            $table->boolean(Attributes::HAPPY_PAST_EXPERIENCE)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Tables::USERS, function (Blueprint $table) {
            $table->dropColumn(Attributes::PRO_PAST_EXPERIENCE);
            $table->dropColumn(Attributes::HAPPY_PAST_EXPERIENCE);
        });
    }
}