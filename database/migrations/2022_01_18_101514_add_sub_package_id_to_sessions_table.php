<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubPackageIdToSessionsTable extends Migration
{
    protected $table = Tables::SESSIONS;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->table)) {
            Schema::table($this->table, function (Blueprint $table) {
                if(!Schema::hasColumn($this->table, Attributes::SUB_PACKAGE_ID)){
                    $table->bigInteger(Attributes::SUB_PACKAGE_ID)->nullable()->after(Attributes::PACKAGE_ID);
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
                $table->dropColumn(Attributes::SUB_PACKAGE_ID);
            });
        }
    }
}
