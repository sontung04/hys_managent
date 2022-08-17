<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $teacher = Teacher::finOrFail($id);
        BaseHelper::ajaxResponse('Success!', true, $teacher);
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
        $teacher->gender        = $requestData['gender'];
        $teacher->birthday      = $requestData['birthday'];
        $teacher->native_place  = $requestData['native_place'];
        $teacher->level         = $requestData['level'];
        $teacher->job           = $requestData['job'];
        $teacher->position      = $requestData['position'];
        $teacher->description   = $requestData['description'];

        try {
            $teacher->save();
            BaseHelper::ajaxResponse('Success', true, $teacher);
        }catch (\Exception $exception){
            BaseHelper::ajaxResponse('Lỗi xử lý dữ liệu', false);
        }

    }
}
