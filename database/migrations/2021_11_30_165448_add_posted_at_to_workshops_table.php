<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPostedAtToWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable(Tables::WORKSHOPS)) {
            Schema::table(Tables::WORKSHOPS, function (Blueprint $table) {
                if (!Schema::hasColumn(Tables::WORKSHOPS, Attributes::POSTED_AT)) {
                    $table->timestamp(Attributes::POSTED_AT)->nullable();
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
        if (Schema::hasTable(Tables::WORKSHOPS)) {
            Schema::table(Tables::WORKSHOPS, function (Blueprint $table) {
                if (Schema::hasColumn(Tables::WORKSHOPS, Attributes::POSTED_AT)) {
                    $table->dropColumn(Attributes::POSTED_AT);
                }
            });
        }
    }
}
