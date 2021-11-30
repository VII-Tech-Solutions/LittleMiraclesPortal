<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPostedAtAndValidUntilToPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable(Tables::PROMOTIONS)) {
            Schema::table(Tables::PROMOTIONS, function (Blueprint $table) {
                if (!Schema::hasColumn(Tables::PROMOTIONS, Attributes::POSTED_AT)) {
                    $table->timestamp(Attributes::POSTED_AT)->nullable();
                }
                if (!Schema::hasColumn(Tables::PROMOTIONS, Attributes::VALID_UNTIL)) {
                    $table->timestamp(Attributes::VALID_UNTIL)->nullable();
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
        if (Schema::hasTable(Tables::PROMOTIONS)) {
            Schema::table(Tables::PROMOTIONS, function (Blueprint $table) {
                if (Schema::hasColumn(Tables::PROMOTIONS, Attributes::POSTED_AT)) {
                    $table->dropColumn(Attributes::POSTED_AT);
                }
                if (Schema::hasColumn(Tables::PROMOTIONS, Attributes::VALID_UNTIL)) {
                    $table->dropColumn(Attributes::VALID_UNTIL);
                }
            });
        }
    }
}
