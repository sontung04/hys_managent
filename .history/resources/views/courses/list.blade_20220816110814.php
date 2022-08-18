@extends('layouts.sidebar')

@section('script')

@endsection

@section('style')
    <div class="content-wrapper">
        <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Khóa học</h3>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"
                                        style="position: absolute;  right: 2%; vertical-align: middle;">Thêm mới</button>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
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
                    <div class="modal fade" id="myModal">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="/action_page.php">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Thêm bài giảng</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->

                                    <div class="modal-body">
                                        <label for="name" style="width:18%">Tên khóa học: </label>
                                        <input type="text" id="name" name="name" style="width:81%"><br>
                                        <label for="course-id" style="width:18%">Học phí: </label>
                                        <input type="text" id="course-id" name="course-id" style="width:81%"><br>
                                        <label for="description" style="width:18%" style="display: inline;">Mô tả: </label>
                                        <textarea name="description" class="ckeditor" style="background-color=red"></textarea>
                                        <br>
                                        <label for="status" style="width:18%">Trạng thái:</label>
                                        <!-- <input type="text" id="quiz" name="quiz" style="width:81%"><br> -->
                                        Mở <input type="radio" name="status" value="open">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Đóng <input type="radio" name="status" value="close">

                                    </div>


                                    <!-- Modal footer -->

                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-primary" value="Lưu">
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

@section('content')

@endsection
