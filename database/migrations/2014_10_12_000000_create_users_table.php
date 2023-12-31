<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::USERS, function (Blueprint $table) {
            $table->bigIncrements(Attributes::ID);
            $table->string(Attributes::FIRST_NAME);
            $table->string(Attributes::LAST_NAME);
            $table->string(Attributes::PHONE_NUMBER)->nullable();
            $table->string(Attributes::EMAIL)->nullable();
            $table->timestamp(Attributes::VERIFIED_AT)->nullable();
            $table->string(Attributes::PASSWORD)->nullable();
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
        Schema::dropIfExists(Tables::USERS);
    }
}
