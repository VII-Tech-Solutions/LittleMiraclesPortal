<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::ORDER_ITEMS, function (Blueprint $table) {
            $table->bigIncrements(Attributes::ID);
            $table->integer(Attributes::ORDER_ID)->nullable();
            $table->integer(Attributes::ITEM_ID)->nullable();
            $table->integer(Attributes::USER_ID)->nullable();
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
        Schema::dropIfExists(Tables::ORDER_ITEMS);
    }
}
