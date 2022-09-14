<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('studies', function (Blueprint $table) {
            //
            $table->integer('lesson_id')->default(0)->change();
            $table->string('lesson_name', 255)->nullable()->after('lesson_id');
            $table->tinyInteger('status')->after('location')->comment('Hình thức: 1-off, 0-on');
            $table->text('description')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('studies', function (Blueprint $table) {
            //
            $table->integer('lesson_id')->change();
        });
    }
}
