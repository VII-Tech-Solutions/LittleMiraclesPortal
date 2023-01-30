<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndoorAllowedToPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::PACKAGES, function (Blueprint $table) {
            $table->boolean(Attributes::INDOOR_ALLOWED)->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Tables::PACKAGES, function (Blueprint $table) {
            $table->dropColumn(Attributes::INDOOR_ALLOWED);
        });
    }
}
