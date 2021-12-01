<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveIconFromSocialmediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::SOCIAL_MEDIA, function (Blueprint $table) {
            if (Schema::hasColumn(Tables::SOCIAL_MEDIA, Attributes::ICON)) {
                $table->dropColumn(Attributes::ICON);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Tables::SOCIAL_MEDIA, function (Blueprint $table) {
            if (!Schema::hasColumn(Tables::SOCIAL_MEDIA, Attributes::ICON)) {
                $table->string(Attributes::ICON)->nullable();
            }
        });
    }
}
