<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Tables;
use App\Constants\Attributes;

class AddDiscountPriceToSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::SESSIONS, function (Blueprint $table) {
            $table->float(Attributes::DISCOUNT_PRICE)->nullable();
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
            $table->dropColumn(Attributes::DISCOUNT_PRICE);
        });
    }
}
