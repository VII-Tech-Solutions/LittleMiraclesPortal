<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePriceToThreeDecimalTable extends Migration
{
    protected $table = Tables::STUDIO_METADATA;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->table)) {
            Schema::table($this->table, function (Blueprint $table) {
                if(Schema::hasColumn($this->table, Attributes::PRICE)){
                    $table->decimal(Attributes::PRICE,8,3)->nullable()->default(0)->change();
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
                if(Schema::hasColumn($this->table, Attributes::PRICE)){
                    $table->decimal(Attributes::PRICE,8,4)->nullable()->default(0)->change();
                }
            });
        }
    }
}
