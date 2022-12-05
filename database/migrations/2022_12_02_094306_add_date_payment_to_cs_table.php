<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatePaymentToCsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classes_students', function (Blueprint $table) {
            $table->timestamp('date_payment')->nullable()->after('fees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classes_students', function (Blueprint $table) {
            $table->dropColumn('date_payment');
        });
    }
}
