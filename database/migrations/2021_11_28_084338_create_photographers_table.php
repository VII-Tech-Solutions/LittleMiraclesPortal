<?php
use App\Constants\Attributes;
use App\Constants\PhotographersStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotographersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photographers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string(Attributes::NAME)->nullable();
            $table->string(Attributes::IMAGE)->nullable();
            $table->integer(Attributes::STATUS)->default(PhotographersStatus::ACTIVE);;
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
        Schema::dropIfExists('photographers');
    }
}
