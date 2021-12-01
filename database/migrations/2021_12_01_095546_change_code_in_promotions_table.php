<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCodeInPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::PROMOTIONS, function (Blueprint $table) {
            if (Schema::hasColumn(Tables::PROMOTIONS, Attributes::CODE)) {
                $table->dropColumn(Attributes::CODE);
                $table->string(Attributes::PROMO_CODE)->nullable();
            }
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
            if (Schema::hasColumn(Tables::PROMOTIONS, Attributes::PROMO_CODE)) {
                $table->dropColumn(Attributes::PROMO_CODE);
                $table->string(Attributes::CODE)->nullable();
            }
        });
    }
}
