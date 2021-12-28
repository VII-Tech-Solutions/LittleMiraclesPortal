<?php

use App\Constants\AllowedOutdoor;
use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOutdoorAllowedColumnToSessionPackageTable extends Migration
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
                if (!Schema::hasColumn($this->table, Attributes::OUTDOOR_ALLOWED)) {
                    $table->integer(Attributes::OUTDOOR_ALLOWED)->nullable()->default(AllowedOutdoor::NO);
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
                if (Schema::hasColumn($this->table, Attributes::OUTDOOR_ALLOWED)) {
                    $table->dropColumn(Attributes::OUTDOOR_ALLOWED);
                }
            });
        }
    }

}
