@extends('layouts.sidebar')
@section('script')
    <script src="{{ asset('assets/js/user/list.js') }}" defer></script>
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
        </section>

    </div>

@endsection

