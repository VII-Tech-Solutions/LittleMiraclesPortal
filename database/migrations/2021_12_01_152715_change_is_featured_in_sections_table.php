<?php

use App\Constants\Attributes;
use App\Constants\IsFeatured;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIsFeaturedInSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::SECTIONS, function (Blueprint $table) {
            $table->boolean(Attributes::IS_FEATURED)->nullable()->default(IsFeatured::FALSE)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Tables::SECTIONS, function (Blueprint $table) {
            $table->boolean(Attributes::IS_FEATURED)->nullable()->default(IsFeatured::TRUE)->change();
        });
    }
}
