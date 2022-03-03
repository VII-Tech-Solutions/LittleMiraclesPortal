<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSelectedAndUnselectedImageToStudioMetadataTable extends Migration
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
                if(Schema::hasColumn($this->table, Attributes::IMAGE_SELECTED)){
                    $table->dropColumn(Attributes::IMAGE_SELECTED);
                }
                if(Schema::hasColumn($this->table, Attributes::IMAGE_UNSELECTED)){
                    $table->dropColumn(Attributes::IMAGE_UNSELECTED);
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
                if(!Schema::hasColumn($this->table, Attributes::IMAGE_SELECTED)){
                    $table->string(Attributes::IMAGE_SELECTED)->nullable()->after(Attributes::ID);
                }
                if(!Schema::hasColumn($this->table, Attributes::IMAGE_UNSELECTED)){
                    $table->string(Attributes::IMAGE_UNSELECTED)->nullable()->after(Attributes::ID);
                }
            });
        }
    }
}
