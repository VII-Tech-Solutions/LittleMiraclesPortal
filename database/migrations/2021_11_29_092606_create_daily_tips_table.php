<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Attributes;
use App\Constants\Status;

class CreateDailyTipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\App\Constants\Tables::DAILY_TIP, function (Blueprint $table) {
            $table->bigIncrements(Attributes::ID);
            $table->string(Attributes::IMAGE)->nullable();
            $table->string(Attributes::TITLE)->nullable();
            $table->string(Attributes::POSTED_AT)->nullable();
            $table->string(Attributes::CONTENT)->nullable();
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
        Schema::dropIfExists(\App\Constants\Tables::DAILY_TIP);
    }
}
