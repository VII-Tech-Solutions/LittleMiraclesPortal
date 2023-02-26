<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThicknessIdToStudioMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::STUDIO_METADATA, function (Blueprint $table) {
            $table->integer(Attributes::THICKNESS_ID)->nullable();
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
            $table->dropColumn(Attributes::THICKNESS_ID);
        });
    }
}
