<?php

use App\Constants\Attributes;
use App\Constants\StudioSpecsTypes;
use App\Constants\Tables;
use App\Constants\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudioSpecsTable extends Migration
{
    protected $table = Tables::STUDIO_SPECS;

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
                $table->string(Attributes::STUDIO_PRINT_ID)->nullable();
                $table->string(Attributes::STUDIO_PACKAGE_ID)->nullable();
                $table->string(Attributes::TITLE)->nullable();
                $table->string(Attributes::IMAGE)->nullable();
                $table->bigInteger(Attributes::TYPE)->default(StudioSpecsTypes::SIZE);
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
