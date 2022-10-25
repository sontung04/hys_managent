<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameStudentIdInClassesStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classes_students', function (Blueprint $table) {
            $table->renameColumn('student_id', 'student_code');
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
            $table->renameColumn('student_code', 'student_id');
        });
    }
}
