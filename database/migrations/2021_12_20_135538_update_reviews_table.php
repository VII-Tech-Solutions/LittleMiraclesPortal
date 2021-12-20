<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Tables::REVIEWS, function (Blueprint $table) {
            if (Schema::hasColumn(Tables::REVIEWS, Attributes::POSTED_AT)) {
                $table->dropColumn(Attributes::POSTED_AT);
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
        Schema::table(Tables::REVIEWS, function (Blueprint $table) {
            if (!Schema::hasColumn(Tables::REVIEWS, Attributes::POSTED_AT)) {
                $table->string(Attributes::POSTED_AT)->nullable();
            }
        });
    }
}
