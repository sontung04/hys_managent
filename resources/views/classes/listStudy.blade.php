@extends('layouts.sidebar')

@section('script')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/js/user/list.js') }}" defer></script>
    <script src="{{ asset('assets/js/class/listStudy.js') }}" defer></script>
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
                        <h1>Danh sách buổi học của lớp {{ $classes->name }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách buổi học lớp {{ $classes->name }}</li>
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

                        <a class="btn btn-success text-white float-right" id="btnAddStudy">
                            <i class="fas fa-cog"></i>
                            Thêm buổi học mới
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="listStudyTable" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr style="text-align: center">
                                <th style="width: 3%;">STT</th>
                                <th>Tên bài học</th>
                                <th>Giảng viên</th>
                                <th>Ngày học</th>
                                <th style="width: 15%">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($studies as $key => $study)
                                <tr id="role-{{$study->id}}">
                                    <td>{{++$key}}</td>
                                    <td>{{$study->lsname}}</td>
                                    <td>{{$study->tchname}}</td>
                                    <td>
                                        @if(!empty($study->daylearn))
                                            {{date('d/m/Y', strtotime($study->daylearn))}}
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-success btnEdit" data-id="{{$study->id}}"
                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa thông tin">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btnView" data-id="{{$study->id}}"
                                                data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Điểm danh">
                                            <i class="fa-solid fa-school"></i>
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
            <!-- modal Add New Study -->
            <div class="modal fade" id="modalAddStudy">
                <div class="modal-dialog modal-lg" style="width: 85%; max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modalAddStudyTitle">Modal default</h4>
                            <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" id="" class="form-horizontal" method="post">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" id="id" class="form-control" name="id">
                                {{-- <div class="row">
                                    <label class="col-lg-3 col-form-label" for="class_id"> Tên lớp học:  <span class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="" name="class_id" id="class_id" class="form-control" value="{{ $classes->name }}">
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="lesson_id"> Tên bài học:  <span class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="number" name="lesson_id" id="lesson_id" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="teacher">Giảng viên: <span class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <select class="form-control custom-select" name="teacher" id="teacher">
                                            <option value="0" selected>--- Chọn Giảng viên ---</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="carer_staff"> Chủ nhiệm:  <span class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="number" name="carer_staff" id="carer_staff" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="coach"> Trợ giảng:  <span class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="number" name="coach" id="coach" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="birthday" class="col-sm-3">Ngày học:  <span class="text-danger">*</span></label>
                                    <div class="form-group col-sm-9">
                                        <div class="input-group date" id="daylearnStudy" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#daylearnStudy" data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" id="daylearn" name="daylearn" data-target="#daylearnStudy"
                                                   data-toggle="datetimepicker" data-min="01/01/1950"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="location"> Địa điểm : <span class="text-danger"></span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="location" id="location" class="form-control">
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
