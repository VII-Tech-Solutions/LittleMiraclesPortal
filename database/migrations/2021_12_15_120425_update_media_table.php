<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable(Tables::MEDIA)) {
            Schema::table(Tables::MEDIA, function (Blueprint $table) {
                $table->bigInteger(Attributes::PACKAGE_ID)->nullable();
                $table->bigInteger(Attributes::SESSION_ID)->nullable();
                $table->bigInteger(Attributes::FAMILY_ID)->nullable();
                $table->bigInteger(Attributes::USER_ID)->nullable();
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
        if (Schema::hasTable(Tables::MEDIA)) {
            Schema::table(Tables::MEDIA, function (Blueprint $table) {
                $table->dropColumn(Attributes::PACKAGE_ID);
                $table->dropColumn(Attributes::SESSION_ID);
                $table->dropColumn(Attributes::FAMILY_ID);
                $table->dropColumn(Attributes::USER_ID);
            });
        }
    }
}
