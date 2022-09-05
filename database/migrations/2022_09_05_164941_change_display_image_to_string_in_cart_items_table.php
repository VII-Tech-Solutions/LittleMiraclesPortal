<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDisplayImageToStringInCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::CART_ITEMS, function (Blueprint $table) {
            $table->string(Attributes::DISPLAY_IMAGE)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Tables::CART_ITEMS, function (Blueprint $table) {
            $table->integer(Attributes::DISPLAY_IMAGE)->nullable()->change();
        });
    }
}
