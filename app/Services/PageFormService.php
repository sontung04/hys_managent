<?php

namespace App\Services;

/**
 * Dùng để kiểm tra điều kiện cho form của attendance và student register
 */

class PageFormService
{
    /**
     * Function kiểm tra số điện thoại học viên có tồn tại và hợp lệ hay không
     * @param string $phone
     * @return string msg
     */
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

    /**
     * Function kiểm tra email học viên có tồn tại và hợp lệ hay không
     * @param string $email
     * @return string msg
     */
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
