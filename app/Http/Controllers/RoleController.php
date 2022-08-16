<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Role;
use App\Models\UserGroup;
use App\Services\RoleService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{


    public function __construct()
    {

    }

    public function list()
    {
        $roles = Role::all();
        return view('roles.list', compact('roles'));
    }

    public function manageTest(Request $request)
    {
//        $testU = UserGroup::findOrFail(100);
//
//        print_r(12233);
//        die();

        $userGroups = DB::table('user_groups', 'ug')
            ->join('groups as g', 'ug.group_id', '=', 'g.id')
            ->select('ug.*', 'g.name', 'g.type' )
            ->where('user_id', '=', 6)
            ->orderBy('created_at','DESC')->get();

        $userGroupRoles = DB::table('user_groups', 'ug')
            ->join('user_group_roles as ugr', 'ug.id', '=', 'ugr.ug_id')
            ->join('groups as g', 'ugr.group_id', '=', 'g.id')
            ->select('ug.group_id as groupParent', 'g.type' , 'ug.area', 'ugr.*', 'g.name' )
            ->where('ug.user_id', '=', 6)
            ->orderBy('created_at', 'DESC')->get();

//        print_r($userGroups);
//        die();
        $items = [];

        //Gộp theo các group
        foreach ($userGroups as $value) {
            if(!isset($items[$value->area])) {
                $items[$value->area] = [
                    'ugid' => $value->id,
                    'list' => [],
                    'roles' => [],
                ];
            }

            if($value->area == $value->group_id) {
                $items[$value->area]['name']      = $value->name;
                $items[$value->area]['type']      = $value->type;
                $items[$value->area]['status']    = $value->status;
                $items[$value->area]['startTime'] = $value->created_at;
                $items[$value->area]['endTime']   = $value->updated_at;
            }

            if($value->area != $value->group_id && !isset($items[$value->area]['list'][$value->id])) {
                $items[$value->area]['list'][$value->id] = [
                    'ugid' => $value->id,
                    'gid' => $value->group_id,
                    'name' => $value->name,
                    'type' => $value->type,
                    'status' => $value->status,
                    'startTime' => $value->created_at,
                    'endTime' => $value->updated_at,
                    'list' => [],
                    'roles' => [],
                ];
            }

        }

        //Lấy ra các role theo từng khu vực và gán vào mảng
        foreach ($userGroupRoles as $val) {
            if($val->area == $val->group_id) {
                if($val->area == $val->groupParent) {
                    $items[$val->area]['roles'][] = [
                        'ugrid'  => $val->id,
                        'status' => $val->status,
                        'roleid' => $val->role_id,
                        'startTime' => $val->created_at,
                        'endTime' => $val->updated_at,
                    ];
                } else {
                    $items[$val->area]['list'][$val->ug_id]['roles'][] = [
                        'ugrid'  => $val->id,
                        'status' => $val->status,
                        'roleid' => $val->role_id,
                        'startTime' => $val->created_at,
                        'endTime' => $val->updated_at,
                    ];
                }
            } else {
                if(!isset($items[$val->area]['list'][$val->ug_id]['list'][$val->group_id])) {
                    $items[$val->area]['list'][$val->ug_id]['list'][$val->group_id] = [
                        'id' => $val->id,
                        'name' => $val->name,
                        'type' => $val->type,
                        'groupid' => $val->group_id,
                        'roles' => [],
                    ];
                }

                $items[$val->area]['list'][$val->ug_id]['list'][$val->group_id]['roles'][] = [
                    'ugrid'  => $val->id,
                    'status' => $val->status,
                    'roleid' => $val->role_id,
                    'startTime' => $val->created_at,
                    'endTime' => $val->updated_at,
                ];
            }

        }

//        print_r($items);
//        die();

        $itemRoles = DB::table('roles')->select('id', 'name')->get();
        $roles = [];

        foreach ($itemRoles as $val) {
            $roles[$val->id] = $val->name;
        }

        return view('roles.test', compact('items', 'roles'));
    }

    public function manageTest2($userid, Request $request)
    {
        $userGroups = DB::table('user_groups', 'ug')
            ->join('groups as g', 'ug.group_id', '=', 'g.id')
            ->select('ug.*', 'g.name', 'g.type', 'g.parent', 'g.depart' )
            ->where('user_id', '=', $userid)
            ->orderBy('g.parent')
            ->orderBy('g.type')
            ->orderBy('ug.area')
            ->orderBy('created_at', 'DESC')->get();
//        print_r($userGroups);
//        die();

        $userGroupRoles = DB::table('user_groups', 'ug')
            ->join('user_group_roles as ugr', 'ug.id', '=', 'ugr.ug_id')
            ->select('ug.group_id' , 'ugr.*' )
            ->where('ug.user_id', '=', $userid)
            ->orderBy('created_at', 'DESC')->get();
//        print_r($userGroupRoles);
//        die();

        $items = [];
        $itemUgrs = [];

        foreach ($userGroupRoles as $value) {
            if(!isset($itemUgrs[$value->group_id])) {
                $itemUgrs[$value->group_id] = [];
            }

            $itemUgrs[$value->group_id][] = [
                'ugrid' => $value->id,
                'roleid' => $value->role_id,
                'status' => $value->status,
                'startTime' => $value->starttime,
                'endTime'   => $value->finishtime,
            ];
        }

//        print_r($itemUgrs);
//        die();

        //Gộp theo các group
        foreach ($userGroups as $value) {
            if(!isset($items[$value->area])) {
                $items[$value->area] = [];
            }

            if($value->area == $value->group_id) {
                $items[$value->area]['ugid']      = $value->id;
                $items[$value->area]['name']      = $value->name;
                $items[$value->area]['type']      = $value->type;
                $items[$value->area]['status']    = $value->status;
                $items[$value->area]['startTime'] = $value->starttime;
                $items[$value->area]['endTime']   = $value->finishtime;
                $items[$value->area]['list']      = [];
                $items[$value->area]['roles']     = [];
            }

            if(isset($itemUgrs[$value->area])) {
                $items[$value->area]['roles'] = $itemUgrs[$value->area];
            }

            if($value->parent) {
                if($value->parent == $value->area) {
                    if(!isset($items[$value->area]['list'][$value->group_id])) {
                        if ($value->type != 5) {
                            $items[$value->area]['list'][$value->group_id] = [
                                'ugid' => $value->id,
                                'name' => $value->name,
                                'type' => $value->type,
                                'status'    => $value->status,
                                'startTime' => $value->starttime,
                                'endTime'   => $value->finishtime,
                                'list'   => [],
                                'roles'  => [],
                            ];

                            if(isset($itemUgrs[$value->group_id])) {
                                $items[$value->area]['list'][$value->group_id]['roles'] = $itemUgrs[$value->group_id];
                            }

                        } else {
                            $items[$value->area]['list'][$value->depart]['list'][$value->group_id] = [
                                'ugid' => $value->id,
                                'name' => $value->name,
                                'type' => $value->type,
                                'status'    => $value->status,
                                'startTime' => $value->starttime,
                                'endTime'   => $value->finishtime,
                                'list'   => [],
                                'roles'  => [],
                            ];
                            if(isset($itemUgrs[$value->group_id])) {
                                $items[$value->area]['list'][$value->depart]['list'][$value->group_id]['roles'] = $itemUgrs[$value->group_id];
                            }
                        }
                    }

                } else {
                    if(isset($items[$value->area]['list'][$value->parent])) {
                        if($value->type != 5) {
                            $items[$value->area]['list'][$value->parent]['list'][$value->group_id] = [
                                'ugid' => $value->id,
                                'name' => $value->name,
                                'type' => $value->type,
                                'status'    => $value->status,
                                'startTime' => $value->starttime,
                                'endTime'   => $value->finishtime,
                                'list'   => [],
                                'roles'  => [],
                            ];

                            if(isset($itemUgrs[$value->group_id])) {
                                $items[$value->area]['list'][$value->parent]['list'][$value->group_id]['roles'] = $itemUgrs[$value->group_id];
                            }
                        } else {
                            $items[$value->area]['list'][$value->parent]['list'][$value->depart]['list'][$value->group_id] = [
                                'ugid' => $value->id,
                                'name' => $value->name,
                                'type' => $value->type,
                                'status'    => $value->status,
                                'startTime' => $value->starttime,
                                'endTime'   => $value->finishtime,
                                'list'   => [],
                                'roles'  => [],
                            ];

                            if(isset($itemUgrs[$value->group_id])) {
                                $items[$value->area]['list'][$value->parent]['list'][$value->depart]['list'][$value->group_id]['roles'] = $itemUgrs[$value->group_id];
                            }
                        }

                    }

                }
            }
        }

        $itemRoles = DB::table('roles')->select('id', 'name')->get();
        $roles = [];

//        print_r($items);
//        die();

        foreach ($itemRoles as $val) {
            $roles[$val->id] = $val->name;
        }

        return view('roles.test2', compact('items', 'roles', 'userid'));
    }

    public function manage()
    {
        return view('roles.manage');
    }

    public function getInfo($id, Request $request)
    {
        $this->checkRequestAjax($request);

        $role = Role::find($id);
        BaseHelper::ajaxResponse('Success!', true, $role);
    }

    public function saveInfo(Request $request)
    {
        $this->checkRequestAjax($request);

        $requestData = $request->all();
        #create new record
        if (!isset($requestData['id']) || empty($requestData['id'])) {

            $role = new Role();
            $role->created_at = time();
            $role->updated_at = time();
            $role->created_by = Auth::id();

        } else {

            #update data role
            $role = Role::find($requestData['id']);
            $role->updated_by = Auth::id();
            $role->updated_at = strtotime('now');
        }

        $role->name = $requestData['name'];
        $role->description = $requestData['description'];
        $role->status = $requestData['status'];
        $role->group_type = $requestData['group_type'];

        try {
            $role->save();
            BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true);
        } catch (\Exception $exception) {
            BaseHelper::ajaxResponse('Có lỗi trong quá trình xử lý dữ liệu!', false);
        }
    }

    public function getListRole(Request $request)
    {
        $this->checkRequestAjax($request);

        $requestData = $request->all();
        $arrCondition = [];
        foreach ($requestData as $key => $value) {
            $arrCondition[] = [$key, '=', $value];
        }

        $results = DB::table('roles')
            ->where($arrCondition)
            ->select('id', 'name')->get();

        $datas = [];

        foreach ($results as $val) {
            $datas[$val->id] = [
                'id'   => $val->id,
                'name' => $val->name,
            ];
        }

        BaseHelper::ajaxResponse('Success!', true, $datas);
    }
}
