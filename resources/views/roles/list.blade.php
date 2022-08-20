@extends('layouts.sidebar')

@section('script')
    <!-- Ckeidtor -->
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/js/role/list.js') }}" defer></script>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/role/list.css') }}">

@endsection

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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"></h3>

                        <a class="btn btn-success text-white float-right" id="btnAddRole">
                            <i class="fas fa-cog"></i>
                            Thêm Chức vụ mới
                        </a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr style="text-align: center">
                                <th style="width: 3%">STT</th>
                                <th style="width: 15%">Chức vụ</th>
                                <th style="width: 55%">Mô tả</th>
                                <th style="width: 10%">Trạng thái</th>
                                <th style="width: 7%">Cấp</th>
                                <th style="width: 10%">Hành động</th>
                            </tr>
                            </thead>
                            <tbody id="tableRoleList">
                            @forelse($roles as $key => $role)
                                <tr id="role-{{$role->id}}">
                                    <th style="text-align: center">{{++$key}}</th>
                                    <th>{{$role->name}}</th>
                                    <th><?php echo $role->description;  ?></th>
                                    <th style="text-align: center">
                                        <?php echo $role->status ? '<span style="color:green;">Đang hoạt động</span>' : '<span style="color:red">Dừng hoạt động</span>' ?>
                                    </th>
                                    <th style="text-align: center"><?php echo $role->group_type ? $groupType[$role->group_type] : '' ?></th>
                                    <th style="text-align: center"><button type="button" class="btn btn-outline-success btn-sm btnEdit" data-id="{{$role->id}}">Chỉnh sửa</button></th>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="6" style="text-align: center">Không có dữ liệu hiển thị! Vui lòng thử lại!</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <!-- modal Add New Role -->
    <div class="modal fade" id="modalAddRole">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddRoleTitle">Modal default</h4>
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="" class="form-horizontal" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control" name="id">

                        <div class="row">
                            <label class="col-lg-2 col-form-label" for="name" id="inputNameTitle">Tên chức vụ: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-10">
                                <input type="text" name="name" id="name" class="form-control" >
                            </div>
                        </div>

                        <div class="form-group row" >
                            <label class="col-lg-2 col-form-label" for="description">Mô tả:</label>
                            <div class="col-lg-10">
                                <textarea type="text" name="description" id="description" class="form-control" ></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-lg-2 col-form-label" for="status">Trạng thái: </label>
                            <div class="form-group col-lg-10">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status1" name="status" value="1" checked>
                                    <label for="status1" style="margin-right: 10px">
                                        Đang hoạt động
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status2" name="status" value="0">
                                    <label for="status2">
                                        Dừng hoạt động
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-2 col-form-label" for="email">Cấp:</label>
                            <div class="form-group col-lg-10">
                                <select class="form-control custom-select" name="group_type" id="group_type">
                                    <option value="" selected disabled>---Chọn Cấp chức vụ---</option>
                                    @foreach($groupType as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
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
