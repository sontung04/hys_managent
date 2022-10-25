@extends('layouts.sidebar')

@section('title', 'HYS Manage - Thêm thành viên mới')

@section('script')

    <script src="{{ asset('assets/js/user/user.js') }}" defer></script>
@endsection
@section("content")
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tạo người dùng</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Tạo người dùng</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <form action="" id="formCreateUser">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Các thông tin cơ bản:</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <label for="area" class="col-sm-3">Khu vực hoạt động: <span style="color: red">*</span></label>
                                    <div class="form-group col-sm-9">
                                        <select class="form-control custom-select" name="area" id="area">
                                            <option selected disabled>Chọn Khu vực</option>
                                            @foreach($areaName as $key => $value)
                                                <option value="{{$key}}">{{ $key ? 'HYS ' . $value : $value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class=" row">
                                    <label for="code" class="col-sm-3">Mã thành viên: <span style="color: red">*</span></label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" id="code" name="code" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="lastname" class="col-sm-3">Họ: <span style="color: red">*</span></label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" id="lastname" name="lastname" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="firstname" class="col-sm-3">Tên: <span style="color: red">*</span></label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" id="firstname" name="firstname" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="phone" class="col-sm-3">Số điện thoại: <span style="color: red">*</span></label>
                                    <div class="form-group col-sm-9">
                                        <input type="number" id="phone" name="phone" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="email" class="col-sm-3">Email: <span style="color: red">*</span></label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" id="email" name="email" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="birthday" class="col-sm-3">Ngày sinh: <span style="color: red">*</span></label>
                                    <div class="form-group col-sm-9">
                                        <div class="input-group date" id="birthdayDate" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#birthdayDate" data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" id="birthday" name="birthday"
                                                   data-target="#birthdayDate" data-toggle="datetimepicker" data-min="01/01/1960"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="gender" class="col-sm-3">Giới tính: <span style="color: red">*</span></label>
                                    <div class="form-group col-sm-9">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="gender1" name="gender" value="1" checked>
                                            <label for="gender1" style="margin-right: 10px">
                                                Nam
                                            </label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="gender2" name="gender" value="0">
                                            <label for="gender2">
                                                Nữ
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="facebook" class="col-sm-3">Link Facebook: </label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" id="facebook" name="facebook" class="form-control">
                                    </div>

                                </div>

                                <div class="row">
                                    <label for="address" class="col-sm-3">Quê quán: </label>
                                    <div class="form-group col-sm-9">
                                        <textarea id="address" name="address" class="form-control" rows="3"></textarea>
                                    </div>

                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Các thông tin khác:</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="school" class="col-sm-3">Trường đang học:</label>
                                    <div class="form-group col-sm-9">
                                        <textarea type="text" id="school" name="school" class="form-control" rows="2"></textarea>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="major" class="col-sm-3">Ngành học:</label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" name="major" id="major" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="major" class="col-sm-3">Công việc hiện tại:</label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" name="work" id="work" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="major" class="col-sm-3">Nơi làm việc hiện tại:</label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" name="company" id="company" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="major" class="col-sm-3">Kỹ năng cá nhân:</label>
                                    <div class="form-group col-sm-9">
                                        <textarea name="skill" id="skill" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="major" class="col-sm-3">Mong muốn khi hoạt động ở HYS:</label>
                                    <div class="form-group col-sm-9">
                                        <textarea name="desire" id="desire" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div style="text-align: center">
                    <button type="reset" class="btn btn-secondary mr-2">Nhập lại</button>
                    <button type="submit"  class="btn btn-success">Tạo tài khoản</button>
                </div>
            </form>
        </section>
    </div>
@endsection
