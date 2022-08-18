<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class LessonController extends Controller
{
    public function __construct()
    {

    }

    public function list(Request $request)
    {
        $this->checkRequestAjax($request);

        $lesson = DB::table('lessons')->where('course_id',$request->input())->get();
        return view('lessons.list',compact('lesson'));
    }

    public function getInfoAjax(Request $request, $id){
        $this->checkRequestAjax($request);

        $lesson = Lesson::findOrFail($id);
        BaseHelper::ajaxResponse('Success!', true, $lesson);

    }

    public function saveInfoAjax(Request $request){
        $this->checkRequestAjax($request);

        $requestData = $request->all();

        if (!isset($requestData['id']) || empty($requestData['id'])){
            # Create new lesson
            $lesson = new Lesson();
            $lesson->created_by = Auth::id();
            $lesson->created_at = Carbon::now();
        }else{
            #update lesson
            $lesson = Lesson::findOrFail($requestData['id']);
            $lesson->updated_by = Auth::id();
            $lesson->updated_at = Carbon::now();
        }

        $lesson->name       = $requestData['name'];
        $lesson->teacher    = $requestData['teacher'];
        $lesson->description= $requestData['description'];
        $lesson->question   = $requestData['question'];
        $lesson->document   = $requestData['document'];
        $lesson->homework   = $requestData['homework'];
        $lesson->course_id = $requestData['course_id'];

        try {
            $lesson->save();
            BaseHelper::ajaxResponse('Success!',true,$lesson);
        }catch (\Exception $exception){
            BaseHelper::ajaxResponse('Lỗi xử lý dữ liệu',false);
        }
    }
}
