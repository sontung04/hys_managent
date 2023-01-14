<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->default(0);
            $table->string('name', 255);
            $table->tinyInteger('gender')->default('0');
            $table->timestamp('birthday')->nullable();
            $table->string('img', 255)->nullable();
            $table->string('native_place', 255)->nullable();
            $table->string('nation', 255)->nullable();
            $table->string('religion', 255)->nullable();
            $table->string('citizen_identify', 12)->default('0');
            $table->timestamp('date_of_issue')->nullable();
            $table->string('place_of_issue', 255)->nullable();
            $table->string('address', 255);
            $table->string('phone', 15);
            $table->string('email', 255);
            $table->string('facebook', 255)->nullable();
            $table->string('school', 255)->nullable();
            $table->string('major', 255)->nullable();
            $table->string('guardian_name', 255);
            $table->string('guardian_phone', 15);
            $table->string('father', 255)->nullable();
            $table->string('father_job', 255)->nullable();
            $table->timestamp('father_birthday')->nullable();
            $table->string('mother', 255)->nullable();
            $table->string('mother_job', 255)->nullable();
            $table->timestamp('mother_birthday')->nullable();
            $table->string('course_where')->nullable();
            $table->text('desire')->nullable();
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
        Schema::dropIfExists('students');
    }
}
