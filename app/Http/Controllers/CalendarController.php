<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Plugins\BaseHelper;
class CalendarController extends Controller
{
    public function __construct()
    {

    }

    public function weekHys()
    {
        $events = array();
        $calendars = Calendar::all();
        // dd($calendars);
        foreach($calendars as $calendar){
            $events[] = [
                'id' => $calendar->id,
                'title' => $calendar->title,
                'start' => $calendar->starttime,
                'end' => $calendar->endtime,
            ];
        }
        // dd($events);
        return view('calendars.index', ['events' => $events]);
    }

    public function create(){
        return view('calendars.create');
    }
    public function store1(Request $request){
        $data = $request->all();
        Calendar::create($data);
        return redirect('/calendars/weekHys');
    }
    public function store2(Request $request){
        $this->checkRequestAjax($request);

        $requestData = $request->all();
        #create new record
        if (!isset($requestData['id']) || empty($requestData['id'])) {

            $calendar = new Calendar();
            $calendar->created_at = time();
            $calendar->updated_at = time();
            $calendar->created_by = Auth::id();

        } else {

            #update data 
            $calendar = Calendar::find($requestData['id']);
            $calendar->updated_by = Auth::id();
            $calendar->updated_at = strtotime('now');
        }

        $calendar->title = $requestData['title'];
        $calendar->description = $requestData['description'];
        $calendar->starttime = $requestData['startime'];
        $calendar->endtime = $requestData['endtime'];
        $calendar->address = $requestData['address'];
        $calendar->area = $requestData['area'];
        $calendar->formality = $requestData['formality'];
        $calendar->group_id = $requestData['group_id'];

        try {
            $calendar->save();
            BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true);
        } catch (\Exception $exception) {
            BaseHelper::ajaxResponse('Có lỗi trong quá trình xử lý dữ liệu!', false);
        }
    }

    public function getInfoCalendar($id, Request $request)
    {
        $this->checkRequestAjax($request);

        $role = Calendar::find($id);

        BaseHelper::ajaxResponse('Success!', true, $role);
    }
}
