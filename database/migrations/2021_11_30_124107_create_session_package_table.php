<?php

use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\SessionPackageTypes;
use App\Constants\IsPopular;

class CreateSessionPackageTable extends Migration
{

    protected $table = Tables::SESSION_PACKAGES;

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
                $table->string(Attributes::IMAGE)->nullable();
                $table->string(Attributes::TITLE)->nullable();
                $table->string(Attributes::TAG)->nullable();
                $table->float(Attributes::PRICE)->nullable();
                $table->boolean(Attributes::IS_POPULAR)->nullable()->default(IsPopular::NO);// NEED CHANGE
                $table->integer(Attributes::TYPE)->nullable()->default(SessionPackageTypes::NORMAL_SESSION);
                $table->string(Attributes::CONTENT)->nullable();
                $table->string(Attributes::LOCATION_TEXT)->nullable();
                $table->string(Attributes::LOCATION_LINK)->nullable();
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
