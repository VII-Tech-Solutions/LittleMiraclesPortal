<?php

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable(Tables::PAYMENT_METHOD)) {
            Schema::create(Tables::PAYMENT_METHOD, function (Blueprint $table) {
                // Generic Attributes
                $table->bigIncrements(Attributes::ID);
                $table->integer(Attributes::STATUS)->default(Status::ACTIVE);
                $table->timestamps();
                $table->softDeletes();

                // Specific Attributes
                $table->string(Attributes::TITLE)->nullable();
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
        Schema::dropIfExists(Tables::PAYMENT_METHOD);
    }
}
