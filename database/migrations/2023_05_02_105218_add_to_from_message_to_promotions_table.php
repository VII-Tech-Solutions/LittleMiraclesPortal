<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Tables;
use App\Constants\Attributes;
class AddToFromMessageToPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::PROMOTIONS, function (Blueprint $table) {
            $table->string(Attributes::TO)->nullable();
            $table->string(Attributes::FROM)->nullable();
            $table->string(Attributes::MESSAGE)->nullable();
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
            $table->dropColumn(Attributes::TO);
            $table->dropColumn(Attributes::FROM);
            $table->dropColumn(Attributes::MESSAGE);
        });
    }
}
