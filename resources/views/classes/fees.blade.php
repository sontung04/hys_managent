@extends('layouts.sidebar')

@section('content')
    <style>

    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Thông tin công nợ học phí</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Học phí</li>
                        </ol>
                    </div>
                </div>
            </div>
            <hr>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div style="padding: 10px; width: 100%" class="card-header">
                        <table >
                            <tbody>
                                <tr>
                                    <td >Họ và tên</td>
                                </tr>
                                <tr>
                                    <td>Mã thành viên</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <table>
                        <tbody>
                        <tr>
                            <td>Thong tin</td>
                        </tr>
                        <tr>
                            <td>
                                <div>
                                    <div>
                                        <div>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <span>Dữ liệu sinh viên</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div>
                                                                <div>
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="align-content-md-center">
                                                                                <span>
                                                                                    <strong>Mã thành viên: </strong>
                                                                                    HYS0001
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <span>
                                                                                <strong>Họ và Tên : </strong> Vũ Minh Đăng
                                                                                <br>
                                                                                <strong>Giới tính : </strong> Nam
                                                                                <br>
                                                                                <strong>Ngày sinh : </strong> 19/03/2002
                                                                                <br>
                                                                            </span>
                                                                        </div>
                                                                        <div class="col-md-4"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section>
            <div></div>
        </section>
    </div>

@endsection
