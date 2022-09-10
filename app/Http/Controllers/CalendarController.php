<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\CalendarWeek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Function lấy ra dữ liệu hoạt động theo thời gian đầu vào
     * @param Request $request
     */
    public function weekHysGetListAjax(Request $request)
    {
        $this->checkRequestAjax($request);
        $requestData = $request->all();
        $cals = DB::table('calendars_week')
            ->where([
                ['starttime', '>=', $requestData['starttime']],
                ['starttime', '<=', $requestData['finishtime']],
            ])
            ->get();

        BaseHelper::ajaxResponse('success', true, $cals);
    }


    /**
     * Function lưu thông tin các hoạt động khi thêm mới hoặc cập nhật lịch tuần
     * @param Request $request
     */
    public function weekHysSaveInfoAjax(Request $request){
        $this->checkRequestAjax($request);

        $requestData = $request->all();
        if (!isset($requestData['id']) || empty($requestData['id'])){
            # Create new calendar week
            $calWeek = new CalendarWeek();
            $calWeek->created_by = Auth::id();
            $calWeek->created_at = time();
        }else{
            #update info calendar week
            $calWeek = CalendarWeek::findOrFail($requestData['id']);
            $calWeek->updated_by = Auth::id();
            $calWeek->updated_at = time();
        }
        $calWeek->title       = $requestData['title'];
        $calWeek->description = $requestData['description'];
        $calWeek->address     = $requestData['address'];
        $calWeek->area        = $requestData['area'];
        $calWeek->group_id    = $requestData['group_id'];
        $calWeek->group_name  = $requestData['group_name'];
        $calWeek->formality   = $requestData['formality'];
        $calWeek->starttime   = $this->changeFormatDateInput($requestData['starttime']);
        $calWeek->finishtime  = $this->changeFormatDateInput($requestData['finishtime']);

        try {
            $calWeek->save();
            BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true, $calWeek);
        } catch (\Exception $exception){
            BaseHelper::ajaxResponse(config('app.textSaveError'), false);
        }

    }
}
