@extends('layouts.sidebar')

@section('script')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{asset('assets/js/intern/list.js')}}" defer ></script>
@endsection

@section('content')
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
                        <h1>Danh sách Thực tập sinh CiTEdu</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách Thực tập sinh CiTEdu</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-header">
                        <a class="btn btn-success text-white float-right" id="btnAddStudent">
                            <i class="fas fa-cog"></i>
                            Thêm Thực tập sinh mới
                        </a>
                    </div>

                    <!-- /.card-body -->
                    <div class="card-body">
                        <table id="tableInternList" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr style="text-align: center">
                                <th style="width: 3%;">STT</th>
                                <th>Họ tên</th>
                                <th>Điện thoại</th>
                                <th>Facebook</th>
                                <th>Ngày tham gia</th>
                                <th style="width: 10%">Trạng thái</th>
                                <th style="width: 10%">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $index = 1 ?>
                            @forelse($interns as $key => $intern)
                                <tr id="intern-{{$intern->id}}">
{{--                                    <td>--}}
{{--                                        {{(($interns->currentPage() - 1) * 25) + $index++}}--}}
{{--                                    </td>--}}
                                    <td>{{++$key}}</td>
                                    <td>{{$intern->name}}</td>
                                    <td>{{$intern->phone}}</td>
                                    <td>
                                        @if(!empty($intern->facebook))
                                            <a href="{{$intern->facebook}}" target="_blank">Link</a>
                                        @endif
                                    </td>
                                    <td>{{date('d/m/Y', strtotime($intern->starttime))}}</td>
                                    <td style="text-align: center">
                                        <?php echo $intern->status ? '<span style="color:green;">Hoạt động</span>' : '<span style="color:red">Nghỉ</span>' ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-success btnEdit" data-id="{{$intern->id}}"
                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btnView" data-id="{{$intern->id}}"
                                                data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="7" style="text-align: center">Không có dữ liệu hiển thị! Vui lòng thử lại!</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
{{--                    @if ($students->hasPages())--}}
{{--                        <div class="card-footer clearfix">--}}
{{--                            <ul class="pagination m-0 float-right">--}}
{{--                                @if (!$students->onFirstPage())--}}
{{--                                    <li class="btn page-item">--}}
{{--                                        <a class="page-link" data-page="{{$students->currentPage() - 1}}" href="">--}}
{{--                                            <i class="fa-solid fa-angle-left"></i>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                @endif--}}

{{--                                @for($i = 1; $i <= $students->lastPage(); $i++)--}}
{{--                                    @if($i == 1 || $i == $students->lastPage() || ($i <= ($students->currentPage() + 1) && $i >= ($students->currentPage() - 1)))--}}

{{--                                        <li class="btn page-item {{$i == $students->currentPage() ? 'active' : ''}}">--}}
{{--                                            <a class="page-link" data-page="{{$i}}" href="">{{$i}}</a>--}}
{{--                                        </li>--}}
{{--                                    @elseif($i == $students->currentPage() - 2 || $i == $students->currentPage() + 2)--}}
{{--                                        <li class="btn page-item disabled"><a class="page-link" >...</a></li>--}}
{{--                                    @endif--}}
{{--                                @endfor--}}

{{--                                @if($students->hasMorePages())--}}
{{--                                    <li class="btn page-item">--}}
{{--                                        <a class="page-link" data-page="{{$students->currentPage() + 1}}" href="">--}}
{{--                                            <i class="fa-solid fa-angle-right"></i>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                @endif--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                </div>
            </div>

            <!-- Modal update info intern with status and finnishtime -->
            <div class="modal fade" id="modalUpdateIntern">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modalUpdateInternTitle">Modal default </h4>
                            <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" id="formUpdateIntern" class="form-horizontal" method="post">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" id="intern_id" name="intern_id" >
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="name">Họ và Tên: </label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="name" id="name" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="gender">Giới tính: </label>
                                    <div class="form-group col-lg-9" style="height: 38px;">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="gender1" name="gender" value="1" checked >
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
                                    <label for="birthday" class="col-sm-3">Ngày sinh: </label>
                                    <div class="form-group col-sm-9">
                                        <div class="input-group date" id="birthdayDate" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#birthdayDate" data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" id="birthday" name="birthday" data-target="#birthdayDate"
                                                   data-toggle="datetimepicker" data-min="01/01/1950" readonly >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="phone">Số điện thoại: </label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="phone" id="phone" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="phone">Email: </label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="email" id="email" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="starttime">Ngày bắt đầu: </label>
                                    <div class="form-group col-lg-9">
                                        <div class="input-group date" id="starttimeDate" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#starttimeDate" data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" id="starttime" name="starttime"
                                                   data-target="#starttimeDate" data-toggle="datetimepicker" readonly>
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
                                            <input type="radio" id="status1" name="status" value="1">
                                            <label for="status1" style="margin-right: 10px">
                                                Đang hoạt động
                                            </label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="status2" name="status" value="0">
                                            <label for="status2">
                                                Dừng hoạt động
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-primary btnUpdateIntern"><i class="fas fa-save"></i>Lưu thông tin</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


