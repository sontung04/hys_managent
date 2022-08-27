@extends('layouts.sidebar')

@section('script')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/js/user/list.js') }}" defer></script>
    <script src="{{ asset('assets/js/class/list.js') }}" defer></script>
@endsection

@section('content')
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
                        <h1>Danh sách học viên {{$classes->name}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách học viên lớp {{$classes->name}}</li>
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

                        <a class="btn btn-success text-white float-right" id="btnAddStudent">
                            <i class="fas fa-cog"></i>
                            Thêm học viên lớp
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="listStdClassTable" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr style="text-align: center">
                                <th style="width: 3%;">STT</th>
                                <th>Họ tên</th>
                                <th>Giới tính</th>
                                <th>Ngày sinh</th>
                                <th>Quê quán</th>
                                <th>Điện thoại</th>
                                <th>Email</th>
                                <th style="width: 5%">Trạng thái học</th>
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
                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa trạng thái học">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btnView" data-id="{{$student->id}}"
                                                data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Xem lịch sử học">
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
            <!-- modal Add New Student -->
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
                            <!-- Change students status in class -->
                            <div class="modal-body">
                                <input type="hidden" id="id" class="form-control" name="id">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-lg-3 col-form-label" for="gender">Trạng thái: <span class="text-danger">*</span></label>
                                            <div class="form-group col-lg-9" style="height: 38px;">
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" id="status1" name="status" value="1" checked>
                                                    <label for="gender1" style="margin-right: 10px">
                                                        Học
                                                    </label>
                                                </div>
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" id="status2" name="gender" value="0">
                                                    <label for="gender2">
                                                        Nghỉ
                                                    </label>
                                                </div>
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
