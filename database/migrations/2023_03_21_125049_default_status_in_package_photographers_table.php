<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DefaultStatusInPackagePhotographersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::PACKAGE_PHOTOGRAPHERS, function (Blueprint $table) {
            $table->integer(Attributes::STATUS)->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Tables::PACKAGE_PHOTOGRAPHERS, function (Blueprint $table) {
            $table->integer(Attributes::STATUS)->nullable()->change();

        });
    }
}
