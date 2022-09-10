<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes_students', function (Blueprint $table) {
            $table->id();
            $table->integer('class_id');
            $table->integer('student_id');
            $table->timestamp('starttime')->nullable();
            $table->timestamp('finishtime')->nullable();
            $table->string('note', 255)->nullable();
            $table->integer('fees')->default('0');
            $table->tinyInteger('status')->default('1');
            $table->integer('fees')->default(0);
            $table->integer('created_by')->default('0')->nullable();
            $table->integer('updated_by')->default('0')->nullable();
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
        Schema::dropIfExists('classes_students');
    }
}
