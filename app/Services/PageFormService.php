<?php

namespace App\Services;

class PageFormService
{
    public function phoneValidation($phone) {
        if (preg_match('/^(09|03|07|08|05)+[0-9]{8}$/', $phone)) {
            if (!StudentService::checkIssetByPhone($phone)) {
                return [
                    'msg' => 'Số điện thoại không tồn tại!'
                ];
            }
            return;
        }
        return [
            'msg' => 'Số điện thoại không hợp lệ!'
        ];
    }

    public function emailValidation($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (!StudentService::checkIssetByEmail($email)) {
                return [
                    'msg' => 'Email không tồn tại!'
                ];
            }
            return;
        }
        return [
            'msg' => 'Email không hợp lệ!'
        ];
    }
}
