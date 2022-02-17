<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToStudioPackagesTable extends Migration
{
    protected $table = Tables::STUDIO_PACKAGES;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->table)) {
            Schema::table($this->table, function (Blueprint $table) {
                if(!Schema::hasColumn($this->table, Attributes::TYPE)){
                    $table->string(Attributes::TYPE)->nullable()->after(Attributes::STATUS);
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
                if(Schema::hasColumn($this->table, Attributes::TYPE)){
                    $table->dropColumn(Attributes::TYPE);
                }
            });
        }
    }
}
