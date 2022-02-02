<?php

namespace App\Http\Controllers;

class RoleController extends Controller
{
    public function list()
    {
        return view('roles.list');
    }

    public function manage()
    {
        return view('roles.manage');
    }
}
