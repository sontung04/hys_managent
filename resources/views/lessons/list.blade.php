@extends('layouts.sidebar')

@section('title', 'HYS Manage - Danh sách bài học')

@section('script')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <!-- Select2 -->
    <script src="{{ asset('themes/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/lesson/list.js') }}" defer></script>
@endsection

@section('style')
    <style>
        @media only screen and (min-width: 280px) and (max-width: 1880px) {
            #tableListLesson {
                display: block;
                overflow-x: auto;
            }
            #tableListLesson .setMinWidthMediumText {
                min-width: 150px;
            }

            #tableListLesson .setMinWidthLongText {
                min-width: 200px;
            }
        }
    </style>
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('themes/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h1>Danh sách bài học</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách bài học</li>
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
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label class="col-lg-2 col-form-label">Chọn khóa học: <span
                                                    class="text-danger">*</span></label>
                                            <div class="form-group col-lg-5">
                                                <select class="" id="selectCourse" multiple="multiple"
                                                        data-placeholder="--- Chọn khóa học ---"
                                                        style="width: 100%;">
                                                </select>
                                            </div>
                                            <div class="col-lg-5">
                                                <a class="btn btn-info text-white float-left" id="btnFilterLesson">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                    Tìm kiếm
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <a class="btn btn-success text-white float-right" id="btnAddLesson">
                                            <i class="fas fa-cog"></i>
                                            Thêm bài học mới
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table id="tableListLesson" class="table table-bordered table-hover">
                                    <thead>
                                    <tr style="text-align: center">
                                        <th style="width: 3%">STT</th>
                                        <th style="min-width:100px; width: 100px">Thứ tự học</th>
                                        <th class="setMinWidthMediumText" style="width: 150px">Tên Bài giảng</th>
                                        <th class="setMinWidthMediumText">Khóa học</th>
                                        <th class="setMinWidthMediumText">Giảng viên</th>
                                        <th style="min-width:100px; width: 100px">Trạng thái</th>
                                        <th class="setMinWidthLongText" style="width: 200px">Mô tả</th>
                                        <th class="setMinWidthLongText" style="width: 200px">Câu hỏi</th>
                                        <th class="setMinWidthLongText" style="width: 200px">Tài liệu</th>
                                        <th class="setMinWidthLongText" style="width: 200px">Bài tập về nhà</th>
                                        <th style="min-width: 105px; width: 7%">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tableBodyLessonList">
                                    <tr>
                                        <th colspan="11" style="text-align: center">Vui lòng chọn khóa học trước!</th>
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
    <!-- </section> -->
    <!-- The Modal Lesson -->
    <div class="modal fade" id="modalAddLesson">
        <div class="modal-dialog" style="width: 72%; max-width: 80%;">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddLessonTitle">Thêm bài học mới</h4>
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="formAddLesson" class="form-horizonal" method="post">
                    @csrf
                    <!-- Modal body -->
                    <input type="hidden" id="id" name="id" class="form-control">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="course_id">Khóa học: <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <select class="form-control custom-select" name="course_id" id="course_id">
                                            <option value="" selected disabled="disabled">--- Chọn khóa học ---</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="name">Tên bài giảng: <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="name" id="name" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label" for="description">Mô tả bài giảng:</label>
                                    <div class="col-lg-9">
                                        <textarea type="text" name="description" id="description"
                                                  class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label" for="document">Tài liệu tham khảo:</label>
                                    <div class="col-lg-9">
                                        <textarea type="text" name="document" id="document"
                                                  class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="teacher_id">Giảng viên: <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <select class="form-control custom-select" name="teacher_id" id="teacher_id">
                                            <option value="0" selected>--- Chọn Giảng viên ---</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="status">Trạng thái: </label>
                                    <div class="form-group col-lg-9">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="status1" name="status" value="1" checked>
                                            <label for="status1" style="margin-right: 10px">
                                                <span style="color:green;">Mở</span>
                                            </label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="status2" name="status" value="0">
                                            <label for="status2">
                                                <span style="color:red;">Đóng</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="name">Thứ tự bài giảng: <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="order" id="order" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label" for="question">Câu hỏi thảo luận:</label>
                                    <div class="col-lg-9">
                                        <textarea type="text" name="question" id="question"
                                                  class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label" for="homework">Bài tập về nhà:</label>
                                    <div class="col-lg-9">
                                        <textarea type="text" name="homework" id="homework"
                                                  class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="btnSave"><i class="fas fa-save"></i> Lưu thông
                            tin
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
