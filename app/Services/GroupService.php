<?php

namespace App\Services;

use App\Models\Group;
use Illuminate\Support\Facades\DB;

class GroupService
{

    /**
     * Lấy ra danh sách các Group
     * @param $request
     * @return array
     */
    public function getListGroupService($requestData = [])
    {
        if(empty($requestData)) {
            $groups = Group::all();
        } else {
            $request = [];
            foreach ($requestData as $key => $val) {
                $requestData[] = [$key, '=', $val];
            }
            $groups = DB::table('group')
                ->select('id', 'name', 'type', 'status')
                ->where($request)
                ->get();
        }

        if(!count($groups)) {
            return [];
        }

        $datas = [];
        foreach ($groups as $group) {
            $datas[$group->id] = [
                'id' => $group->id,
                'name' => $group->name,
                'type' => $group->type,
            ];
        }

        return $datas;
    }
}
