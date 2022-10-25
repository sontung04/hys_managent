<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeedbackToAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->tinyInteger('student_type')->default(0)->after('student_id')
                ->comment('0: Học viên, 1: Chủ Nhiệm, 2: Trợ giảng');
            $table->text('feedback')->nullable()->default('')->after('note');
            $table->text('question')->nullable()->default('')->after('feedback');
            $table->text('comment')->nullable()->default('')->after('question');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['student_type', 'feedback', 'question', 'comment']);
        });
    }
}
