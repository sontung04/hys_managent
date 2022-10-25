@extends('layouts.sidebar')

@section('title', 'HYS Manage - Danh sách lớp')

@section('style')
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

@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/js/user/list.js') }}" defer></script>
    <script src="{{ asset('assets/js/class/list.js') }}" defer></script>
@endsection

@section("content")
    <?php $years = range(strftime("%Y", time()), 2010); ?>
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

                        <form action="{{route('class.list')}}" method="post" id="formFilterClass">
                            @csrf
                            <input type="hidden" name="page" value="">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" >Tên khoá học:</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="course_id" id="course_id">
                                                <option value="" {{ (isset($filters['course_id']) && '' == $filters['course_id']) ? 'selected' : ''}}>Chọn khóa học</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" style="text-align: right">Năm khai giảng:</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="yearOfStart" id="yearOfStart">
                                                <option value="" {{ (isset($filters['yearOfStart']) && '' == $filters['yearOfStart']) ? 'selected' : ''}}>Chọn năm khai giảng</option>
                                                @foreach($years as $year)
                                                    <option value="{{$year}}" {{(isset($filters['yearOfStart']) && $year == $filters['yearOfStart']) ? 'selected' : ''}}>{{$year}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" style="text-align: right" >Trạng thái:</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="status" id="status">
                                                <option value="" {{ (isset($filters['status']) && '' == $filters['status']) ? 'selected' : ''}}>Chọn trạng thái</option>
                                                <option value="0" {{ (isset($filters['status']) && 0 == $filters['status']) ? 'selected' : ''}}>Hủy</option>
                                                <option value="1" {{ (isset($filters['status']) && 1 == $filters['status']) ? 'selected' : ''}}>Đang học</option>
                                                <option value="2" {{ (isset($filters['status']) && 2 == $filters['status']) ? 'selected' : ''}}>Hoãn khai giảng</option>
                                                <option value="3" {{ (isset($filters['status']) && 3 == $filters['status']) ? 'selected' : ''}}>Đã tổng kết</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group row">
                                        <div class="col-sm-7">
                                            <button type="submit" class="btn btn-info mr-2" id="btnSubmit"><span class="fa fa-search"></span>Tìm kiếm</button>
                                            <button type="button" class="btn btn-default" id="btnReset">Đặt lại</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

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
                                <th style="width: 11%">Hành động</th>
                            </tr>
                            </thead>
                            <tbody id="tableListClassBody">
                            <?php $index = 1; ?>
                            @forelse($classes as $class)
                                <tr>
                                    <td>
                                        {{(($classes->currentPage() - 1) * 25) + $index++}}
                                    </td>
                                    <td>{{$class->name}}</td>
                                    <td>{{$coursesName[$class->course_id]}}</td>
                                    <td>{{$class->coach}}</td>

                                    <td>{{$class->carer_staff}}</td>

                                    <td> {{date('d/m/Y', strtotime($class->starttime))}}</td>
                                    <td style="text-align: center">
                                        @switch($class->status)
                                            @case(0)
                                                <span style="color: red"> Hủy</span>
                                                @break
                                            @case(1)
                                                <span style="color: green"> Đang học</span>
                                                @break
                                            @case(2)
                                                <span style="color: yellow"> Hoãn khai giảng</span>
                                                @break
                                            @case(3)
                                                <span style="color: blue"> Đã tổng kết</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-success btnEdit" data-id="{{$class->id}}"
                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button type="button" class="btn btn-outline-primary btnViewDiary" data-id="{{$class->id}}"
                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Xem nhật ký của lớp">
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
                    @if ($classes->hasPages())
                        <div class="card-footer clearfix">
                            <ul class="pagination m-0 float-right">
                                @if (!$classes->onFirstPage())
                                    <li class="btn page-item">
                                        <a class="page-link" data-page="{{$classes->currentPage() - 1}}" href="">
                                            <i class="fa-solid fa-angle-left"></i>
                                        </a>
                                    </li>
                                @endif

                                @for($i = 1; $i <= $classes->lastPage(); $i++)
                                    @if($i == 1 || $i == $classes->lastPage() || ($i <= ($classes->currentPage() + 1) && $i >= ($classes->currentPage() - 1)))

                                        <li class="btn page-item {{$i == $classes->currentPage() ? 'active' : ''}}">
                                            <a class="page-link" data-page="{{$i}}" href="">{{$i}}</a>
                                        </li>
                                    @elseif($i == $classes->currentPage() - 2 || $i == $classes->currentPage() + 2)
                                        <li class="btn page-item disabled"><a class="page-link" >...</a></li>
                                    @endif
                                @endfor

                                @if($classes->hasMorePages())
                                    <li class="btn page-item">
                                        <a class="page-link" data-page="{{$classes->currentPage() + 1}}" href="">
                                            <i class="fa-solid fa-angle-right"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif
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
                            <label class="col-lg-3 col-form-label" for="coach">Mã trợ giảng: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="number" name="coach" id="coach" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="carer_staff">Mã chủ nhiệm lớp: <span class="text-danger">*</span></label>
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

