@extends('layouts.sidebar')

@section('script')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/js/user/list.js') }}" defer></script>
    <script src="{{ asset('assets/js/class/list.js') }}" defer></script>
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
                        <table id="listStdTable" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr style="text-align: center">
                                <th style="width: 3%;">STT</th>
                                <th>Tên lớp</th>
                                <th>Carer staff</th>
                                <th>Coach</th>
                                <th>Start time</th>
                                <th style="width: 5%">Trạng thái</th>
                                <th style="width: 5%">Hành động</th>
                            </tr>
                            </thead>
                            <tbody id="tableClassList">
                            @forelse($classes as $key => $class)
                                <tr id="role-{{$class->id}}">
                                    <td>{{++$key}}</td>
                                    <td>{{$class->name}}</td>
                                    <td>{{$class->carer_staff}}</td>
                                    <td>{{$class->coach}}</td>
                                    <td>
                                        @if(!empty($class->starttime))
                                            {{date('d/m/Y', strtotime($class->starttime))}}
                                        @endif
                                    </td>
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
                            <div class="col-md-6">
                            <div class="row">
                            <label class="col-lg-3 col-form-label" for="name" id="">Tên lớp: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="text" name="name" id="name" class="form-control" >

                            </div>
                        </div>
                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="course_id">Tên khoá học: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="text" name="course_id" id="course_id" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="carer_staff">Carer Staff: </label>
                            <div class="form-group col-lg-9">
                                <input type="text" name="carer_staff" id="carer_staff" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="coach">Coach: </label>
                            <div class="form-group col-lg-9">
                                <input type="text" name="coach" id="coach" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="starttime"> Start time:  <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="date" name="starttime" id="starttime" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="finishtime"> Finish time:  <span class="text-danger"></span></label>
                            <div class="form-group col-lg-9">
                                <input type="date" name="finishtime" id="finishtime" class="form-control">
                            </div>
                        </div>
                        <div class="row" >
                            <label class="col-lg-3 col-form-label" for="status">Trạng thái: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status1" name="status" value="1" checked>
                                    <label for="status1" style="margin-right: 10px">
                                        Đang học
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status2" name="status" value="2">
                                    <label for="status">
                                        Hoãn khai giảng
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer ">
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

