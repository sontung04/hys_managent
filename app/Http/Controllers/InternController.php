<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InternController extends Controller
{

    // Lưu thông tin học viên vào thực tập sinh
    public function saveInternAjax(Request $request){
        $this->checkRequestAjax($request);

        $requestData = $request->all();

        if ($this->checkConditionIntern($requestData['student_id'])){

            $checkExist = DB::table('interns')
                ->where('student_id', '=', $requestData['student_id'])
                ->exists();

            if ($checkExist) {
                BaseHelper::ajaxResponse('Học viên đã được thêm vào danh sách thực tập sinh', false);
            }

            $student = Student::findOrFail($requestData['student_id']);

            DB::table('interns')
                ->insert([
                    'student_id'    => $student->id,
                    'name'          => $student->name,
                    'phone'         => $student->phone,
                    'status'        => $requestData['status'],
                    'starttime'     => $this->changeFormatDateInput($requestData['starttime']),
                    'finishtime'    =>$this->changeFormatDateInput( $student['finishtime']),
                    'created_by'    => Auth::id(),
                    'created_at'    => Carbon::now(),
                ]);

            BaseHelper::ajaxResponse(config('app.textSaveSuccess'),true);
        } else {
            BaseHelper::ajaxResponse('Chưa đủ điều kiện trở thành thực tập sinh', false);
        }
    }

    // Kiểm tra một học viên có đủ điều kiện thành thực tập sinh không qua student_id
    protected function checkConditionIntern($id){
        if (isset($id)){
            return DB::table('courses')
                ->join('classes_hc', 'courses.id', '=', 'classes_hc.course_id')
                ->join('classes_students', 'classes_hc.id', '=', 'classes_students.class_id')
                ->where([
                    ['courses.id', '=', 2],                     //Id Tư duy tài năng = 2
                    ['classes_students.student_id', '=', $id],
                    ['classes_hc.status', '=', 3],              //Lớp đã tổng kết (Thực tế: Lớp >= 10 buổi)
                    ['classes_students.status', '=', 0]         //Học viên đã hoàn thành khóa học (Thực tế: Học viên học >= 8 buổi)
                ])->exists();

        }else BaseHelper::ajaxResponse('Không có dữ liệu học viên');
    }
}
