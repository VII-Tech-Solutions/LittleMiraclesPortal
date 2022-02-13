<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvailableUntilToPromotionsTable extends Migration
{
    protected $table = Tables::PROMOTIONS;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->table)) {
            Schema::table($this->table, function (Blueprint $table) {
                if(!Schema::hasColumn($this->table, Attributes::AVAILABLE_UNTIL)){
                    $table->string(Attributes::AVAILABLE_UNTIL)->nullable()->after(Attributes::AVAILABLE_FROM);
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
                if(Schema::hasColumn($this->table, Attributes::AVAILABLE_UNTIL)){
                    $table->dropColumn(Attributes::AVAILABLE_UNTIL);
                }
            });
        }
    }
}
