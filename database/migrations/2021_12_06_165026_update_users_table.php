<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    protected $table = Tables::USERS;


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->table)) {
            Schema::table($this->table, function (Blueprint $table) {
                $table->string(Attributes::PROVIDER_ID)->nullable();
                $table->string(Attributes::FIRST_NAME)->nullable()->change();
                $table->string(Attributes::LAST_NAME)->nullable()->change();
                $table->text(Attributes::AVATAR)->nullable()->change();
                $table->string(Attributes::USERNAME)->nullable();
                $table->string(Attributes::BIRTH_DATE)->nullable()->change();
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
                $table->dropColumn(Attributes::PROVIDER_ID);
                $table->dropColumn(Attributes::USERNAME);
            });
        }
    }
}
