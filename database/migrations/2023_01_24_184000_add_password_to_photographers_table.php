<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Tables;
use App\Constants\Attributes;
class AddPasswordToPhotographersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::PHOTOGRAPHERS, function (Blueprint $table) {
            $table->string(Attributes::PASSWORD)->nullable();
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
            $table->dropColumn(Attributes::PASSWORD);
        });
    }
}
