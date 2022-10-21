
@extends('layouts.index')

@section('style')
    <style>
        body {
            background: -webkit-gradient(linear, left bottom, right top, from(#fc2c77), to(#6c4079));
            background: -webkit-linear-gradient(bottom left, #fc2c77 0%, #6c4079 100%);
            background: -moz-linear-gradient(bottom left, #fc2c77 0%, #6c4079 100%);
            background: -o-linear-gradient(bottom left, #fc2c77 0%, #6c4079 100%);
            background: linear-gradient(to top right, #fc2c77 0%, #6c4079 100%);
        }
    </style>
@endsection

@section('script')
    <script src="{{ asset('assets/js/page/form/registerClass.js') }}" defer></script>
@endsection

@section('content')
    <?php
        $classStatus = [
            0 => 'đã dừng',
            1 => 'đang học',
            2 => 'đã hoàn thành',
            3 => 'hoãn khai giảng',
        ];
    ?>
    <div class="container">
        <br>
        <br>
        <br>
        <div class="register-logo font-weight-light text-white" >
            <b>{{$classInfo->name}}</b>
            <br>
            @if($classInfo->status == 1)
                <div >
                    <b>Form đăng ký lớp</b>
                </div>
            @else
                <br>
                <div>
                    <h1>Thông báo!</h1>
                    <b>Lớp học {{$classStatus[$classInfo->status]}}. Bạn không thể đăng ký nhập học!</b>
                </div>
            @endif

        </div>
        <br>
        <div style="width: 100%; display: flex; justify-content: center;">

            <!-- form check isset student -->
            <div class="card" id="divCheckStudentInfo" style="width: 360px" @if($classInfo->status != 1) hidden="hidden" @endif>
                <div class="card-body register-card-body" style="border-radius: 25px">
                    <p class="login-box-msg">Vui lòng nhập mã học viên của bạn!</p>

                    <form id="" action="" method="post">
                        @csrf
                        <input type="hidden" id="class_id" name="class_id" value="{{$classInfo->id}}">
                        <div class="form-group input-group mb-3">
                            <input type="number" class="form-control" name="student_code" id="student_code" placeholder="Mã học viên">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Kiểm tra thông tin &nbsp; <i class="fa-solid fa-id-card"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-block" id="btnEmptyCodeStudent">
                                    Chưa có mã học viên &nbsp; <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </div>
                            <div class="col-2"></div>
                        </div>
                    </form>
                </div>
                <!-- /.form-box -->
            </div>
        </div>


        <div class="card" id="divFormRegisterClass" hidden="hidden">
            <div class="card-header">
                <h4 class="card-title" id=""><span id="formTitle"></span> <b>(Lưu ý: Ô có dấu <span class="text-danger">*</span> không được để trống)</b></h4>
            </div>
            <form action="" id="" class="form-horizontal" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="id" name="id"> <!-- /.student_id -->
                    <input type="hidden" id="class_id" name="class_id" value="{{$classInfo->id}}">
                    <input type="hidden" id="class_length" name="class_length" value="{{$classInfo->length}}">
                    <input type="hidden" id="class_fee" name="class_fee" value="{{$classInfo->fees}}">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="row">
                                <label class="col-lg-3 col-form-label" for="name" id="">Họ và Tên: <span class="text-danger">*</span></label>
                                <div class="form-group col-lg-9">
                                    <input type="text" name="name" id="name" class="form-control" >
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3 col-form-label" for="gender">Giới tính: <span class="text-danger">*</span></label>
                                <div class="form-group col-lg-9" style="height: 38px;">
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" id="gender1" name="gender" value="1" checked>
                                        <label for="gender1" style="margin-right: 10px">
                                            Nam
                                        </label>
                                    </div>
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" id="gender2" name="gender" value="0">
                                        <label for="gender2">
                                            Nữ
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label for="birthday" class="col-sm-3 col-form-label">Ngày sinh: <span style="color: red">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group input-group date">
                                        <input type="text" class="form-control " id="birthday" name="birthday"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3 col-form-label" for="phone">Số điện thoại: <span class="text-danger">*</span></label>
                                <div class="form-group col-lg-9">
                                    <input type="number" name="phone" id="phone" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3 col-form-label" for="email">Email: <span class="text-danger">*</span></label>
                                <div class="form-group col-lg-9">
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <label for="address" class="col-sm-3 col-form-label">Nơi ở hiện tại: <span class="text-danger">*</span></label>
                                <div class="form-group col-sm-9">
                                    <textarea id="address" name="address" class="form-control" rows="3"></textarea>
                                </div>
                            </div>

                            <div class=" row">
                                <label class="col-lg-3 col-form-label" for="guardian_name">Người giám hộ: <span class="text-danger">*</span></label>
                                <div class="form-group col-lg-9">
                                    <input type="text" name="guardian_name" id="guardian_name" class="form-control">
                                </div>
                            </div>

                            <div class=" row">
                                <label class="col-lg-3 col-form-label" for="guardian_phone">SĐT Giám hộ: <span class="text-danger">*</span></label>
                                <div class="form-group col-lg-9">
                                    <input type="number" name="guardian_phone" id="guardian_phone" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3 col-form-label" for="school">Trường học: <span class="text-danger">*</span> </label>
                                <div class="form-group col-lg-9">
                                    <input type="text" name="school" id="school" class="form-control">
                                </div>
                            </div>

                            <div class=" row">
                                <label class="col-lg-3 col-form-label" for="major">Chuyên ngành: <span class="text-danger">*</span> </label>
                                <div class="form-group col-lg-9">
                                    <input type="text" name="major" id="major" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3 col-form-label" for="citizen_identify">CCCD: <span class="text-danger">*</span></label>
                                <div class="form-group col-lg-9">
                                    <input type="number" name="citizen_identify" id="citizen_identify" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3 col-form-label" for="date_of_issue">Ngày cấp CCCD: </label>
                                <div class="form-group col-lg-9">
                                    <div class="input-group date">
                                        <input type="text" class="form-control" id="date_of_issue" name="date_of_issue"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3 col-form-label" for="place_of_issue">Nơi cấp CCCD: </label>
                                <div class="form-group col-lg-9">
                                    <input type="text" name="place_of_issue" id="place_of_issue" class="form-control">
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-lg-3 col-form-label" for="facebook">Link Facebook: <span class="text-danger">*</span></label>
                                <div class="form-group col-lg-9">
                                    <input type="url" name="facebook" id="facebook" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3 col-form-label" for="native_place">Quê quán: </label>
                                <div class="form-group col-lg-9">
                                    <input type="text" name="native_place" id="native_place" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3 col-form-label" for="nation">Dân tộc : </label>
                                <div class="form-group col-lg-9">
                                    <input type="text" name="nation" id="nation" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3 col-form-label" for="religion">Tôn Giáo: </label>
                                <div class="form-group col-lg-9">
                                    <input type="text" name="religion" id="religion" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3 col-form-label" for="father">Họ và Tên Bố: </label>
                                <div class="form-group col-lg-9">
                                    <input type="text" name="father" id="father" class="form-control">
                                </div>
                            </div>

                            <div class=" row">
                                <label class="col-lg-3 col-form-label" for="father_birthday">Ngày sinh bố: </label>
                                <div class="form-group col-sm-9">
                                    <input type="text" class="form-control" id="father_birthday" name="father_birthday"/>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3 col-form-label" for="father_job">Nghề nghiệp bố: </label>
                                <div class="form-group col-lg-9">
                                    <input type="text" name="father_job" id="father_job" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3 col-form-label" for="mother">Họ và Tên mẹ: </label>
                                <div class="form-group col-lg-9">
                                    <input type="text" name="mother" id="mother" class="form-control">
                                </div>
                            </div>

                            <div class=" row">
                                <label class="col-lg-3 col-form-label" for="mother_birthday">Ngày sinh mẹ: </label>
                                <div class="form-group col-sm-9">
                                    <input type="text" class="form-control" id="mother_birthday" name="mother_birthday"/>
                                </div>
                            </div>

                            <div class=" row">
                                <label class="col-lg-3 col-form-label" for="mother_job">Nghề nghiệp mẹ: </label>
                                <div class="form-group col-lg-9">
                                    <input type="text" name="mother_job" id="mother_job" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <label for="course_where" class="col-sm-3">Bạn biết khóa học từ đâu: </label>
                                <div class="form-group col-sm-9">
                                    <textarea id="course_where" name="course_where" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <label for="desire" class="col-sm-3">Bạn mong muốn điều gì từ khóa học: </label>
                                <div class="form-group col-sm-9">
                                    <textarea id="desire" name="desire" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="display: block; text-align: center">
                    <button type="reset" class="btn btn-default" id="btnReset">Nhập lại</button>
                    <button type="submit" class="btn btn-primary" ><i class="fa-solid fa-pen-nib"></i> &nbsp; Xác nhận đăng ký </button>
                </div>
            </form>
        </div>
        <br>
        <br>
        <br>
    </div>

@endsection


