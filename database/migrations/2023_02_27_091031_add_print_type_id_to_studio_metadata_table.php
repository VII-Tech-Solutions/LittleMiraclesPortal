<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrintTypeIdToStudioMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::STUDIO_METADATA, function (Blueprint $table) {
            $table->integer(Attributes::PRINT_TYPE_ID)->nullable();
            $table->integer(Attributes::PAPER_TYPE_ID)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Tables::STUDIO_METADATA, function (Blueprint $table) {
            $table->dropColumn(Attributes::PRINT_TYPE_ID);
            $table->dropColumn(Attributes::PAPER_TYPE_ID);
        });
    }
}
