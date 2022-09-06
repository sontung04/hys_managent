@extends('layouts.sidebar')

@section('style')
    <link rel="stylesheet" href="https://fullcalendar.io/js/fullcalendar-3.9.0/fullcalendar.min.css">

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <script src="{{ asset('assets/js/calendar/weekHys.js') }}" ></script>
@endsection

@section('content')
    <style>
        .fc-content {
            font-size: 1.5em;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Lịch tuần HYS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Lịch tuần HYS</li>
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

                        <a class="btn btn-primary text-white float-right" id="btnAddCalendarWeekHys">
                            <i class="fas fa-cog"></i>
                            Thêm hoạt động mới
                        </a>

                    </div>
                    <div class="card-body">
                        <div id='calendarWeekHys'>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- modal Add New Role -->
    <div class="modal fade" id="modalCalWeekHys" tabindex="-1" aria-labelledby="modalCalWeekHysLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Thêm mới sự kiện </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="" class="form-horizontal" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">

                        <div class="row" >
                            <label class="col-lg-3 col-form-label" for="area" id="">Khu vực: <span style="color: red">*</span></label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select" name="area" id="area">
                                    <option value="" selected>--- Chọn Khu vực ---</option>
                                    @foreach($areaName as $key => $value)
                                        @if($key != 0)
                                            <option value="{{$key}}" data-name="{{$key.$value}}">{{'HYS ' . $value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row" id="selectGroup" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="group_id" id="">Đơn vị: <span style="color: red">*</span></label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select" name="group_id" id="group_id">
                                    <option value="0" selected>--- Chọn đơn vị phụ trách ---</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="group_name" id="group_name">

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="" id="">Tên hoạt động: <span style="color: red">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="text" name="title" id="title" class="form-control" value="">
                            </div>
                        </div>

                        <div class="form-group row" id="">
                            <label class="col-lg-3 col-form-label" for="starttime">Thời gian bắt đầu: <span style="color: red">*</span></label>
                            <div class="form-group col-lg-9">
                                <div class="input-group date" id="inputStarttime" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#inputStarttime" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="starttime" name="starttime"
                                           data-target="#inputStarttime" data-toggle="datetimepicker" data-format="DD/MM/YYYY HH:mm">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" id="">
                            <label class="col-lg-3 col-form-label" for="finishtime">Thời gian kết thúc: </label>
                            <div class="form-group col-lg-9">
                                <div class="input-group date" id="inputFinishtime" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#inputFinishtime" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="finishtime" name="finishtime"
                                           data-target="#inputFinishtime" data-toggle="datetimepicker" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="status">Hình thức: </label>
                            <div class="form-group col-lg-9">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="formality1" name="formality" value="1" checked>
                                    <label for="formality1" style="margin-right: 10px">
                                        Offline
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="formality2" name="formality" value="0">
                                    <label for="formality2">
                                        Online
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="" id="">Địa điểm tổ chức:</label>
                            <div class="form-group col-lg-9">
                                <input type="text" name="address" id="address" class="form-control" value="">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="" id="">Nội dung: </label>
                            <div class="form-group col-lg-9">
                                <textarea type="text" name="description" id="description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary closeModal" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
