@extends('layouts.sidebar')

@section("content")
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh sách Sự kiện HYS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách Sự kiện HYS</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <h2 class="mt-4 mb-2" style="text-align: center">HYS</h2>
                <div class="row">
                    <div class="col-lg-6 col-xl-4">
                        <div class="card mb-3 widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Tên sự kiện</div>
                                        <div class="widget-subheading">Ngày diễn ra</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-success">1896</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="progress-bar-xs progress">
                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-left">Trưởng BTC: tên</div>
                                        <div class="sub-label-right">100%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4">
                        <div class="card mb-3 widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Clients</div>
                                        <div class="widget-subheading">Total Clients Profit</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-primary">$12.6k</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="progress-bar-lg progress-bar-animated progress">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="47" aria-valuemin="0" aria-valuemax="100" style="width: 47%;">47/100</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-left">Retention</div>
                                        <div class="sub-label-right">100%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4">
                        <div class="card mb-3 widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Products Sold</div>
                                        <div class="widget-subheading">Total revenue streams</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-warning">$3M</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="progress-bar-xs progress-bar-animated-alt progress">
                                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">85/100</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-left">Sales</div>
                                        <div class="sub-label-right">100%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4">
                        <div class="card mb-3 widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Followers</div>
                                        <div class="widget-subheading">People Interested</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-danger">45,9%</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="progress-bar-sm progress-bar-animated-alt progress">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-left">Twitter Progress</div>
                                        <div class="sub-label-right">100%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="mt-4 mb-2" style="text-align: center">HYS Thăng Long</h2>
                <div class="row">
                    <div class="col-lg-6 col-xl-4">
                        <div class="card mb-3 widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Tên sự kiện</div>
                                        <div class="widget-subheading">Ngày diễn ra</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-success">1896</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="progress-bar-xs progress">
                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-left">Trưởng BTC: tên</div>
                                        <div class="sub-label-right">100%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4">
                        <div class="card mb-3 widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Clients</div>
                                        <div class="widget-subheading">Total Clients Profit</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-primary">$12.6k</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="progress-bar-lg progress-bar-animated progress">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="47" aria-valuemin="0" aria-valuemax="100" style="width: 47%;">47/100</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-left">Retention</div>
                                        <div class="sub-label-right">100%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4">
                        <div class="card mb-3 widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Products Sold</div>
                                        <div class="widget-subheading">Total revenue streams</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-warning">$3M</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="progress-bar-xs progress-bar-animated-alt progress">
                                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">85/100</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-left">Sales</div>
                                        <div class="sub-label-right">100%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4">
                        <div class="card mb-3 widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Followers</div>
                                        <div class="widget-subheading">People Interested</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-danger">45,9%</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="progress-bar-sm progress-bar-animated-alt progress">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-left">Twitter Progress</div>
                                        <div class="sub-label-right">100%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection
