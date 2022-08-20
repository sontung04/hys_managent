@extends('layouts.sidebar')

@section('script')
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<script src="{{ asset('assets/js/lesson/list.js') }}" defer></script>
@endsection

@section('style')
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
                <h3 class="card-title"></h3>
                <a class="btn btn-success text-white float-right" id="btnAddLesson" >
                                            <i class="fas fa-cog"></i>
                                            Thêm bài học mới
                                        </a>

              </div>
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr style="text-align: center">
                      <th style="width: 10px">STT</th>
                      
                      <th >Tên Bài giảng</th>
                      <th style="width: 10px">Khóa học</th>
                      <th>Giáo viên</th>
                      <th style="width: 15%">Mô tả</th>
                      <th style="width: 15%">Câu hỏi</th>
                      <th style="width: 15%">Tài liệu</th>
                      <th style="width: 15%">Bài tập về nhà</th>
                      <th style="width: 8%">Hành động</th>
                    </tr>
                  </thead>
                  <tbody id="tableLessonList">
                  @forelse($lessons as $key => $lesson)
                    <tr id="lesson-{{$lesson->id}}">
                      <th style="text-align:center;">{{++$key}}</th>
                      <th style="text-align:center;">{{$lesson->name}}</th>
                      <th style="text-align:center;">{{$lesson->course_id}}</th>
                      <th style="text-align:center;">{{$lesson->teacher_id}}</th>
                      <th style="text-align:center;">{{$lesson->description}}</th>
                      <th style="text-align:center;">{{$lesson->question}}</th>
                      <th style="text-align:center;">{{$lesson->document}}</th>
                      <th style="text-align:center;">{{$lesson->homework}}</th>
                      <th>
                        <button type="button" class="btn btn-outline-success btnEdit" data-id="{{$lesson->id}}"
                         data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                          <i class="fas fa-edit"></i>
                        </button>
                      </th>
                    </tr>
                  @empty
                    <tr>
                      <th colspan="8" style="text-align: center">Không có dữ hiệu hiển thị! Vui lòng thử lại</th>
                    </tr>
                  @forelse
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
  <!-- The Modal -->
  <div class="modal fade" id="modalAddLesson">
    <div class="modal-dialog modal-lg">
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


          <div class="modal-body">
          <input type="hidden" id="id" class="form-control" name="id">
            <div class="row">
              <label class="col-lg-2 col-form-label" for="name" id="inputNameTitle"> Tên bài giảng: <span
                  class="text-danger">*</span></label>
              <div class="form-group col-lg-10">
                <input type="text" name="name" id="name" class="form-control">
              </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-form-label" for="course_id" id="inputNameTitle"> Khóa học: <span
                  class="text-danger">*</span></label>
              <div class="form-group col-lg-10">
                <input type="text" name="course_id" id="course_id" class="form-control">
              </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-form-label" for="teacher_id"> Giảng viên: </label>
              <div class="form-group col-lg-10">
                <input type="text" name="teacher_id" id="teacher_id" class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label" for="description">Mô tả:</label>
              <div class="col-lg-10">
                <textarea type="text" name="description" id="description" class="form-control"></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label" for="question">Câu hỏi:</label>
              <div class="col-lg-10">
                <textarea type="text" name="question" id="question" class="form-control"></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label" for="document">Tài liệu:</label>
              <div class="col-lg-10">
                <textarea type="text" name="document" id="document" class="form-control"></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label" for="homework">Bài tập:</label>
              <div class="col-lg-10">
                <textarea type="text" name="description" id="homework" class="form-control"></textarea>
              </div>
            </div>
            
            <!-- Modal footer -->
            
          </div>
          <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary" id="btnSave"><i class="fas fa-save"></i> Lưu thông tin </button>
          </div>
        </form>

      </div>
    </div>
  </div>





@endsection
