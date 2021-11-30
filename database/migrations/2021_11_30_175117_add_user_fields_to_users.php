<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Constants\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserFieldsToUsers extends Migration
{

    protected $table = Tables::USERS;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->table)) {
            Schema::table($this->table , function (Blueprint $table) {
                if(!Schema::hasColumn($this->table , Attributes::USER_ID)){
                    $table->integer(Attributes::USER_ID)->nullable();
                }
                if(!Schema::hasColumn($this->table , Attributes::COUNTRY_CODE)){
                    $table->integer(Attributes::COUNTRY_CODE)->nullable();
                }
                if(!Schema::hasColumn($this->table , Attributes::GENDER)){
                    $table->integer(Attributes::GENDER)->nullable();
                }
                if(!Schema::hasColumn($this->table , Attributes::BIRTH_DATE)){
                    $table->string(Attributes::BIRTH_DATE)->nullable();
                }
                if(!Schema::hasColumn($this->table , Attributes::PROVIDE)){
                    $table->string(Attributes::PROVIDE)->nullable();
                }
                if(!Schema::hasColumn($this->table , Attributes::AVATAR)){
                    $table->string(Attributes::AVATAR)->nullable();
                }
                if(!Schema::hasColumn($this->table , Attributes::PAST_EXPERIENCE)){
                    $table->string(Attributes::PAST_EXPERIENCE)->nullable();
                }
                if(!Schema::hasColumn($this->table , Attributes::FAMILY_ID)){
                    $table->bigInteger(Attributes::FAMILY_ID)->nullable();
                }
                if(!Schema::hasColumn($this->table , Attributes::STATUS)){
                    $table->integer(Attributes::STATUS)->nullable()->default(Status::ACTIVE);
                }
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
        Schema::table($this->table , function (Blueprint $table) {
            //
        });
    }
}
