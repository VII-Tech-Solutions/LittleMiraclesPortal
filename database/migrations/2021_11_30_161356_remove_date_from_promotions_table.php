<?php

use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Tables;


class RemoveDateFromPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::PROMOTIONS, function (Blueprint $table) {
            if (Schema::hasColumn(Tables::PROMOTIONS, Attributes::DATE)) {
                $table->dropColumn(Attributes::DATE);
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
            if (!Schema::hasColumn(Tables::PROMOTIONS, Attributes::DATE)) {
                $table->string(Attributes::DATE)->nullable();
            }
        });
    }
}
