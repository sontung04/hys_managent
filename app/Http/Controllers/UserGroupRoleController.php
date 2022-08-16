<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\UserGroupRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserGroupRoleController extends Controller
{
    public function getInfoAjax(Request $request)
    {
        $this->checkRequestAjax($request);

        $requestData = $request->all();

        if($requestData['type'] == 'ug') {
            $selectTable = 'user_groups';
        } else {
            $selectTable = 'user_group_roles';
        }

        $respon = DB::table($selectTable)
            ->select('id', 'status', 'starttime', 'finishtime')
            ->where('id', '=', $requestData['id'])
            ->get();

        if(!count($respon)){
            BaseHelper::ajaxResponse('Dữ liệu trống! Vui lòng thử lại sau!', false);
        }

        $respon[0]->starttime  = $this->changeFormatDateOutput($respon[0]->starttime);
        $respon[0]->finishtime = $this->changeFormatDateOutput($respon[0]->finishtime);

        BaseHelper::ajaxResponse('Success!', true, $respon[0]);
    }

    public function saveInfoUgr(Request $request)
    {
        $this->checkRequestAjax($request);

        $requestData = $request->all();
        if($requestData['group_type'] == 1) {
            $requestData['group_id'] = $requestData['area'];
        }

        $requestData['starttime']  = $this->changeFormatDateInput($requestData['starttime']);
        $requestData['finishtime'] = $this->changeFormatDateInput($requestData['finishtime']);
        unset($requestData['_token']);

//        $groupInfo = Group::select('id', 'parent', 'type', 'depart','area')
//            ->where('id', $requestData['group_id'])->get();
//        print_r($requestData);
//        die();
//        $userInfo = User::select('id', 'area')->where('id', $requestData['userid'])->get();
//        $test = DB::table('user_groups')->select('group_id')->where('user_id', 6)->get()->toArray();
//        print_r($test);
//        die();
//        print_r($userInfo);0

        $userGroupArea = UserGroup::firstOrCreate(
            [
                'user_id'  => $requestData['userid'],
                'group_id' => $requestData['area'],
                'area'     => $requestData['area'],
            ],
            [
                'user_id'  => $requestData['userid'],
                'group_id' => $requestData['area'],
                'area'     => $requestData['area'],
                'starttime'  => $requestData['starttime'],
                'finishtime' => $requestData['finishtime'],
                'created_at' => time()
            ]
        );

        switch ($requestData['type']) {
//            case 1:
//                $ugRecordId = $userGroupArea->id;
//                break;
            case 2:
                if($requestData['parent'] != $requestData['parent']) {
                    $groupInfo = Group::select('id', 'parent', 'type', 'depart','area')
                        ->where('id', $requestData['group_id'])->get();

                    $userGroupParent = UserGroup::firstOrCreate(
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupInfo[0]->parent,
                            'area'     => $requestData['area'],
                        ],
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupInfo[0]->parent,
                            'area'     => $requestData['area'],
                            'starttime'  => $requestData['starttime'],
                            'finishtime' => $requestData['finishtime'],
                            'created_at' => time()
                        ]
                    );

                    $userGroupDepart = UserGroup::firstOrCreate(
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupInfo[0]->depart,
                            'area'     => $requestData['area'],
                        ],
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupInfo[0]->depart,
                            'area'     => $requestData['area'],
                            'starttime'  => $requestData['starttime'],
                            'finishtime' => $requestData['finishtime'],
                            'created_at' => time()
                        ]
                    );
                }

                break;
