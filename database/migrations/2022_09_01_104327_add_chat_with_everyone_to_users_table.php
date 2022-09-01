<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChatWithEveryoneToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::USERS, function (Blueprint $table) {
            $table->boolean(Attributes::CHAT_WITH_EVERYONE)->default(false);
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
            $table->dropColumn(Attributes::CHAT_WITH_EVERYONE);

        });
    }
}
