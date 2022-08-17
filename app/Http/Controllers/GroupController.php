<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Services\GroupService;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    private $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function list()
    {
        $hys = Group::find(1);
        $areas = DB::table('groups')->where([
            ['id', '>', 1],
            ['status', '=', 1],
            ['type', '=', 1],
            ['area', '=', 0],
            ['parent', '=', 0],
        ])->get();

        $departments = DB::table('groups')->where([
            ['status', '=', 1],
            ['type', '=', 2],
            ['area', '=', 1],
            ['parent', '=', 1],
        ])->get();

        return view('groups.list', compact('hys', 'areas', 'departments'));
    }

    public function detail($id)
    {
        $group = Group::find($id);
        return view('groups.detail', compact('group'));
    }

    public function manage(Request $request)
    {
        $groups = DB::table('groups', 'g')
            ->join('users as u', 'g.created_by', '=', 'u.id')
            ->select('g.id', 'g.parent', 'g.name', 'g.area', 'g.depart', 'g.type', 'g.status', 'g.created_at', 'u.firstname', 'u.lastname')
            ->get();
        $groupInfos = $this->groupService->getListGroupService();
        return view('groups.test', compact('groups', 'groupInfos'));
    }

    public function test(Request $request)
    {

        $tests = DB::table('users', 'u')
            ->get();

        $groups = DB::table('groups', 'g')
            ->join('users as u', 'g.created_by', '=', 'u.id')
            ->select('g.id', 'g.parent', 'g.name', 'g.area', 'g.depart', 'g.type', 'g.status', 'g.created_at', 'u.firstname', 'u.lastname')
            ->get();
        $groupInfos = $this->groupService->getListGroupService();
        return view('groups.test', compact('groups', 'groupInfos'));
    }

    public function saveInfoAjax(Request $request)
    {
        $this->checkRequestAjax($request);

        $requestData = $request->all();

        #create new group
        if (!isset($requestData['id']) || empty($requestData['id'])) {

            $group = new Group();
            $group->type = $requestData['type'];
            $group->created_at = time();
            $group->created_by = Auth::id();

        } else {
            #update data group
            $group = Group::find($requestData['id']);
            $group->updated_by = Auth::id();
        }

        if($requestData['type'] == 3) {
            $requestData['parent'] = $requestData['area'];
        }

        $group->name = $requestData['name'];
        $group->area = $requestData['area'];
        if(isset($requestData['parent'])) {
            $group->parent = $requestData['parent'];
        }
        if(isset($requestData['depart'])) {
            $group->depart = $requestData['depart'];
        }
        $group->birthday    = $this->changeFormatDateInput($requestData['birthday']);

        $group->description = addslashes($requestData['description']);
        $group->slogan      = $requestData['slogan'];
        $group->status      = $requestData['status'];
        $group->address     = $requestData['address'];
        $group->email       = $requestData['email'];
        $group->zalo        = $requestData['zalo'];
        $group->facebook    = $requestData['facebook'];
        $group->youtube     = $requestData['youtube'];
        $group->instagram   = $requestData['instagram'];
        $group->tiktok      = $requestData['tiktok'];
        $group->updated_at  = time();

        if($requestData['type'] == 1) {
            $group->song     = $requestData['song'];
            $group->color    = $requestData['color'];
        }

        try {
            $group->save();
            BaseHelper::ajaxResponse('Lưu dữ liệu thành công!', true);
        } catch (\Exception $exception) {
            BaseHelper::ajaxResponse('Có lỗi trong quá trình xử lý dữ liệu!', false);
        }
    }

    /**
     * function lấy ra thông tin của 1 group và trả ra qua ajax
     * @param $id
     * @param Request $request
     */
    public function getInfoGroupAjax($id, Request $request)
    {
        $this->checkRequestAjax($request);
        $group = Group::find($id);

        $group->birthday = $this->changeFormatDateOutput($group->birthday);

        BaseHelper::ajaxResponse('Success!', true, $group);
    }

    /**
     * function lấy ra danh sách các group để gán vào option select
     * Hàm đang được dùng dể trả dữ liệu cho View: Group/Manage
     * @param Request $request
     */
    public function getListGroupOption(Request $request)
    {
        $this->checkRequestAjax($request);

        $requestData = $request->all();

        if($requestData['field'] == 'parent') {
            $results = DB::table('groups')
                ->select('id', 'name', 'area', 'type')
                ->where([
                    ['status', '=', 1],
                    ['area', '=', $requestData['area']],
                    ['type', '=', 3],
                ])
                ->get();

        } else {
            $groupParent = Group::find($requestData['parent']);
            if($groupParent->type == 1 && $requestData['type'] == 2) {
                $requestData['area'] = 1;
            }

            if($requestData['type'] == 2) {
                $requestData['parent'] = $requestData['area'];
            }


            $results = DB::table('groups')
                ->select('id', 'name', 'area', 'type')
                ->where([
                    ['status', '=', 1],
                    ['parent', '=', $requestData['parent']],
                    ['area',   '=', $requestData['area']],
                    ['type',   '=', 2],
                ])
                ->get();
        }

        if(!count($results)) {
            BaseHelper::ajaxResponse('Dữ liệu Khu vực trống! Vui lòng thử lại sau!', false);
            return;
        }

        $datas = [];
        foreach ($results as $val) {
            $datas[$val->id] = [
                'id' => $val->id,
                'name' => $val->name,
                'type' => $val->type,
                'step' => 1,
            ];
        }

        if(($requestData['type'] == 2 || $requestData['type'] == 5) && $requestData['field'] == 'parent') {
            $area = Group::find($requestData['area']);
            $datas = [
                $area->id => [
                    'id' => $area->id,
                    'name' => $area->name,
                    'type' => $area->type,
                    'child' => $datas,
                    'step' => 0,
                ]
            ];
        }

        BaseHelper::ajaxResponse('Success!', true, $datas);
    }

    /**
     * function lấy ra danh sách các group để gán vào option select
     * Hàm trả ra 1 mảng các group được sắp xếp theo dạng cha con
     * Hàm đang được dùng dể trả dữ liệu cho View: Role/Manage
     * @param Request $request
     */
    public function getListGroupChild(Request $request)
    {
        $this->checkRequestAjax($request);

        $requestData = $request->all();

        if($requestData['type'] == 5){
            $results = DB::table('groups', 'c')
                ->join('groups as p', 'c.depart', '=', 'p.id')
                ->select('c.id', 'c.depart as parent', 'c.parent as parentArea', 'c.name', 'c.area', 'c.type', 'p.name as parentName', 'p.type as parentType' )
                ->where([
                    ['c.status', '=', 1],
                    ['c.area', '=', $requestData['area']],
                    ['c.type', '=', $requestData['type']],
                ])
                ->orderBy('c.parent','ASC')->get();
        } else {
            $results = DB::table('groups', 'c')
                ->join('groups as p', 'c.parent', '=', 'p.id')
                ->select('c.id', 'c.parent', 'c.name', 'c.area', 'c.type', 'p.name as parentName', 'p.type as parentType' )
                ->where([
                    ['c.status', '=', 1],
                    ['c.area', '=', $requestData['area']],
                    ['c.type', '=', $requestData['type']],
                ])
                ->orderBy('c.parent','ASC')->get();
        }

        if(!count($results)) {
            BaseHelper::ajaxResponse('Dữ liệu Khu vực trống! Vui lòng thử lại sau!', false);
            return;
        }

        $datas = [
            'child' => []
        ];
        foreach ($results as $val) {
            if($val->area != $val->parent) {
                if(!isset($datas[$val->parent])) {
                    $datas[$val->parent] = [
                        'id' => $val->parent,
                        'name' => $val->parentName,
                        'type' => $val->parentType,
                        'child' => [],
                    ];
                }
                $datas[$val->parent]['child'][] = [
                    'id' => $val->id,
                    'name' => $val->name,
                    'type' => $val->type,
                ];

            } else {
                $datas['child'][] = [
                    'id' => $val->id,
                    'name' => $val->name,
                    'type' => $val->type,
                    'parent' => $val->parent,
                ];
            }
        }

        BaseHelper::ajaxResponse('Success!', true, $datas);
    }
}
