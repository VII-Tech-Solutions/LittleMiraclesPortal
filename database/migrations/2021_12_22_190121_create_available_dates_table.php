<?php

use App\Constants\Attributes;
use App\Constants\AvailableDateType;
use App\Constants\Tables;
use App\Models\Helpers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailableDatesTable extends Migration
{

    public $table = Tables::AVAILABLE_DATES;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                Helpers::defaultMigration($table);
                $table->string(Attributes::START_DATE)->nullable();
                $table->string(Attributes::END_DATE)->nullable();
                $table->integer(Attributes::TYPE)->default(AvailableDateType::INCLUDE)->nullable();
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
        Schema::dropIfExists($this->table);
    }
}
