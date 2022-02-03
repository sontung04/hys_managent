@extends('layouts.sidebar')
@section('script')
    <!-- Ckeidtor -->
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/js/group.js') }}" defer></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/group.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{$group->id == 1 ? $groupType[$group->type] : $groupType[$group->type] . ' ' . $group->name}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">{{$group->id == 1 ? $groupType[$group->type] : $groupType[$group->type] . ' ' . $group->name}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Banner -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-widget widget-user">
                            <div class="widget-user-header text-white"
                                 style="background: url({{ asset('themes/dist/img/photo1.png') }} ) center center;">
                                <h3 class="widget-user-username ">CLB Thanh niên khởi nghiệp Hà Nội</h3>
                                <h5 class="widget-user-desc"></h5>
                            </div>
                            <div class="widget-user-image">
                                <img class="img-circle" src="{{ asset('themes/dist/img/user3-128x128.jpg') }}" alt="User Avatar">
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">Thành viên</h5>
                                            <span class="description-text">3,200</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">Khu vực</h5>
                                            <span class="description-text">7</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4">
                                        <div class="description-block">
                                            <h5 class="description-header">Ban chuyên môn</h5>
                                            <span class="description-text">6</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Banner -->

                <div class="row">
                    <div class="col-md-3">
                        @if($group->type == 1)
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Giới thiệu</h3>
                                </div>
                                <div class="card-body">

                                    <strong><i class="fas fa-birthday-cake"></i> Ngày thành lập </strong>
                                    <p class="text-muted">
                                        {{date('d/m/Y', strtotime($group->birthday))}}
                                    </p>

                                    <hr>

                                    <strong><i class="fas fa-music"></i> Bài hát truyền thống </strong>
                                    <p class="text-muted">{{$group->song}}</p>

                                    <hr>

                                    <strong><i class="fas fa-paint-brush"></i> Màu sắc truyền thống </strong>
                                    <p class="text-muted">{{$group->color}}</p>

                                    <hr>

                                    <strong><i class="fas fa-hands"></i> Slogan </strong>
                                    <p class="text-muted">{{$group->slogan}}</p>

                                    <hr>

                                    <strong><i class="fas fa-home"></i> Địa chỉ </strong>
                                    <p class="text-muted">{{$group->address}}</p>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        @endif
                        <!-- /.card -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Liên hệ</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item">
                                        <div class="nav-link">
                                            <strong><i class="far fa-envelope" style="color: crimson"></i> Email: {{$group->email}}</strong>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{$group->facebook}}" target="_blank">
                                            <strong><i class="fab fa-facebook-square" style="color: dodgerblue"></i> Facebook </strong>
                                        </a>
                                    </li>
                                    @if(!empty($group->youtube))
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" target="_blank">
                                            <strong><i class="fab fa-youtube"  style="color: red"></i> Youtube </strong>
                                        </a>
                                    </li>
                                    @endif

                                    @if(!empty($group->instagram))
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" target="_blank">
                                            <i class="fab fa-tiktok"></i>
                                            <strong><i class="fab fa-instagram-square" id="instaIcon" ></i> Instagram </strong>
                                        </a>
                                    </li>
                                    @endif

                                    @if(!empty($group->tiktok))
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" target="_blank">
                                            <strong><i class="fas fa-music" ></i> Tiktok </strong>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card card-primary card-outline">

                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Mô tả</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#human" data-toggle="tab">Thủ lĩnh</a></li>
                                    <li class="nav-item ml-auto"><a class="nav-link" href="" id="updateInfoGroup" data-toggle="tab">Chỉnh sửa thông tin nhóm</a></li>
                                </ul>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">

                                        <div class="mailbox-read-message">
                                            <?php echo $group->description;  ?>
                                        </div>

                                    </div>

                                    <div class="tab-pane" id="human">
                                        <div class="card">
                                            <div class="card-header" >
                                                <h3 class="text-center" >Danh sách Thủ Lĩnh</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover text-nowrap">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>User</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Reason</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>183</td>
                                                        <td>John Doe</td>
                                                        <td>11-7-2014</td>
                                                        <td><span class="tag tag-success">Approved</span></td>
                                                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>219</td>
                                                        <td>Alexander Pierce</td>
                                                        <td>11-7-2014</td>
                                                        <td><span class="tag tag-warning">Pending</span></td>
                                                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>657</td>
                                                        <td>Bob Doe</td>
                                                        <td>11-7-2014</td>
                                                        <td><span class="tag tag-primary">Approved</span></td>
                                                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>175</td>
                                                        <td>Mike Doe</td>
                                                        <td>11-7-2014</td>
                                                        <td><span class="tag tag-danger">Denied</span></td>
                                                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </section>
    </div>

    <!-- modal Add Group -->
    <div class="modal fade" id="modalUpdateInfoGroup">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalUpdateTitle">Modal default</h4>
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="" method="" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id" value="{{$group->id}}">
                        <input type="hidden" id="type" name="type" value="{{$group->type}}">
                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="name" id="labelNameTitle"> </label>
                            <div class="form-group col-lg-9">
                                <input type="text" name="name" id="name" class="form-control" value="{{$group->name}}" required>
                            </div>
                        </div>
                        <div class="form-group row" id="inputBirthday" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="birthday">Ngày thành lập: <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <div class="input-group date" id="birthdayDate" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#birthdayDate" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="birthday" name="birthday" data-target="#birthdayDate" data-toggle="datetimepicker"
                                           data-format="DD/MM/YYYY" data-min="17/11/2013" data-max="{{date("d/m/Y")}}" value="{{date('d/m/Y', strtotime($group->birthday))}}"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label class="col-lg-3 col-form-label" for="description">Mô tả: <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <textarea type="text" name="description" id="description" class="form-control">{{$group->description}}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="email">Email: <span class="text-danger">*</span></label>
                            <div class="form-group  col-lg-9">
                                <input type="email" name="email" id="email" class="form-control" value="{{$group->email}}" >
                            </div>
                        </div>
                        <div class="form-group row" id="inputSong" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="song">Bài hát truyền thống:</label>
                            <div class="col-lg-9">
                                <input type="text" name="song" id="song" class="form-control" value="{{$group->song}}" >
                            </div>
                        </div>
                        <div class="form-group row" id="inputColor" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="color">Màu sắc truyền thống:</label>
                            <div class="col-lg-9">
                                <input type="text" name="color" id="color" class="form-control" value="{{$group->color}}" >
                            </div>
                        </div>
                        <div class="form-group row" id="inputAddress" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="address">Địa chỉ :</label>
                            <div class="col-lg-9">
                                <textarea type="text" name="address" id="address" class="form-control" row="2" >{{$group->address}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row" id="inputSlogan" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="slogan" >Slogan: </label>
                            <div class="col-lg-9">
                                <textarea type="text" name="slogan" id="slogan" class="form-control"  row="2" >{{$group->slogan}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="facebook">Link Facebook:</label>
                            <div class="col-lg-9">
                                <input type="text" name="facebook" id="facebook" class="form-control" value="{{$group->facebook}}" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="youtube">Link Youtube:</label>
                            <div class="col-lg-9">
                                <input type="text" name="youtube" id="youtube" class="form-control" value="{{$group->youtube}}" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="instagram">Link Instagram:</label>
                            <div class="col-lg-9">
                                <input type="text" name="instagram" id="instagram" class="form-control" value="{{$group->instagram}}" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="tiktok">Link Tiktok:</label>
                            <div class="col-lg-9">
                                <input type="text" name="tiktok" id="tiktok" class="form-control" value="{{$group->tiktok}}" >
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="btnUpdateInfoGroup"><i class="fas fa-save"></i> Lưu thông tin</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

