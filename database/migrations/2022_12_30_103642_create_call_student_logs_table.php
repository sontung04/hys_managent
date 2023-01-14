<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallStudentLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_student_logs', function (Blueprint $table) {
            $table->id();
            $table->string('agent', 255);
            $table->timestamp('date_call')->nullable();
            $table->tinyInteger('channel')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->text('note')->default('')->nullable();
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
        Schema::dropIfExists('call_student_logs');
    }
}
