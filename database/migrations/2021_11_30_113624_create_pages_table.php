<?php

use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Status;
use App\Constants\Tables;


class CreatePagesTable extends Migration
{

    protected $table = Tables::PAGES;

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
                $table->string(Attributes::TITLE)->nullable();;
                $table->text(Attributes::CONTENT)->nullable();;
                $table->string(Attributes::SLUG)->nullable();
                $table->integer(Attributes::STATUS)->default(Status::ACTIVE);
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
        Schema::dropIfExists('pages');
    }
}
