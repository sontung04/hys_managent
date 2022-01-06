<?php

namespace App\Http\Controllers;

use App\Models\Group;

class GroupController extends Controller
{
    public function list()
    {
        return view('groups.list');
    }

    public function detail()
    {
        return view('groups.detail');
    }
}
