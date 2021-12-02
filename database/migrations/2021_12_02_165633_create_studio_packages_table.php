<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\StudioPrintCategory;
use App\Constants\Tables;

class CreateStudioPackagesTable extends Migration
{

    protected $table = Tables::STUDIO_PACKAGES;
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
                $table->string(Attributes::TITLE);
                $table->string(Attributes::IMAGE);
                $table->decimal(Attributes::STARTING_PRICE);
                $table->text(Attributes::DETAILS);
                $table->text(Attributes::EXAMPLE);
                $table->integer(Attributes::CATEGORY)->nullable();
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
