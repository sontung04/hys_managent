@extends('layouts.sidebar')

@section('script')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/js/user/list.js') }}" defer></script>
    <script src="{{ asset('assets/js/student/list.js') }}" defer></script>
@endsection

@section("content")
    <style>
        .cell-table-scroll {
            max-height: 50px;
            overflow: auto;
            overflow-y: hidden;
            white-space: nowrap;
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
{{--                    <div class="card-header">--}}

{{--                        <form action="{{route('user.list')}}" method="post" id="formFilterUser">--}}
{{--                            @csrf--}}
{{--                            <input type="hidden" name="page" value="">--}}

{{--                            <div class="row">--}}
{{--                                <div class="col-lg-3">--}}
{{--                                    <div class="form-group row">--}}
{{--                                        <label class="col-sm-5 col-form-label" style="text-align: right">Khu vực:</label>--}}
{{--                                        <div class="col-sm-7">--}}
{{--                                            <select class="form-control" name="area" id="area">--}}
{{--                                                <option value="" >Chọn Khu vực</option>--}}
{{--                                                @foreach($areaName as $key => $value)--}}
{{--                                                    <option value="{{$key}}" {{ (isset($filters['area']) && $key == $filters['area']) ? 'selected' : ''}}>--}}
{{--                                                        {{ $key ? 'HYS ' . $value : $value}}--}}
{{--                                                    </option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-3">--}}
{{--                                    <div class="form-group row">--}}
{{--                                        <label class="col-sm-5 col-form-label" style="text-align: right">Ban: </label>--}}
{{--                                        <div class="col-sm-7">--}}
{{--                                            <select class="form-control" name="depart" id="depart">--}}
{{--                                                <option value="" >Chọn Phòng ban</option>--}}
{{--                                                @foreach($departs as $depart)--}}
{{--                                                    <option value="{{$depart->id}}" {{ (isset($filters['depart']) && $depart->id == $filters['depart']) ? 'selected' : ''}}>--}}
{{--                                                        {{ 'Ban ' . $depart->name }}--}}
{{--                                                    </option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-3">--}}
{{--                                    <div class="form-group row">--}}
{{--                                        <label class="col-sm-5 col-form-label" style="text-align: right">Cơ sở/Team:</label>--}}
{{--                                        <div class="col-sm-7">--}}
{{--                                            <select class="form-control" name="type" id="select_cate_type">--}}
{{--                                                <option name="type" value=""> Test 1</option>--}}
{{--                                                <option name="type" value=""> Test 2</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-3">--}}
{{--                                    <div class="form-group row">--}}
{{--                                        <label class="col-sm-5 col-form-label" style="text-align: right">Trạng thái TV:</label>--}}
{{--                                        <div class="col-sm-7">--}}
{{--                                            <select class="form-control" name="status" id="status">--}}
{{--                                                <option value="" {{ (isset($filters['status']) && '' == $filters['status']) ? 'selected' : ''}}>Chọn trạng thái</option>--}}
{{--                                                <option value="1" {{ (isset($filters['status']) && 1 == $filters['status']) ? 'selected' : ''}}>Đang hoạt động</option>--}}
{{--                                                <option value="0" {{ (isset($filters['status']) && 0 == $filters['status']) ? 'selected' : ''}}>Dừng hoạt động</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-lg-3">--}}
{{--                                    <div class="form-group row">--}}
{{--                                        <label class="col-sm-5 col-form-label" style="text-align: right">Mã thành viên:</label>--}}
{{--                                        <div class="col-sm-7">--}}
{{--                                            <input class="form-control" name="code" id="code"--}}
{{--                                                   value="{{ isset($filters['code']) ? $filters['code'] : '' }}">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-3">--}}
{{--                                    <div class="form-group row">--}}
{{--                                        <label class="col-sm-5 col-form-label" style="text-align: right">Họ tên:</label>--}}
{{--                                        <div class="col-sm-7">--}}
{{--                                            <input class="form-control" name="name" id="name"--}}
{{--                                                   value="{{ isset($filters['name']) ? $filters['name'] : '' }}">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-3">--}}
{{--                                    <div class="form-group row">--}}
{{--                                        <label class="col-sm-5 col-form-label" style="text-align: right">Ngày tham gia:</label>--}}
{{--                                        <div class="col-sm-7">--}}
{{--                                            <div class="input-group date" id="filterJointime" data-target-input="nearest">--}}
{{--                                                <div class="input-group-append" data-target="#filterJointime" data-toggle="datetimepicker">--}}
{{--                                                    <div class="input-group-text">--}}
{{--                                                        <i class="fa fa-calendar"></i>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <input type="text" class="form-control datetimepicker-input" id="jointime" name="jointime"--}}
{{--                                                       data-target="#filterJointime" data-toggle="datetimepicker" data-format="DD/MM/YYYY"--}}
{{--                                                       data-min="17/11/2013" data-max="{{date("d/m/Y")}}"--}}
{{--                                                       data-value="{{ isset($filters['jointime']) ? $filters['jointime'] : '' }}"/>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-3">--}}
{{--                                    <div class="form-group row">--}}
{{--                                        <label class="col-sm-5"></label>--}}
{{--                                        <div class="col-sm-7">--}}
{{--                                            <button type="submit" class="btn btn-info mr-2" id="btnSubmit"><span class="fa fa-search"></span>Tìm kiếm</button>--}}
{{--                                            <button type="button" class="btn btn-default" id="btnReset">Đặt lại</button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}

{{--                    </div>--}}
                    <!-- /.card-header -->
                    <div class="card-header">
                                <h3 class="card-title"></h3>

                                <a class="btn btn-success text-white float-right" id="btnAddStudent">
                                    <i class="fas fa-cog"></i>
                                    Thêm Học viên mới
                                </a>
                            </div>
                    <div class="card-body">
                        <table id="usersTable" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr style="text-align: center">
                                <th style="width: 3%;">STT</th>
                                <th>Họ tên</th>
                                <th>Giới tính</th>
                                <th>Ngày sinh</th>
                                <th>Quê quán</th>
                                <th>Điện thoại</th>
                                <th>Email</th>
                                <th style="width: 5%">Trạng thái</th>
                                <th style="width: 10%">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($students as $key => $student)
                                <tr id="role-{{$student->id}}">
                                    <td>{{++$key}}</td>
                                    <td>{{$student->name}}</td>
                                    <td>{{$student->gender ? "Nam" : "Nữ"}}</td>
                                    <td>
                                        @if(!empty($student->birthday))
                                            {{date('d/m/Y', strtotime($student->birthday))}}
                                        @endif
                                    </td>
                                    <td>{{$student->native_place}}</td>
                                    <td>{{$student->phone}}</td>
                                    <td>{{$student->email}}</td>
                                    <td style="text-align: center">
                                        <?php echo $student->status ? '<span style="color:green;">Học</span>' : '<span style="color:red">Nghỉ</span>' ?>
                                    </td>
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
                                    <th colspan="9" style="text-align: center">Không có dữ liệu hiển thị! Vui lòng thử lại!</th>
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
                    <!-- Status and image not add yet -->
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
                                    <label class="col-lg-3 col-form-label" for="birthday"> Ngày sinh:  <span class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="date" name="birthday" id="birthday" class="form-control">
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
                                    <label class="col-lg-3 col-form-label" for="citizen_identify">CCCD: <span class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="number" name="citizen_identify" id="citizen_identify" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="date_of_issue"> Ngày cấp CCCD:  <span class="text-danger"></span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="date" name="date_of_issue" id="date_of_issue" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="place_of_issue">Nơi cấp CCCD: </label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="place_of_issue" id="place_of_issue" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="address" class="col-sm-3">Nơi ở hiện tại: <span class="text-danger">*</span></label>
                                    <div class="form-group col-sm-9">
                                        <textarea id="address" name="address" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="phone">Số điện thoại: <span class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="phone" id="phone" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="email">Email : <span class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="email" name="email" id="email" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="facebook">Facebook : </label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="facebook" id="facebook" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="school">Trường học: </label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="school" id="school" class="form-control">
                                    </div>
                                </div>
                                <div class=" row">
                                    <label class="col-lg-3 col-form-label" for="majors">Chuyên ngành: </label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="majors" id="majors" class="form-control">
                                    </div>
                                </div>
                                <div class=" row">
                                    <label class="col-lg-3 col-form-label" for="guardian">Người giám hộ: <span class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="guardian" id="guardian" class="form-control">
                                    </div>
                                </div>
                                <div class=" row">
                                    <label class="col-lg-3 col-form-label" for="guardian_phone">SĐT Giám hộ: <span class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="guardian_phone" id="guardian_phone" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="father"> Họ và Tên Bố : </label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="father" id="father" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="father_job">Nghề nghiệp bố : </label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="father_job" id="father_job" class="form-control">
                                    </div>
                                </div>
                                <div class=" row">
                                    <label class="col-lg-3 col-form-label" for="father_birthday">Ngày sinh bố: </label>
                                    <div class="form-group col-lg-9">
                                        <input type="date" name="father_birthday" id="father_birthday" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="mother">Họ và Tên mẹ : </label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="mother" id="mother" class="form-control">
                                    </div>
                                </div>
                                 <div class=" row">
                                    <label class="col-lg-3 col-form-label" for="mother_job">Nghề nghiệp mẹ : </label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="mother_job" id="mother_job" class="form-control">
                                    </div>
                                </div>
                                <div class=" row">
                                    <label class="col-lg-3 col-form-label" for="mother_birthday">Ngày sinh mẹ: </label>
                                    <div class="form-group col-lg-9">
                                        <input type="date" name="mother_birthday" id="mother_birthday" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="course_where" class="col-sm-3">Bạn biết khóa học từ đâu: </label>
                                    <div class="form-group col-sm-9">
                                        <textarea id="course_where" name="course_where" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="desire" class="col-sm-3">Bạn mong muốn điều gì từ khóa học : </label>
                                    <div class="form-group col-sm-9">
                                        <textarea id="desire" name="desire" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer " >
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

