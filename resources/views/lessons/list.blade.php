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
            <h1>Danh sách bài giảng</h1>
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
                <a class="btn btn-success text-white float-right" id="btnAddLesson" data-toggle="modal" data-target="#modalAddLesson">
                                            <i class="fas fa-cog"></i>
                                            Thêm bài học mới
                                        </a>

              </div>
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr style="text-align: center">
                      <th style="width: 10px">STT</th>
                      <th class="course-id" style="width: 10px">Khóa học</th>
                      <th class="name">Tên Bài giảng</th>
                      <th>Giáo viên</th>
                      <th style="width: 15%">Mô tả</th>
                      <th style="width: 15%">Quiz</th>
                      <th style="width: 15%">Tài liệu</th>
                      <th style="width: 15%">Bài tập về nhà</th>
                      <th style="width: 8%">Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="text-align:center;">1</td>
                      <td class="course-id">1</td>
                      <td class="name">ABC</td>
                      <td style="text-align:center;">
                        Nguyen Van A
                      </td>
                      <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sequi, distinctio nulla doloribus
                        voluptatum autem recusandae placeat suscipit voluptatem sunt nesciunt iste commodi, delectus
                        molestias praesentium aperiam. Laborum aliquam repellendus impedit!</td>
                      <td>aaaaaaaaaa aaaaaaaaaa aaaaaaaaaaaaa aaaaaaaaa aaaaaaaaaa aaaaaaaa</td>
                      <td>aaaaaaaaaa aaaaaaaaaa aaaaaaaaaaaaa aaaaaaaaa aaaaaaaaaa aaaaaaaa</td>
                      <td>aaaaaaaaaa aaaaaaaaaa aaaaaaaaaaaaa aaaaaaaaa aaaaaaaaaa aaaaaaaa</td>
                      <td>
                        <button type="button" class="btn btn-outline-success btnEdit mr-1 editModalLesson" data-toggle="popover"
                          data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                          <i class="fas fa-edit"></i>
                        </button>
                      </td>

                    </tr>
                    <tr>
                      <td style="text-align:center;">1</td>
                      <td class="course-id">1</td>
                      <td class="name">ABC</td>
                      <td style="text-align:center;">
                        Nguyen Van A
                      </td>
                      <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sequi, distinctio nulla doloribus
                        voluptatum autem recusandae placeat suscipit voluptatem sunt nesciunt iste commodi, delectus
                        molestias praesentium aperiam. Laborum aliquam repellendus impedit!</td>
                      <td>aaaaaaaaaa aaaaaaaaaa aaaaaaaaaaaaa aaaaaaaaa aaaaaaaaaa aaaaaaaa</td>
                      <td>aaaaaaaaaa aaaaaaaaaa aaaaaaaaaaaaa aaaaaaaaa aaaaaaaaaa aaaaaaaa</td>
                      <td>aaaaaaaaaa aaaaaaaaaa aaaaaaaaaaaaa aaaaaaaaa aaaaaaaaaa aaaaaaaa</td>
                      <td>
                        <button type="button" class="btn btn-outline-success btnEdit mr-1 editModalLesson" data-toggle="popover"
                          data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                          <i class="fas fa-edit"></i>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td style="text-align:center;">1</td>
                      <td class="course-id">1</td>
                      <td class="name">ABC</td>
                      <td style="text-align:center;">
                        Nguyen Van A
                      </td>
                      <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sequi, distinctio nulla doloribus
                        voluptatum autem recusandae placeat suscipit voluptatem sunt nesciunt iste commodi, delectus
                        molestias praesentium aperiam. Laborum aliquam repellendus impedit!</td>
                      <td>aaaaaaaaaa aaaaaaaaaa aaaaaaaaaaaaa aaaaaaaaa aaaaaaaaaa aaaaaaaa</td>
                      <td>aaaaaaaaaa aaaaaaaaaa aaaaaaaaaaaaa aaaaaaaaa aaaaaaaaaa aaaaaaaa</td>
                      <td>aaaaaaaaaa aaaaaaaaaa aaaaaaaaaaaaa aaaaaaaaa aaaaaaaaaa aaaaaaaa</td>
                      <td>
                        <button type="button" class="btn btn-outline-success btnEdit mr-1 editModalLesson" data-toggle="popover"
                          data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                          <i class="fas fa-edit"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
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
    <!-- </section> -->
  <!-- The Modal -->
  <div class="modal fade" id="modalAddLesson">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="" id="formAddLesson" class="form-horizonal" method="get">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Thêm bài giảng</h4>
            <button type="button" class="close" data-dismiss="modal">&times;
            </button>
          </div>

          <!-- Modal body -->


          <div class="modal-body">
            <div class="row">
              <label class="col-lg-2 col-form-label" for="nameLesson" id="inputNameTitle"> Tên bài giảng: <span
                  class="text-danger">*</span></label>
              <div class="form-group col-lg-10">
                <input type="text" name="name" id="nameLesson" class="form-control">
              </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-form-label" for="course_id" id="inputNameTitle"> Khóa học: <span
                  class="text-danger">*</span></label>
              <div class="form-group col-lg-10">
                <input type="text" name="course_id" id="name" class="form-control">
              </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-form-label" for="teacher"> Giảng viên: </label>
              <div class="form-group col-lg-10">
                <input type="text" name="teacher" id="name" class="form-control">
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
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" >Lưu</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  </div>
  </section>
</div>




@endsection
