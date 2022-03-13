<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::USER_TOKENS, function (Blueprint $table) {
            $table->bigIncrements(Attributes::ID);
            $table->bigInteger(Attributes::USER_ID)->nullable();
            $table->longText(Attributes::TOKEN)->nullable();
            $table->integer(Attributes::STATUS)->default(Status::ACTIVE);
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
        Schema::dropIfExists(Tables::USER_TOKENS);
    }
}
