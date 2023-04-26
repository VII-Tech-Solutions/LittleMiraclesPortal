<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Tables;
use App\Constants\Attributes;

class AddDetailsToSubPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::SUB_PACKAGES, function (Blueprint $table) {
            $table->longText(Attributes::DETAILS)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Tables::SUB_PACKAGES, function (Blueprint $table) {
            $table->dropColumn(Attributes::DETAILS);
        });
    }
}
