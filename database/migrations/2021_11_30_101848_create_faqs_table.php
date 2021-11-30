<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Attributes;
use App\Constants\Status;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FAQS', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string(Attributes::QUESTION)->nullable();
            $table->text(Attributes::ANSWER)->nullable();
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
        Schema::dropIfExists('faqs');
    }
}
