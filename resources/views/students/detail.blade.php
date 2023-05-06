@extends('layouts.sidebar')

@section('title', 'HYS Manage - Thông tin học viên')

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
                        <h1>Thông tin chi tiết học viên</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Thông tin chi tiết học viên</li>
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
                                    <li class="nav-item"><a class="nav-link active" href="#infoStudent" data-toggle="tab">Thông tin cá nhân</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#timelineCourse" data-toggle="tab">Khóa học</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">

                                    {{--tab info User: Thông tin của người dùng--}}
                                    <div class="active tab-pane" id="infoStudent">
                                        <ul class="list-group">

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><b> Trường học <span style="float: right">:</span> </b></div>
                                                    <div class="col-sm-10">{{ $student->school }}</div>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><b> Ngành học <span style="float: right">:</span> </b></div>
                                                    <div class="col-sm-10">{{ $student->major }}</div>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><b> Quê quán <span style="float: right">:</span> </b></div>
                                                    <div class="col-sm-10">{{ $student->native_place }}</div>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><b> Nơi ở hiện tại <span style="float: right">:</span> </b></div>
                                                    <div class="col-sm-10">{{ $student->address }}</div>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><b> Số CCCD <span style="float: right">:</span> </b></div>
                                                    <div class="col-sm-4">{{ $student->citizen_identify }}</div>
                                                    <div class="col-sm-2"><b> Ngày cấp CCCD <span style="float: right">:</span> </b></div>
                                                    <div class="col-sm-4">{{date('d/m/Y', strtotime($student->date_of_issue))}}</div>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><b> Địa chỉ cấp CCCD <span style="float: right">:</span> </b></div>
                                                    <div class="col-sm-10">{{ $student->place_of_issue }}</div>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><b> Dân tộc <span style="float: right">:</span> </b></div>
                                                    <div class="col-sm-4">{{ $student->nation }}</div>
                                                    <div class="col-sm-2"><b> Tôn giáo <span style="float: right">:</span> </b></div>
                                                    <div class="col-sm-4">{{ $student->religion }}</div>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><b> Tên người giám hộ <span style="float: right">:</span> </b></div>
                                                    <div class="col-sm-4">{{ $student->guardian_name }}</div>
                                                    <div class="col-sm-2"><b> SĐT người giám hộ <span style="float: right">:</span> </b></div>
                                                    <div class="col-sm-4">{{ $student->guardian_phone }}</div>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><b> Tên bố <span style="float: right">:</span> </b></div>
                                                    <div class="col-sm-4">{{ $student->father }}</div>
                                                    <div class="col-sm-2"><b> Ngày sinh của bố <span style="float: right">:</span> </b></div>
                                                    <div class="col-sm-4">
                                                        @if(!is_null($student->father_birthday))
                                                            {{date('d/m/Y', strtotime($student->father_birthday))}}
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><b> Công việc của bố <span style="float: right">:</span></b></div>
                                                    <div class="col-sm-10">{{ $student->father_job }}</div>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><b><b> Tên mẹ <span style="float: right">:</span> </b></b></div>
                                                    <div class="col-sm-4">{{ $student->mother }}</div>
                                                    <div class="col-sm-2"><b> Ngày sinh của mẹ <span style="float: right">:</span> </b></div>
                                                    <div class="col-sm-4">
                                                        @if(!is_null($student->mother_birthday))
                                                            {{date('d/m/Y', strtotime($student->mother_birthday))}}
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><b> Công việc của mẹ <span style="float: right">:</span> </b></div>
                                                    <div class="col-sm-10">{{ $student->mother_job }}</div>
                                                </div>
                                            </li>

{{--                                            <li class="list-group-item">--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-sm-3"><b> Biết tới khóa học từ đâu <span style="float: right">:</span> </b></div>--}}
{{--                                                    <div class="col-sm-9">{{ $student->course_where }}</div>--}}
{{--                                                </div>--}}
{{--                                            </li>--}}

{{--                                            <li class="list-group-item">--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-sm-3"><b> Mong muốn khi tham gia học <span style="float: right">:</span> </b></div>--}}
{{--                                                    <div class="col-sm-9">{{ $student->desire }}</div>--}}
{{--                                                </div>--}}
{{--                                            </li>--}}

                                        </ul>
                                    </div>

                                    <!-- /.tab-pane -->
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
                                    <!-- /.tab-pane -->

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
