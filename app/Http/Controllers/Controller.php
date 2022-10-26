<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Services\RoleService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $arrTime = explode(" ", $date);
            $strDate = $arrTime[0];
            $strDate = explode('/', $strDate);
            $strDate = implode('-', [$strDate[2], $strDate[1], $strDate[0]]);
            if(count($arrTime) > 1) {
                return $strDate . ' ' . $arrTime[1];
            }
            return $strDate;
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

    /**
     * Kiểm tra 1 giá trị có bị trùng hay không
     * Trả ra True nếu không bị trùng và ngược lại False nếu bị trùng
     * @param string $tableName
     * @param string $field
     * @return boolean
     */
    protected function checkDuplicateVal($tableName, $field, $value)
    {
        $dataCheck = DB::table($tableName)->where($field, '=', $value)->first();
        if ($dataCheck === null) {
            return true;
        }
        return false;
    }
}
