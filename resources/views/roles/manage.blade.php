@extends('layouts.sidebar')

@section('script')
    <script src="{{ asset('assets/js/role.js') }}" defer></script>
@endsection

@section("content")
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Quản lý chức vụ thành viên HYS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Quản lý chức vụ thành viên</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="{{asset('themes/dist/img/user1-128x128.jpg')}}" alt="user image">
                                    <span class="username">
                                            <a href="#">Username</a>
                                        </span>
                                    <span class="description" style="font-size: 16px">Trạng thái:<strong> Đang Hoạt động</strong></span>
                                </div>

                                <a class="btn btn-success text-white float-right" id="btnAddRole">
                                    <i class="fas fa-cog"></i>
                                    Thêm/Chỉnh Sửa Chức vụ
                                </a>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="timeline">
                                            <!-- timeline time label -->
                                            <div class="time-label">
                                                <span class="bg-red">HYS Tổng</span>
                                            </div>
                                            <!-- /.timeline-label -->
                                            <!-- timeline item -->

                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-user-check bg-green"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
                                                    <h3 class="timeline-header no-border"><a href="#">Phó Chủ nhiệm</a></h3>
                                                </div>
                                            </div>

                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-user-check bg-green"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> Thời gian bắt đầu: 20/02/2021 - Thời gian kết thúc: 20/05/2022</span>
                                                    <h3 class="timeline-header"><a href="#">Ban Tổ chức kiểm tra - Phó Ban </a></h3>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->

                                            <!-- timeline time label -->
                                            <div class="time-label">
                                                <span class="bg-yellow">HYS Thăng Long</span>
                                            </div>
                                            <!-- /.timeline-label -->

                                            <div>
                                                <i class="fas fa-user-times bg-red"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> Thời gian bắt đầu: 20/02/2021 - Thời gian kết thúc: 20/05/2022</span>
                                                    <h3 class="timeline-header no-border"><a href="#">Chủ nhiệm</a></h3>
                                                </div>
                                            </div>

                                            <div>
                                                <i class="fas fa-user-times bg-red"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> Thời gian bắt đầu: 20/02/2021 - Thời gian kết thúc: 20/05/2022</span>
                                                    <h3 class="timeline-header no-border"><a href="#">Phó Chủ nhiệm</a></h3>
                                                </div>
                                            </div>
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-user-times bg-red"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> Thời gian bắt đầu: 20/02/2021 - Thời gian kết thúc: 20/05/2022</span>
                                                    <h3 class="timeline-header"><a href="#">Cơ sở Xây dựng - Chủ Nhiệm </a></h3>
                                                </div>
                                            </div>

                                            <div>
                                                <i class="fas fa-location-arrow bg-blue"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> Thời gian tham gia: 20/02/2021</span>
                                                    <h3 class="timeline-header"><a href="#">Cơ sở Kinh tế</a></h3>
                                                    <div class="timeline-body">
                                                        <div class="timeline">
                                                            <div>
                                                                <i class="fas fa-user-times bg-red"></i>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="fas fa-clock"></i> Thời gian bắt đầu: 20/02/2021 - Thời gian kết thúc: 20/05/2022</span>
                                                                    <h3 class="timeline-header no-border"><a href="#" class="btnEditRole">Chủ nhiệm</a></h3>
                                                                </div>
                                                            </div>
                                                            <!-- timeline item -->
                                                            <div>
{{--                                                                <i class="fas fa-map-marker-alt bg-cyan"></i>--}}
                                                                <i class="fas fa-user-times bg-red"></i>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
                                                                    <h3 class="timeline-header no-border"><a href="#" class="btnEditRole">Đội Kinh tế 4</a></h3>
                                                                </div>
                                                            </div>
                                                            <!-- END timeline item -->
                                                            <div>
                                                                <i class="fas fa-user-times bg-red"></i>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
                                                                    <h3 class="timeline-header no-border"><a href="#" class="btnEditRole">Đội Kinh tế 3 - Thành viên</a></h3>
                                                                </div>
                                                            </div>
                                                            <!-- /.timeline-label -->

                                                            <div>
                                                                <i class="fas fa-clock bg-gray"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->

                                            <div>
                                                <i class="fas fa-clock bg-gray"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addEditRoleModal" tabindex="-1" role="dialog" aria-labelledby="addEditRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEditRoleModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="" method="" class="form-horizontal">
                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="name" id="">Khu vực: <span style="color: red">*</span></label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select">
                                    <option>option 1</option>
                                    <option>option 2</option>
                                    <option>option 3</option>
                                    <option>option 4</option>
                                    <option>option 5</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="name" id="">Cơ sở: </label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select">
                                    <option>option 1</option>
                                    <option>option 2</option>
                                    <option>option 3</option>
                                    <option>option 4</option>
                                    <option>option 5</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="name" id="">Ban: </label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select">
                                    <option>option 1</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="name" id="">Chức vụ: <span style="color: red">*</span></label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select">
                                    <option>option 1</option>
                                    <option>option 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="status" class="col-sm-3">Trạng thái: <span style="color: red">*</span></label>
                            <div class="form-group col-sm-9">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status1" name="status" value="1" checked>
                                    <label for="status1" style="margin-right: 10px">
                                        Hoạt động
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status2" name="status" value="0">
                                    <label for="status2">
                                        Nghỉ chức vụ
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary">Lưu thông tin</button>
                </div>
            </div>
        </div>
    </div>
@endsection
