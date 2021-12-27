<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSessionsTable extends Migration
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
                $table->text(Attributes::LOCATION_TEXT)->nullable();
                $table->text(Attributes::LOCATION_LINK)->nullable();
                $table->boolean(Attributes::IS_OUTDOOR)->default(false)->nullable();
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
                $table->dropColumn(Attributes::LOCATION_TEXT);
                $table->dropColumn(Attributes::LOCATION_LINK);
                $table->dropColumn(Attributes::IS_OUTDOOR);
            });
        }
    }
}
