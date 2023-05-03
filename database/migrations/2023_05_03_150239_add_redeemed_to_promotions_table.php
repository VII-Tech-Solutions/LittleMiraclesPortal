<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Tables;
use App\Constants\Attributes;
class AddRedeemedToPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::PROMOTIONS, function (Blueprint $table) {
            $table->boolean(Attributes::REDEEMED)->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Tables::PROMOTIONS, function (Blueprint $table) {
            $table->dropColumn(Attributes::REDEEMED);
        });
    }
}
