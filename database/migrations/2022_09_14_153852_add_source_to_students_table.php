<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSourceToStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->integer('code')->unique()->after('user_id');
            $table->integer('source')->default(0)->after('birthday');
            $table->string('phone', 15)->unique()->change();
            $table->string('email', 255)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('phone', 15)->change();
            $table->string('email', 255)->change();
            $table->dropColumn(['code', 'source']);
        });
    }
}
