@extends('layouts.sidebar')
@section('script')
    <!-- Ckeidtor -->
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/js/group.js') }}" defer></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/group.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh sách Khu vực, Phòng ban</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách Khu vực, Phòng ban</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="card card-widget widget-user">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header text-white"
                                 style="background: url({{ asset('themes/dist/img/photo1.png') }} ) center center;">
                                <h3 class="widget-user-username ">
                                    CLB Thanh niên khởi nghiệp Hà Nội
                                    <a href="{{route('group.detail', [1])}}" data-toggle="tooltip" data-placement="bottom" title="Xem thông tin chi tiết">
                                        <i class="fas fa-sign-in-alt float-right"></i>
                                    </a>
                                </h3>

                            </div>
                            <div class="widget-user-image">
                                <img class="img-circle" src="{{ asset('themes/dist/img/user3-128x128.jpg') }}" alt="User Avatar">
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">Thành viên</h5>
                                            <span class="description-text">3,200</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">Khu vực</h5>
                                            <span class="description-text">{{count($areas)}}</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4">
                                        <div class="description-block">
                                            <h5 class="description-header">Ban chuyên môn</h5>
                                            <span class="description-text">{{count($departments)}}</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>

                <!-- Khu vực -->
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="mt-4 mb-2">Khu vực</h4>
                    </div>
                    <div class="col-sm-6">
                        <a class="btn btn-primary text-white float-right mt-4 mb-2 btnAddGroup" id="" data-type="1">+ Thêm khu vực</a>
                    </div>
                </div>

                <?php $i = 0; ?>
                @foreach($areas as $area)
                    @if($i % 4 == 0)
                        <div class="row">
                            @endif
                            <div class="col-md-3">
                                <div class="card card-widget">
                                    <div class="card-header">
                                        <h5 class="card-title">{{'HYS ' . $area->name}}</h5>
                                    </div>
                                    <div class="card-footer p-0">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <div class="nav-link" style="color: #007bff">
                                                    Thành viên hiện tại <span class="float-right badge bg-success">31</span>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <div class="nav-link" style="color: #007bff">
                                                    Cơ sở <span class="float-right badge bg-warning">5</span>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <div class="nav-link" style="color: #007bff">
                                                    Ngày kỷ niệm <span class="float-right badge bg-danger">{{date('d/m', strtotime($area->birthday))}}</span>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Facebook <span class="float-right"><i class="fab fa-facebook-square fa-lg" style="color: dodgerblue"></i></span>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <div style="text-align: center">
                                                    <a href="{{ route('group.detail', [$area->id]) }}" class="nav-link small-box-footer">
                                                        Thông tin chi tiết <i class="fas fa-arrow-circle-right"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @if($i % 4 == 3 || $i == count($areas) - 1)
                        </div>
                    @endif
                <?php $i++; ?>
                @endforeach

{{--                    <div class="col-md-3">--}}

