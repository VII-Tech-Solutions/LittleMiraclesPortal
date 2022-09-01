<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFirebaseIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::USERS, function (Blueprint $table) {
            $table->string(Attributes::FIREBASE_ID)->nullable();
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
            $table->dropColumn(Attributes::FIREBASE_ID);
        });
    }
}
