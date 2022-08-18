@extends('layouts.sidebar')

@section('script')
    <!-- <script src="{{ asset('assets/js/courses/jquery.min.js') }}"></script> -->
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/js/courses/list.js') }}" defer></script>
    <script>
        $( ".editCourseModal" ).click(function() {
            $('#modalAddCourse').modal('show');
        });
    </script>
    <script type="text/javascript">
            $(document).ready(function () {
            $.validator.setDefaults({
                submitHandler: function () {
                alert("Form successful submitted!");
                }
            });
            $('#formAddCourse').validate({
                rules: {
                name: {
                    required: true,
                },

                },
                messages: {
                name: {
                    required: "Tên khóa học không được bỏ trống"
                },
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                }
            });
            });

    </script>
    <script src="{{ asset('assets/js/courses/jquery.validate.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/courses/additional-methods.min.js') }}" defer></script>
        <!-- <script src="./jquery.validate.min.js"></script>
    <script src="./additional-methods.min.js"></script> -->
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
                                                    <th style="width: 8%">Hành động</th>
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
                                                        <th>
                                                        <button type="button" class="btn btn-outline-success btnEdit mr-1 editCourseModal" 
                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa" id=>
                                                            <i class="fas fa-edit"></i>

                                                        </button>
                                                        <!-- <button type="button" class="btn btn-outline-primary btnView" 
                                                data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Xem chi tiết">
                                                        <i class="fas fa-eye"></i>
                                                        </button> -->
                                                        </th>
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
                                                    <td>
                                                    <button type="button" class="btn btn-outline-success btnEdit mr-1 editCourseModal" 
                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa" >
                                                            <i class="fas fa-edit"></i>

                                                        </button>
                                                    </td>
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
                                                    <td>
                                                    <button type="button" class="btn btn-outline-success btnEdit mr-1 editCourseModal" 
                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa" data-toggle="modal" data-target="#modalAddCourse">
                                                            <i class="fas fa-edit"></i>

                                                        </button>
                                                    </td>
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
                                                    <td>
                                                    <button type="button" class="btn btn-outline-success btnEdit mr-1 editCourseModal" 
                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa" >
                                                            <i class="fas fa-edit"></i>
                                                        
                                                        </button>
                                                    </td>
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
                                    <form action="" id="formAddCourse" class="form-horizontal" method="get">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="modalAddCourseTitle">Thêm Khóa học</h4>
                                            <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <!-- Modal body -->
                                    
                                            <div class="modal-body">
                                                <div class="row">
                                                    <label class="col-lg-2 col-form-label" for="name" id="inputNameTitle"> Tên khóa học: <span class="text-danger">*</span></label>
                                                    <div class="form-group col-lg-10">
                                                        <input type="text" name="name" id="name" class="form-control" >
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-lg-2 col-form-label" for="fee">Học phí (VNĐ)</label>
                                                    <div class="form-group col-lg-10">
                                                        <input type="number" min="0" max="10000" name="fee" id="fee" class="form-control" >
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

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <!-- <button type="reset" class="btn btn-primary">clear</button> -->
                                            <!-- <input type="submit" class="btn btn-primary" value="Lưu"> -->
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- /.row -->

                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
        </section>
    </div>


@endsection
