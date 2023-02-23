<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ClassStudentService
{

    /**
     * Update trạng thái Các học viên trong 1 Lớp
     * Khi update trạng thái của lớp: Hoàn thành hay Tạm dừng
     * @param integer $class_id
     * @param integer $class_status
     * @return boolean
     */
    public function updateStatusCs($class_id, $class_status)
    {
        $whereCondition = [
            ['class_id', $class_id],
            ['status', 1]
        ];

        if($class_status == 0) {
            DB::table('classes_students')
                ->where($whereCondition)
                ->update(['status' => 3]); //Bảo lưu khóa học
            return true;
        }

        $classInfo = DB::table('classes_hc', 'chc')
            ->select('chc.course_id', 'c.length', 'c.fees')
            ->join('courses as c', 'chc.course_id', '=', 'c.id')
            ->where('chc.id', '=', $class_id)
            ->get();
        $classInfo = $classInfo[0];

        $results = DB::select( DB::raw("SELECT COUNT(ca.id) AS learn, ca.student_code FROM (
            SELECT s.lesson_id, COUNT(a.id) AS id, a.student_code
            FROM attendances a
            INNER JOIN studies s ON a.study_id = s.id
            INNER JOIN classes_hc c ON s.class_id = c.id
            WHERE a.student_code IN (SELECT student_code FROM classes_students WHERE class_id = :class_id)
            AND c.course_id = :course_id AND a.status <> 0
            GROUP BY a.student_code, s.lesson_id ) AS ca
            GROUP BY ca.student_code"), [
            'class_id' => $class_id,
            'course_id' => $classInfo->course_id,
        ]);

        $studentDone = [];
        $studentFail = [];
        $studentFailFee = [];

        foreach ($results as $result) {
            if($result->learn / $classInfo->length >= 2/3) {
                $studentDone[] = $result->student_code;
            } else {
                $studentFail[] = $result->student_code;
                $studentFailFee[$result->student_code] = $result->learn;
            }
        }

        try {
            if(!empty($studentDone)) {
                DB::table('classes_students')
                    ->where($whereCondition)
                    ->whereIn('student_code', $studentDone)
                    ->update(['status' => 2]); //Hoàn thành khóa học
            }


            if(!empty($studentFail)) {
                DB::table('classes_students')
                    ->where($whereCondition)
                    ->whereIn('student_code', $studentFail)
                    ->update(['status' => 4]); //Học lại khóa học

                if($classInfo->length > 10) {

                    foreach ($studentFailFee as $key => $value) {

                        if($value < 10) {
                            $courseFee = round($classInfo->fees / $classInfo->length, -4) * $value;
                        } else {
                            $courseFee = $classInfo->fees;
                        }

                        DB::table('classes_students')
                            ->where([
                                ['student_code', $key],
                                ['class_id', $class_id],
                            ])
                            ->update(['fees' => $courseFee]);
                    }
                }
            }

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param $class_id
     */
    public function updateFeeCs($class_id)
    {
        $classInfo = DB::table('classes_hc', 'chc')
            ->select('chc.course_id', 'c.length', 'c.fees',
                DB::raw('COUNT(s.id) as studies'))
            ->join('courses as c', 'chc.course_id', '=', 'c.id')
            ->join('studies as s', 'chc.id', '=', 's.class_id')
            ->where('chc.id', '=', $class_id)
            ->get();
        $classInfo = $classInfo[0];

        if($classInfo->length >= 10) {
            $timeline = round($classInfo->length / 3);

            if($classInfo->studies == $timeline) {
                $courseFee = round($classInfo->fees / 3, -4);
            } elseif($classInfo->studies == $timeline * 2) {
                $courseFee = round($classInfo->fees / 3, -4) * 2;
            } elseif ($classInfo->studies == $classInfo->length) {
                $courseFee = $classInfo->fees;
            }

            if(isset($courseFee)) {
                try {
                    DB::table('classes_students')
                        ->where([
                            ['class_id', $class_id],
                        ])
                        ->whereIn('status', [1, 2])
                        ->update(['fees' => $courseFee]); //Cập nhập tiền học học viên
                    return true;
                } catch (\Exception $exception) {
                    return false;
                }
            }
        }

        return true;
    }


    public function updateFeeStudentClass($student_code, $class_id, $course_id)
    {
        $courseInfo = DB::table('courses')
            ->select('fees', 'length')
            ->where('id', '=', $course_id)
            ->get();

        $courseInfo = $courseInfo[0];

        $countAtten = DB::table('attendances', 'a')
            ->select('a.id')
            ->join('studies as s', 'a.study_id', '=', 's.id')
            ->join('classes_hc as chc', 's.class_id', '=', 'chc.id')
            ->where([
                ['a.student_code', '=', $student_code],
                ['chc.course_id', '=', $course_id],
                ['a.status', '<>', 0],
            ])
            ->groupBy('s.lesson_id')
            ->get();

        if(count($countAtten) < 10) {
            $courseFee = round($courseInfo->fees / $courseInfo->length, -4) * count($countAtten);
        } else {
            $courseFee = $courseInfo->fees;
        }

        try {
            DB::table('classes_students')
                ->where([
                    ['student_code', $student_code],
                    ['class_id', $class_id],
                ])
                ->update(['fees' => $courseFee]); //Cập nhập tiền học học viên
            return true;
        } catch (\Exception $exception) {
//            print_r($exception->getMessage());
//            die();
            return false;
        }
    }
}
