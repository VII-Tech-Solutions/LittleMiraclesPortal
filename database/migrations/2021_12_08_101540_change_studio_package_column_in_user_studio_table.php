<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStudioPackageColumnInUserStudioTable extends Migration
{
    protected $table = Tables::USER_STUDIO;


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->table)) {
            Schema::table($this->table, function (Blueprint $table) {
                $table->renameColumn('STUDIO_PACKAGE_ID',Attributes::STUDIO_PACKAGE_ID);
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
                $table->renameColumn(Attributes::STUDIO_PACKAGE_ID,'STUDIO_PACKAGE_ID');


            });
        }
    }
}
