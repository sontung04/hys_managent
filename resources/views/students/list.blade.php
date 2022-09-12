@extends('layouts.sidebar')

@section('script')
    <script src="{{ asset('assets/js/student/list.js') }}" defer></script>
@endsection

@section("content")
    <?php $years = range(strftime("%Y", time()), 1900); ?>
    <style>
        @media only screen and (max-width: 540px) {
            #tableStudentList {
                display: block;
                overflow-x: auto;
            }
        }

        @media only screen and (max-width: 976px) {
            #tableStudentList {
                display: block;
                overflow-x: auto;
            }
        }
        .table thead th {
            vertical-align: middle;
        }

        .table tbody td {
            vertical-align: middle;
            text-align: center;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh sách học viên CiTEdu</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách học viên CiTEdu</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">

                        <form action="{{route('student.list')}}" method="post" id="formFilterStudent">
                            @csrf
                            <input type="hidden" name="page" value="">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" style="text-align: right">Họ tên:</label>
                                        <div class="col-sm-7">
                                            <input class="form-control" name="name" id="name"
                                                   value="{{ isset($filters['name']) ? $filters['name'] : '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" style="text-align: right">Số điện thoại:</label>
                                        <div class="col-sm-7">
                                            <input class="form-control" name="phone" id="phone"
                                                   value="{{ isset($filters['phone']) ? $filters['phone'] : '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" style="text-align: right">Email:</label>
                                        <div class="col-sm-7">
                                            <input class="form-control" name="email" id="email"
                                                   value="{{ isset($filters['email']) ? $filters['email'] : '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" style="text-align: right">Năm sinh:</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="yearOfBirth" id="yearOfBirth">
                                                <option value="" {{ (isset($filters['yearOfBirth']) && '' == $filters['yearOfBirth']) ? 'selected' : ''}}>Chọn năm sinh</option>
                                                @foreach($years as $year)
                                                    <option value="{{$year}} {{(isset($filters['yearOfBirth']) && $year == $filters['yearOfBirth']) ? 'selected' : ''}}">{{$year}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label class="col-sm-5"></label>
                                        <div class="col-sm-7">
                                            <button type="submit" class="btn btn-info mr-2" id="btnSubmit"><span class="fa fa-search"></span>Tìm kiếm</button>
                                            <button type="button" class="btn btn-default" id="btnReset">Đặt lại</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                    <!-- /.card-header -->
                    <div class="card-header">
                        <a class="btn btn-success text-white float-right" id="btnAddStudent">
                            <i class="fas fa-cog"></i>
                            Thêm Học viên mới
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="tableStudentList" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr style="text-align: center">
                                <th style="width: 3%;">STT</th>
                                <th>Họ tên</th>
                                <th>Giới tính</th>
                                <th>Ngày sinh</th>
                                <th>Điện thoại</th>
                                <th>Email</th>
                                <th>Quê quán</th>
{{--                                <th style="width: 5%">Trạng thái</th>--}}
                                <th style="width: 8%">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($students as $key => $student)
                                <tr id="role-{{$student->id}}">
                                    <td>{{++$key}}</td>
                                    <td>{{$student->name}}</td>
                                    <td>{{$student->gender ? "Nam" : "Nữ"}}</td>
                                    <td>{{date('d/m/Y', strtotime($student->birthday))}}</td>
                                    <td>{{$student->phone}}</td>
                                    <td>{{$student->email}}</td>
                                    <td>{{$student->native_place}}</td>
{{--                                    <td style="text-align: center">--}}
{{--                                        <?php echo $student->status ? '<span style="color:green;">Học</span>' : '<span style="color:red">Nghỉ</span>' ?>--}}
{{--                                    </td>--}}
                                    <td>
                                        <button type="button" class="btn btn-outline-success btnEdit" data-id="{{$student->id}}"
                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btnView" data-id="{{$student->id}}"
                                                data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="8" style="text-align: center">Không có dữ liệu hiển thị! Vui lòng thử lại!</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- modal Add New Role -->
    <div class="modal fade" id="modalAddStudent">
        <div class="modal-dialog modal-lg" style="width: 85%; max-width: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddStudentTitle">Modal default</h4>
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="" class="form-horizontal" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control" name="id">
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
                                    <label for="birthday" class="col-sm-3">Ngày sinh: <span style="color: red">*</span></label>
                                    <div class="form-group col-sm-9">
                                        <div class="input-group date" id="birthdayDate" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#birthdayDate" data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" id="birthday" name="birthday" data-target="#birthdayDate"
                                                   data-toggle="datetimepicker" data-min="01/01/1950"/>
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
                                    <label for="address" class="col-sm-3">Nơi ở hiện tại: <span class="text-danger">*</span></label>
                                    <div class="form-group col-sm-9">
                                        <textarea id="address" name="address" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class=" row">
                                    <label class="col-lg-3 col-form-label" for="guardian">Người giám hộ: <span class="text-danger">*</span></label>
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
                                    <label class="col-lg-3 col-form-label" for="citizen_identify">CCCD: <span class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="number" name="citizen_identify" id="citizen_identify" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="date_of_issue">Ngày cấp CCCD: </label>
                                    <div class="form-group col-lg-9">
                                        <div class="input-group date" id="issueDate" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#issueDate" data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" id="date_of_issue" name="date_of_issue"
                                                   data-target="#issueDate" data-toggle="datetimepicker"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="place_of_issue">Nơi cấp CCCD: </label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="place_of_issue" id="place_of_issue" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="school">Trường học: </label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="school" id="school" class="form-control">
                                    </div>
                                </div>

                                <div class=" row">
                                    <label class="col-lg-3 col-form-label" for="major">Chuyên ngành: </label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="major" id="major" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="facebook">Facebook cá nhân: </label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="facebook" id="facebook" class="form-control">
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
                                        <div class="input-group date" id="birthdayFather" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#birthdayFather" data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" id="father_birthday" name="father_birthday"
                                                   data-target="#birthdayFather" data-toggle="datetimepicker"/>
                                        </div>
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
                                        <div class="input-group date" id="birthdayMother" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#birthdayMother" data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" id="mother_birthday" name="mother_birthday"
                                                   data-target="#birthdayMother" data-toggle="datetimepicker"/>
                                        </div>
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
                    <div class="modal-footer" >
                        <button type="button" class="btn btn-default closeModal" data-dismiss="modal" >Đóng</button>
                        <button type="submit" class="btn btn-primary" id="btnSave"><i class="fas fa-save"></i> Lưu thông tin </button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
        </section>

    </div>

@endsection

