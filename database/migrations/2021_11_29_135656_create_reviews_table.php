<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Attributes;
use App\Constants\Status;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\App\Constants\Tables::REVIEWS, function (Blueprint $table) {
            $table->bigIncrements(Attributes::ID);
            $table->decimal(Attributes::RATING)->nullable();
            $table->string(Attributes::USER_NAME)->nullable();
            $table->string(Attributes::USER_IMAGE)->nullable();
            $table->bigInteger(Attributes::USER_ID)->nullable();
            $table->bigInteger(Attributes::PACKAGE_ID)->nullable();
            $table->bigInteger(Attributes::SESSION_ID)->nullable();
            $table->string(Attributes::COMMENT)->nullable();
            $table->string(Attributes::POSTED_AT)->nullable();
            $table->integer(Attributes::STATUS)->nullable()->default(Status::ACTIVE);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(\App\Constants\Tables::REVIEWS);
    }
}
