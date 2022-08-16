<?php

namespace App\Http\Controllers;

class LessonController extends Controller
{
    public function __construct()
    {

    }

    public function list()
    {
        return view('lessons.list');
    }
}
