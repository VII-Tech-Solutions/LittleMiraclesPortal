<?php

use App\Constants\AllowedSelection;
use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBackdropAllowedColumnToSessionPackageTableTable extends Migration
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
                if (!Schema::hasColumn($this->table, Attributes::BACKDROP_ALLOWED)) {
                    $table->integer(Attributes::BACKDROP_ALLOWED)->nullable()->default(AllowedSelection::ONE);
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
                if (Schema::hasColumn($this->table, Attributes::BACKDROP_ALLOWED)) {
                    $table->dropColumn(Attributes::BACKDROP_ALLOWED);
                }
            });
        }
    }
}
