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

    public function getListByCourseAjax(Request $request)
    {
        $this->checkRequestAjax($request);
        $requestData = $request->all();

        $courseIds = [];
        foreach ($requestData['courseIds'] as $val) {
            $courseIds[] = $val;
        }
        $results = DB::table('lessons')
            ->select('id', 'name', 'teacher_id', 'course_id', 'description', 'question', 'document', 'homework', 'status')
            ->whereIn('course_id', $courseIds)
            ->orderBy('course_id')
            ->get();

        $this->checkEmptyDataAjax($results);

        BaseHelper::ajaxResponse('Success!',true, $results);
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

        $lesson->name        = $requestData['name'];
        $lesson->course_id   = $requestData['course_id'];
        $lesson->teacher_id  = $requestData['teacher_id'];
        $lesson->description = $requestData['description'];
        $lesson->question    = $requestData['question'];
        $lesson->document    = $requestData['document'];
        $lesson->homework    = $requestData['homework'];

        try {
            $lesson->save();
            BaseHelper::ajaxResponse(config('app.textSaveSuccess'),true, $lesson);
        }catch (\Exception $exception){
            BaseHelper::ajaxResponse(config('app.textSaveError'),false);
        }
    }
}
