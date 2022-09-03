<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCalendarsWeekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendars_week', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('address', 255)->nullable();
            $table->integer('area')->default(0)->nullable();
            $table->integer('group_id')->default(0)->nullable();
            $table->string('group_name', 255)->default("")->nullable();
            $table->tinyInteger('formality')->default(1)->comment('Hình thức: 1-off, 0-on');
            $table->timestamp('starttime', 0);
            $table->timestamp('finishtime', 0)->nullable();
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
        Schema::dropIfExists('calendars_week');
    }
}
