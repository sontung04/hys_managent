@extends('layouts.sidebar')

@section('style')
    {{--    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">--}}
    <link rel="stylesheet" href="https://fullcalendar.io/js/fullcalendar-3.9.0/fullcalendar.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/css/bootstrap-datetimepicker.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="{{ asset('assets/css/calender/weekHys.css') }}">
@endsection

@section('script')
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment-with-locales.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
{{--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
    <script src="{{ asset('assets/js/calender/weekHys.js') }}" ></script>
@endsection

@section('content')
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
                    <!-- <button id="add" class="addBtn" style="margin-left: 98.75em">Them moi</button> -->
{{--                    <button type="button" class="btn btn-primary" id="addBtn" data-toggle="modal" data-target="#exampleModal" style="margin-left: 68.35em; height:auto;width: 156px;">--}}
{{--                        Thêm mới sự kiện--}}
{{--                    </button>--}}
                    <div class="card-body">
                        <div id='calendar'>
                        </div>

                    </div>

                    <div class="dropdown">

                        <div class="dropdown-content">

                        </div>

                    </div>

                    <div id='datepicker'></div>

                </div>
            </div>
        </section>
    </div>

    <!-- modal Add New Role -->
    <div class="modal fade" id="modalAddCalWeekHys" tabindex="-1" aria-labelledby="modalAddCalWeekHysLabel" aria-hidden="true">
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
                                    <option value="0" selected>--- Chọn Khu vực ---</option>
                                    @foreach($areaName as $key => $value)
                                        @if($key != 0)
                                            <option value="{{$key}}" data-name="{{$key.$value}}">{{'HYS ' . $value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="" id="">Tên hoạt động: <span style="color: red">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="text" name="title" id="title" class="form-control" value="">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="" id="">Mô tả: </label>
                            <div class="form-group col-lg-9">
                                <textarea type="text" name="description" id="description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group row" id="">
                            <label class="col-lg-3 col-form-label" for="">Thời gian bắt đầu: <span style="color: red">*</span></label>
                            <div class="form-group col-lg-9">
                                <div class="input-group date" id="starts-at1" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#starts-at1" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="starts-at" name="starts_at"
                                           data-target="#starts-at1" data-toggle="datetimepicker"
                                           data-format="DD/MM/YYYY" data-min="17/11/2013" data-max="16/08/2022">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" id="">
                            <label class="col-lg-3 col-form-label" for="birthday">Thời gian kết thúc: <span style="color: red">*</span></label>
                            <div class="form-group col-lg-9">
                                <div class="input-group date" id="ends-at1" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#ends-at1" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="ends-at" name="ends_at"
                                           data-target="#ends-at1" data-toggle="datetimepicker"
                                           data-format="DD/MM/YYYY" data-min="17/11/2013" data-max="16/08/2022">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="save-event" >Save </button>
                        <button type="button" class="btn btn-warning editBtn" id="edit" >Edit </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
