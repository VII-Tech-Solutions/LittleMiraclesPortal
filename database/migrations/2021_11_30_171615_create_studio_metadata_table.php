<?php

use App\Constants\Attributes;
use App\Constants\StudioCategory;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Status;


class CreateStudioMetadataTable extends Migration
{
    protected $table = Tables::STUDIO_METADATA;

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
                $table->string(Attributes::IMAGE)->nullable();
                $table->integer(Attributes::STATUS)->default(Status::ACTIVE);
                $table->integer(Attributes::CATEGORY)->default(StudioCategory::ALBUM_SIZE);
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
