<?php

use App\Constants\Attributes;
use App\Constants\PromotionType;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGiftsColumnInSessionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable(Tables::SESSIONS)) {
            Schema::table(Tables::SESSIONS, function (Blueprint $table) {
                if(!Schema::hasColumn(Tables::SESSIONS, Attributes::GIFT_CLAIMED)){
                    $table->boolean(Attributes::GIFT_CLAIMED)->default(false)->nullable();
                }
            });
        }

        if (Schema::hasTable(Tables::PROMOTIONS)) {
            Schema::table(Tables::PROMOTIONS, function (Blueprint $table) {
                if(!Schema::hasColumn(Tables::PROMOTIONS, Attributes::SESSION_ID)){
                    $table->bigInteger(Attributes::SESSION_ID)->nullable();
                }
                if(!Schema::hasColumn(Tables::PROMOTIONS, Attributes::PACKAGE_ID)){
                    $table->bigInteger(Attributes::PACKAGE_ID)->nullable();
                }
                if(!Schema::hasColumn(Tables::PROMOTIONS, Attributes::USER_ID)){
                    $table->bigInteger(Attributes::USER_ID)->nullable();
                }
                if(Schema::hasColumn(Tables::PROMOTIONS, Attributes::TYPE)){

                }
                $table->dropColumn(Attributes::TYPE);
            });
        }

        if (Schema::hasTable(Tables::SESSION_PACKAGES)) {
            Schema::table(Tables::SESSION_PACKAGES, function (Blueprint $table) {
                if(!Schema::hasColumn(Tables::SESSION_PACKAGES, Attributes::FIVE_SESSIONS_GIFT)){
                    $table->boolean(Attributes::FIVE_SESSIONS_GIFT)->default(false)->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable(Tables::SESSIONS)) {
            Schema::table(Tables::SESSIONS, function (Blueprint $table) {
                $table->dropColumn(Attributes::GIFT_CLAIMED);
            });
        }
        if (Schema::hasTable(Tables::PROMOTIONS)) {
            Schema::table(Tables::PROMOTIONS, function (Blueprint $table) {
                $table->dropColumn(Attributes::USER_ID);
                $table->dropColumn(Attributes::SESSION_ID);
                $table->dropColumn(Attributes::PACKAGE_ID);
                $table->dropColumn(Attributes::TYPE);
            });
        }
        if (Schema::hasTable(Tables::SESSION_PACKAGES)) {
            Schema::table(Tables::SESSION_PACKAGES, function (Blueprint $table) {
                $table->dropColumn(Attributes::FIVE_SESSIONS_GIFT);
            });
        }
    }
}
