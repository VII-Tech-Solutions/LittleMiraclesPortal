<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use VIITech\Helpers\Constants\Status;

class CreateUserDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::USER_DEVICES, function (Blueprint $table) {
            $table->bigIncrements(Attributes::ID);
            $table->bigInteger(Attributes::USER_ID)->nullable();
            $table->string(Attributes::PLATFORM)->nullable();
            $table->string(Attributes::APP_VERSION)->nullable();
            $table->text(Attributes::TOKEN)->nullable();
            $table->integer(Attributes::STATUS)->default(Status::ACTIVE)->nullable();
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
        Schema::dropIfExists(Tables::USER_DEVICES);
    }
}
