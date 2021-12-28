<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Guideline;

class AddHasGuidlineColumnToPackageTable extends Migration
{
    protected $table = Tables::SESSION_PACKAGES;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->table)) {
            Schema::table($this->table, function (Blueprint $table) {
                if (!Schema::hasColumn($this->table, Attributes::HAS_GUIDELINE)) {
                    $table->integer(Attributes::HAS_GUIDELINE)->nullable()->default(Guideline::NO);
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
    if (Schema::hasTable($this->table)) {
        Schema::table($this->table, function (Blueprint $table) {
            if (Schema::hasColumn($this->table, Attributes::HAS_GUIDELINE)) {
                $table->dropColumn(Attributes::HAS_GUIDELINE);
            }
        });
    }
}
}
