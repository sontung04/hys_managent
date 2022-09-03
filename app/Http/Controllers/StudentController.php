<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function __construct()
    {

    }

    public function list(){
        $students = Student::all();
        return view('students.list',compact('students'));
    }

    public function getInfoAjax(Request $request, $id){
        $this->checkRequestAjax($request);

        $student = Student::findOrFail($id);

        BaseHelper::ajaxResponse('Success', true, $student);
    }

    public function saveInfoAjax(Request $request){
        $this->checkRequestAjax($request);

        $requestData = $request->all();
        print_r($requestData);
        die();
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
        $student->birthday          = $requestData['birthday'];
        $student->img               = config('app.avatarDefault');
        $student->native_place      = $requestData['native_place'];
        $student->nation            = $requestData['nation'];
        $student->religion          = $requestData['religion'];
        $student->citizen_identify  = $requestData['citizen_identify'];
        $student->date_of_issue     = $requestData['date_of_issue'];
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
        $student->father_name       = $requestData['father_name'];
        $student->mother            = $requestData['mother'];
        $student->mother_name       = $requestData['mother_name'];
        $student->status            = $requestData['status'];

        try {
            $student->save();
            BaseHelper::ajaxResponse('Success',true);
        }catch (\Exception $exception){
            BaseHelper::ajaxResponse('Lỗi xử lí dữ liệu', false);
        }
    }

}
