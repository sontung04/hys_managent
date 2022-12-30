@extends('layouts.sidebar')

@section('title', 'HYS Manage - Chi tiết học phí học viên')

@section('style')

@endsection

@section('script')

@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Chi tiết học phí học viên</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Chi tiết học phí học viên</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{ asset($student->img) }}" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{ $student->name }}</h3>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Ngày sinh</b> <a class="float-right">{{date('d/m/Y', strtotime($student->birthday))}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Giới tính</b> <a class="float-right">{{ $student->gender ? 'Nam' : 'Nữ'}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Số điện thoại</b> <a class="float-right">{{ $student->phone }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Email</b> <a class="float-right">{{ $student->email }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Facebook</b> <a href="{{ $student->facebook }}" class="float-right"
                                                           target="_blank">Link</a>
                                    </li>
                                </ul>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#timelineCourse" data-toggle="tab">Khóa học</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#paymentLog" data-toggle="tab">Lịch sử đóng tiền</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#callLog" data-toggle="tab">Lịch sử gọi điện</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">

                                    <!-- Tab lịch sử các khóa học -->
                                    <div class="tab-pane" id="timelineCourse">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-hover text-nowrap">
                                                    <thead>
                                                    <tr>
                                                        <th>Khóa học</th>
                                                        <th>Lớp</th>
                                                        <th>Số buổi học</th>
                                                        <th>Trạng thái</th>
                                                        <th>Học phí cần đóng</th>
                                                        <th>Học phí đã đóng</th>
                                                        <th>Còn nợ</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>Tên khóa</td>
                                                        <td>Tên lớp</td>
                                                        <td>số buổi</td>
                                                        <td><span class="text-warning">Trạng thái ClassStudent</span></td>
                                                        <td>480.000</td>
                                                        <td>0</td>
                                                        <td>480.000</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Thủ lĩnh khởi nghiệp</td>
                                                        <td>Thủ lĩnh khởi nghiệp 10.3</td>
                                                        <td>4</td>
                                                        <td><span class="text-danger">Nghỉ giữa chừng</span></td>
                                                        <td>480.000</td>
                                                        <td>0</td>
                                                        <td>480.000</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tư duy tài năng</td>
                                                        <td>Tư duy tài năng 13.3</td>
                                                        <td>12</td>
                                                        <td><span class="text-success">Hoàn thành</span></td>
                                                        <td>3.600.000</td>
                                                        <td>3.600.000</td>
                                                        <td>0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tư duy thành đạt</td>
                                                        <td>Tư duy thành đạt 12.1</td>
                                                        <td>12</td>
                                                        <td><span class="text-success">Hoàn thành</span></td>
                                                        <td>3.600.000</td>
                                                        <td>1.000.000</td>
                                                        <td>2.600.000</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tư duy đột phá</td>
                                                        <td>Tư duy đột phá 7.2</td>
                                                        <td>9</td>
                                                        <td><span class="text-danger">Nghỉ giữa chừng</span></td>
                                                        <td>3.600.000</td>
                                                        <td>0</td>
                                                        <td>3.600.000</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- End Tab lịch sử các khóa học -->


                                    <!-- Tab lịch sử các lần nộp tiền -->
                                    <div class="tab-pane active" id="paymentLog">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="post">
                                                            <h4 style="text-align: center"><b>Lịch sử đóng tiền</b></h4>
                                                        </div>

                                                        <div class="post">
                                                            <div class="user-block">
                                                                <span style="font-weight: 600">
                                                                  <a href="#">Lớp Thủ lĩnh khởi nghiệp 10.6</a>
                                                                </span>
                                                                <span style="display: block; color: #28a745"><b>Học phí: 3.600.000</b> </span>
                                                                <span style="display: block; color: red"><b>Còn nợ: 1.000.000</b> </span>

                                                            </div>
                                                            <table class="table table-hover text-nowrap">
                                                                <thead>
                                                                <tr>
                                                                    <th>STT</th>
                                                                    <th>Số tiền</th>
                                                                    <th>Người thu</th>
                                                                    <th>Hình thức</th>
                                                                    <th>Ngày đóng</th>
                                                                    <th>Ghi chú</th>

                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>600.000</td>
                                                                    <td>Bùi Minh Quang</td>
                                                                    <td>Online</td>
                                                                    <td>10/10/2022</td>
                                                                    <td>Đóng lần 1</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td>1.000.000</td>
                                                                    <td>Bùi Minh Quang</td>
                                                                    <td>Offline</td>
                                                                    <td>30/10/2022</td>
                                                                    <td>hẹn ngày tiếp theo đóng nốt</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>3</td>
                                                                    <td>2.000.000</td>
                                                                    <td>Bùi Minh Quang</td>
                                                                    <td>Online</td>
                                                                    <td>27/11/2022</td>
                                                                    <td>Đã đóng xong</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>

                                                        <div class="post">
                                                            <div class="user-block">
                                                                <span style="font-weight: 600">
                                                                  <a href="#">Lớp Thủ lĩnh khởi nghiệp 10.6</a>
                                                                </span>
                                                                <span style="display: block; color: #28a745"><b>Học phí: 3.600.000</b> </span>
                                                                <span style="display: block; color: red"><b>Còn nợ: 1.000.000</b> </span>

                                                            </div>
                                                            <p><b>Chưa đóng tiền khóa học</b></p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Tab lịch sử các lần nộp tiền -->


                                    <!-- Tab lịch sử các lần nộp tiền -->
                                    <div class="tab-pane" id="callLog">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="post">
                                                            <h4 style="text-align: center"><b>Lịch sử gọi điện</b></h4>
                                                        </div>
                                                        <br>

                                                        <table class="table table-hover text-nowrap">
                                                            <thead>
                                                            <tr>
                                                                <th>STT</th>
                                                                <th>Người gọi</th>
                                                                <th>Ngày gọi</th>
                                                                <th>Kênh gọi</th>
                                                                <th>Trạng thái</th>
                                                                <th>Ghi chú</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Vũ Thị Mai Huế</td>
                                                                <td>15/12/2020</td>
                                                                <td>SĐT</td>
                                                                <td>Liên lạc được</td>
                                                                <td>0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>Vũ Thị Mai Huế</td>
                                                                <td>17/12/2020</td>
                                                                <td>Zalo</td>
                                                                <td>Không liên lạc được</td>
                                                                <td>0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>Vũ Thị Mai Huế</td>
                                                                <td>15/12/2020</td>
                                                                <td>SĐT</td>
                                                                <td>Liên lạc được</td>
                                                                <td>0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>4</td>
                                                                <td>Vũ Thị Mai Huế</td>
                                                                <td>15/12/2020</td>
                                                                <td>SĐT</td>
                                                                <td>Liên lạc được</td>
                                                                <td>0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>5</td>
                                                                <td>Vũ Thị Mai Huế</td>
                                                                <td>15/12/2020</td>
                                                                <td>SĐT</td>
                                                                <td>Liên lạc được</td>
                                                                <td>0</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Tab lịch sử các lần nộp tiền -->

                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
