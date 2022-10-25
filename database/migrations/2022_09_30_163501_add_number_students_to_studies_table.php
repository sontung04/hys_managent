<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumberStudentsToStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('studies', function (Blueprint $table) {
            $table->integer('number_eat')->default(0)->after('status');
            $table->integer('number_learn')->default(0)->after('number_eat');
            $table->integer('carer_staff')->default(0)->change();
            $table->integer('coach')->default(0)->change();
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
            $table->integer('carer_staff')->change();
            $table->integer('coach')->change();
            $table->dropColumn(['number_eat', 'number_learn']);
        });
    }
}
