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
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh sách thành viên HYS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách thành viên</li>
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

                        <form action="{{route('user.list')}}" method="post" id="formFilterUser">
                            @csrf
                            <input type="hidden" name="page" value="">

                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" style="text-align: right">Khu vực:</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="area" id="area">
                                                <option value="" >Chọn Khu vực</option>
                                                @foreach($areaName as $key => $value)
                                                    <option value="{{$key}}" {{ (isset($filters['area']) && $key == $filters['area']) ? 'selected' : ''}}>
                                                        {{ $key ? 'HYS ' . $value : $value}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" style="text-align: right">Ban: </label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="depart" id="depart">
                                                <option value="" >Chọn Phòng ban</option>
                                                @foreach($departs as $depart)
                                                    <option value="{{$depart->id}}" {{ (isset($filters['depart']) && $depart->id == $filters['depart']) ? 'selected' : ''}}>
                                                        {{ 'Ban ' . $depart->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" style="text-align: right">Cơ sở/Team:</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="type" id="select_cate_type">
                                                <option name="type" value=""> Test 1</option>
                                                <option name="type" value=""> Test 2</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" style="text-align: right">Trạng thái TV:</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="status" id="status">
                                                <option value="" {{ (isset($filters['status']) && '' == $filters['status']) ? 'selected' : ''}}>Chọn trạng thái</option>
                                                <option value="1" {{ (isset($filters['status']) && 1 == $filters['status']) ? 'selected' : ''}}>Đang hoạt động</option>
                                                <option value="0" {{ (isset($filters['status']) && 0 == $filters['status']) ? 'selected' : ''}}>Dừng hoạt động</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" style="text-align: right">Mã thành viên:</label>
                                        <div class="col-sm-7">
                                            <input class="form-control" name="code" id="code"
                                                   value="{{ isset($filters['code']) ? $filters['code'] : '' }}">
                                        </div>
                                    </div>
                                </div>
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
                                        <label class="col-sm-5 col-form-label" style="text-align: right">Ngày tham gia:</label>
                                        <div class="col-sm-7">
                                            <div class="input-group date" id="filterJointime" data-target-input="nearest">
                                                <div class="input-group-append" data-target="#filterJointime" data-toggle="datetimepicker">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control datetimepicker-input" id="jointime" name="jointime"
                                                       data-target="#filterJointime" data-toggle="datetimepicker" data-format="DD/MM/YYYY"
                                                       data-min="17/11/2013" data-max="{{date("d/m/Y")}}"
                                                       data-value="{{ isset($filters['jointime']) ? $filters['jointime'] : '' }}"/>
                                            </div>
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
                    <div class="card-body">
                        <table id="usersTable" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr style="text-align: center">
                                <th>Mã thành viên</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Facebook</th>
                                <th>Ngày sinh</th>
                                <th>Quê quán</th>
                                <th>Ngày tham gia</th>
                                <th>Trạng thái</th>
                                <th>Khu vực</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                                <tr id="role-{{$user->id}}">
                                    <td style="text-align: center">{{$user->code}}</td>
                                    <td>{{$user->lastname . ' ' . $user->firstname}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>
                                        @if(!empty($user->facebook))
                                            <a href="{{$user->facebook}}" target="_blank">Link</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($user->birthday))
                                            {{date('d/m/Y', strtotime($user->birthday))}}
                                        @endif
                                    </td>
                                    <td class="cell-table-scroll" style="max-width: 240px; ">
                                        {{$user->address}}
                                    </td>
                                    <td>
                                        @if(!empty($user->jointime))
                                            {{date('d/m/Y', strtotime($user->jointime))}}
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        <?php echo $user->status ? '<span style="color:green;">Đang hoạt động</span>' : '<span style="color:red">Dừng hoạt động</span>' ?>
                                    </td>
                                    <td><?php echo $user->area ? 'HYS ' . $areaName[$user->area] : '' ?></td>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary btnViewProfile mr-1" data-id="{{$user->id}}"
                                                data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Xem thông tin cá nhân">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btnViewUrg" data-id="{{$user->id}}"
                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Xem lịch sử hoạt động">
                                            <i class="fa-brands fa-font-awesome"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="11" style="text-align: center">Không có dữ liệu hiển thị! Vui lòng thử lại!</th>
                                </tr>
                            @endforelse

                            </tbody>
                            <tfoot>
                            <tr style="text-align: center">
                                <th>Mã thành viên</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Facebook</th>
                                <th>Quê quán</th>
                                <th>Ngày tham gia</th>
                                <th>Trạng thái</th>
                                <th>Khu vực</th>
                                <th>Chức vụ</th>
                                <th>Hành động</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    @if ($users->hasPages())
                        <div class="card-footer clearfix">
                            <ul class="pagination m-0 float-right">
                                @if (!$users->onFirstPage())
                                    <li class="btn page-item">
                                        <a class="page-link" data-page="{{$users->currentPage() - 1}}" href="">
                                            <i class="fa-solid fa-angle-left"></i>
                                        </a>
                                    </li>
                                @endif

                                @for($i = 1; $i <= $users->lastPage(); $i++)
                                    @if($i == 1 || $i == $users->lastPage() || ($i <= ($users->currentPage() + 1) && $i >= ($users->currentPage() - 1)))

                                        <li class="btn page-item {{$i == $users->currentPage() ? 'active' : ''}}">
                                            <a class="page-link" data-page="{{$i}}" href="">{{$i}}</a>
                                        </li>
                                    @elseif($i == $users->currentPage() - 2 || $i == $users->currentPage() + 2)
                                        <li class="btn page-item disabled"><a class="page-link" >...</a></li>
                                    @endif
                                @endfor

                                @if($users->hasMorePages())
                                    <li class="btn page-item">
                                        <a class="page-link" data-page="{{$users->currentPage() + 1}}" href="">
                                            <i class="fa-solid fa-angle-right"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif

                    <!-- /.card-body -->
                </div>
            </div>
        </section>

    </div>

@endsection
