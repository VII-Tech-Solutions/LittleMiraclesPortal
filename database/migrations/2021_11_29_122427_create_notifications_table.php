<?php

use App\Constants\Attributes;
use App\Constants\NotificationTypes;
use App\Constants\Status;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable(Tables::NOTIFICATIONS)) {
            Schema::create(Tables::NOTIFICATIONS, function (Blueprint $table) {
                $table->bigIncrements(Attributes::ID);
                $table->text(Attributes::TITLE);
                $table->text(Attributes::MESSAGE);
                $table->bigInteger(Attributes::TYPE)->default(NotificationTypes::GENERIC);
                $table->bigInteger(Attributes::ITEM_TYPE)->nullable();
                $table->bigInteger(Attributes::ITEM_ID)->nullable();
                $table->integer(Attributes::STATUS)->default(Status::ACTIVE);
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
        Schema::dropIfExists(Tables::NOTIFICATIONS);
    }
}
