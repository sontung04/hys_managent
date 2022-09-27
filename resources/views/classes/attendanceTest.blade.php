@extends('layouts.sidebar')

@section('style')
    <style>
        /*@media only screen and (max-width: 540px) {*/
        /*    #tableAtt {*/
        /*        display: block;*/
        /*        overflow-x: auto;*/
        /*    }*/
        /*}*/

        /*@media only screen and (max-width: 976px) {*/
        /*    #tableAtt {*/
        /*        display: block;*/
        /*        overflow-x: auto;*/
        /*    }*/
        /*}*/

        #diaryClassTable thead th {
            text-align: center;
            vertical-align: middle;
        }

    </style>
@endsection

@section('script')
    <script src="{{ asset('assets/js/class/attendanceTest.js') }}" defer></script>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tên lớp</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Tên lớp</li>
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
                            <div class="card-header p-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#listStudentClass" data-toggle="tab">Danh sách học viên</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#diaryClass" data-toggle="tab">Nhật ký lớp</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#attendanceStudentClass" data-toggle="tab">Danh sách điểm danh</a></li>
                                        </ul>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="user-block float-right">
                                            <img class="img-circle img-bordered-sm" alt="user image"
                                                 src="{{asset('themes/dist/img/user1-128x128.jpg')}}" >
                                            <span class="username">
                                                <a href="#">Đỗ Thị Phương Thảo</a>
                                            </span>
                                            <span class="description" style="font-size: 16px"><strong> Trợ giảng </strong></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="user-block float-right mr-3">
                                            <img class="img-circle img-bordered-sm" alt="user image"
                                                 src="{{asset('themes/dist/img/user1-128x128.jpg')}}" >
                                            <span class="username">
                                                <a href="#">Nguyễn Thị Minh Ngọc</a>
                                            </span>
                                            <span class="description" style="font-size: 16px"><strong> Chủ Nhiệm </strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">

                                    {{-- Tab List Student: Danh sách học viên của lớp --}}
                                    <div class="tab-pane" id="listStudentClass">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr style="text-align: center">
                                                <th>Học viên</th>
                                                <th>Số điện thoại</th>
                                                <th>Email</th>
                                                <th>Ngày sinh</th>
                                                <th>Ngày tham gia</th>
                                                <th>Trạng thái</th>
                                                <th>Hành động</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <img src="{{asset('themes/dist/img/default-150x150.png')}}" alt="Product 1" class="img-circle img-size-32 mr-2">
                                                    Some Product
                                                </td>
                                                <td>0912345678</td>
                                                <td>gami@gmail.com</td>
                                                <td>14/04/2022</td>
                                                <td>20/09/2022</td>
                                                <td>$29 USD</td>
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-outline-success btnEdit" data-id=""
                                                            data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="{{asset('themes/dist/img/default-150x150.png')}}" alt="Product 1" class="img-circle img-size-32 mr-2">
                                                    Another Product
                                                </td>
                                                <td>0985743126</td>
                                                <td>gami12@gmail.com</td>
                                                <td>13/04/2021</td>
                                                <td>20/09/2022</td>
                                                <td>$29 USD</td>
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-outline-success btnEdit" data-id="id"
                                                            data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="{{asset('themes/dist/img/default-150x150.png')}}" alt="Product 1" class="img-circle img-size-32 mr-2">
                                                    Amazing Product
                                                </td>
                                                <td>0975442189</td>
                                                <td>aigami8@gmail.com</td>

                                                <td>29/05/2022</td>
                                                <td>20/09/2022</td>
                                                <td>$1,230 USD</td>
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-outline-success btnEdit" data-id=""
                                                            data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="{{asset('themes/dist/img/default-150x150.png')}}" alt="Product 1" class="img-circle img-size-32 mr-2">
                                                    Perfect Item
                                                </td>
                                                <td>0932564178</td>
                                                <td>yamigami87@gmail.com</td>
                                                <td>30/10/2022</td>
                                                <td>20/09/2022</td>
                                                <td>$199 USD</td>
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-outline-success btnEdit" data-id=""
                                                            data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- End Tab List Student --}}

                                    {{-- Tab Diary Class: Nhật ký lớp học --}}
                                    <div class="tab-pane active" id="diaryClass">
                                        <a class="btn btn-success text-white float-right" id="btnAddClassLesson">
                                            <i class="fa-solid fa-folder-plus"></i>
                                            Thêm buổi học
                                        </a>

                                        <br>
                                        <br>

                                        <table class="table table-bordered table-striped" id="diaryClassTable">
                                            <thead>
                                            <tr style="">
                                                <th>Buổi</th>
                                                <th>Tên bài học</th>
                                                <th>Giảng viên</th>
                                                <th>Trợ giảng</th>
                                                <th>Chủ nhiệm</th>
                                                <th>Ngày học</th>
                                                <th>Địa điểm</th>
                                                <th>Số học viên <br>(Dùng bữa/Đi học)</th>
                                                <th>Hành động</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>0912345678</td>
                                                <td>gami@gmail.com</td>
                                                <td>gami@gmail.com</td>
                                                <td>14/04/2022</td>
                                                <td>20/09/2022</td>
                                                <td>$29 USD</td>
                                                <td>$29 USD</td>
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-outline-info btnFeedbackCoach" data-id=""
                                                            data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Nhận xét buổi học">
                                                        <i class="fas fa-comment"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-success btnEdit" data-id=""
                                                            data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>0985743126</td>
                                                <td>gami12@gmail.com</td>
                                                <td>gami12@gmail.com</td>
                                                <td>13/04/2021</td>
                                                <td>20/09/2022</td>
                                                <td>$29 USD</td>
                                                <td>$29 USD</td>
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-outline-success btnEdit" data-id="id"
                                                            data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>0975442189</td>
                                                <td>aigami8@gmail.com</td>

                                                <td>29/05/2022</td>
                                                <td>20/09/2022</td>
                                                <td>20/09/2022</td>
                                                <td>$1,230 USD</td>
                                                <td>$1,230 USD</td>
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-outline-success btnEdit" data-id=""
                                                            data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>0932564178</td>
                                                <td>yamigami87@gmail.com</td>
                                                <td>30/10/2022</td>
                                                <td>20/09/2022</td>
                                                <td>20/09/2022</td>
                                                <td>$199 USD</td>
                                                <td>$199 USD</td>
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-outline-success btnEdit" data-id=""
                                                            data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- End Tab Diary Class --}}

                                    {{-- Tab Attendance Student: Tab điểm danh học viên lớp --}}
                                    <div class="tab-pane" id="attendanceStudentClass">

                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" >
                                                <thead>
                                                <tr>
                                                    <th >Học viên</th>
                                                    <?php
                                                    for ($i = 1; $i <= 15; $i++) {
                                                        echo '<td>Buổi ' . $i . ' <a href="javascript:void(0);" class="btnViewStudyClass" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-content="Xem thông tin buổi học">
                                                            <i class="fa-regular fa-eye"></i>
                                                        </a></td>';
                                                    }
                                                    ?>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <img src="{{asset('themes/dist/img/user3-128x128.jpg')}}" alt="Product 1" class="img-circle img-size-32 mr-2">
                                                        Bùi Minh Quang
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="javascript:void(0);" class="btnAttenUpdate" data-html="true" data-toggle="popover" data-trigger="hover"
                                                           data-placement="right" data-content="<div><b>Trạng thái:</b> Đi học <br> <b>Ghi chú:</b> Nội dung ghi chú</div>">
                                                            <i class="fa fa-check text-success"></i>
                                                        </a>
                                                    </td>

                                                    <?php
                                                    for ($i = 0; $i < 14; $i++) {
                                                        if($i == 13) {
                                                            echo '<td style="text-align: center"><a href="javascript:void(0);" class="btnAttenUpdate" data-html="true" data-toggle="popover" data-trigger="hover"
                                                           data-placement="right" data-content="<div><b>Trạng thái:</b> Đi học <br> <b>Ghi chú:</b> Nội dung ghi chú</div>">
                                                            <i class="fa fa-check text-success"></i>
                                                        </a></td>';
                                                        } else {
                                                            echo '<td style="text-align: center">Ap</td>';
                                                        }

                                                    }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>Alexander Pierce</td>
                                                    <td style="text-align: center">
                                                        <a href="javascript:void(0);" class="btnAttenUpdate">
                                                            <i class="fa fa-close text-danger"></i>
                                                        </a>
                                                    </td>

                                                    <?php
                                                    for ($i = 0; $i < 14; $i++) {
                                                        echo '<td style="text-align: center">tr</td>';
                                                    }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>657</td>
                                                    <td style="text-align: center">
                                                        <a href="javascript:void(0);" class="btnAttenUpdate">
                                                            <i class="fa-solid fa-minus text-black-50"></i>
                                                        </a>
                                                    </td>

                                                    <?php
                                                    for ($i = 0; $i < 14; $i++) {
                                                        echo '<td style="text-align: center">Ba</td>';
                                                    }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td>Mike Doe</td>
                                                    <?php
                                                    for ($i = 0; $i < 15; $i++) {
                                                        echo '<td style="text-align: center">fdg</td>';
                                                    }
                                                    ?>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{-- End Tab Attendance Student --}}

                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- The Modal Feedback Coach Study Tab Diary Class-->
    <div class="modal fade" id="modalFeedbackCoach">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddCourseTitle">Thông tin buổi học</h4>
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <div class="card-header" style="text-align: center">
                            <b> Nhận xét của Trợ Giảng </b>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-lg-3" for="name" id=""> Tên Trợ giảng: </label>
                                <div class="col-lg-9 form-group">
                                    Hoa Thị Hà Trang
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3" for="name" id=""> Nhận xét về buổi học: </label>
                                <div class="col-lg-9 form-group">
                                    Test nhận xest: Lớp học sôi động, vui vẻ, các b hăng hái phát biểu, thảo luận nhiệt huyết
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3" for="name" id=""> Câu hỏi, thắc mắc cần được tư vấn thêm: </label>
                                <div class="col-lg-9 form-group">
                                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle quora plaxo ideeli hulu weebly balihoo...
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3" for="name" id=""> Ý kiến đóng góp cho CiT: </label>
                                <div class="col-lg-9 form-group">

                                </div>
                            </div>

                            <div class="row">
                                <label class="col-lg-3 col-form-label" for="name" > Tên khóa học: <span class="text-danger">*</span></label>
                                <div class="form-group col-lg-9">
                                    <input type="text" name="name" id="name" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="card-footer" style="text-align: right">
                            <button type="button" class="btn btn-primary" ><i class="far fa-edit"></i> Chỉnh sửa </button>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" style="text-align: center">
                            <b> Nhận xét của Chủ Nhiệm </b>
                        </div>
                        <form action="" id="" class="form-horizontal" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <label class="col-lg-3" for="name" id=""> Tên Trợ giảng: </label>
                                    <div class="col-lg-9 form-group">
                                        Hoa Thị Hà Trang
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3" for="name" id=""> Nhận xét về buổi học: </label>
                                    <div class="col-lg-9 form-group">
                                        Test nhận xest: Lớp học sôi động, vui vẻ, các b hăng hái phát biểu, thảo luận nhiệt huyết
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3" for="name" id=""> Câu hỏi, thắc mắc cần được tư vấn thêm: </label>
                                    <div class="col-lg-9 form-group" id="care_staffQuestionRow">
                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle quora plaxo ideeli hulu weebly balihoo...
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3" for="name" id=""> Ý kiến đóng góp cho CiT: </label>
                                    <div class="col-lg-9 form-group" id="care_staffCommentRow">

                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3 col-form-label" for="name" > Tên khóa học: <span class="text-danger">*</span></label>
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="name" id="name" class="form-control" >
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer" style="text-align: right">
                                <button type="button" class="btn btn-primary" id="testBtnEdit"><i class="far fa-edit"></i> Chỉnh sửa </button>
                                <div id="care_staffBtnSave" hidden="hidden">
                                    <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary" id="btnSave"><i class="fas fa-save"></i> Lưu thông tin </button>
                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="card">
                        <div class="card-header" style="text-align: center">
                            <b> Nhận xét của Giảng viên </b>
                        </div>
                        <form action="" id="" class="form-horizontal" method="post">
                            @csrf
                            <div class="card-body">
                                <p>Chưa có nhận xét nào</p>
                            </div>
                            <div class="card-footer" style="text-align: right">
                                <button type="button" class="btn btn-primary" id=""><i class="fa-solid fa-comment-medical"></i> Thêm nhận xét </button>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                </div>

            </div>
        </div>
    </div>
    <!-- End Modal Feedback Coach Study -->

    <!-- The Modal Study Info Tab Attendance Student-->
    <div class="modal fade" id="modalStudyInfo">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddCourseTitle">Thông tin buổi học</h4>
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" id="" class="form-horizontal" method="post">
                    <!-- Modal body -->
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control" name="id">
                        <div class="row">
                            <label class="col-lg-2 col-form-label" for="name" id="inputNameTitle"> Tên bài học: </label>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="btnSave"><i class="fas fa-save"></i> Lưu thông tin </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End Modal Study Info -->

    <!-- The Modal Attendance Student Tab Attendance Student-->
    <div class="modal fade" id="modalAttenStudent">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddCourseTitle">Điểm danh học viên</h4>
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="formAttenStudent" class="form-horizontal" method="post">
                    <!-- Modal body -->
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control" name="id">
                        <div class="row">
                            <label class="col-lg-3" for="name" id="inputNameTitle"> Tên bài học: </label>
                            <div class="col-lg-9">
                                Giải mã tài năng (Buổi 1)
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3" for="fee">Tên học viên: </label>
                            <div class="col-lg-9">
                                Vương Thị Ánh Nguyệt
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
                            <label class="col-lg-3 col-form-label" for="description">Ghi chú:</label>
                            <div class="col-lg-9">
                                <textarea type="text" name="note" id="note" class="form-control" rows="3"></textarea>
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
    <!-- End Modal Attendance Student -->

@endsection
