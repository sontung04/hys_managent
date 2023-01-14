<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('subname',100)->nullable();
            $table->tinyInteger('gender')->default(0);
            $table->timestamp('birthday')->nullable();
            $table->string('img', 255)->nullable();
            $table->string('address',255)->nullable();
            $table->string('level',255)->nullable();
            $table->string('job',255)->nullable();
            $table->string('position','255')->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('teachers');
    }
}
