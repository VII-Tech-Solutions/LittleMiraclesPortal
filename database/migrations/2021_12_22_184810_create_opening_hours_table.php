<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Models\Helpers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpeningHoursTable extends Migration
{
    public $table = Tables::OPENING_HOURS;

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
                $table->bigInteger(Attributes::AVAILABLE_DATE_ID)->nullable();
                $table->string(Attributes::DAY)->nullable();
                $table->integer(Attributes::DAY_ID)->nullable();
                $table->string(Attributes::FROM)->nullable();
                $table->string(Attributes::TO)->nullable();
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
