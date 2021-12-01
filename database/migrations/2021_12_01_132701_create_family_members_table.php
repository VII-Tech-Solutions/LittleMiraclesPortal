<?php

use App\Constants\Attributes;
use App\Constants\Relationship;
use App\Constants\Status;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateFamilyMembersTable extends Migration
{
    protected $table = Tables::FAMILY_MEMBERS;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger(Attributes::USER_ID)->nullable();
                $table->bigInteger(Attributes::FAMILY_ID)->nullable();
                $table->string(Attributes::FIRST_NAME)->nullable();
                $table->string(Attributes::LAST_NAME)->nullable();
                $table->integer(Attributes::GENDER)->nullable();
                $table->date(Attributes::BIRTH_DATE)->nullable();
                $table->integer(Attributes::RELATIONSHIP)->nullable();
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
