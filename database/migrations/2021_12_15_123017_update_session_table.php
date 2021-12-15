<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable(Tables::SESSIONS)) {
            Schema::table(Tables::SESSIONS, function (Blueprint $table) {
                $table->dropColumn(Attributes::SESSION_STATUS);
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
        if (Schema::hasTable(Tables::SESSIONS)) {
            Schema::table(Tables::SESSIONS, function (Blueprint $table) {
                $table->string(Attributes::SESSION_STATUS)->nullable();
            });
        }
    }
}
