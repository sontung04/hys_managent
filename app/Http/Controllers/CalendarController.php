<?php

namespace App\Http\Controllers;

class CalendarController extends Controller
{
    public function __construct()
    {

    }

    public function weekHys()
    {
        return view('calendars.weekHys');
    }
}
