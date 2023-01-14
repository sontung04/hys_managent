<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesHcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes_hc', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id');
            $table->string('name', 255);
            $table->integer('carer_staff')->default(0);
            $table->integer('coach')->default(0);
            $table->timestamp('starttime')->nullable();
            $table->timestamp('finishtime')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('classes_hc');
    }
}
