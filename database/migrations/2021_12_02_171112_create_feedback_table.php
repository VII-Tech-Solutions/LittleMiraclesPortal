<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Constants\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    protected $table = Tables::FEEDBACK;

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
                $table->bigInteger(Attributes::USER_ID)->nullable();
                $table->bigInteger(Attributes::FAMILY_ID)->nullable();
                $table->bigInteger(Attributes::QUESTION_ID)->nullable();
                $table->text(Attributes::ANSWER)->nullable();
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
