@extends('layouts.sidebar')

@section('script')

@endsection

@section('style')
    
@endsection


@section('content')
<div class="content-wrapper">
        <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Danh sách khóa học</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                                <li class="breadcrumb-item active">Danh sách khóa học</li>
                            </ol>
                        </div>
                    </div>
                </div>
        </section>
        <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"></h3>
                                        <a class="btn btn-success text-white float-right" id="btnAddCourse" data-toggle="modal" data-target="#modalAddCourse">
                                            <i class="fas fa-cog"></i>
                                            Thêm Khóa học mới
                                        </a>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr style="text-align: center">
                                                    <th style="width: 10px">STT</th>
                                                    <th>Tên khóa học</th>
                                                    <th style="width: 12%">Học phí</th>
                                                    <th style="width: 45%">Mô tả</th>
                                                    <th style="width: 10%">Trạng thái</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="text-align:center;">1</td>
                                                    <td>ABC</td>
                                                    <td style="text-align:center;">
                                                        10000000
                                                    </td>
                                                    <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sequi, distinctio
                                                        nulla doloribus voluptatum autem recusandae placeat suscipit voluptatem sunt
                                                        nesciunt iste commodi, delectus molestias praesentium aperiam. Laborum
                                                        aliquam repellendus impedit!</td>
                                                    <td style="text-align:center;"><span class="badge bg-success">Mở</span></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:center;">1</td>
                                                    <td>ABC</td>
                                                    <td style="text-align:center;">
                                                        10000000
                                                    </td>
                                                    <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sequi, distinctio
                                                        nulla doloribus voluptatum autem recusandae placeat suscipit voluptatem sunt
                                                        nesciunt iste commodi, delectus molestias praesentium aperiam. Laborum
                                                        aliquam repellendus impedit!</td>
                                                    <td style="text-align:center;"><span class="badge bg-success">Mở</span></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:center;">1</td>
                                                    <td>ABC</td>
                                                    <td style="text-align:center;">
                                                        10000000
                                                    </td>
                                                    <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sequi, distinctio
                                                        nulla doloribus voluptatum autem recusandae placeat suscipit voluptatem sunt
                                                        nesciunt iste commodi, delectus molestias praesentium aperiam. Laborum
                                                        aliquam repellendus impedit!</td>
                                                    <td style="text-align:center;"><span class="badge bg-danger">Đóng</span></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:center;">1</td>
                                                    <td>ABC</td>
                                                    <td style="text-align:center;">
                                                        10000000
                                                    </td>
                                                    <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sequi, distinctio
                                                        nulla doloribus voluptatum autem recusandae placeat suscipit voluptatem sunt
                                                        nesciunt iste commodi, delectus molestias praesentium aperiam. Laborum
                                                        aliquam repellendus impedit!</td>
                                                    <td style="text-align:center;"><span class="badge bg-success">Mở</span></td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>

                        </div>




                        <!-- The Modal -->

                        <div class="modal fade" id="modalAddCourse">
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
                        <!-- /.row -->

                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
        </section>
    </div>


@endsection
