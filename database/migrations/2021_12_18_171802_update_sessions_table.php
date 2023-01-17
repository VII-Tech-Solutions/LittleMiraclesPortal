<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Models\Helpers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSessionsTable extends Migration
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
                if(!Schema::hasColumn(Tables::SESSIONS, Attributes::DATE)){
                    $table->string(Attributes::DATE)->nullable();
                }
                if(!Schema::hasColumn(Tables::SESSIONS, Attributes::TIME)) {
                    $table->string(Attributes::TIME)->nullable();
                }
                if(!Schema::hasColumn(Tables::SESSIONS, Attributes::PAYMENT_METHOD)) {
                    $table->integer(Attributes::PAYMENT_METHOD)->nullable();
                }
                if(!Schema::hasColumn(Tables::SESSIONS, Attributes::PHOTOGRAPHER)) {
                    $table->bigInteger(Attributes::PHOTOGRAPHER)->nullable();
                }
            });
        }

        if (!Schema::hasTable(Tables::SESSION_DETAILS)) {
            Schema::create(Tables::SESSION_DETAILS, function (Blueprint $table) {
                Helpers::defaultMigration($table);
                $table->bigInteger(Attributes::SESSION_ID)->nullable();
                $table->bigInteger(Attributes::PACKAGE_ID)->nullable();
                $table->bigInteger(Attributes::FAMILY_ID)->nullable();
                $table->bigInteger(Attributes::USER_ID)->nullable();
                $table->integer(Attributes::TYPE)->nullable();
                $table->string(Attributes::VALUE)->nullable();
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
                $table->dropColumn(Attributes::DATE);
                $table->dropColumn(Attributes::TIME);
                $table->dropColumn(Attributes::PAYMENT_METHOD);
            });
        }

        Schema::dropIfExists(Tables::SESSION_DETAILS);
    }
}
