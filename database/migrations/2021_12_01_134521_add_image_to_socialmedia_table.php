<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToSocialmediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable(Tables::SOCIAL_MEDIA)) {
            Schema::table(Tables::SOCIAL_MEDIA, function (Blueprint $table) {
                if (!Schema::hasColumn(Tables::SOCIAL_MEDIA, Attributes::IMAGE)) {
                    $table->string(Attributes::IMAGE)->nullable();
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
        if (Schema::hasTable(Tables::SOCIAL_MEDIA)) {
            Schema::table(Tables::SOCIAL_MEDIA, function (Blueprint $table) {
                if (Schema::hasColumn(Tables::SOCIAL_MEDIA, Attributes::IMAGE)) {
                    $table->dropColumn(Attributes::IMAGE);
                }
            });
        }
    }
}
