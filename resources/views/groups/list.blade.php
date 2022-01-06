@extends('layouts.sidebar')
@section('script')

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
                                <h3 class="widget-user-username ">CLB Thanh niên khởi nghiệp Hà Nội</h3>
                                <h5 class="widget-user-desc"></h5>
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
                                            <span class="description-text">7</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4">
                                        <div class="description-block">
                                            <h5 class="description-header">Ban chuyên môn</h5>
                                            <span class="description-text">6</span>
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
                <h4 class="mt-4 mb-2">Khu vực</h4>
                <div class="row">

                    <div class="col-md-3">

                        <div class="card card-widget">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="card-header">
{{--                                <div class="widget-user-image">--}}
{{--                                    <img class="img-circle elevation-2" src="../dist/img/user7-128x128.jpg" alt="User Avatar">--}}
{{--                                </div>--}}
                                <!-- /.widget-user-image -->
                                <h5 class="card-title">Name group</h5>
{{--                                <h5 class="widget-user-desc">Lead Developer</h5>--}}
                            </div>
                            <div class="card-footer p-0">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Thành viên hiện tại <span class="float-right badge bg-primary">31</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Cơ sở <span class="float-right badge bg-info">5</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Ngày kỷ niệm <span class="float-right badge bg-success">12</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Link Facebook <span class="float-right badge bg-danger">842</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-3">
                        <div class="card card-widget">
                            <div class="card-header">
                                <h5 class="card-title">Name group</h5>
                            </div>
                            <div class="card-footer p-0">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Thành viên hiện tại <span class="float-right badge bg-primary">31</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Cơ sở <span class="float-right badge bg-info">5</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Ngày kỷ niệm <span class="float-right badge bg-success">12</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Link Facebook <span class="float-right badge bg-danger">842</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card card-widget">
                            <div class="card-header">
                                <h5 class="card-title">Name group</h5>
                            </div>
                            <div class="card-footer p-0">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Thành viên hiện tại <span class="float-right badge bg-primary">31</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Cơ sở <span class="float-right badge bg-info">5</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Ngày kỷ niệm <span class="float-right badge bg-success">12</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Link Facebook <span class="float-right badge bg-danger">842</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card card-widget">
                            <div class="card-header">
                                <h5 class="card-title">Name group</h5>
                            </div>
                            <div class="card-footer p-0">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Thành viên hiện tại <span class="float-right badge bg-primary">31</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Cơ sở <span class="float-right badge bg-info">5</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Ngày kỷ niệm <span class="float-right badge bg-success">12</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Link Facebook <span class="float-right badge bg-danger">842</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End Khu vực -->

                <!-- Phòng ban -->
                <h4 class="mt-4 mb-2">Phòng ban</h4>

                <div class="row">
                    <div class="col-md-3">
                        <a href="">
                            <div class="card mb-3 widget-content bg-arielle-smile">
                                <div class="widget-content-wrapper text-white">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Truyền Thông</div>
                                        <div class="widget-subheading">Trưởng ban</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-white"><span><i class="fas fa-user"></i> 568</span></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
{{--                    <div class="col-lg-3 col-6">--}}
{{--                        <!-- small card -->--}}
{{--                        <div class="small-box bg-info">--}}
{{--                            <div class="inner">--}}
{{--                                <h3>Tên ban</h3>--}}

{{--                                <p>Thành viên hiện tại 50</p>--}}
{{--                            </div>--}}
{{--                            <div class="icon">--}}
{{--                                <i class="fas fa-shopping-cart"></i>--}}
{{--                            </div>--}}
{{--                            <a href="#" class="small-box-footer">--}}
{{--                                More info <i class="fas fa-arrow-circle-right"></i>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <!-- Phòng ban -->
            </div>
        </section>
    </div>
@endsection
