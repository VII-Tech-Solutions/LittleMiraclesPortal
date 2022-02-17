<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudioPackageMediaTable extends Migration
{
    protected $table = Tables::STUDIO_PACKAGE_MEDIA;

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
                $table->bigInteger(Attributes::STUDIO_PACKAGE_ID)->nullable();
                $table->bigInteger(Attributes::MEDIA_ID)->nullable();
                $table->bigInteger(Attributes::ORDER)->nullable();
                $table->string(Attributes::STATUS)->default(0)->nullable();
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
