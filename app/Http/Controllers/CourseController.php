<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{

    public function __construct()
    {

    }

    public function list()
    {
        $courses = Course::all();
        return view('courses.list',compact('courses'));
    }

    public function getInfoAjax(Request $request, $id){
        $this->checkRequestAjax($request);
        $course = Course::findOrFail($id);
        BaseHelper::ajaxResponse(config('app.textGetSuccess'), true, $course);
    }

    public function saveInfoAjax(Request $request ){
        $this->checkRequestAjax($request);

        $requestData = $request->all();

        if (!isset($requestData['id']) || empty($requestData['id'])){
            #create new course
            $course = new Course();
            $course->created_by = Auth::id();
            $course->created_at = Carbon::now();
        }else{
            #update a record
            $course = Course::findOrFail($requestData['id']);
            $course->updated_by = Auth::id();
            $course->updated_at = Carbon::now();
        }
        $course->name        = $requestData['name'];
        $course->fees        = $requestData['fees'];
        $course->length      = $requestData['length'];
        $course->description = $requestData['description'];
        $course->status      = $requestData['status'];

        try {
            $course->save();
            BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true, $course);
        }catch (\Exception $exception){
            BaseHelper::ajaxResponse(config('app.textSaveError'), false);
        }
    }

    public function getListCourseAjax(Request $request){
        $this->checkRequestAjax($request);

//        $requestData = $request->all();
//        $arrCondition = [];
//        foreach ($requestData as $key => $value) {
//            $arrCondition[] = [$key, '=', $value];
//        }

        $results = DB::table('courses')
//            ->where($arrCondition)
            ->select('id', 'name')->get();

        $datas = [];

        foreach ($results as $val) {
            $datas[$val->id] = [
                'id'   => $val->id,
                'name' => $val->name,
            ];
        }
        BaseHelper::ajaxResponse(config('app.textGetSuccess'), true, $datas);
    }
}
