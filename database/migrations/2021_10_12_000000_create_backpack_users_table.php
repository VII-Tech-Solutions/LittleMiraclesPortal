<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackpackUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::ADMIN_USERS, function (Blueprint $table) {
            $table->bigIncrements(Attributes::ID);
            $table->string(Attributes::NAME);
            $table->string(Attributes::EMAIL)->unique();
            $table->string(Attributes::PASSWORD);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Tables::ADMIN_USERS);
    }
}
