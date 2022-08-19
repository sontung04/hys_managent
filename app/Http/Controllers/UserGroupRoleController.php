<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\UserGroupRole;
use Carbon\Carbon;
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
        if(empty($requestData['starttime'])) $requestData['starttime'] = Carbon::parse(time());
        $requestData['finishtime'] = $this->changeFormatDateInput($requestData['finishtime']);
        if(empty($requestData['finishtime'])) $requestData['finishtime'] = Carbon::parse(time());
        unset($requestData['_token']);

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

        $groupInfo = Group::select('id', 'parent', 'type', 'depart','area')
            ->where('id', $requestData['group_id'])->get();
        $groupInfo = $groupInfo[0];
        switch ($requestData['group_type']) {
//            case 1:
//                $ugRecordId = $userGroupArea->id;
//                break;
            case 2:

                if($groupInfo->parent != $groupInfo->area) {

                    $userGroupParent = UserGroup::firstOrCreate(
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupInfo->parent,
                            'area'     => $requestData['area'],
                        ],
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupInfo->parent,
                            'area'     => $requestData['area'],
                            'starttime'  => $requestData['starttime'],
                            'finishtime' => $requestData['finishtime'],
                            'created_at' => time()
                        ]
                    );

                    $userGroupDepart = UserGroup::firstOrCreate(
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupInfo->depart,
                            'area'     => $requestData['area'],
                        ],
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupInfo->depart,
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
                        'group_id' => $groupInfo->parent,
                        'area'     => $requestData['area'],
                    ],
                    [
                        'user_id'  => $requestData['userid'],
                        'group_id' => $groupInfo->parent,
                        'area'     => $requestData['area'],
                        'starttime'  => $requestData['starttime'],
                        'finishtime' => $requestData['finishtime'],
                        'created_at' => time()
                    ]
                );

                break;
            case 5:
//                print_r('case5');
//                die();
                if($groupInfo->parent == $groupInfo->area) {

                    $userGroupDepart = UserGroup::firstOrCreate(
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupInfo->depart,
                            'area'     => $requestData['area'],
                        ],
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupInfo->depart,
                            'area'     => $requestData['area'],
                            'starttime'  => $requestData['starttime'],
                            'finishtime' => $requestData['finishtime'],
                            'created_at' => time()
                        ]
                    );
                } else {

                    $groupDepartInfo = Group::select('id', 'parent', 'type', 'depart','area')
                        ->where('id', $groupInfo->depart)->get();

                    $userGroupParent = UserGroup::firstOrCreate(
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupInfo->parent,
                            'area'     => $requestData['area'],
                        ],
                        [
                            'user_id'  => $requestData['userid'],
                            'group_id' => $groupInfo->parent,
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
//        print_r(1233);
//        die();

        if ($requestData['group_type'] == 1) {
            $userGroupRecordId = $userGroupArea->id;
            if(empty($requestData['role_id'])) {
                $userGroupArea->status = 0;
                $userGroupArea->save();
            }
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

            if(empty($requestData['role_id'])) {
                $userGroupRecord->status = 0;
                $userGroupRecord->save();
            }

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

        $requestData['starttime']  = $this->changeFormatDateInput($requestData['starttime']);
        if(empty($requestData['starttime'])) $requestData['starttime'] = Carbon::parse(time());

        $requestData['finishtime'] = $this->changeFormatDateInput($requestData['finishtime']);
        if(empty($requestData['finishtime'])) $requestData['finishtime'] = Carbon::parse(time());

        if (isset($requestData['type']) && !empty($requestData['type'])) {
            if($requestData['type'] == 'ug') {
                $ug = UserGroup::find($requestData['id']);
                $this->checkEmptyDataAjax($ug);
                $ug->status = $requestData['status'];
                $ug->starttime  = $requestData['starttime'];
                $ug->finishtime = $requestData['finishtime'];
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
                $ugr->starttime  = $requestData['starttime'];
                $ugr->finishtime = $requestData['finishtime'];
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
