@extends('layouts.sidebar')

@section("content")
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
                            <li class="breadcrumb-item active">Danh sách Chức vụ HYS</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Bordered Table</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr style="text-align: center">
                                        <th style="width: 2%">STT</th>
                                        <th style="width: 25%">Chức vụ</th>
                                        <th style="width: 48%">Mô tả</th>
                                        <th style="width: 10%">Trạng thái</th>
                                        <th style="width: 15%">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Update software</td>
                                        <td>Update software</td>
                                        <td>

                                        </td>
                                        <td><span class="badge bg-danger">55%</span></td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Clean database</td>
                                        <td>Clean database</td>
                                        <td>

                                        </td>
                                        <td><span class="badge bg-warning">70%</span></td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Cron job running</td>
                                        <td>Cron job running</td>
                                        <td>

                                        </td>
                                        <td><span class="badge bg-primary">30%</span></td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Fix and squish bugs</td>
                                        <td>Fix and squish bugs</td>
                                        <td>

                                        </td>
                                        <td><span class="badge bg-success">90%</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
{{--                            <div class="card-footer clearfix">--}}
{{--                                <ul class="pagination pagination-sm m-0 float-right">--}}
{{--                                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>--}}
{{--                                    <li class="page-item"><a class="page-link" href="#">1</a></li>--}}
{{--                                    <li class="page-item"><a class="page-link" href="#">2</a></li>--}}
{{--                                    <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
{{--                                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