{{--                        <div class="card card-widget">--}}
{{--                            <!-- Add the bg color to the header using any of the bg-* classes -->--}}
{{--                            <div class="card-header">--}}
{{--                                <div class="widget-user-image">--}}
{{--                                    <img class="img-circle elevation-2" src="{{asset('themes/dist/img/user7-128x128.jpg')}}" alt="User Avatar">--}}
{{--                                </div>--}}
{{--                                <!-- /.widget-user-image -->--}}
{{--                                <h5 class="card-title">Name group</h5>--}}
{{--                                <h5 class="widget-user-desc">Lead Developer</h5>--}}
{{--                            </div>--}}
{{--                            <div class="card-footer p-0">--}}
{{--                                <ul class="nav flex-column">--}}
{{--                                    <li class="nav-item">--}}
{{--                                        <a href="#" class="nav-link">--}}
{{--                                            Thành viên hiện tại <span class="float-right badge bg-primary">31</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="nav-item">--}}
{{--                                        <a href="#" class="nav-link">--}}
{{--                                            Cơ sở <span class="float-right badge bg-info">5</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="nav-item">--}}
{{--                                        <a href="#" class="nav-link">--}}
{{--                                            Ngày kỷ niệm <span class="float-right badge bg-success">12</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="nav-item">--}}
{{--                                        <a href="#" class="nav-link">--}}
{{--                                            Link Facebook <span class="float-right badge bg-danger">842</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
                <!-- End Khu vực -->

                <!-- Phòng ban -->
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="mt-4 mb-2">Ban chuyên môn</h4>
                    </div>
                    <div class="col-sm-6">
                        <a class="btn btn-primary text-white float-right mt-4 mb-2 btnAddGroup" id="" data-type="2">+ Thêm ban</a>
                    </div>
                </div>

                <?php $i = 0; ?>
                @foreach($departments as $department)
                    @if($i % 4 == 0)
                        <div class="row">
                            @endif
                            <div class="col-md-3">
                                <a href="{{ route('group.detail', [$department->id]) }}">
                                    <div class="card mb-3 widget-content bg-arielle-smile">
                                        <div class="widget-content-wrapper text-white">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">{{'Ban ' . $department->name}}</div>
                                                <div class="widget-subheading">Trưởng ban: Tên trưởng ban</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-white"><span><i class="fas fa-user"></i> 568</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @if($i % 4 == 3 || $i == count($departments) - 1)
                        </div>
                    @endif
                    <?php $i++; ?>
                @endforeach
{{--                <div class="row">--}}
{{--                    <div class="col-md-3">--}}
{{--                        <a href="">--}}
{{--                            <div class="card mb-3 widget-content bg-arielle-smile">--}}
{{--                                <div class="widget-content-wrapper text-white">--}}
{{--                                    <div class="widget-content-left">--}}
{{--                                        <div class="widget-heading">Truyền Thông</div>--}}
{{--                                        <div class="widget-subheading">Trưởng ban: Tên trưởng ban</div>--}}
{{--                                    </div>--}}
{{--                                    <div class="widget-content-right">--}}
{{--                                        <div class="widget-numbers text-white"><span><i class="fas fa-user"></i> 568</span></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <!-- Phòng ban -->
            </div>
        </section>
    </div>

    <!-- modal Add Group -->
    <div class="modal fade" id="modalAddGroup">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddTitle">Modal default</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="" method="" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="type" name="type">
                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="name" id="inputNameTitle"> </label>
                            <div class="form-group col-lg-9">
                                <input type="text" name="name" id="name" class="form-control" value="" >
                            </div>
                        </div>
                        <div class="form-group row" id="inputBirthday" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="birthday">Ngày thành lập: <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <div class="input-group date" id="birthdayDate" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#birthdayDate" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="birthday" name="birthday" data-target="#birthdayDate"
                                           data-toggle="datetimepicker" data-format="DD/MM/YYYY" data-min="17/11/2013" data-max="{{date("d/m/Y")}}"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label class="col-lg-3 col-form-label" for="description">Mô tả: <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <textarea type="text" name="description" id="description" class="form-control" ></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="email">Email: <span class="text-danger">*</span></label>
                            <div class="form-group  col-lg-9">
                                <input type="email" name="email" id="email" class="form-control" value="" >
                            </div>
                        </div>
                        <div class="form-group row" id="inputSong" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="song">Bài hát truyền thống:</label>
                            <div class="col-lg-9">
                                <input type="text" name="song" id="song" class="form-control" value="" >
                            </div>
                        </div>
                        <div class="form-group row" id="inputColor" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="color">Màu sắc truyền thống:</label>
                            <div class="col-lg-9">
                                <input type="text" name="color" id="color" class="form-control" value="" >
                            </div>
                        </div>
                        <div class="form-group row" id="inputAddress" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="address">Địa chỉ :</label>
                            <div class="col-lg-9">
                                <textarea type="text" name="address" id="address" class="form-control" row="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group row" id="inputSlogan" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="slogan" >Slogan: </label>
                            <div class="col-lg-9">
                                <textarea type="text" name="slogan" id="slogan" class="form-control"  row="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="facebook">Link Facebook:</label>
                            <div class="col-lg-9">
                                <input type="text" name="facebook" id="facebook" class="form-control" value="" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="youtube">Link Youtube:</label>
                            <div class="col-lg-9">
                                <input type="text" name="youtube" id="youtube" class="form-control" value="" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="instagram">Link Instagram:</label>
                            <div class="col-lg-9">
                                <input type="text" name="instagram" id="instagram" class="form-control" value="" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="tiktok">Link Tiktok:</label>
                            <div class="col-lg-9">
                                <input type="text" name="tiktok" id="tiktok" class="form-control" value="" >
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="btnSave"><i class="fas fa-save"></i> Lưu thông tin </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
