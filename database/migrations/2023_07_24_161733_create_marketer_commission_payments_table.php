<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketer_commission_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marketer_id');
            $table->unsignedBigInteger('amount')->default(0);
            $table->string('payment_method');
            $table->string('status')->default('paid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marketer_commission_payments');
    }
};
