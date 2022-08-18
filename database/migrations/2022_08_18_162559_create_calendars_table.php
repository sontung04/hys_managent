<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('calendars')){
            Schema::create('calendars', function (Blueprint $table) {
                $table->id();
                $table->string('title', 255);
                $table->text('description', 500)->nullable(); 
                $table->dateTime('starttime');
                $table->dateTime('endtime');
                $table->string('address', 255)->nullable();
                $table->tinyInteger('formality')->default(1);
                $table->integer('area')->nullable();
                $table->integer('group_id')->nullable();
                $table->integer('created_by')->default(0)->nullable();
                $table->integer('updated_by')->default(0)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendars');
    }
}
