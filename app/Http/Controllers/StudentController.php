<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Student;
use App\Models\User;
use App\Services\StudentService;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    private $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function list(Request $request){
        $filters = $request->all();

        $query = DB::table('students', 's');

        $query->orderBy('code', 'DESC');

        if ($request->isMethod('POST')){
            $paged = $filters['page'];
            unset($filters['page']);
            unset($filters['_token']);

            foreach ($filters as $key => $value){
                if ($value != '' && $value != NULL){
                    switch ($key){
                        case 'name':
                            $query->where('s.name', 'LIKE', '%' . $value . '%');
                            break;
                        case 'phone':
                            $query->where('s.phone', 'LIKE', '%' . $value . '%');
                            break;
                        case 'email':
                            $query->where('s.email', 'LIKE', '%' . $value . '%');
                            break;
                        case 'gender':
                            $query->where('s.gender', '=', $value);
                            break;
                        case 'yearOfBirth':
                            $query->where('s.birthday', 'LIKE', $value . '%');
                            break;
                        default:
                            break;
                    }
                }
            }

            $students = $query->paginate(20, ['*'], 'page', $paged);
        } else {
            $students = $query->paginate(20);
        }


        return view('students.list',compact('students', 'filters'));
    }

    /**
     * Lấy ra thông tin của 1 học viên theo id và trả ra Ajax
     * @param Request $request
     * @param $id
     */
    public function getInfoAjax(Request $request, $id){
        $this->checkRequestAjax($request);

        $student = Student::findOrFail($id);
        $student->birthday        = $this->changeFormatDateOutput($student->birthday);
        $student->date_of_issue   = $this->changeFormatDateOutput($student->date_of_issue);
        $student->father_birthday = $this->changeFormatDateOutput($student->father_birthday);
        $student->mother_birthday = $this->changeFormatDateOutput($student->mother_birthday);
        BaseHelper::ajaxResponse('Success', true, $student);
    }

    /**
     * Nhận Request Ajax lưu thông tin của học viên
     * @param Request $request
     */
    public function saveInfoAjax(Request $request)
    {
        $this->checkRequestAjax($request);

        $requestData = $request->all();

        if (!isset($requestData['id']) || empty($requestData['id'])){
            if(!$this->checkDuplicateVal('students', 'phone', $requestData['phone'])) {
                BaseHelper::ajaxResponse('SĐT học viên bị trùng với một học viên khác! <br> Vui lòng kiểm tra lại SĐT học viên!', false);
            }

            if(!$this->checkDuplicateVal('students', 'email', $requestData['email'])) {
                BaseHelper::ajaxResponse('Email học viên bị trùng với một học viên khác! <br> Vui lòng kiểm tra lại email học viên!', false);
            }

            # create a new student
            $student = new Student();
            $student->code       = $this->studentService->createNewCodeStudent();
            $student->created_by = Auth::id();
            $student->created_at = Carbon::now();

            $checkUser = User::select('id')
                ->where('phone', '=', $requestData['phone'])
                ->orWhere('email', '=', $requestData['email'])
                ->get();

            if(!is_null($checkUser)) {
                $student->user_id = $checkUser[0]->id;
            }
        } else {
            # update student
            $student = Student::findOrFail($requestData['id']);

            if($student->phone != $requestData['phone'] && !$this->checkDuplicateVal('students', 'phone', $requestData['phone'])) {
                BaseHelper::ajaxResponse('SĐT học viên bị trùng với một học viên khác! <br> Vui lòng kiểm tra lại SĐT học viên!', false);
            }

            if($student->email != $requestData['email'] && !$this->checkDuplicateVal('students', 'email', $requestData['email'])) {
                BaseHelper::ajaxResponse('Email học viên bị trùng với một học viên khác! <br> Vui lòng kiểm tra lại Email học viên!', false);
            }

            $student->updated_by = Auth::id();
            $student->updated_at = Carbon::now();
        }

        $student->name              = $requestData['name'];
        $student->gender            = $requestData['gender'];
        $student->birthday          = $this->changeFormatDateInput($requestData['birthday']);
        $student->img               = config('app.avatarDefault');
        $student->native_place      = $requestData['native_place'];
        $student->nation            = $requestData['nation'];
        $student->religion          = $requestData['religion'];
        $student->citizen_identify  = $requestData['citizen_identify'];
        $student->date_of_issue     = $this->changeFormatDateInput($requestData['date_of_issue']);
        $student->place_of_issue    = $requestData['place_of_issue'];
        $student->address           = $requestData['address'];
        $student->phone             = $requestData['phone'];
        $student->email             = $requestData['email'];
        $student->facebook          = $requestData['facebook'];
        $student->school            = $requestData['school'];
        $student->major             = $requestData['major'];
        $student->guardian_name     = $requestData['guardian_name'];
        $student->guardian_phone    = $requestData['guardian_phone'];
        $student->father            = $requestData['father'];
        $student->father_birthday   = $this->changeFormatDateInput($requestData['father_birthday']);
        $student->father_job        = $requestData['father_job'];
        $student->mother            = $requestData['mother'];
        $student->mother_birthday   = $this->changeFormatDateInput($requestData['mother_birthday']);;
        $student->mother_job        = $requestData['mother_job'];

        try {
            $student->save();
            BaseHelper::ajaxResponse(config('app.textSaveSuccess'),true);
        }catch (\Exception $exception){
//            print_r($exception->getMessage());
//            die();
            BaseHelper::ajaxResponse(config('app.textSaveError'), false);
        }
    }

    /**
     * Function lấy ra các thông tin của 1 học viên theo id và trả ra view
     * @param $id
     */
    public function getDetail($id)
    {
        $student = Student::findOrFail($id);
        // $detail = DB::table('students')
        //         ->select('*')
        //         ->where('students.id', '=', $id)
        //         ->get();
        return view('students.detail', compact('student'));
    }


}
