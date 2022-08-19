<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Group;
use App\Models\User;
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

//        $testQuery = DB::table('users', 'u');
//        $test = $testQuery->join('user_groups as ug', 'u.id', '=', 'ug.user_id')->where('u.id', '=', 6)->get();
//        print_r($test);
//        die();
        $query = DB::table('users', 'u');

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

            $users = $query->paginate(25, ['*'], 'page', $paged);
        } else {
            $users = $query->paginate(25);
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

            $user = new User();
            $user->code       = $requestData['code'];
            $user->password   = Hash::make(env('PASSWORD_DEFAULT'));
            $user->email      = $requestData['email'];
            $user->img        = config('app.avatarDefault');
            $user->created_at = time();
            $user->updated_at = time();
            $user->created_by = Auth::id();

        } else {

            #update data user
            $user = User::find($requestData['id']);

            $user->updated_by = Auth::id();
            $user->updated_at = strtotime('now');

        }

        $user->firstname  = $requestData['firstname'];
        $user->lastname   = $requestData['lastname'];
        $user->phone      = $requestData['phone'];
        $user->birthday   = $this->changeFormatDateInput($requestData['birthday']);
        $user->school     = $requestData['school'];
        $user->major      = $requestData['major'];
        $user->address    = $requestData['address'];
        $user->facebook   = $requestData['facebook'];
        $user->gender     = $requestData['gender'];
        $user->skill      = $requestData['skill'];
        $user->desire     = $requestData['desire'];
        $user->company    = $requestData['company'];
        $user->work       = $requestData['work'];

        try {
            $user->save();
            BaseHelper::ajaxResponse('Lưu dữ liệu thành công!', true);
        } catch (\Exception $exception) {
            BaseHelper::ajaxResponse('Có lỗi trong quá trình xử lý dữ liệu!', false);
        }
    }
}
