<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{

    public function list()
    {
        return view('users.list');
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
        if(!$request->ajax()){
            BaseHelper::ajaxResponse('Permission denied!');
        }

        $requestData = $request->all();

        #create new user
        if (!isset($requestData['id']) || empty($requestData['id'])) {

            $user = new User();
            $user->code       = $requestData['code'];
            $user->firstname  = $requestData['firstname'];
            $user->lastname   = $requestData['lastname'];
            $user->password   = Hash::make(env('PASSWORD_DEFAULT'));
            $user->email      = $requestData['email'];
            $user->phone      = $requestData['phone'];
            $user->birthday   = $requestData['birthday'];
            $user->school     = $requestData['school'];
            $user->major      = $requestData['major'];
            $user->address    = $requestData['address'];
            $user->facebook   = $requestData['facebook'];
            $user->img        = env('AVATAR_DEFAULT');
            $user->gender     = $requestData['gender'];
            $user->skill      = $requestData['skill'];
            $user->desire     = $requestData['desire'];
            $user->company    = $requestData['company'];
            $user->work       = $requestData['work'];
            $user->created_at = time();
            $user->updated_at = time();
            $user->created_by = Auth::id();

        } else {

            #update data user
            $user = User::find($requestData['id']);
            $user->firstname  = $requestData['firstname'];
            $user->lastname   = $requestData['lastname'];
            $user->phone      = $requestData['phone'];
            $user->birthday   = $requestData['birthday'];
            $user->school     = $requestData['school'];
            $user->major      = $requestData['major'];
            $user->address    = $requestData['address'];
            $user->facebook   = $requestData['facebook'];
            $user->gender     = $requestData['gender'];
            $user->skill      = $requestData['skill'];
            $user->desire     = $requestData['desire'];
            $user->company    = $requestData['company'];
            $user->work       = $requestData['work'];
            $user->updated_by = Auth::id();
            $user->updated_at = strtotime('now');

        }

        $user->save(['timestamps' => true]);
        BaseHelper::ajaxResponse('Lưu dữ liệu thành công!', true);

        try {
            $user->save();
            BaseHelper::ajaxResponse('Lưu dữ liệu thành công!', true);
        } catch (\Exception $exception) {
            BaseHelper::ajaxResponse('Có lỗi trong quá trình xử lý dữ liệu!', false);
        }
    }
}
