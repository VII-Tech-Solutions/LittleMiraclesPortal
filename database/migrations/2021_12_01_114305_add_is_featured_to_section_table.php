<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFeaturedToSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable(Tables::SECTIONS)) {
            Schema::table(Tables::SECTIONS, function (Blueprint $table) {
                if (!Schema::hasColumn(Tables::SECTIONS, Attributes::IS_FEATURED)) {
                    $table->boolean(Attributes::IS_FEATURED)->default(false);
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
        if (Schema::hasTable(Tables::SECTIONS)) {
            Schema::table(Tables::SECTIONS, function (Blueprint $table) {
                if (Schema::hasColumn(Tables::SECTIONS, Attributes::IS_FEATURED)) {
                    $table->dropColumn(Attributes::IS_FEATURED);
                }
            });
        }
    }
}
