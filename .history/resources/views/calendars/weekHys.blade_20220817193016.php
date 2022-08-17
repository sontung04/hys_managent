@extends('layouts.sidebar')

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/js/calender/wee_calender.js') }}" ></script>
@endsection

@section('style')
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://fullcalendar.io/js/fullcalendar-3.0.1/fullcalendar.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/css/bootstrap-datetimepicker.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
     <link rel="stylesheet" href="{{ asset('assets/css/calender/wee_calender.css') }}">
@endsection

@section('content')
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh sách Chức vụ HYS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách các Sự Kiện  HYS</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
    <div class="card">
        <!-- <button id="add" class="addBtn" style="margin-left: 98.75em">Them moi</button> -->
    <button type="button" class="btn btn-primary" id="addBtn" data-toggle="modal" data-target="#exampleModal" style="margin-left: 59.75em ; height:auto ; width :auto">
    Thêm mới sự kiện 
    </button>

    <div id='calendar'>
    </div>

    <div class="dropdown">

        <div class="dropdown-content">

        </div>

    </div>

    <div id='datepicker'></div>
    <!-- modal Add New Role -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thêm mới sự kiện </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
             <input type="hidden" name="id" id="id" value="">
            <!-- <h4><input class="modal-title" type="text" name="title" id="title" placeholder="Event Title" /></h4> -->
            <div class="row">
                <label class="col-lg-3 col-form-label" for="name" id="inputNameTitle">Tên Sự Kiện : <span style="color: red">*</span></label>
                <div class="form-group col-lg-9">
                <input type="text" name="title" id="title" class="form-control" value="">
                </div>
            </div>
            <!-- <h4><input class="modal-title" type="text2" name="title2" id="title2" placeholder="Description" /></h4> -->
            <div class="row">
                <label class="col-lg-3 col-form-label" for="name" id="inputNameTitle">Nội Dung Sự Kiện : <span style="color: red">*</span></label>
                <div class="form-group col-lg-9">
                <input type="text" name="title2" id="title2" class="form-control modal-title" value="">
                </div>
            </div>
            <div class="row">
                       <div class="form-group row" id="inputBirthday">
                                    <label class="col-lg-3 col-form-label" for="birthday">Bắt Đầu Sự kiện :</label>
                                    <div class="col-lg-9">
                                        <div class="input-group date" id="starts-at1" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#starts-at1" data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" id="starts-at" name="starts_at" data-target="#starts-at1" data-toggle="datetimepicker" data-format="DD/MM/YYYY" data-min="17/11/2013" data-max="16/08/2022">
                                        </div>
                                    </div>
                                </div>
                        <div class="form-group row" id="inputBirthday">
                                    <label class="col-lg-3 col-form-label" for="birthday">Kết Thúc Sự kiện:</label>
                                    <div class="col-lg-9">
                                        <div class="input-group date" id="ends-at1" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#ends-at1" data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" id="ends-at" name="ends_at" data-target="#ends-at1" data-toggle="datetimepicker" data-format="DD/MM/YYYY" data-min="17/11/2013" data-max="16/08/2022">
                                        </div>
                                    </div>
                                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-event" >Save </button>
        <button type="button" class="btn btn-warning editBtn" id="edit" >Edit </button>
      </div>
    </div>
  </div>
</div>
    </div>
 </div>
@endsection
