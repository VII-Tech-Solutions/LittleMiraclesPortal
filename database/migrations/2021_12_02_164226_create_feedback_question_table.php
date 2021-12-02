<?php

use App\Constants\Attributes;
use App\Constants\QuestionType;
use App\Constants\Tables;
use App\Constants\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackQuestionTable extends Migration
{
    protected $table = Tables::FEEDBACK_QUESTION;

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
                $table->string(Attributes::QUESTION)->nullable();
                $table->integer(Attributes::STATUS)->nullable()->default(Status::ACTIVE);
                $table->integer(Attributes::QUESTION_TYPE)->nullable()->default(QuestionType::TEXT);
                $table->string(Attributes::OPTIONS)->nullable();
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
