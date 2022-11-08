
@extends('layouts.index')

@section('title', 'HYS - Form Checkin Học viên CiTEdu')

@section('style')
    <style>
        body {
            background: -webkit-gradient(linear, left bottom, left top, from(#fbc2eb), to(#a18cd1));
            background: -webkit-linear-gradient(bottom, #fbc2eb 0%, #a18cd1 100%);
            background: -moz-linear-gradient(bottom, #fbc2eb 0%, #a18cd1 100%);
            background: -o-linear-gradient(bottom, #fbc2eb 0%, #a18cd1 100%);
            background: linear-gradient(to top, #fbc2eb 0%, #a18cd1 100%);
        }

        @media only screen and (max-width: 550px) {
            #divFormCheckinStudent {
                max-width: 360px;
            }
        }
    </style>
@endsection

@section('script')
    <script src="{{ asset('assets/js/page/form/attendanceStudent.js') }}" defer></script>
@endsection

@section('content')
    <div class="container">
        <br>
        <br>
        <br>

        <div class="register-logo" >
            <a href="javascript:void(0);"><h1 style="color: black">Checkin buổi học</h1></a>

            <a href="javascript:void(0);"><h1 style="color: black">{{$studyInfo->class_name}}</h1></a>
        </div>
        <br>

        <div style="width: 100%; display: flex; justify-content: center;">
            <!-- form check isset student -->
            <div class="card" id="divCheckIssetStudent" style="width: 360px">
                <div class="card-body register-card-body">
                    <div style="text-align: center">
                        <b style="font-size: 1.5rem; color: #28a745"> Tên bài:
                            @if($studyInfo->lesson_id)
                                {{$studyInfo->lname}}
                            @else
                                {{$studyInfo->lesson_name}}
                            @endif
                        </b>

                        <br>

                        @if(!$timeCheckinBefore || !$timeCheckinAfter)
                            <b style="font-size: 1.2rem; color: #dc3545">
                                @if(!$timeCheckinBefore)
                                    Chưa đến thời gian Checkin!
                                @endif

                                @if(!$timeCheckinAfter) Đã quá thời gian Checkin! @endif

                                <br>
                                Bạn không thể checkin buổi học này!
                            </b>
                        @endif



                    </div>

                    <form id="" action="" method="post" @if(!$timeCheckinBefore || !$timeCheckinAfter) hidden="hidden" @endif>
                        <p class="login-box-msg">Nhập thông tin của bạn</p>
                        @csrf
                        <input type="hidden" name="study_id" id="study_id" value="{{$studyInfo->id}}">

                        <div class="form-group input-group mb-3">
                            <select class="form-control" name="student_type" id="student_type">
                                <option value="" disabled selected>--- Bạn là ---</option>
                                <option value="0">Học viên</option>
                                <option value="1">Chủ nhiệm</option>
                                <option value="2">Trợ giảng</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group input-group mb-3">
                            <input type="number" class="form-control" name="student_code" id="student_code" placeholder="Mã học viên">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Tiếp theo <i class="fa-solid fa-arrow-right ml-1"></i>
                                </button>
                            </div>
                            <div class="col-6"></div>
                        </div>
                    </form>
                </div>
                <!-- /.form-box -->
            </div>

            <!-- form attendance student -->
            <div class="card" id="divFormCheckinStudent" style="width: 630px" hidden="hidden">
                <form action="" id="" class="form-horizontal" method="post">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" id="student_type" name="student_type">
                        <input type="hidden" class="form-control" id="student_code" name="student_code">
                        <input type="hidden" id="study_id" name="study_id" value="{{$studyInfo->id}}">

                        <div class="row">
                            <label class="col-form-label col-lg-3" for="lessonNameRow" id=""> Tên bài học: </label>
                            <div class="col-form-label col-lg-9" id="lessonNameRow">
                                @if($studyInfo->lesson_id)
                                    {{$studyInfo->lname}}
                                @else
                                    {{$studyInfo->lesson_name}}
                                @endif
                            </div>
                        </div>

                        <div class=" row">
                            <label class="col-form-label col-lg-3" for="" id=""> Ngày học: </label>
                            <div class="col-form-label col-lg-9" id="">
                                {{date('d/m/Y', strtotime($studyInfo->daylearn))}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-3" for="" id="nameCodeStudentTitle"> Học viên: </label>
                            <div class="col-form-label col-lg-9" id="nameCodeStudent">

                            </div>
                        </div>

                        <div class="row" id="divStatusCheckin">
                            <label class="col-lg-3" for="status">Trạng thái checkin: </label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select" name="status" id="status">
                                    <option value="" selected disabled>--- Chọn trạng thái ---</option>
                                    <option value="0">Nghỉ học</option>
                                    <option value="1">Đi học</option>
                                    <option value="2">Đi học muộn</option>
                                    <option value="3">Học bù</option>
                                </select>
                            </div>
                        </div>

                        <div class="row" id="divStudentNumber" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for=""> Sĩ số lớp: </label>
                            <div class="form-group col-lg-4">
                                <input type="number" name="number_eat" id="number_eat" class="form-control" placeholder="Số HV dùng bữa">
                            </div>
                            <label class=" col-form-label col-lg-1" for="" style="text-align: center"> / </label>
                            <div class="form-group col-lg-4">
                                <input type="number" name="number_learn" id="number_learn" class="form-control" placeholder="Số HV đi học">
                            </div>
                        </div>

                        <div class="form-group row" id="divStudentNote" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="">Ghi chú: </label>
                            <div class="col-lg-9">
                                <textarea type="text" name="note" id="note" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group row" >
                            <label class="col-lg-3" for="feedback">Cảm nhận về bài học: <span class="text-danger">*</span></label>
                            <div class="col-lg-9" >
                                <textarea type="text" name="feedback" id="feedback" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3" for="question">Câu hỏi/thắc mắc về bài học:</label>
                            <div class="col-lg-9" >
                                <textarea type="text" name="question" id="question" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 " for="comment">Góp ý của bạn:</label>
                            <div class="col-lg-9">
                                <textarea type="text" name="comment" id="comment" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer" style="text-align: center">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-user-check"></i> &nbsp; Checkin </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

{{--    <div class="register-page">--}}
{{--        <div class="register-box">--}}
{{--            <div class="register-logo">--}}
{{--                <a href="javascript:void(0);"><b>Checkin buổi học</b></a>--}}
{{--                <br>--}}
{{--                <a href="javascript:void(0);"><b>{{$studyInfo->class_name}}</b></a>--}}
{{--            </div>--}}

{{--            <!-- form check isset student -->--}}
{{--            <div class="card" id="divCheckIssetStudent">--}}
{{--                <div class="card-body register-card-body">--}}
{{--                    <p class="login-box-msg">Nhập thông tin của bạn</p>--}}

{{--                    <form id="" action="" method="post">--}}
{{--                        @csrf--}}
{{--                        <input type="hidden" name="study_id" id="study_id" value="{{$studyInfo->id}}">--}}

{{--                        <div class="form-group input-group mb-3">--}}
{{--                            <select class="form-control" name="student_type" id="student_type">--}}
{{--                                <option value="" disabled selected>--- Bạn là ---</option>--}}
{{--                                <option value="0">Học viên</option>--}}
{{--                                <option value="1">Chủ nhiệm</option>--}}
{{--                                <option value="2">Trợ giảng</option>--}}
{{--                            </select>--}}
{{--                            <div class="input-group-append">--}}
{{--                                <div class="input-group-text">--}}
{{--                                    <span class="fas fa-lock"></span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group input-group mb-3">--}}
{{--                            <input type="number" class="form-control" name="student_code" id="student_code" placeholder="Mã học viên">--}}
{{--                            <div class="input-group-append">--}}
{{--                                <div class="input-group-text">--}}
{{--                                    <span class="fas fa-user"></span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="row">--}}
{{--                            <div class="col-3"></div>--}}
{{--                            <div class="col-6">--}}
{{--                                <button type="submit" class="btn btn-primary btn-block">--}}
{{--                                    Tiếp theo <i class="fa-solid fa-arrow-right ml-1"></i>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                            <div class="col-6"></div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--                <!-- /.form-box -->--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <!-- form attendance student -->--}}
{{--        <div class="card" id="divFormCheckinStudent" style="width: 630px" hidden="hidden">--}}
{{--            <form action="" id="" class="form-horizontal" method="post">--}}
{{--                @csrf--}}
{{--                <div class="card-body">--}}
{{--                    <input type="hidden" id="student_type" name="student_type">--}}
{{--                    <input type="hidden" class="form-control" id="student_code" name="student_code">--}}
{{--                    <input type="hidden" id="study_id" name="study_id" value="{{$studyInfo->id}}">--}}

{{--                    <div class="row">--}}
{{--                        <label class="col-form-label col-lg-3" for="lessonNameRow" id=""> Tên bài học: </label>--}}
{{--                        <div class="col-form-label col-lg-9" id="lessonNameRow">--}}
{{--                            @if($studyInfo->lesson_id)--}}
{{--                                {{$studyInfo->lname}}--}}
{{--                            @else--}}
{{--                                {{$studyInfo->lesson_name}}--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="form-group row">--}}
{{--                        <label class="col-form-label col-lg-3" for="" id=""> Ngày học: </label>--}}
{{--                        <div class="col-form-label col-lg-9" id="">--}}
{{--                            {{date('d/m/Y', strtotime($studyInfo->daylearn))}}--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="row" id="divStatusCheckin">--}}
{{--                        <label class="col-lg-3" for="status">Trạng thái checkin: </label>--}}
{{--                        <div class="form-group col-lg-9">--}}
{{--                            <select class="form-control custom-select" name="status" id="status">--}}
{{--                                <option value="" selected disabled>--- Chọn trạng thái ---</option>--}}
{{--                                <option value="0">Nghỉ học</option>--}}
{{--                                <option value="1">Đi học</option>--}}
{{--                                <option value="2">Đi học muộn</option>--}}
{{--                                <option value="3">Học bù</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="row" id="divStudentNumber" hidden="hidden">--}}
{{--                        <label class="col-lg-3 col-form-label" for=""> Sĩ số lớp: </label>--}}
{{--                        <div class="form-group col-lg-4">--}}
{{--                            <input type="number" name="number_eat" id="number_eat" class="form-control" placeholder="Số HV dùng bữa">--}}
{{--                        </div>--}}
{{--                        <label class=" col-form-label col-lg-1" for="" style="text-align: center"> / </label>--}}
{{--                        <div class="form-group col-lg-4">--}}
{{--                            <input type="number" name="number_learn" id="number_learn" class="form-control" placeholder="Số HV đi học">--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="form-group row" >--}}
{{--                        <label class="col-lg-3 col-form-label" for="">Ghi chú:</label>--}}
{{--                        <div class="col-lg-9">--}}
{{--                            <textarea type="text" name="note" id="note" class="form-control" rows="3"></textarea>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="form-group row" >--}}
{{--                        <label class="col-lg-3" for="feedback">Cảm nhận về bài học: <span class="text-danger">*</span></label>--}}
{{--                        <div class="col-lg-9" >--}}
{{--                            <textarea type="text" name="feedback" id="feedback" class="form-control" rows="3"></textarea>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="form-group row">--}}
{{--                        <label class="col-lg-3" for="question">Câu hỏi/thắc mắc về bài học:</label>--}}
{{--                        <div class="col-lg-9" >--}}
{{--                            <textarea type="text" name="question" id="question" class="form-control" rows="3"></textarea>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="form-group row">--}}
{{--                        <label class="col-lg-3 " for="comment">Góp ý của bạn:</label>--}}
{{--                        <div class="col-lg-9">--}}
{{--                            <textarea type="text" name="comment" id="comment" class="form-control" rows="3"></textarea>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="card-footer" style="text-align: center">--}}
{{--                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-user-check"></i> &nbsp; Checkin </button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}

{{--    </div>--}}

@endsection

