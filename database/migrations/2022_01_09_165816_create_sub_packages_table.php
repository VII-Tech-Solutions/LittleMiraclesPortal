<?php

use App\Constants\AllowedSelection;
use App\Constants\Attributes;
use App\Constants\IsPopular;
use App\Constants\SessionPackageTypes;
use App\Constants\Status;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubPackagesTable extends Migration
{
    protected $table = Tables::SUB_PACKAGES;

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
                $table->string(Attributes::TITLE)->nullable();
                $table->string(Attributes::DESCRIPTION)->nullable();
                $table->integer(Attributes::BACKDROP_ALLOWED)->nullable()->default(AllowedSelection::ONE);
                $table->integer(Attributes::CAKE_ALLOWED)->nullable()->default(AllowedSelection::ONE);
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
