<?php

use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSessionPackagesToPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable(Tables::SESSION_PACKAGES)) {
            Schema::rename(Tables::SESSION_PACKAGES, Tables::PACKAGES);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable(Tables::PACKAGES)) {
            Schema::rename(Tables::PACKAGES, Tables::SESSION_PACKAGES);
        }

    }
}
