<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ChangePasswordController extends Controller
{
    public function showChangeForm(){
        $user = DB::table('users')->where('id',Auth::id())->get();
        return view('auth.passwords.change',compact('user'));
    }

    public function changePassword(Request $request){
        if(!Hash::check($request->input('current_password'), Auth::user()->password)){
            $this->currentPasswordFalse($request);
            return redirect()->route('password.edit');
        }

        $validator = $request->validate($this->rules(), $this->validationErrorMessages());
        if ($validator == null){
            return redirect()->route('password.edit')->withErrors();
        }

        $user = Auth::user();
        $user->password = Hash::make($request->input('new_password'));
        $user->save();
        return redirect('/');
    }

    protected function currentPasswordFalse(Request $request){
        throw ValidationException::withMessages([
            'current_password' => 'Sai mật khẩu hiện tại.'
        ]);
    }

    protected function rules(){
        return [
            'current_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'different:current_password',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ];
    }

    protected function validationErrorMessages(){
        return [
            'required' => 'Không được để trống',
            'min' => 'Ít nhất :min kí tự',
            'string' => 'Mật khẩu phải là chuỗi',
            'confirmed' => 'Mật khẩu xác nhận không khớp',
            'different' => 'Mật khẩu mới phải khác với mật khẩu cũ',
            'regex' => 'Mật khẩu phải ít nhất 1 số, 1 chữ hoa và 1 kí tự đặc biệt'
        ];
    }

}
