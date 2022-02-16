<?php

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryCodeAndPhoneNumberColumnsToFamilyMembers extends Migration
{
    protected $table = Tables::FAMILY_MEMBERS;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->table)) {
            Schema::table($this->table, function (Blueprint $table) {
                if(!Schema::hasColumn($this->table, Attributes::PHONE_NUMBER)){
                    $table->string(Attributes::PHONE_NUMBER)->nullable()->after(Attributes::LAST_NAME);
                }
                if(!Schema::hasColumn($this->table, Attributes::COUNTRY_CODE)){
                    $table->string(Attributes::COUNTRY_CODE)->nullable()->after(Attributes::LAST_NAME);
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
        if (Schema::hasTable($this->table)) {
            Schema::table($this->table, function (Blueprint $table) {
                if(Schema::hasColumn($this->table, Attributes::COUNTRY_CODE)){
                    $table->dropColumn(Attributes::COUNTRY_CODE);
                }
                if(Schema::hasColumn($this->table, Attributes::PHONE_NUMBER)){
                    $table->dropColumn(Attributes::PHONE_NUMBER);
                }
            });
        }
    }
}
