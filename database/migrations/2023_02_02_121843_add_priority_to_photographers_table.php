<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriorityToPhotographersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::PHOTOGRAPHERS, function (Blueprint $table) {
            $table->integer(Attributes::PRIORITY)->nullable();
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
            $table->dropColumn(Attributes::PRIORITY);

        });
    }
}
