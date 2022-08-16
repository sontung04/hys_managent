<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RoleService
{
    public static function setSessionCurrentRole()
    {
        $results = DB::table('user_groups', 'ug')
            ->join('user_group_roles as ugr', 'ug.id', '=', 'ugr.ug_id')
            ->select('ug.group_id as groupParent', 'ug.area', 'ugr.role_id', 'ugr.group_id')
            ->where([
                ['ug.user_id', '=', 6],
                ['ug.status', '=', 1],
                ['ugr.status', '=', 1],
            ])->get();
        $datas = [];
        foreach ($results as $result) {
            if(!isset($datas[$result->area])) {
                $datas[$result->area] = [];
            }

            if($result->group_id == $result->area) {
                $datas[$result->area][$result->groupParent] = $result->role_id;
            } else {
                $datas[$result->area][$result->group_id] = $result->role_id;
            }
        }
        Session::put('currentRole' . Auth::id(), $datas);

    }
}
