<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Services\RoleService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {

    }

    protected function changeFormatDateInput($date)
    {
        if(!empty($date)) {
            $date = explode('/', $date);
            return implode('-', [$date[2], $date[1], $date[0]]);
        }
        return NULL;
    }

    protected function changeFormatDateOutput($date)
    {
        if(!empty($date)) {
            $date = date_format(date_create($date), "Y/m/d");
            $date = explode('/', $date);
            return $date[2] . '/' . $date[1] . '/' . $date[0];
        }
        return NULL;
    }

    protected function checkRequestAjax($request)
    {
        if(!$request->ajax()){
            BaseHelper::ajaxResponse('Quyền truy cập bị từ chối!');
        }
    }

    protected function checkEmptyDataAjax($data)
    {
        if(empty($data)) {
            BaseHelper::ajaxResponse('Dữ liệu trống! Vui lòng thử lại sau!', false);
        }
    }
}
