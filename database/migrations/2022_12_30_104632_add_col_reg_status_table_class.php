<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColRegStatusTableClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classes_hc', function (Blueprint $table) {
            $table->tinyInteger('reg_status')->default(1)->after('status');
            $table->string('note', 255)->default('')->nullable()->after('reg_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classes_hc', function (Blueprint $table) {
            $table->dropColumn('reg_status');
            $table->dropColumn('note');
        });
    }
}
