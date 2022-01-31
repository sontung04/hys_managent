@extends('layouts.sidebar')
@section('script')
    <script src="{{ asset('assets/js/user/user.js') }}" defer></script>
@endsection
@section("content")
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{ asset($user->img) }}" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{$user->lastname . ' ' . $user->firstname }}</h3>

                                <p class="text-muted text-center">Software Engineer</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Khu vực</b> <a class="float-right">{{ 'HYS ' . $area[$user->area]}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Ban</b> <a class="float-right">543</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Chức vụ</b> <a class="float-right">13,287</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Trạng thái</b> <a class="float-right">@if($user->status) Đang hoạt động @else Dừng hoạt động @endif</a>
                                    </li>
                                </ul>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- About Me Box -->
{{--                        <div class="card card-primary">--}}
{{--                            <div class="card-header">--}}
{{--                                <h3 class="card-title">About Me</h3>--}}
{{--                            </div>--}}
{{--                            <!-- /.card-header -->--}}
{{--                            <div class="card-body">--}}
{{--                                <strong><i class="fas fa-book mr-1"></i> Education</strong>--}}

{{--                                <p class="text-muted">--}}
{{--                                    B.S. in Computer Science from the University of Tennessee at Knoxville--}}
{{--                                </p>--}}

{{--                                <hr>--}}

{{--                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>--}}

{{--                                <p class="text-muted">Malibu, California</p>--}}

{{--                                <hr>--}}

{{--                                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>--}}

{{--                                <p class="text-muted">--}}
{{--                                    <span class="tag tag-danger">UI Design</span>--}}
{{--                                    <span class="tag tag-success">Coding</span>--}}
{{--                                    <span class="tag tag-info">Javascript</span>--}}
{{--                                    <span class="tag tag-warning">PHP</span>--}}
{{--                                    <span class="tag tag-primary">Node.js</span>--}}
{{--                                </p>--}}

{{--                                <hr>--}}

{{--                                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>--}}

{{--                                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>--}}
{{--                            </div>--}}
{{--                            <!-- /.card-body -->--}}
{{--                        </div>--}}
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#infoUser" data-toggle="tab">About Me</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#timeline1" data-toggle="tab">Timeline</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#timeline2" data-toggle="tab">Settings</a></li>
                                    <li class="nav-item ml-auto"><a class="nav-link" href="#updateInfoUser" data-toggle="tab">Cập nhật thông tin cá nhân</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">

                                   {{--tab info User: Thông tin của người dùng--}}
                                    <div class="active tab-pane" id="infoUser">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><i class="fas fa-code"></i><b> Mã thành viên: </b></div>
                                                    <div class="col-sm-10">{{$user->code}}</div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><i class="fas fa-user mr-1"></i><b> Họ tên: </b></div>
                                                    <div class="col-sm-10">{{$user->lastname . ' ' . $user->firstname }}</div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><i class="fas fa-phone mr-1"></i><b> Số điện thoại: </b></div>
                                                    <div class="col-sm-10">{{$user->phone}}</div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><i class="fas fa-envelope mr-1"></i><b> Email: </b></div>
                                                    <div class="col-sm-10">{{$user->email}}</div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><i class="fas fa-birthday-cake"></i><b> Ngày sinh: </b></div>
                                                    <div class="col-sm-10">{{date('d/m/Y', strtotime($user->birthday))}}</div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><i class="fas fa-venus-mars mr-1"></i><b> Giới tính: </b></div>
                                                    <div class="col-sm-10">{{$user->gender}}</div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><i class="fas fa-map-marker-alt mr-1"></i><b> Quê quán: </b></div>
                                                    <div class="col-sm-10">{{$user->address}}</div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><i class="fab fa-facebook-square mr-1"></i><b> Facebook: </b></div>
                                                    <div class="col-sm-10">{{$user->facebook}}</div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><i class="fas fa-school mr-1"></i><b> Trường học: </b></div>
                                                    <div class="col-sm-10">{{$user->school}}</div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><i class="fas fa-glasses mr-1"></i><b> Ngành học: </b></div>
                                                    <div class="col-sm-10">{{$user->major}}</div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><i class="fas fa-file-signature mr-1"></i><b> Thời gian tham gia: </b></div>
                                                    <div class="col-sm-10">{{$user->jointime}}</div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><i class="fas fa-hourglass-end mr-1"></i><b> Thời gian dừng: </b></div>
                                                    <div class="col-sm-10">{{$user->stoptime}}</div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><i class="fas fa-hand-point-right mr-1"></i><b> Kỹ năng: </b></div>
                                                    <div class="col-sm-10">{{$user->skill}}</div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><i class="fas fa-star"></i><b> Nguyện vọng: </b></div>
                                                    <div class="col-sm-10">{{$user->derise}}</div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><i class="fas fa-wrench mr-1"></i><b> Công việc hiện tại: </b></div>
                                                    <div class="col-sm-10">{{$user->work}}</div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-2"><i class="fas fa-building mr-1"></i><b> Nơi làm việc: </b></div>
                                                    <div class="col-sm-10">{{$user->company}}</div>
                                                </div>
                                            </li>
                                        </ul>

                                    </div>

                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="timeline1">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                            <!-- timeline time label -->
                                            <div class="time-label">
                        <span class="bg-danger">
                          10 Feb. 2014
                        </span>
                                            </div>
                                            <!-- /.timeline-label -->
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-envelope bg-primary"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i class="far fa-clock"></i> 12:05</span>

                                                    <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                                    <div class="timeline-body">
                                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                                        quora plaxo ideeli hulu weebly balihoo...
                                                    </div>
                                                    <div class="timeline-footer">
                                                        <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-user bg-info"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                                                    <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                                                    </h3>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-comments bg-warning"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                                                    <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                                                    <div class="timeline-body">
                                                        Take me to your leader!
                                                        Switzerland is small and neutral!
                                                        We are more like Germany, ambitious and misunderstood!
                                                    </div>
                                                    <div class="timeline-footer">
                                                        <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                            <!-- timeline time label -->
                                            <div class="time-label">
                        <span class="bg-success">
                          3 Jan. 2014
                        </span>
                                            </div>
                                            <!-- /.timeline-label -->
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-camera bg-purple"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                                                    <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                                                    <div class="timeline-body">
                                                        <img src="http://placehold.it/150x100" alt="...">
                                                        <img src="http://placehold.it/150x100" alt="...">
                                                        <img src="http://placehold.it/150x100" alt="...">
                                                        <img src="http://placehold.it/150x100" alt="...">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                            <div>
                                                <i class="far fa-clock bg-gray"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="timeline2">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                            <!-- timeline time label -->
                                            <div class="time-label">
                        <span class="bg-danger">
                          10 Feb. 2014
                        </span>
                                            </div>
                                            <!-- /.timeline-label -->
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-envelope bg-primary"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i class="far fa-clock"></i> 12:05</span>

                                                    <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                                    <div class="timeline-body">
                                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                                        quora plaxo ideeli hulu weebly balihoo...
                                                    </div>
                                                    <div class="timeline-footer">
                                                        <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-user bg-info"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                                                    <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                                                    </h3>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-comments bg-warning"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                                                    <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                                                    <div class="timeline-body">
                                                        Take me to your leader!
                                                        Switzerland is small and neutral!
                                                        We are more like Germany, ambitious and misunderstood!
                                                    </div>
                                                    <div class="timeline-footer">
                                                        <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                            <!-- timeline time label -->
                                            <div class="time-label">
                        <span class="bg-success">
                          3 Jan. 2014
                        </span>
                                            </div>
                                            <!-- /.timeline-label -->
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-camera bg-purple"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                                                    <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                                                    <div class="timeline-body">
                                                        <img src="http://placehold.it/150x100" alt="...">
                                                        <img src="http://placehold.it/150x100" alt="...">
                                                        <img src="http://placehold.it/150x100" alt="...">
                                                        <img src="http://placehold.it/150x100" alt="...">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                            <div>
                                                <i class="far fa-clock bg-gray"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->

                                    {{--tab Update infoUser: Chỉnh sửa thông tin cá nhân người dùng Thông tin người dùng--}}
                                    <div class="tab-pane" id="updateInfoUser">
                                        <form class="form-horizontal" method="post" id="formUpdateInfoUser" enctype="multipart/form-data">

                                            <input type="hidden" name="id" value="{{$user->id}}">
{{--                                            <input type="hidden" name="code" value="{{$user->code}}">--}}
{{--                                            <input type="hidden" name="email" value="{{$user->email}}">--}}

                                            <div class="row">
                                                <label for="lastname" class="col-sm-2 col-form-label">Họ:</label>
                                                <div class="form-group col-sm-10">
                                                    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Họ" value="{{$user->lastname}}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="firstname" class="col-sm-2 col-form-label">Tên:</label>
                                                <div class="form-group col-sm-10">
                                                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Tên" value="{{$user->firstname}}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="phone" class="col-sm-2 col-form-label">Số điện thoại:</label>
                                                <div class="form-group col-sm-10">
                                                    <input type="number" class="form-control" name="phone" id="phone" placeholder="Số điện thoại" value="{{$user->phone}}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="gender1" class="col-sm-2 col-form-label">Giới tính:</label>
                                                <div class="form-group col-sm-10">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="radio" id="gender1" name="gender" value="1" @if($user->gender) checked @endif>
                                                        <label for="gender1" style="margin-right: 10px">
                                                            Nam
                                                        </label>
                                                    </div>
                                                    <div class="icheck-primary d-inline">
                                                        <input type="radio" id="gender2" name="gender" value="0" @if(!$user->gender) checked @endif>
                                                        <label for="gender2">
                                                            Nữ
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="birthday" class="col-sm-2 col-form-label">Ngày sinh:</label>
                                                <div class="form-group col-sm-10">
                                                    <div class="input-group date" id="birthdayDate" data-target-input="nearest">
                                                        <div class="input-group-append" data-target="#birthdayDate" data-toggle="datetimepicker">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control datetimepicker-input" id="birthday" name="birthday" data-target="#birthdayDate"
                                                               data-toggle="datetimepicker" data-format="DD/MM/YYYY" data-min="01/01/1960" data-max="{{date("d/m/Y")}}"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="facebook" class="col-sm-2 col-form-label">Link Facebook:</label>
                                                <div class="form-group col-sm-10">
                                                    <input type="url" class="form-control" name="facebook" id="facebook" placeholder="Link Facebook" value="{{$user->facebook}}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="school" class="col-sm-2 col-form-label">Trường học:</label>
                                                <div class="form-group col-sm-10">
                                                    <input type="text" class="form-control" name="school" id="school" placeholder="Tên trường" value="{{$user->school}}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="major" class="col-sm-2 col-form-label">Ngành học:</label>
                                                <div class="form-group col-sm-10">
                                                    <input type="text" class="form-control" name="major" id="major" placeholder="Ngành theo học" value="{{$user->major}}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="address" class="col-sm-2 col-form-label">Quê quán:</label>
                                                <div class="form-group col-sm-10">
                                                    <textarea class="form-control" name="address" id="address" placeholder="Quê quán" value="{{$user->address}}"></textarea>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="skill" class="col-sm-2 col-form-label">Kỹ năng:</label>
                                                <div class="form-group col-sm-10">
                                                    <textarea class="form-control" name="skill" id="skill" placeholder="Kỹ năng cá nhân" value="{{$user->skill}}"></textarea>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="work" class="col-sm-2 col-form-label">Công việc hiện tại:</label>
                                                <div class="form-group col-sm-10">
                                                    <input type="text" class="form-control" name="work" id="work" placeholder="Công việc hiện tại" value="{{$user->work}}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="company" class="col-sm-2 col-form-label">Nơi làm việc:</label>
                                                <div class="form-group col-sm-10">
                                                    <input type="text" class="form-control" name="company" id="company" placeholder="Nơi làm việc hiện tại" value="{{$user->company}}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="desire" class="col-sm-2 col-form-label">Mong muốn khi tham gia CLB:</label>
                                                <div class="form-group col-sm-10">
                                                    <textarea class="form-control" name="desire" id="desire" placeholder="Mong muốn của bạn khi tham gia CLB" value="{{$user->derise}}"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger" id="btnSubmit">Cập nhật</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
