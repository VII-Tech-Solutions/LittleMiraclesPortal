<?php

use App\Constants\Attributes;
use App\Constants\PromotionType;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderColumnToFeedbackQuestionTable extends Migration
{
    protected $table = Tables::FEEDBACK_QUESTION;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->table)) {
            Schema::table($this->table, function (Blueprint $table) {
                if(!Schema::hasColumn($this->table, Attributes::ORDER)){
                    $table->integer(Attributes::ORDER)->default(0)->nullable()->after(Attributes::OPTIONS);
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
                $table->dropColumn(Attributes::ORDER);
            });
        }
    }
}
