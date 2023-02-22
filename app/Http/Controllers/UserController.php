<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Group;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{

    public function list(Request $request, User $user)
    {
        $filters = $request->all();

        $query = DB::table('users', 'u');
        $query->orderBy('u.code', 'DESC');

        $departs = DB::table('groups')
            ->select('id', 'name')
            ->where([
//                ['status', '=', 1],
                ['area', '=', 1],
                ['parent', '=', 1],
                ['type', '=', 2],
            ])->get();

        if($request->isMethod('POST'))
        {
//            print_r($filters);
//            die();
            $paged = $filters['page'];
            unset($filters['_token']);
            unset($filters['page']);
//            $query = $user;

            foreach ($filters as $key => $value) {
                if($value != '' && $value != NULL ) {
                    switch ($key) {
                        case 'area':
                            $query = $query->where('u.area', '=', $value);
                            break;
                        case 'code':
                            $query = $query->where('u.code', 'LIKE', '%' . $value . '%');
                            break;
                        case 'name':
                            $strNameArr = explode(' ', $value);
                            if(count($strNameArr) == 1) {
                                $query = $query->where(function ($query) use ($value) {
                                    $query->where('u.firstname', 'LIKE', '%' . $value . '%')
                                        ->orWhere('u.lastname', 'LIKE', '%' . $value . '%');
                                });
                            } else {
                                $firstname = $strNameArr[count($strNameArr) - 1];
                                unset($strNameArr[count($strNameArr) - 1]);
                                $lastname = implode(' ', $strNameArr);
                                $query = $query->where([
                                        ['u.firstname', 'LIKE', '%' . $firstname . '%'],
                                        ['u.lastname', 'LIKE', '%' . $lastname . '%'],
                                    ]);
                            }
                            break;
                        case 'status':
                            $query = $query->where('status', '=', $value);
                            break;
                        case 'jointime':
                            $query = $query->where('u.jointime', '>=', $this->changeFormatDateInput($filters['jointime']));
                            break;
                        default:
                            break;
                    }
                }
            }

            $users = $query->paginate(20, ['*'], 'page', $paged);
        } else {
            $users = $query->paginate(20);
        }
//        $users = DB::table('users')->paginate(1);
//        $paged = $users->currentPage();

        return view('users.list', compact('users', 'filters', 'departs'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function profile($id = null)
    {
        if(is_null($id)) {
            $id = Auth::id();
        }
        $user = User::find($id);
        return view('users.profile', compact('user'));
    }

    public function saveInfo(Request $request)
    {
        $this->checkRequestAjax($request);

        $requestData = $request->all();

        #create new user
        if (!isset($requestData['id']) || empty($requestData['id'])) {

            if(!$this->checkDuplicateVal('users', 'phone', $requestData['phone'])) {
                BaseHelper::ajaxResponse('SĐT của bạn bị trùng với một tài khoản khác! <br> Vui lòng kiểm tra lại SĐT người dùng!', false);
            }

            if(!$this->checkDuplicateVal('users', 'email', $requestData['email'])) {
                BaseHelper::ajaxResponse('Email của bạn bị trùng với một tài khoản khác! <br> Vui lòng kiểm tra lại Email người dùng!', false);
            }

            $user = new User();
            $user->code       = $requestData['code'];
            $user->area       = $requestData['area'];
            $user->password   = Hash::make(env('PASSWORD_DEFAULT'));
            $user->img        = config('app.avatarDefault');
            $user->created_at = time();
            $user->updated_at = time();
            $user->created_by = Auth::id();

        } else {

            #update data user
            $user = User::find($requestData['id']);

            if($user->phone != $requestData['phone'] && !$this->checkDuplicateVal('users', 'phone', $requestData['phone'])) {
                BaseHelper::ajaxResponse('SĐT người dùng bị trùng với một tài khoản khác! <br> Vui lòng kiểm tra lại SĐT người dùng!', false);
            }

            if($user->email != $requestData['email'] && !$this->checkDuplicateVal('users', 'email', $requestData['email'])) {
                BaseHelper::ajaxResponse('Email người dùng bị trùng với một tài khoản khác! <br> Vui lòng kiểm tra lại Email người dùng!', false);
            }

            $user->updated_by = Auth::id();
            $user->updated_at = strtotime('now');
        }

        $user->firstname  = $requestData['firstname'];
        $user->lastname   = $requestData['lastname'];
        $user->email      = $requestData['email'];
        $user->phone      = $requestData['phone'];
        $user->birthday   = $this->changeFormatDateInput($requestData['birthday']);
        $user->school     = $requestData['school'];
        $user->major      = $requestData['major'];
        $user->address    = $requestData['address'];
        $user->facebook   = $requestData['facebook'];
        $user->gender     = $requestData['gender'];
        $user->status     = $requestData['status'];
        $user->jointime   = $this->changeFormatDateInput($requestData['jointime']);
        $user->stoptime   = $this->changeFormatDateInput($requestData['stoptime']);
        $user->skill      = $requestData['skill'];
        $user->desire     = $requestData['desire'];
        $user->company    = $requestData['company'];
        $user->work       = $requestData['work'];

        if($requestData['status'] == 0) {
            $user->stoptime = Carbon::now();
        }

        try {
            $user->save();

            if (!isset($requestData['id']) || empty($requestData['id'])) {
                $checkStudent = Student::select('id')
                    ->where('phone', '=', $requestData['phone'])
                    ->orWhere('email', '=', $requestData['email'])
                    ->get();

                if(!is_null($checkStudent)) {
                    $student = Student::find($checkStudent[0]->id);
                    $student->user_id = $user->id;
                    $student->save();
                }

            }
            BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true);
        } catch (\Exception $exception) {
//            print_r($exception->getMessage());
//            die();
            BaseHelper::ajaxResponse(config('app.textSaveError'), false);
        }
    }
}
