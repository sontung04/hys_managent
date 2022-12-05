<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClassHcController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::prefix('/form')->group(function () {

    //Route form student register class
    Route::prefix('/class/register')->group(function () {
        Route::get('/{classid}', 'ClassStudentController@formRegister');
        Route::post('/student/checkInfoByCodeAjax', 'ClassStudentController@checkInfoByCodeAjax');
        Route::post('/submitAjax', 'ClassStudentController@submitFormRegisterAjax');
    });

    //Route form attendance student
    Route::prefix('/attendance/student')->group(function () {
        Route::get('/{studyid}', 'AttendanceController@formStudent');
        Route::post('/checkCodeStudentAjax', 'AttendanceController@checkCodeStudentAjax');
        Route::post('/submitAjax', 'AttendanceController@formStudentSubmitAjax');
    });

});


Route::middleware(['cors', 'auth'])->group(function (){
    Route::get('/', function () {
        return view('index');
    })->name('index');
    Route::get('/error404', function () {
        return view('pages.404');
    })->name('error404');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('password/change','Auth\ChangePasswordController@showChangeForm')->name('password.edit');
    Route::post('password/change','Auth\ChangePasswordController@changePassword')->name('password.change');

    //Route User
    Route::prefix('/user')->group(function () {
        Route::match(['get', 'post'],'/list', 'UserController@list')->name('user.list');
        Route::get('/create', 'UserController@create')->name('user.create');
        Route::get('/profile/{id?}', 'UserController@profile')->name('user.profile')->where('id', '[0-9]+');
        Route::post('/saveInfo', 'UserController@saveInfo');
    });

    //Route Group
    Route::prefix('/group')->group(function () {
        Route::get('/test', 'GroupController@test')->name('group.test');
        Route::get('/manage', 'GroupController@manage')->name('group.manage');
        Route::get('/list', 'GroupController@list')->name('group.list');
        Route::get('/detail/{id}', 'GroupController@detail')->where('id', '[0-9]+')->name('group.detail');
        Route::post('/saveInfoAjax', 'GroupController@saveInfoAjax');
        Route::get('/getInfoGroupAjax/{id}', 'GroupController@getInfoGroupAjax')->where('id', '[0-9]+');
        Route::get('/getListGroupOptionAjax', 'GroupController@getListGroupOptionAjax');
        Route::get('/getListGroupChild', 'GroupController@getListGroupChild');
    });

    //Route Event
    Route::prefix('/event')->group(function () {
        Route::get('/list', function () {
            return view('events.list');})->name('event.list');
    });

    //Route Role HYS
    Route::prefix('/role')->group(function () {
        Route::get('/list', 'RoleController@list')->name('role.list');
        Route::get('/manage/{userid}', 'RoleController@manage')->where('id', '[0-9]+')->name('role.manage');
        Route::get('/test2/{userid}', 'RoleController@manageTest2')->name('role.test2');
        Route::get('/getInfoAjax/{id}', 'RoleController@getInfoAjax');
        Route::get('/getListRole', 'RoleController@getListRole');
        Route::post('/saveInfoAjax', 'RoleController@saveInfoAjax');
    });

    //Route User Group Role
    Route::prefix('/ugr')->group(function () {
        Route::get('/getInfoAjax', 'UserGroupRoleController@getInfoAjax');
        Route::post('/saveInfoUgr', 'UserGroupRoleController@saveInfoUgr');
        Route::post('/updateStatusUg', 'UserGroupRoleController@updateStatusUg');
        Route::get('/deleteAjax/{id}', 'UserGroupRoleController@deleteAjax');
    });

    //Route Calendar
    Route::prefix('/calendar')->group(function () {
        Route::prefix('/weekHys')->group(function () {
            Route::get('/', function () {
                return view('calendars.weekHys');
            })->name('calendar.weekHys');
            Route::get('/getListAjax', 'CalendarController@weekHysGetListAjax');
            Route::get('/getInfoAjax/{id}', 'CalendarController@weekHysGetInfoAjax');
            Route::post('/saveInfoAjax', 'CalendarController@weekHysSaveInfoAjax');
        });
    });

    //Route Course + Teacher
    Route::prefix('/course')->group(function () {
        Route::get('/list', 'CourseController@list')->name('course.list');
        Route::get('/getInfoAjax/{id}', 'CourseController@getInfoAjax');
        Route::get('/getListCourseAjax','CourseController@getListCourseAjax');
        Route::post('/saveInfoAjax', 'CourseController@saveInfoAjax');

        Route::prefix('/teacher')->group(function () {
            Route::get('/', 'TeacherController@list')->name('course.teacherList');
            Route::get('/getInfoAjax/{id}', 'TeacherController@getInfoAjax');
            Route::get('/getListAjax','TeacherController@getListAjax');
            Route::post('/saveInfoAjax', 'TeacherController@saveInfoAjax');
        });
    });

    //Route Lesson
    Route::prefix('/lesson')->group(function () {
        Route::get('/list', function () {
            return view('lessons.list');
        })->name('lesson.list');
        Route::get('/getListByCourseAjax', 'LessonController@getListByCourseAjax');
        Route::get('/getInfoAjax/{id}', 'LessonController@getInfoAjax');
        Route::post('/saveInfoAjax', 'LessonController@saveInfoAjax');
    });

    //Route Student
    Route::prefix('/student')->group(function (){
        Route::match(['get', 'post'],'/list','StudentController@list')->name('student.list');
        Route::get('/getInfoAjax/{id}','StudentController@getInfoAjax');
        Route::post('/saveInfoAjax','StudentController@saveInfoAjax');
        Route::get('/detail/{id}', 'StudentController@getDetail');

        //Route Student - class
        Route::prefix('/class')->group(function (){
            Route::post('/addStudentToClassAjax','ClassStudentController@addStudentToClassAjax');
            Route::get('/getInfoAjax/{id}','ClassStudentController@getInfoAjax');
            Route::post('/updateInfoAjax','ClassStudentController@updateInfoAjax');
        });

        //Route Fees
        Route::prefix('/fee')->group(function (){
            Route::get('/list', 'FeeController@studentList')->name('s.fee.list');
        });
    });

    //Route Class
    Route::prefix('/class')->group(function (){

        Route::get('/diary/{classId}', 'ClassHcController@diary');

        Route::match(['get', 'post'], '/list', 'ClassHcController@list')->name('class.list');
        Route::get('/getInfoAjax/{id}', 'ClassHcController@getInfoAjax');
        Route::post('/saveInfoAjax', 'ClassHcController@saveInfoAjax');

    });

    //Route Study
    Route::prefix('/study')->group(function (){
        Route::get('/getInfoAjax/{id}', 'StudyController@getInfoAjax');
        Route::post('/saveInfoAjax', 'StudyController@saveInfoAjax');
    });

    //Route Attendance
    Route::prefix('/attendance')->group(function (){
        Route::get('/getInfoAjax', 'AttendanceController@getInfoAjax');
        Route::post('/saveInfoAjax', 'AttendanceController@saveInfoAjax');
    });

    //Route Intern
    Route::prefix('/intern')->group(function (){
        Route::get('/list','InternController@list')->name('intern.list');
        Route::get('/getInfoAjax/{id}', 'InternController@getInfoAjax');
        Route::post('/addStudentToInternAjax', 'InternController@addStudentToInternAjax');
        Route::post('/updateInfoAjax', 'InternController@updateInfoAjax');
    });


});

