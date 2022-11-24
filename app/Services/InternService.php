<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class InternService
{
    /**
     * Lấy ra danh sách các TTS hiện tại
     * @return array
     */
    public function getListCurrent()
    {
        $interns = DB::table('interns')
            ->select('student_code', 'name')
            ->where('status', '=', 1)->get();

        if(!count($interns)) {
            return [];
        }

        $datas = [];
        foreach ($interns as $intern) {
            $datas[$intern->student_code] = [
                'code' => $intern->student_code,
                'name' => $intern->name,
            ];
        }

        return $datas;
    }

}
