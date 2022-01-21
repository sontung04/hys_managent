<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
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
            ['area', '=', 0],
            ['parent', '=', 0],
        ])->get();

        return view('groups.list', compact('hys', 'areas', 'departments'));
    }

    public function detail($id)
    {
        $group = Group::find($id);
        return view('groups.detail', compact('group'));
    }

    public function saveInfo(Request $request)
    {
        if(!$request->ajax()){
            BaseHelper::ajaxResponse('Permission denied!');
        }

        $requestData = $request->all();

        #create new group
        if (!isset($requestData['id']) || empty($requestData['id'])) {
            $group = new Group();

            $group->type = $requestData['type'];
            $group->created_at = time();

        } else {
            #update data group

            $group = Group::find($requestData['id']);
            $group->updated_by  = Auth::id();
        }

        $group->name = $requestData['name'];
        $group->description = addslashes($requestData['description']);
        $group->email       = $requestData['email'];
        $group->facebook    = $requestData['facebook'];
        $group->youtube     = $requestData['youtube'];
        $group->instagram   = $requestData['instagram'];
        $group->tiktok      = $requestData['tiktok'];
        $group->updated_at  = time();

        if($requestData['type'] == 1) {
            $group->birthday = $this->changeFormatDate($requestData['birthday']);
            $group->song     = $requestData['song'];
            $group->color    = $requestData['color'];
            $group->address  = $requestData['address'];
            $group->slogan   = $requestData['slogan'];
        }

        try {
            $group->save();
            BaseHelper::ajaxResponse('Lưu dữ liệu thành công!', true);
        } catch (\Exception $exception) {
            BaseHelper::ajaxResponse('Có lỗi trong quá trình xử lý dữ liệu!', false);
        }

    }
}
