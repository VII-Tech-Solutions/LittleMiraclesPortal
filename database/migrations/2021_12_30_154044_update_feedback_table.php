<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFeedbackTable extends Migration
{
    protected $table = Tables::FEEDBACK;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->table)) {
            Schema::table($this->table, function (Blueprint $table) {
                if(!Schema::hasColumn($this->table, Attributes::USER_ID)){
                    $table->bigInteger(Attributes::USER_ID)->nullable();
                }
                if(!Schema::hasColumn($this->table, Attributes::FAMILY_ID)){
                    $table->bigInteger(Attributes::FAMILY_ID)->nullable();
                }
                if(!Schema::hasColumn($this->table, Attributes::PACKAGE_ID)){
                    $table->bigInteger(Attributes::PACKAGE_ID)->nullable();
                }
                if(!Schema::hasColumn($this->table, Attributes::SESSION_ID)) {
                    $table->bigInteger(Attributes::SESSION_ID)->nullable();
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
                $table->dropColumn(Attributes::SESSION_ID);
                $table->dropColumn(Attributes::PACKAGE_ID);
                $table->dropColumn(Attributes::USER_ID);
                $table->dropColumn(Attributes::FAMILY_ID);
            });
        }
    }
}
