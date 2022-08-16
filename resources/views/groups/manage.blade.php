@extends('layouts.sidebar')
@section('script')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/js/group/manage.js') }}" defer></script>
@endsection
@section("content")
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh sách Group HYS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách Group</li>
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
                        <a class="btn btn-success text-white float-right" id="btnAddGroup">
                            <i class="fa-solid fa-house-chimney-medical"></i>
                            Thêm mới Group
                        </a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tableGroup" class="table table-bordered table-striped">
                            <thead>
                            <tr style="text-align: center">
                                <th style="width: 4%">ID</th>
                                <th>Tên</th>
                                <th>Trực thuộc</th>
                                <th>Khu vực</th>
                                <th>Phòng ban</th>
                                <th>Phân loại</th>
                                <th>Trạng thái</th>
                                <th>Người tạo</th>
                                <th style="width: 8%">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($groups as $group)
                                <tr>
                                    <th style="text-align: center">{{$group->id}}</th>
                                    <th>
                                        <?php
                                        if($group->type == 1) {
                                            echo 'HYS ';
                                        } else {
                                            echo $groupType[$group->type] . ' ';
                                        }
                                        echo $group->name;
                                        ?>
                                    </th>
                                    <th>
                                        <?php
                                        if($group->parent) {
                                            if($groupInfos[$group->parent]['type'] == 1) {
                                                echo 'HYS ';
                                            } else {
                                                echo $groupType[$groupInfos[$group->parent]['type']] . ' ';
                                            }
                                            echo $groupInfos[$group->parent]['name'];
                                        } else {
                                            echo '';
                                        }
                                        ?>
                                    </th>
                                    <th><?php echo $group->area ? 'HYS ' . $areaName[$group->area] : ''; ?></th>
                                    <th style="text-align: center">
                                        <?php echo $group->depart ? $groupInfos[$group->depart]['name'] : ''; ?>
                                    </th>
                                    <th style="text-align: center">{{$groupType[$group->type]}}</th>
                                    <th style="text-align: center">
                                        <?php echo $group->status ? '<span style="color:green;">Đang hoạt động</span>' : '<span style="color:red">Dừng hoạt động</span>' ?>
                                    </th>
                                    <th>{{$group->firstname . ' ' . $group->lastname}}</th>
                                    <th>
                                        <button type="button" class="btn btn-outline-success btnEdit mr-1" data-id="{{$group->id}}"
                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btnView" data-id="{{$group->id}}"
                                                data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </th>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="8" style="text-align: center">Không có dữ liệu để hiển thị!</th>
                                </tr>
                            @endforelse
                            </tbody>
                            {{--                            <tfoot>--}}
                            {{--                            <tr>--}}
                            {{--                                <th>Họ tên</th>--}}
                            {{--                                <th>Email</th>--}}
                            {{--                                <th>Số điện thoại</th>--}}
                            {{--                                <th>Quê quán</th>--}}
                            {{--                                <th>Chức vụ</th>--}}
                            {{--                            </tr>--}}
                            {{--                            </tfoot>--}}
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </section>
    </div>

    <!-- modal Add Group -->
    <div class="modal fade" id="modalAddGroup">
        <div class="modal-dialog modal-dialog-centered" style="width: 72%; max-width: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddTitle">Thêm mới Group</h4>
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="" method="post" class="form-horizontal">
                    <input type="hidden" id="id" class="form-control" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="email">Loại: <span style="color: red">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <select class="form-control custom-select" name="type" id="type">
                                            <option value="" selected disabled="disabled">--- Chọn loại group ---</option>
                                            @foreach($groupType as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row" id="selectArea" hidden="hidden">
                                    <label class="col-lg-3 col-form-label" for="area" id="">Khu vực: <span style="color: red">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <select class="form-control custom-select" name="area" id="area">
                                            <option value="" selected disabled="disabled">--- Chọn Khu vực ---</option>
                                            <option value="0" hidden="hidden"></option>
                                            @foreach($areaName as $key => $value)
                                                @if($key != 0)
                                                    <option value="{{$key}}" data-name="{{$key.$value}}">{{'HYS ' . $value}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row" id="selectParent" hidden="hidden">
                                    <label class="col-lg-3 col-form-label" for="parent" id="">Group trực thuộc: <span style="color: red">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <select class="form-control custom-select" name="parent" id="parent">
                                            <option value="" disabled>--- Chọn Group trực thuộc ---</option>
                                            <option value="0" hidden="hidden"></option>

                                        </select>
                                    </div>
                                </div>

                                <div class="row" id="selectDepart" hidden="hidden">
                                    <label class="col-lg-3 col-form-label" for="depart" id="">Phòng ban: <span style="color: red">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <select class="form-control custom-select" name="depart" id="depart">
                                            <option value="" disabled>--- Chọn Phòng ban ---</option>
                                            <option value="0" hidden="hidden"></option>

                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="name" id="inputNameTitle">Tên: <span style="color: red">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="name" id="name" class="form-control" value="" >
                                    </div>
                                </div>
                                <div class="form-group row" id="inputBirthday">
                                    <label class="col-lg-3 col-form-label" for="birthday">Ngày thành lập:</label>
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
                                    <label class="col-lg-3 col-form-label" for="description">Mô tả: </label>
                                    <div class="col-lg-9">
                                        <textarea type="text" name="description" id="description" class="form-control" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label" for="email">Email: </label>
                                    <div class="form-group col-lg-8">
                                        <input type="email" name="email" id="email" class="form-control" value="" >
                                    </div>
                                </div>

                                <div class="form-group row" id="inputSong" hidden="hidden">
                                    <label class="col-lg-4 col-form-label" for="song">Bài hát truyền thống:</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="song" id="song" class="form-control" value="" >
                                    </div>
                                </div>

                                <div class="form-group row" id="inputColor" hidden="hidden">
                                    <label class="col-lg-4 col-form-label" for="color">Màu sắc truyền thống:</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="color" id="color" class="form-control" value="" >
                                    </div>
                                </div>

                                <div class="form-group row" id="inputAddress">
                                    <label class="col-lg-4 col-form-label" for="address">Địa bàn hoạt động:</label>
                                    <div class="col-lg-8">
                                        <textarea type="text" name="address" id="address" class="form-control" row="2"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row" id="inputSlogan">
                                    <label class="col-lg-4 col-form-label" for="slogan" >Slogan: </label>
                                    <div class="col-lg-8">
                                        <textarea type="text" name="slogan" id="slogan" class="form-control"  row="2"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="facebook">Link Facebook:</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="facebook" id="facebook" class="form-control" value="" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="zalo">Link Zalo:</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="zalo" id="zalo" class="form-control" value="" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="youtube">Link Youtube:</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="youtube" id="youtube" class="form-control" value="" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="instagram">Link Instagram:</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="instagram" id="instagram" class="form-control" value="" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="tiktok">Link Tiktok:</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="tiktok" id="tiktok" class="form-control" value="" >
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-4 col-form-label" for="status">Trạng thái: </label>
                                    <div class="form-group col-lg-8">
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
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
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
