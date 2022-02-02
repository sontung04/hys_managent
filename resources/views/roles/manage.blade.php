@extends('layouts.sidebar')

@section('script')
    <script src="{{ asset('assets/js/role.js') }}" defer></script>
@endsection

@section("content")
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Quản lý chức vụ thành viên HYS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Quản lý chức vụ thành viên</li>
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
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="{{asset('themes/dist/img/user1-128x128.jpg')}}" alt="user image">
                                    <span class="username">
                                            <a href="#">Username</a>
                                        </span>
                                    <span class="description" style="font-size: 16px">Trạng thái:<strong> Đang Hoạt động</strong></span>
                                </div>

                                <a class="btn btn-success text-white float-right" id="btnAddEditRole">
                                    <i class="fas fa-cog"></i>
                                    Thêm/Chỉnh Sửa Chức vụ
                                </a>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">

                                <table class="table table-bordered" style="text-align: center">
                                    <thead>
                                    <tr>
                                        <th colspan="4">HYS Thăng Long</th>
                                        <th rowspan="2" style="vertical-align: middle">HYS</th>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            Phó Chủ Nhiệm
                                            <a href="javascript:;" class="text-danger" style="padding-left: 5px" data-toggle="tooltip" data-placement="right" title="Xóa chức vụ">
                                                <i class="fas fa-user-slash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th colspan="2">Cơ sở Kinh Tế</th>
                                        <th>Cơ sở Xây Dựng</th>
                                        <th>Ban Văn phòng</th>
                                        <th>Ban Tổ chức kiểm tra</th>
                                    </tr>
                                    <tr>
                                        <th>Đội Kinh tế 3</th>
                                        <th>Đội Kinh tế 4</th>
                                        <td rowspan="2" style="vertical-align: middle">
                                            Chủ Nhiệm
                                            <a href="javascript:;" class="text-danger" style="padding-left: 5px" data-toggle="tooltip" data-placement="right" title="Xóa chức vụ">
                                                <i class="fas fa-user-slash"></i>
                                            </a>
                                        </td>
                                        <td rowspan="2" style="vertical-align: middle">
                                            Phó Chánh
                                            <a href="javascript:;" class="text-danger" style="padding-left: 5px" data-toggle="tooltip" data-placement="right" title="Xóa chức vụ">
                                                <i class="fas fa-user-slash"></i>
                                            </a>
                                        </td>
                                        <td rowspan="2" style="vertical-align: middle">
                                            Phó Ban
                                            <a href="javascript:;" class="text-danger" style="padding-left: 5px" data-toggle="tooltip" data-placement="right" title="Xóa chức vụ">
                                                <i class="fas fa-user-slash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Thành viên</td>
                                        <td>
                                            Đội trưởng
                                            <a href="javascript:;" class="text-danger" style="padding-left: 5px" data-toggle="tooltip" data-placement="right" title="Xóa chức vụ">
                                                <i class="fas fa-user-slash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addEditRoleModal" tabindex="-1" role="dialog" aria-labelledby="addEditRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa Chức vụ Thành viên</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary">Lưu thông tin</button>
                </div>
            </div>
        </div>
    </div>
@endsection
