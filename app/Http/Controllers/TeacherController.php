<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function __construct()
    {

    }

    public function list(){
        $teachers = Teacher::all();
        return view('courses.teacher',compact('teachers'));
    }

    public function getInfoAjax(Request $request, $id){
        $this->checkRequestAjax($request);

        $teacher = Teacher::findOrFail($id);
        $teacher->birthday = $this->changeFormatDateOutput($teacher->birthday);
        BaseHelper::ajaxResponse('success', true, $teacher);
    }

    public function saveInfoAjax(Request $request){
        $this->checkRequestAjax($request);

        $requestData = $request->all();
        if (!isset($requestData['id']) || empty($requestData['id'])){
            # Create new teacher
            $teacher = new Teacher();
            $teacher->created_by = Auth::id();
            $teacher->created_at = Carbon::now();
        }else{
            #update infomation teacher
            $teacher = Teacher::findOrFail($requestData['id']);
            $teacher->updated_by = Auth::id();
            $teacher->updated_at = Carbon::now();
        }
        $teacher->name          = $requestData['name'];
        $teacher->subname       = $requestData['subname'];
        $teacher->gender        = $requestData['gender'];
        $teacher->birthday      = $this->changeFormatDateInput($requestData['birthday']);
        $teacher->img           = config('app.avatarDefault');
        $teacher->address       = $requestData['address'];
        $teacher->level         = $requestData['level'];
        $teacher->job           = $requestData['job'];
        $teacher->position      = $requestData['position'];
        $teacher->description   = $requestData['description'];

        try {
            $teacher->save();
            BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true);
        }catch (\Exception $exception){
            BaseHelper::ajaxResponse(config('app.textSaveError'), false);
        }

    }

    public function getListAjax(Request $request)
    {
        $this->checkRequestAjax($request);

        $results = Teacher::select('id', 'name', 'subname')->get();

        $datas = [];

        foreach ($results as $val) {
            $datas[$val->id] = [
                'id' => $val->id,
            ];

            if(empty($val->subname)) {
                $datas[$val->id]['name'] = $val->name;
            } else {
                $datas[$val->id]['name'] = $val->subname . ' ' . $val->name;
            }
        }
        BaseHelper::ajaxResponse(config('app.textGetSuccess'), true, $datas);
    }
}
