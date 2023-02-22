<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Intern;
use App\Models\Study;
use App\Services\ClassStudentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudyController extends Controller
{
    private $classStudentService;

    public function __construct(ClassStudentService $classStudentService)
    {
        $this->classStudentService = $classStudentService;
    }

    /**
     * Lấy ra thông tin 1 buổi học
     * @param Request $request
     * @param $id
     */
    public function getInfoAjax(Request $request, $id)
    {
        $this->checkRequestAjax($request);
        $study = DB::table('studies', 's')
            ->join('interns as c', 's.coach', '=', 'c.student_code')
            ->join('interns as cs', 's.carer_staff', '=', 'cs.student_code')
            ->select('s.id', 's.lesson_id', 's.lesson_name', 's.teacher', 's.coach', 's.carer_staff',
                's.daylearn', 's.location', 's.status', 's.number_eat', 's.number_learn', 's.description',
                'c.name as coach_name', 'cs.name as carer_staff_name')
            ->where('s.id', '=', $id)
            ->get();
        $study = $study[0];
        $study->daylearn = $this->changeFormatDateOutput($study->daylearn);
        BaseHelper::ajaxResponse('success', true, $study);
    }

    /**
     * Nhận request Ajax lưu thông tin 1 buổi học
     * @param Request $request
     */
    public function saveInfoAjax(Request $request)
    {

        $this->checkRequestAjax($request);

        $requestData = $request->all();

        if (!isset($requestData['id']) || empty($requestData['id'])) {
            # Create new study
            $study = new Study();
            $study->created_by = Auth::id();
            $study->created_at = Carbon::now();
        } else {
            #update infomation study
            $study = Study::findOrFail($requestData['id']);
            $study->updated_by = Auth::id();
            $study->updated_at = Carbon::now();
        }

        if(is_numeric($requestData['lesson_id'])) {
            $study->lesson_id = $requestData['lesson_id'];
        } else {
            $study->lesson_id = 0;
            $study->lesson_name = $requestData['lesson_id'];
        }

        //Check code Intern Coach
        if (!Intern::where('student_code', '=', $requestData['coach'])->exists()) {
            BaseHelper::ajaxResponse('Mã Trợ giảng lớp không đúng!', false);
        }

        //Check code Intern Carer_staff
        if (!Intern::where('student_code', '=', $requestData['carer_staff'])->exists()) {
            BaseHelper::ajaxResponse('Mã Chủ nhiệm lớp không đúng!', false);
        }

        if ($requestData['carer_staff'] == $requestData['coach']) {
            BaseHelper::ajaxResponse('Mã Trợ giảng và Chủ Nhiệm lớp bị trùng nhau!', false);
        }

        $study->class_id     = $requestData['class_id'];
        $study->teacher      = $requestData['teacher'];
        $study->coach        = $requestData['coach'];
        $study->carer_staff  = $requestData['carer_staff'];
        $study->daylearn     = $this->changeFormatDateInput($requestData['daylearn']);
        $study->status       = $requestData['status'];
        $study->location     = $requestData['location'];

        if(!is_null($requestData['number_eat'])) $study->number_eat = $requestData['number_eat'];
        if(!is_null($requestData['number_learn'])) $study->number_learn = $requestData['number_learn'];

        $study->description  = $requestData['description'];

        try {
            $study->save();

            if (!isset($requestData['id']) || empty($requestData['id'])) {
                $this->classStudentService->updateFeeCs($requestData['class_id']);
            }

            BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true);
        } catch (\Exception $exception){
//            print_r($exception->getMessage());
//            die();
            BaseHelper::ajaxResponse(config('app.textSaveError'), false);
        }
    }
}
