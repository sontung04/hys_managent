<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function __construct()
    {

    }

    public function list(Request $request){
        $filters = $request->all();

        $query = DB::table('students', 's');

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
            $students = $query->paginate(25, ['*'], 'page', $paged);
        }else
            $students = $query->paginate(25);

        return view('students.list',compact('students', 'filters'));
    }

    public function getInfoAjax(Request $request, $id){
        $this->checkRequestAjax($request);

        $student = Student::findOrFail($id);
        $student->birthday        = $this->changeFormatDateOutput($student->birthday);
        $student->date_of_issue   = $this->changeFormatDateOutput($student->date_of_issue);
        $student->father_birthday = $this->changeFormatDateOutput($student->father_birthday);
        $student->mother_birthday = $this->changeFormatDateOutput($student->mother_birthday);
        BaseHelper::ajaxResponse('Success', true, $student);
    }

    public function saveInfoAjax(Request $request)
    {
        $this->checkRequestAjax($request);

        $requestData = $request->all();

        if (!isset($requestData['id']) || empty($requestData['id'])){
            # create a new student
            $student = new Student();
            $student->created_by = Auth::id();
            $student->created_at = Carbon::now();
        }else{
            # update student
            $student = Student::findOrFail($requestData['id']);
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
//        $student->status            = $requestData['status'];

        try {
            $student->save();
            BaseHelper::ajaxResponse(config('app.textSaveSuccess'),true);
        }catch (\Exception $exception){
            BaseHelper::ajaxResponse(config('app.textSaveError'), false);
        }
    }

}
