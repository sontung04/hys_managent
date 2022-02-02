<?php

namespace App\Http\Controllers;

class EventController extends Controller
{
    public function list()
    {
        return view('events.list');
    }
}
