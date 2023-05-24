@extends('layouts.sidebar')

@section('title', 'HYS Manage - Danh sách giảng viên')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/course/teacher.css') }}">
@endsection

@section('script')
    <!-- Ckeidtor -->
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/js/course/teacher.js') }}" defer></script>
@endsection

@section("content")
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh sách Giảng viên</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách Giảng viên khóa học</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"></h3>

                                <a class="btn btn-success text-white float-right" id="btnAddTeacher">
                                    <i class="fas fa-cog"></i>
                                    Thêm Giảng viên mới
                                </a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="tableListTeacher" class="table table-bordered table-hover">
                                    <thead >
                                    <tr style="text-align: center" >
                                        <th style="width: 3%">STT</th>
                                        <th style="min-width: 275px">Tên</th>
                                        <th style="min-width: 85px">Giới tính</th>
                                        <th style="min-width: 100px">Ngày sinh</th>
                                        <th style="min-width: 135px">Trạng thái</th>
                                        <th>Quê quán</th>
                                        <th>Nghề nghệp</th>
                                        <th>Trình độ</th>
                                        <th>Mô tả</th>
                                        <th style="width: 8%">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $index = 0; ?>
                                    @forelse($teachers as $teacher)
                                        <tr>
                                            <th style="text-align: center">{{++$index}}</th>
                                            <th>{{$teacher->subname . " " . $teacher->name}}</th>
                                            <td style="text-align: center; vertical-align: middle;">{{$teacher->gender ? "Nam" : "Nữ"}}</td>
                                            <td style="text-align: center; vertical-align: middle;">{{date('d/m/Y',strtotime($teacher->birthday))}}</td>
                                            <th style="text-align: center">
                                                @if($teacher->status)
                                                    <span style="color:green;">Đang giảng dạy</span>
                                                @else
                                                    <span style="color:red">Dừng giảng dạy</span>
                                                @endif
                                            </th>
                                            <td>{{$teacher->address}}</td>
                                            <td class="cell-table-scroll setMinWidth">{{$teacher->job}}</td>
                                            <td class="cell-table-scroll setMinWidth">{{$teacher->level}}</td>
                                            <td class="cell-table-scroll setMinWidth">{{$teacher->description}}</td>
                                            <th style="text-align: center">
                                                <button type="button" class="btn btn-outline-primary btnView"
                                                        data-id="{{$teacher->id}}"
                                                        data-toggle="popover" data-trigger="hover" data-placement="top"
                                                        data-content="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-success btnEdit"
                                                        data-id="{{$teacher->id}}"
                                                        data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                        data-content="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </th>
                                        </tr>
                                    @empty
                                        <tr>
                                            <th colspan="8" style="text-align: center">Không có dữ liệu hiển thị! Vui lòng thử lại!</th>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- modal Add New Role -->
    <div class="modal fade" id="modalAddTeacher">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddTeacherTitle">Modal default</h4>
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="" class="form-horizontal" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control" name="id">

                        <div class="row">
                            <label class="col-lg-2 col-form-label" for="name" id="">Họ và Tên: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-10">
                                <input type="text" name="name" id="name" class="form-control" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="birthday">Ngày sinh: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-10">
                                <div class="input-group date" id="birthdayDate" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#birthdayDate" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="birthday" name="birthday" data-target="#birthdayDate"
                                           data-toggle="datetimepicker" data-min="01/01/1960" data-max="{{date("d/m/Y")}}"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-2 col-form-label" for="subname" id="">Chức danh: </label>
                            <div class="form-group col-lg-10">
                                <input type="text" name="subname" id="subname" class="form-control" >
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-2 col-form-label" for="gender">Giới tính:</label>
                            <div class="form-group col-lg-10">
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
                            <label class="col-lg-2 col-form-label" for="status">Trạng thái: </label>
                            <div class="form-group col-lg-10">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status1" name="status" value="1" checked>
                                    <label for="status1" style="margin-right: 10px">
                                        Đang giảng dạy
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status2" name="status" value="0">
                                    <label for="status2">
                                        Dừng giảng dạy
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="address">Quê quán: </label>
                            <div class="form-group col-lg-10">
                                <input type="text" name="address" id="address" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="level">Trình độ: </label>
                            <div class="form-group col-lg-10">
                                <textarea name="level" id="level" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="job">Công việc: </label>
                            <div class="form-group col-lg-10">
                                <input type="text" name="job" id="job" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="position">Chức vụ: </label>
                            <div class="form-group col-lg-10">
                                <input type="text" name="position" id="position" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label class="col-lg-2 col-form-label" for="description">Mô tả:</label>
                            <div class="col-lg-10">
                                <textarea type="text" name="description" id="description" class="form-control" ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="btnSave"><i class="fas fa-save"></i> Lưu thông tin </button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
