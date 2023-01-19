<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use App\Constants\Roles;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailRoleToPhotographersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::PHOTOGRAPHERS, function (Blueprint $table) {
            $table->string(Attributes::EMAIL)->nullable();
            $table->integer(Attributes::ROLE)->default(Roles::PHOTOGRAPHER);
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
            $table->dropColumn(Attributes::EMAIL);
            $table->dropColumn(Attributes::ROLE);
        });
    }
}
