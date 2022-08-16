<?php

namespace App\Http\Controllers;

class CourseController extends Controller
{

    public function __construct()
    {

    }

    public function list()
    {
        return view('courses.list');
    }
}
