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
                                <i class="fa-solid fa-circle-plus"></i>
                                Thêm Khóa học mới
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr style="text-align: center">
                                    <th style="width: 3%">STT</th>
                                    <th style="width: 25%">Tên khóa học</th>
                                    <th style="width: 8%">Học phí (VNĐ)</th>
                                    <th style="width: 8%">Số buổi học</th>
                                    <th>Mô tả khóa học</th>
                                    <th style="width: 8%">Trạng thái</th>
                                    <th style="width: 8%">Hành động</th>
                                </tr>
                                </thead>
                                <tbody id="tableCourseList">
                                <?php $index = 0; ?>
                                @forelse($courses as $course)
                                    <tr id="course-{{$course->id}}">
                                        <th style="text-align:center;">{{++$index}}</th>
                                        <th>{{$course->name}}</th>
                                        <th style="text-align: center;">{{$course->fees}}</th>
                                        <th style="text-align: center;">{{$course->length}}</th>
                                        <td><?php echo $course->description; ?></td>
                                        <th style="text-align: center">
                                            <?php echo $course->status ? '<span style="color:green;">Mở</span>' : '<span style="color:red">Đóng</span>' ?>
                                        </th>
                                        <th style="text-align: center;">
                                            <button type="button" class="btn btn-outline-success btnEdit" data-id="{{$course->id}}"
                                                    data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </th>
                                    </tr>
                                @empty
                                    <tr>
                                        <th colspan="7" style="text-align: center">Không có dữ liệu hiển thị! Vui lòng thử lại!</th>
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
                        <label class="col-lg-3 col-form-label" for="name" id="inputNameTitle">Tên khóa học: <span class="text-danger">*</span></label>
                        <div class="form-group col-lg-9">
                            <input type="text" name="name" id="name" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="fee">Học phí (VNĐ): <span class="text-danger">*</span></label>
                        <div class="form-group col-lg-9">
                            <input type="number" name="fees" id="fees" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="length">Số buổi học: </label>
                        <div class="form-group col-lg-9">
                            <input type="number" name="length" id="length" class="form-control" >
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-lg-3 col-form-label" for="status">Trạng thái: </label>
                        <div class="form-group col-lg-9">
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

                    <div class="form-group row" >
                        <label class="col-lg-3 col-form-label" for="description">Mô tả khóa học:</label>
                        <div class="col-lg-9">
                            <textarea type="text" name="description" id="description" class="form-control" ></textarea>
                        </div>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer ">
                    <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="btnSave"><i class="fas fa-save"></i> Lưu thông tin </button>
                </div>
            </form>

        </div>
    </div>
</div>


@endsection
