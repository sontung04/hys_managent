<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        View::share('area', config('app.area'));
        View::share('groupType', config('app.groupType'));
    }

    public function changeFormatDate( $date)
    {
        $date = explode('/', $date);
        return implode('-', [$date[2], $date[1], $date[0]]);
    }
}