//            case 3:
//                break;
            case 4:
                $userGroupParent = UserGroup::firstOrCreate(
                    [
                        'user_id'  => $requestData['userid'],
                        'group_id' => $requestData['parent'],
                        'area'     => $requestData['area'],
                    ],
                    [
                        'user_id'  => $requestData['userid'],
                        'group_id' => $requestData['parent'],
                        'area'     => $requestData['area'],
                        'starttime'  => $requestData['starttime'],
                        'finishtime' => $requestData['finishtime'],
                        'created_at' => time()
                    ]
                );

                break;
            case 5:
                $groupInfo = Group::select('id', 'parent', 'type', 'depart','area')
                    ->where('id', $requestData['group_id'])->get();
                if($requestData['parent'] == $requestData['parent']) {
                    $userGroupDepart = UserGroup::firstOrCreate(
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupInfo[0]->depart,
                            'area'     => $requestData['area'],
                        ],
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupInfo[0]->depart,
                            'area'     => $requestData['area'],
                            'starttime'  => $requestData['starttime'],
                            'finishtime' => $requestData['finishtime'],
                            'created_at' => time()
                        ]
                    );
                } else {
                    $groupDepartInfo = Group::select('id', 'parent', 'type', 'depart','area')
                        ->where('id', $groupInfo[0]->depart)->get();

                    $userGroupParent = UserGroup::firstOrCreate(
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $requestData['parent'],
                            'area'     => $requestData['area'],
                        ],
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $requestData['parent'],
                            'area'     => $requestData['area'],
                            'starttime'  => $requestData['starttime'],
                            'finishtime' => $requestData['finishtime'],
                            'created_at' => time()
                        ]
                    );

                    $userGroupDepartParent = UserGroup::firstOrCreate(
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupDepartInfo[0]->depart,
                            'area'     => $requestData['area'],
                        ],
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupDepartInfo[0]->depart,
                            'area'     => $requestData['area'],
                            'starttime'  => $requestData['starttime'],
                            'finishtime' => $requestData['finishtime'],
                            'created_at' => time()
                        ]
                    );

                    $userGroupDepartChild = UserGroup::firstOrCreate(
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupDepartInfo[0]->id,
                            'area'     => $requestData['area'],
                        ],
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupDepartInfo[0]->id,
                            'area'     => $requestData['area'],
                            'starttime'  => $requestData['starttime'],
                            'finishtime' => $requestData['finishtime'],
                            'created_at' => time()
                        ]
                    );
                }
                break;
//            default:
//                break;
        }

        if ($requestData['type'] == 1) {
            $userGroupRecordId = $userGroupArea->id;
        } else {
            $userGroupRecord = UserGroup::firstOrCreate(
                [
                    'user_id'  => $requestData['userid'],
                    'group_id' => $requestData['group_id'],
                    'area'     => $requestData['area'],
                ],
                [
                    'user_id'  => $requestData['userid'],
                    'group_id' => $requestData['group_id'],
                    'area'     => $requestData['area'],
                    'starttime'  => $requestData['starttime'],
                    'finishtime' => $requestData['finishtime'],
                    'created_at' => time()
                ]
            );

            $userGroupRecordId = $userGroupRecord->id;
        }

//        die();

        if(!empty($requestData['role_id'])) {
            $ugr = new UserGroupRole();
            $ugr->ug_id = $userGroupRecordId;
            $ugr->role_id = $requestData['role_id'];
            $ugr->status  = $requestData['status'];
            $ugr->starttime  = $requestData['starttime'];
            $ugr->finishtime = $requestData['finishtime'];
            $ugr->created_by = Auth::id();
            $ugr->updated_by = Auth::id();
            $ugr->created_at = time();

            try {
                $ugr->save();
                BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true);
            } catch (\Exception $exception) {
                BaseHelper::ajaxResponse(config('app.textSaveError'), false);
            }
        }


        BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true);
    }

    public function updateStatusUg(Request $request)
    {
        $this->checkRequestAjax($request);

        $requestData = $request->all();
        if (isset($requestData['type']) && !empty($requestData['type'])) {
            if($requestData['type'] == 'ug') {
                $ug = UserGroup::find($requestData['id']);
                $this->checkEmptyDataAjax($ug);
                $ug->status = $requestData['status'];
                $ug->updated_at = time();

                try {
                    $ug->save();
                    BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true);
                } catch (\Exception $exception) {
                    BaseHelper::ajaxResponse(config('app.textSaveError'), false);
                }

            } else {
                $ugr = UserGroupRole::find($requestData['id']);
                $this->checkEmptyDataAjax($ugr);
                $ugr->status = $requestData['status'];
                $ugr->updated_by = Auth::id();
                $ugr->updated_at = time();
                try {
                    $ugr->save();
                    BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true);
                } catch (\Exception $exception) {
                    BaseHelper::ajaxResponse(config('app.textSaveError'), false);
                }
            }
        }

        BaseHelper::ajaxResponse(config('app.textSaveError'), false);
    }

    public function deleteAjax(Request $request, $id)
    {
        $this->checkRequestAjax($request);
        $ugr = UserGroupRole::find($id);
        $this->checkEmptyDataAjax($ugr);
        $ugr->delete();
        BaseHelper::ajaxResponse('Xóa dữ liệu thành công!', true, $ugr);
    }
}
