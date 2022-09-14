@extends('layouts.sidebar')

@section('script')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/js/user/list.js') }}" defer></script>
    <script src="{{ asset('assets/js/class/list.js') }}" defer></script>
@endsection

@section("content")
    <style>
        @media only screen and (max-width: 540px) {
            #tableListClass {
                display: block;
                overflow-x: auto;
            }
        }

        @media only screen and (max-width: 976px) {
            #tableListClass {
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
                        <h1>Danh sách lớp học CiTEdu</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách lớp học CiTEdu</li>
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
                        <h3 class="card-title"></h3>

                        <a class="btn btn-success text-white float-right" id="btnAddClass">
                            <i class="fas fa-cog"></i>
                            Thêm Lớp học mới
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="tableListClass" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr style="text-align: center">
                                <th style="width: 3%;">STT</th>
                                <th>Tên lớp</th>
                                <th>Tên Khóa học</th>
                                <th>Trợ giảng</th>
                                <th>Chủ nhiệm</th>
                                <th>Ngày khai giảng</th>
                                <th style="width: 10%">Trạng thái</th>
                                <th style="width: 8%">Hành động</th>
                            </tr>
                            </thead>
                            <tbody id="tableListClassBody">
                            <?php $index = 0; ?>
                            @forelse($classes as $class)
                                <tr>
                                    <td>{{++$index}}</td>
                                    <td>{{$class->name}}</td>
                                    <td>{{$coursesName[$class->course_id]}}</td>
                                    <td>{{$class->carer_staff}}</td>
                                    <td>{{$class->coach}}</td>
                                    <td> {{date('d/m/Y', strtotime($class->starttime))}}</td>
                                    <td style="text-align: center">
                                        <?php echo $class->status ? '<span style="color:green;">Đang học</span>' : '<span style="color:red">Đã hoàn thành</span>' ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-success btnEdit" data-id="{{$class->id}}"
                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btnView" data-id="{{$class->id}}"
                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Xem học sinh của lớp">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btnViewStudy" data-id="{{$class->id}}"
                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Xem buổi học của lớp">
                                            <i class="fa-solid fa-book"></i>
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
        </section>
    </div>

    <!-- modal Add New Class -->
    <div class="modal fade" id="modalAddClass">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddClassTitle">Modal default</h4>
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="" class="form-horizontal" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control" name="id">

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="course_id">Tên khoá học: <span
                                    class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select" name="course_id" id="course_id">
                                    <option value="" selected disabled="disabled">--- Chọn khóa học ---</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="name" id="">Tên lớp: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="coach">Trợ giảng: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="number" name="coach" id="coach" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="carer_staff">Chủ nhiệm lớp: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="number" name="carer_staff" id="carer_staff" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="starttime">Ngày khai giảng: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <div class="input-group date" id="starttimeDate" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#starttimeDate" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="starttime" name="starttime"
                                           data-target="#starttimeDate" data-toggle="datetimepicker"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="finishtime">Ngày kết thúc: </label>
                            <div class="form-group col-lg-9">
                                <div class="input-group date" id="finishtimeDate" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#finishtimeDate" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="finishtime" name="finishtime"
                                           data-target="#finishtimeDate" data-toggle="datetimepicker"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="status">Trạng thái: </label>
                            <div class="form-group col-lg-9">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status1" name="status" value="1" checked>
                                    <label for="status1" style="margin-right: 10px">
                                        Đang học
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status2" name="status" value="2">
                                    <label for="status2">
                                        Hoãn khai giảng
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="btnSave"><i class="fas fa-save"></i> Lưu thông tin</button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

