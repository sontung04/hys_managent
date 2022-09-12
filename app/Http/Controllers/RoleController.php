<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Role;
use App\Models\User;
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

    public function manage($userid, Request $request)
    {
        $userGroups = DB::table('user_groups', 'ug')
            ->join('groups as g', 'ug.group_id', '=', 'g.id')
            ->select('ug.*', 'g.name', 'g.type', 'g.parent', 'g.depart' )
            ->where('user_id', '=', $userid)
            ->orderBy('g.parent')
            ->orderBy('g.type')
            ->orderBy('ug.area')
            ->orderBy('created_at', 'DESC')->get();

        $userGroupRoles = DB::table('user_groups', 'ug')
            ->join('user_group_roles as ugr', 'ug.id', '=', 'ugr.ug_id')
            ->select('ug.group_id' , 'ugr.*' )
            ->where('ug.user_id', '=', $userid)
            ->orderBy('created_at', 'DESC')->get();


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

        foreach ($itemRoles as $val) {
            $roles[$val->id] = $val->name;
        }

        $userInfo = User::select('id', 'firstname', 'lastname', 'img', 'status')->where('id', $userid)->get();
        $userInfo = $userInfo[0];

        return view('roles.manage', compact('items', 'roles', 'userid', 'userInfo'));
    }

    public function getInfoAjax($id, Request $request)
    {
        $this->checkRequestAjax($request);

        $role = Role::find($id);
        BaseHelper::ajaxResponse('Success!', true, $role);
    }

    public function saveInfoAjax(Request $request)
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
            BaseHelper::ajaxResponse(config('app.textSaveError'), false);
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
