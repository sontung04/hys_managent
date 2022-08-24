<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;
use App\Http\Plugins\BaseHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    //
    public function __construct()
    {
        
    }

    public function list(){
        $classes = Classes::all();
        return view('classes.list',compact('classes'));
    }

    public function getInfoAjax(Request $request, $id){
        $this->checkRequestAjax($request);

        $class = Classes::findOrFail($id);
        BaseHelper::ajaxResponse('success', true, $class);
    }

    public function saveInfoAjax(Request $request){
        $this->checkRequestAjax($request);

        $requestData = $request->all();
        if (!isset($requestData['id']) || empty($requestData['id'])){
            # Create new class
            $class = new Classes();
            $class->created_by = Auth::id();
            $class->created_at = Carbon::now();
        }else{
            #update infomation class
            $class = Classes::findOrFail($requestData['id']);
            $class->updated_by = Auth::id();
            $class->updated_at = Carbon::now();
        }
        $class->name          = $requestData['name'];
        $class->course_id        = $requestData['course_id'];
        $class->carer_staff      = $requestData['carer_staff'];
        $class->coach           = $requestData['coach'];
        $class->status       = $requestData['status'];
        $class->starttime       = $requestData['starttime'];
        $class->finishtime       = $requestData['finishtime'];

        try {
            $class->save();
            BaseHelper::ajaxResponse('success', true);
        }catch (\Exception $exception){
            BaseHelper::ajaxResponse('Lỗi xử lý dữ liệu', false);
        }

    }

}
