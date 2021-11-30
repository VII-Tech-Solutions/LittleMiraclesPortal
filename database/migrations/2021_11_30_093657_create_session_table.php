<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Attributes;
use App\Constants\Tables;
use App\Constants\Status;
use App\Constants\SessionStatus;

class CreateSessionTable extends Migration
{

    protected $table = Tables::SESSIONS;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->bigIncrements(Attributes::ID);
                $table->integer(Attributes::SESSION_STATUS)->nullable()->default(SessionStatus::BOOKED);
                $table->string(Attributes::TITLE)->nullable();
                $table->bigInteger(Attributes::USER_ID)->nullable();
                $table->bigInteger(Attributes::FAMILY_ID)->nullable();
                $table->bigInteger(Attributes::PACKAGE_ID)->nullable();
                $table->text(Attributes::CUSTOM_BACKDROP)->nullable();
                $table->text(Attributes::CUSTOM_CAKE)->nullable();
                $table->text(Attributes::COMMENTS)->nullable();
                $table->float(Attributes::TOTAL_PRICE)->nullable();
                $table->integer(Attributes::STATUS)->nullable()->default(Status::ACTIVE);
                $table->timestamps();
                $table->softDeletes();


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
        Schema::dropIfExists($this->table);
    }
}
