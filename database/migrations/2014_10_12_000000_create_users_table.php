<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('password', 255);
            $table->rememberToken();
            $table->string('email', 255)->unique();
            $table->integer('email_verified_at')->nullable();
            $table->string('phone', 15)->unique();
            $table->tinyInteger('phone_confirmed')->default(0);
            $table->string('birthday', 255)->nullable();
            $table->string('school', 255)->nullable();
            $table->string('major', 255)->nullable();
            $table->longText('address')->nullable();
            $table->string('facebook', 255)->nullable();
            $table->string('img', 255);
            $table->tinyInteger('gender')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->integer('group')->nullable();
            $table->integer('jointime');
            $table->integer('stoptime')->nullable();
            $table->integer('lastaccess')->default(0);
            $table->longText('skill')->nullable();
            $table->string('company', 255)->nullable();
            $table->string('work', 255)->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('created_at');
            $table->integer('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
