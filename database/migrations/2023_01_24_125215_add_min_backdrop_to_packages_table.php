<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinBackdropToPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::PACKAGES, function (Blueprint $table) {
            $table->integer(Attributes::MIN_BACKDROP)->nullable();
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
            $table->dropColumn(Attributes::MIN_BACKDROP);
        });
    }
}
