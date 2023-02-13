<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFirebaseIdAndDeviceTokenToPhotographersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::PHOTOGRAPHERS, function (Blueprint $table) {
            $table->string(Attributes::FIREBASE_ID)->nullable();
            $table->longText(Attributes::DEVICE_TOKEN)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Tables::PHOTOGRAPHERS, function (Blueprint $table) {
            $table->dropColumn(Attributes::FIREBASE_ID);
            $table->dropColumn(Attributes::DEVICE_TOKEN);
        });
    }
}
