<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::CART_ITEMS, function (Blueprint $table) {
            $table->bigIncrements(Attributes::ID);
            $table->integer(Attributes::PACKAGE_ID)->nullable();
            $table->integer(Attributes::PACKAGE_TYPE)->nullable();
            $table->string(Attributes::TITLE)->nullable();
            $table->string(Attributes::DESCRIPTION)->nullable();
            $table->integer(Attributes::DISPLAY_IMAGE)->nullable();
            $table->string(Attributes::MEDIA_IDS)->nullable();
            $table->integer(Attributes::ALBUM_SIZE)->nullable();
            $table->integer(Attributes::SPREADS)->nullable();
            $table->integer(Attributes::PAPER_TYPE)->nullable();
            $table->integer(Attributes::COVER_TYPE)->nullable();
            $table->integer(Attributes::CANVAS_SIZE)->nullable();
            $table->integer(Attributes::CANVAS_TYPE)->nullable();
            $table->integer(Attributes::QUANTITY)->nullable();
            $table->integer(Attributes::PRINT_TYPE)->nullable();
            $table->integer(Attributes::PAPER_SIZE)->nullable();
            $table->longText(Attributes::ADDITIONAL_COMMENTS)->nullable();
            $table->double(Attributes::TOTAL_PRICE)->nullable();
            $table->integer(Attributes::USER_ID)->nullable();
            $table->integer(Attributes::STATUS)->default(1);
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
        Schema::dropIfExists(Tables::CART_ITEMS);
    }
}
