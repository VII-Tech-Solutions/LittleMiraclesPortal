<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPromoIdColumnToSessionTable extends Migration
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
                if (!Schema::hasColumn($this->table, Attributes::PROMO_ID)) {
                    $table->integer(Attributes::PROMO_ID)->nullable();
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
                if (Schema::hasColumn($this->table, Attributes::PROMO_ID)) {
                    $table->dropColumn(Attributes::PROMO_ID);
                }
            });
        }
    }
}
