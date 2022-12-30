<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassPaymentLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_payment_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('cs_id');
            $table->integer('money_paid');
            $table->string('cashier', 255);
            $table->tinyInteger('status')->default('0')->comment('Hình thức đóng: 0-Off; 1-Onl');
            $table->timestamp('date_paid');
            $table->string('note', 255)->nullable();
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
        Schema::dropIfExists('class_payment_logs');
    }
}
