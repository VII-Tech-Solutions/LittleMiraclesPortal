<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Tables;
use App\Constants\Attributes;
class AddPromotionIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::ORDERS, function (Blueprint $table) {
            $table->integer(Attributes::PROMO_ID)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Tables::ORDERS, function (Blueprint $table) {
            $table->dropColumn(Attributes::PROMO_ID);
        });
    }
}
