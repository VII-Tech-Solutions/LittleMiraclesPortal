<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::ORDERS, function (Blueprint $table) {
            $table->bigIncrements(Attributes::ID);
            $table->string(Attributes::PROMO_CODE)->nullable();
            $table->double(Attributes::TOTAL_PRICE)->nullable();
            $table->double(Attributes::DISCOUNT_PRICE)->nullable();
            $table->integer(Attributes::STATUS)->default(1);
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
        Schema::dropIfExists(Tables::ORDERS);
    }
}
