<?php

use App\Constants\Tables;
use App\Constants\Attributes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\PaymentStatus;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::TRANSACTIONS, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string(Attributes::TRANSACTION_ID)->nullable();
            $table->double(Attributes::AMOUNT)->default(0);
            $table->integer(Attributes::USER_ID)->nullable();
            $table->integer(Attributes::ORDER_ID)->nullable();
            $table->string(Attributes::CURRENCY)->nullable();
            $table->string(Attributes::GATEWAY)->nullable();
            $table->string(Attributes::PAYMENT_METHOD)->nullable();
            $table->string(Attributes::SUCCESS_INDICATOR)->nullable();
            $table->string(Attributes::SUCCESS_URL)->nullable();
            $table->string(Attributes::ERROR_URL)->nullable();
            $table->string(Attributes::DESCRIPTION)->nullable();
            $table->string(Attributes::ERROR_MESSAGE)->nullable();
            $table->string(Attributes::SESSION_VERSION)->nullable();
            $table->string(Attributes::UID)->nullable();
            $table->string(Attributes::PAYMENT_ID)->nullable();
            $table->integer(Attributes::STATUS)->default(PaymentStatus::AWAITING_PAYMENT);
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
        Schema::dropIfExists(Tables::TRANSACTIONS);
    }
}
