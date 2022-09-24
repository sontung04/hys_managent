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
    public function __construct()
    {

    }

    /**
     * Get list all intern in database
     * @return void
     */
    public function list(){
        $interns = DB::table('interns', 'i')
            ->join('students as s', 'i.student_id', '=', 's.id')
            ->get(['s.id', 's.name','s.img', 's.phone', 's.facebook', 'i.status', 'i.starttime']);

        return view('interns/list', compact('interns'));
    }

    /**
     * Save info Intern after check condition by Ajax
     * @param Request $request
     * @return void
     */
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

    /**
     * Check the conditions for students to become interns
     * @param $id ($Student_id)
     * @return bool|void
     */
    protected function checkConditionIntern($id){
        if (isset($id)){
            return DB::table('courses', 'c')
                ->join('classes_hc as hc', 'c.id', '=', 'hc.course_id')
                ->join('classes_students as cs', 'hc.id', '=', 'cs.class_id')
                ->where([
                    ['c.id', '=', 2],                     //Id Tư duy tài năng = 2
                    ['cs.student_id', '=', $id],
                    ['hc.status', '=', 3],              //Lớp đã tổng kết (Thực tế: Lớp >= 10 buổi)
                    ['cs.status', '=', 0]         //Học viên đã hoàn thành khóa học (Thực tế: Học viên học >= 8 buổi)
                ])->exists();

        }else BaseHelper::ajaxResponse('Không có dữ liệu học viên', false);
    }

    /**
     * Get info a intern
     * @param Request $request
     * @param $id
     * @return void
     */
    public function getInfoAjax(Request $request, $id){
        $this->checkRequestAjax($request);

        $intern = DB::table('interns', )
                    ->where('student_id', '=', $id)
                    ->get();
        $intern[0]->starttime = $this->changeFormatDateOutput($intern[0]->starttime);
        $intern[0]->finishtime = $this->changeFormatDateOutput($intern[0]->finishtime);

        BaseHelper::ajaxResponse('Success', true, $intern[0]);          // Offset
    }

    /**
     * Update info Intern into 2 field: finnishtime and status
     * @param Request $request
     * @return void
     */
    public function updateInfoAjax(Request $request){
        $this->checkRequestAjax($request);

        $requestData = $request->all();

        if (!empty($requestData['intern_id'])){
            DB::table('interns', 'i')
                ->where('i.student_id', '=', $requestData['intern_id'])
                ->update([
                    'finishtime'   => $this->changeFormatDateInput($requestData['finishtime']),
                    'status'       => $requestData['status'],
                    'updated_by'   => Auth::id(),
                    'updated_at'   => Carbon::now(),
                ]);
            BaseHelper::ajaxResponse(config('app.textSaveSuccess'),true);
        }else
            BaseHelper::ajaxResponse(config('app.textSaveError'), false);
    }
}
