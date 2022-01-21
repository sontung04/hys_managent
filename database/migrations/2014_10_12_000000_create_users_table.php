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
            $table->string('code', 20);
            $table->string('firstname', 255);
            $table->string('lastname', 255);
            $table->string('password', 255);
            $table->rememberToken();
            $table->string('email', 255)->unique();
            $table->integer('email_verified_at')->nullable();
            $table->string('phone', 15)->unique();
            $table->tinyInteger('phone_confirmed')->default(0);
            $table->timestamp('birthday', 0)->nullable();
            $table->string('school', 255)->nullable();
            $table->string('major', 255)->nullable();
            $table->integer('area')->default(0);
            $table->longText('address')->nullable();
            $table->string('facebook', 255)->nullable();
            $table->string('img', 255);
            $table->tinyInteger('gender')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('departStatus')->default(0);
            $table->string('arealog',15)->nullable();
            $table->timestamp('jointime', 0)->nullable();
            $table->timestamp('stoptime', 0)->nullable();
            $table->timestamp('lastaccess', 0)->nullable();
            $table->longText('skill')->nullable();
            $table->longText('desire')->nullable();
            $table->string('company', 255)->nullable();
            $table->string('work', 255)->nullable();
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
        Schema::dropIfExists('users');
    }
}
