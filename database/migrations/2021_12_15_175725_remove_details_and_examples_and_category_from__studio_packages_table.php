<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDetailsAndExamplesAndCategoryFromStudioPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::STUDIO_PACKAGES, function (Blueprint $table) {
            if (Schema::hasColumn(Tables::STUDIO_PACKAGES, Attributes::DETAILS)) {
                $table->dropColumn(Attributes::DETAILS);
            }

            if (Schema::hasColumn(Tables::STUDIO_PACKAGES, Attributes::EXAMPLE)) {
                $table->dropColumn(Attributes::EXAMPLE);
            }

            if (Schema::hasColumn(Tables::STUDIO_PACKAGES, Attributes::CATEGORY)) {
                $table->dropColumn(Attributes::CATEGORY);
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
        Schema::table(Tables::STUDIO_PACKAGES, function (Blueprint $table) {
            if (!Schema::hasColumn(Tables::STUDIO_PACKAGES, Attributes::DETAILS)) {
                $table->text(Attributes::DETAILS)->nullable();
            }

            if (!Schema::hasColumn(Tables::STUDIO_PACKAGES, Attributes::EXAMPLE)) {
                $table->text(Attributes::EXAMPLE)->nullable();
            }

            if (!Schema::hasColumn(Tables::STUDIO_PACKAGES, Attributes::CATEGORY)) {
                $table->integer(Attributes::CATEGORY)->nullable();
            }
        });
    }
}
