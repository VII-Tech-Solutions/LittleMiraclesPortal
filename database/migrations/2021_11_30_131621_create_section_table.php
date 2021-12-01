<?php

use App\Constants\Attributes;
use App\Constants\SectionTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Status;
use App\Constants\Tables;

class CreateSectionTable extends Migration
{

    protected $table = Tables::SECTIONS;

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
                $table->string(Attributes::CONTENT)->nullable();
                $table->integer(Attributes::STATUS)->default(Status::ACTIVE);
                $table->integer(Attributes::TYPE)->default(SectionTypes::HEADER);
                $table->string(Attributes::ACTION_TEXT)->nullable();
                $table->string(Attributes::GO_TO)->nullable();
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
