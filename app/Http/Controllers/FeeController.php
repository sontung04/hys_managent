<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    public function __construct()
    {

    }

    public function studentList()
    {
        $students = DB::table('students', 's')->get();
        return view('students.fees.list', compact('students'));
    }
}
