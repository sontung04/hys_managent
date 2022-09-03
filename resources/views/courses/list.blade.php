@extends('layouts.sidebar')

@section('script')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/js/course/list.js') }}" defer></script>
 @endsection

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/course/list.css') }}">
  
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
                                        <a class="btn btn-success text-white float-right" id="btnAddCourse">
                                            <i class="fas fa-cog"></i>
                                            Thêm Khóa học mới
                                        </a>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr style="text-align: center">
                                                    <th style="width: 3%">STT</th>
                                                    <th style="width: 15%">Tên khóa học</th>
                                                    <th style="width: 12%">Học phí (VNĐ)</th>
                                                    <th style="width: 12%">Thời gian (giờ)</th>
                                                    <th>Mô tả</th>
                                                    <th style="width: 10%">Trạng thái</th>
                                                    <th style="width: 5%">Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableCourseList">
                                            @forelse($courses as $key => $course)
                                                <tr id="course-{{$course->id}}">
                                                    <th style="text-align:center;">{{++$key}}</th>
                                                    <th style="text-align:center;">{{$course->name}}</th>
                                                    <th style="text-align:center;">{{$course->fees}}</th>
                                                    <th style="text-align:center;">{{$course->length}}</th>
                                                    <th style="text-align: center">{{$course->status ? "Mở" : "Đóng"}}</th>
                                                    <th>
                                                        <button type="button" class="btn btn-outline-success btnEdit" data-id="{{$course->id}}"
                                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </th>
                                                </tr>
                                            @empty
                                                <tr>
                                                <th colspan="8" style="text-align: center">Không có dữ liệu hiển thị! Vui lòng thử lại!</th>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>

                            </div>

                        </div>
                    </div>
                </section>
            </div>


                        <!-- The Modal -->
                        <div class="modal fade" id="modalAddCourse">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="modalAddCourseTitle">Thêm Khóa học</h4>
                                            <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" id="formAddCourse" class="form-horizontal" method="post">
                                        <!-- Modal body -->
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" id="id" class="form-control" name="id">
                                                <div class="row">
                                                    <label class="col-lg-2 col-form-label" for="name" id="inputNameTitle"> Tên khóa học: <span class="text-danger">*</span></label>
                                                    <div class="form-group col-lg-10">
                                                        <input type="text" name="name" id="name" class="form-control" >
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label" for="fee">Học phí (VNĐ)</label>
                                                    <div class="form-group col-lg-10">
                                                        <input type="number" min="0" max="1000000000" name="fee" id="fee" class="form-control" >
                                                    </div>
                                                   
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label" for="length">Thời gian (giờ)</label>
                                                    <div class="form-group col-lg-10">
                                                        <input type="number" min="0" max="10000" name="length" id="length" class="form-control" >
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
                                                                Mở
                                                            </label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="status2" name="status" value="0">
                                                            <label for="status2">
                                                            Đóng
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                        <!-- Modal footer -->

                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-primary" id="btnSave"><i class="fas fa-save"></i> Lưu thông tin </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- /.row -->

                        <!-- /.row -->



@endsection
