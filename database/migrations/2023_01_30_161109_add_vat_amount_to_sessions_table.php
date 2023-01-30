<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVatAmountToSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::SESSIONS, function (Blueprint $table) {
            $table->decimal(Attributes::VAT_AMOUNT)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Tables::SESSIONS, function (Blueprint $table) {
            $table->dropColumn(Attributes::VAT_AMOUNT);
        });
    }
}
