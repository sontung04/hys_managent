@extends('layouts.sidebar')

@section('title', 'HYS Manage - Danh sách học phí học viên')

@section('script')
@endsection

@section("content")
<!--    --><?php //$years = range(strftime("%Y", time()), 1950); ?>
    <style>
        @media only screen and (max-width: 540px) {
            #tableFeeStudentList {
                display: block;
                overflow-x: auto;
            }
        }

        @media only screen and (max-width: 976px) {
            #tableFeeStudentList {
                display: block;
                overflow-x: auto;
            }
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
                        <h1>Danh sách học phí học viên CiTEdu</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách học phí học viên</li>
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



                    </div>

                    <!-- /.card-header -->
                    <div class="card-header">
                        <a class="btn btn-success text-white float-right" id="btnAddStudent">
                            <i class="fas fa-cog"></i>
                            Thêm Học viên mới
                        </a>
                    </div>

                    <!-- /.card-body -->

                    <div class="card-body">
                        <table id="tableFeeStudentList" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr style="text-align: center">
                                <th style="width: 3%;">STT</th>
                                <th>Họ tên</th>
                                <th>Mã học viên</th>
                                <th>Giới tính</th>
                                <th>Ngày sinh</th>
                                <th>Điện thoại</th>
                                <th>Email</th>
                                <th style="width: 6%">Facebook</th>
                                <th>Tổng</th>
                                <th>Đã đóng</th>
                                <th>Còn nợ</th>
                                <th style="width: 11%">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $index = 1 ?>
                            @forelse($listStudent as $key => $student)
                                <tr >
                                    <td>
                                        {{ $index++}}
                                    </td>
                                    <td>{{$student['name']}}</td>
                                    <td>{{$student['code']}}</td>
                                    <td>{{$student['gender'] ? "Nam" : "Nữ"}}</td>
                                    <td>{{date('d/m/Y', strtotime($student['birthday']))}}</td>
                                    <td>{{$student['phone']}}</td>
                                    <td>{{$student['email']}}</td>
                                    <td><a href="{{$student['facebook']}}">Link</a></td>
                                    <td>{{number_format($student['total_fee'])}}</td>
                                    <td>{{number_format($student['money_paid'])}}</td>
                                    <td>{{number_format($student['total_fee'] - $student['money_paid'])}}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-success btnEdit" data-id=""
                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btnView" data-id=""
                                                data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button type="button" class="btn btn-outline-success btnAddIntern" data-id=""
                                                data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Thêm vào thực tập sinh">
                                            <i class="fas fa-plus-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="8" style="text-align: center">Không có dữ liệu hiển thị! Vui lòng thử lại!</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </section>

    </div>

@endsection


