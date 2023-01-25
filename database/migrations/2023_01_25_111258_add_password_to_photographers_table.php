<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Tables;
use App\Constants\Attributes;

class AddPasswordToPhotographersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable(Tables::PHOTOGRAPHERS)) {
            Schema::table(Tables::PHOTOGRAPHERS, function (Blueprint $table) {
                if (!Schema::hasColumn(Tables::PHOTOGRAPHERS, Attributes::PASSWORD)) {
                    $table->string(Attributes::PASSWORD)->nullable();
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
        if (Schema::hasTable(Tables::PHOTOGRAPHERS)) {
            Schema::table(Tables::PHOTOGRAPHERS, function (Blueprint $table) {
                if (Schema::hasColumn(Tables::PHOTOGRAPHERS, Attributes::PASSWORD)) {
                    $table->dropColumn(Attributes::PASSWORD);
                }
            });
        }
    }
}
