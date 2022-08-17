@extends('layouts.sidebar')

@section('script')
    <script src="{{ asset('assets/js/role/manage.js') }}" defer></script>
@endsection

@section("content")
    <style>
        .labelTimelineItem {
            font-size: 16px;
            color: #007bff;
        }
        .labelTimelineItem:hover {
            color: #0056b3;
        }
        b {
            font-size: 14px;
        }
    </style>
    <?php

    $iconList = [
        'userNow'  => '<i class="fas fa-user-check bg-green"></i>',
        'userStop' => '<i class="fas fa-user-times bg-red"></i>',
        'location' => '<i class="fas fa-location-arrow bg-blue"></i>',
        'itemLastNow'  => '<i class="fas fa-user-check bg-green" style="margin-top: 8px"></i>',
        'itemLastStop' => '<i class="fas fa-user-times bg-red" style="margin-top: 8px"></i>',
    ];

    function htmlTimelineItem($data, $iconList, $roles, $lastItem = false) {

        echo '<div>';
        if($lastItem) {
            echo $data['status'] ? $iconList['itemLastNow'] : $iconList['itemLastStop'];
        } else {
            echo $data['status'] ? $iconList['userNow'] : $iconList['userStop'];
        }

        echo '<div class="timeline-item">';
        echo '<span class="time"><i class="fas fa-clock"></i> ';
        echo date('d/m/Y', strtotime($data['startTime']));
        echo !empty($data['endTime']) ? ' - ' . date('d/m/Y', strtotime($data['endTime'])) : '';
        echo '</span>';

        echo '<h3 class="timeline-header no-border"><a href="#">' . (!$data['roleid'] ? 'Thành viên' : $roles[$data['roleid']]) . '</a></h3>';
        echo '</div></div>';

    }

    function showChildGroupRole($items, $iconList, $roles, $groupType) {

        foreach ($items as $item) {

            echo '<div>';

            if((count($item['roles']) == 1) && (!isset($item['list']) || empty($item['list']))) {

                $role = $item['roles'][0];

                echo $role['status'] ? $iconList['userNow'] : $iconList['userStop'];

                echo '<div class="timeline-item">';
                echo '<span class="time"><i class="fas fa-clock"></i> ';
                echo date('d/m/Y', strtotime($role['startTime']));
                echo !empty($role['endTime']) ? ' - ' . date('d/m/Y', strtotime($role['endTime'])) : '';
                echo '</span>';

                echo '<h3 class="timeline-header no-border"><a href="#">';
                echo  $groupType[$item['type']] . ' ' . $item ['name'] . ' - ' . (!$role['roleid'] ? 'Thành viên' : $roles[$role['roleid']]);
                echo '</a></h3>';
                echo '</div>';

            } elseif(count($item['roles']) > 1) {

                echo $iconList['location'];
                echo '<div class="timeline-item">';

                if(isset($item['startTime'])) {
                    echo '<span class="time"><i class="fas fa-clock"></i> ';
                    echo date('d/m/Y', strtotime($item['startTime']));
                    echo !empty($item['endTime']) ? ' - ' . date('d/m/Y', strtotime($item['endTime'])) : '';
                    echo '</span>';
                }

                echo '<h3 class="timeline-header no-border"><a href="#">';
                echo  $groupType[$item['type']] . ' ' . $item ['name'];
                echo '</a></h3>';

                echo '<div class="timeline-body"><div class="timeline">';


                if(!isset($item['list']) || empty($item['list'])) {
                    $index = 0;
                    foreach ($item['roles'] as $key => $role) {
                        if($index == (count($item['roles']) - 1) && $index != 0 ) {
                            htmlTimelineItem($role, $iconList, $roles, true);
                        } else {
                            htmlTimelineItem($role, $iconList, $roles);
                        }
                        $index++;
                    }
                } else {
                    showChildGroupRole($item['list'], $iconList, $roles, $groupType);
                    echo '<div><i class="fas fa-circle bg-gray"></i></div>';

                }

                echo '</div></div>';
                echo '</div>';

            } elseif (count($item['roles']) == 0) {

                if(!isset($item['list']) || empty($item['list'])) {
                    echo $item['status'] ? $iconList['userNow'] : $iconList['userStop'];
                } else {
                    echo $iconList['location'];
                }

                echo '<div class="timeline-item">';
                echo '<span class="time"><i class="fas fa-clock"></i> ';
                echo date('d/m/Y', strtotime($item['startTime']));
                echo !empty($item['endTime']) ? ' - ' . date('d/m/Y', strtotime($item['endTime'])) : '';
                echo '</span>';
                echo '<h3 class="timeline-header no-border"><a href="#">';

                if(!isset($item['list']) || empty($item['list'])) {
                    echo  $groupType[$item['type']] . ' ' . $item ['name'] . ' - Thành viên';
                    echo '</a></h3>';
                    echo '</div>';
                } else {
                    echo  $groupType[$item['type']] . ' ' . $item ['name'];
                    echo '</a></h3>';
                    echo '<div class="timeline-body"><div class="timeline">';

                    showChildGroupRole($item['list'], $iconList, $roles, $groupType);

                    echo '<div><i class="fas fa-circle bg-gray"></i></div>';
                    echo '</div></div>';
                    echo '</div>';
                }

            }

            echo '</div>';
        }

    }
    ?>
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

                                <a class="btn btn-success text-white float-right" id="btnAddRoleUser">
                                    <i class="fas fa-cog"></i>
                                    Thêm/Chỉnh Sửa Chức vụ
                                </a>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="timeline">
                                            <div class="time-label">
                                                <span class="bg-blue">HYS Tổng</span>
                                            </div>
                                            <!-- /.timeline-label -->

                                            <!-- timeline-area -->
{{--                                            <div>--}}
{{--                                                <i class="fas fa-clock bg-indigo"></i>--}}
{{--                                                <div class="timeline-item">--}}
{{--                                                    <h3 class="timeline-header"><b class="labelTimelineItem">--}}
{{--                                                            05/06/2020--}}
{{--                                                        </b></h3>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <div>
                                                <i class="fas fa-check-circle bg-teal"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header"><b class="labelTimelineItem">
                                                            Trạng thái: Đang hoạt động | Thời gian: 05/06/2020 - 25/11/2020
                                                            
                                                        </b>
                                                        <a href="" class="btnEditUserGroup" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                           data-content="Thay đổi trạng thái hoạt động" data-id="6">
                                                            <i class="fas fa-edit ml-2"></i>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>

                                            <div>
                                                <i class="fas fa-location-arrow bg-blue"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> <b>05/06/2020</b></span>
                                                    <h3 class="timeline-header no-border">
                                                        <b class="labelTimelineItem">Ban Đào tạo tương tác</b>
                                                    </h3>
                                                    <div class="timeline-body">
                                                        <div class="timeline">
                                                            <div>
                                                                <i class="fas fa-user-check bg-green"></i>
                                                                <div class="timeline-item">
{{--                                                                    <span class="time"><i class="fas fa-clock"></i> <b>25/11/2020 - 24/08/2021</b></span>--}}
                                                                    <h3 class="timeline-header no-border">
                                                                        <b class="labelTimelineItem">Trưởng Ban: 25/11/2020</b>
                                                                        <a href="" class="btnEditUgr" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                                           data-content="Thay đổi trạng thái chức vụ" data-id="9"><i class="fas fa-edit ml-2"></i></a>
                                                                        <a href="" class="btnDeleteUgr" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Xóa chức vụ" data-id="9">
                                                                            <i class="fas fa-trash ml-2" style="color: red"></i></a>
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <i class="fas fa-user-times bg-red" style="margin-top: 8px"></i>
                                                                <div class="timeline-item">
{{--                                                                    <span class="time"><i class="fas fa-clock"></i> <b>05/06/2020 - 25/11/2020</b></span>--}}
                                                                    <h3 class="timeline-header no-border">
                                                                        <b class="labelTimelineItem">Phó Ban: 05/06/2020 - 25/11/2020</b>
                                                                        <a href="" class="btnEditUgr" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                                           data-content="Thay đổi trạng thái chức vụ" data-id="8">
                                                                            <i class="fas fa-edit ml-2"></i>
                                                                        </a>
                                                                        <a href="" class="btnDeleteUgr" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Xóa chức vụ" data-id="8">
                                                                            <i class="fas fa-trash ml-2" style="color: red"></i>
                                                                        </a>
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            <!-- END timeline-area -->
                                            <!-- timeline time label -->
                                            <div class="time-label">
                                                <span class="bg-orange">HYS Kim Liên</span>
                                            </div>
                                            <!-- /.timeline-label -->

                                            <!-- timeline-area -->
                                            <div>
                                                <i class="fas fa-clock bg-indigo"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header"><b class="labelTimelineItem">
                                                            10/03/2019 - 24/08/2021
                                                        </b></h3>
                                                </div>
                                            </div>
                                            <div>
                                                <i class="fas fa-times-circle bg-maroon"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header">
                                                        <b class="labelTimelineItem">
                                                            Dừng hoạt động
                                                        </b>
                                                        <a href="" class="btnEditUserGroup" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                           data-content="Thay đổi trạng thái hoạt động" data-id="1"><i class="fas fa-edit ml-2"></i></a>                                                        </h3>
                                                </div>
                                            </div>

                                            <div>
                                                <i class="fas fa-times-circle bg-maroon"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header">
                                                        <b class="labelTimelineItem">
                                                            Trạng thái: Dừng hoạt động | Thời gian: 10/03/2019 - 24/08/2021
                                                        </b>
                                                        <a href="" class="btnEditUserGroup" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                           data-content="Thay đổi trạng thái hoạt động" data-id="1"><i class="fas fa-edit ml-2"></i></a>                                                        </h3>
                                                </div>
                                            </div>
                                            <!-- timeline item role area -->
                                            <div>
                                                <i class="fas fa-user-check bg-green"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> <b>30/12/2020 - 30/12/2020</b></span>
                                                    <h3 class="timeline-header no-border">
                                                        <b class="labelTimelineItem">Phó Chủ Nhiệm</b>
                                                        <a href="" class="btnEditUgr" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                           data-content="Thay đổi trạng thái chức vụ" data-id="1">
                                                            <i class="fas fa-edit ml-2"></i>
                                                        </a>
                                                        <a href="" class="btnDeleteUgr" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Xóa chức vụ" data-id="1">
                                                            <i class="fas fa-trash ml-2" style="color: red"></i>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>                                                <!-- END timeline item role area -->

                                            <div>
                                                <i class="fas fa-location-arrow bg-blue"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> <b>01/04/2019 - 24/08/2021</b></span>
                                                    <h3 class="timeline-header no-border">
                                                        <b class="labelTimelineItem">Ban  ĐTTT Kim Liên</b>
                                                    </h3>
                                                    <div class="timeline-body">
                                                        <div class="timeline">
                                                            <div>
                                                                <i class="fas fa-user-times bg-red"></i>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="fas fa-clock"></i> <b>25/11/2020 - 24/08/2021</b></span>
                                                                    <h3 class="timeline-header no-border">
                                                                        <b class="labelTimelineItem">Trưởng Ban</b>
                                                                        <a href="" class="btnEditUgr" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                                           data-content="Thay đổi trạng thái chức vụ" data-id="3">
                                                                            <i class="fas fa-edit ml-2"></i>
                                                                        </a>
                                                                        <a href="" class="btnDeleteUgr" data-toggle="popover" data-trigger="hover" data-placement="right"
                                                                           data-content="Xóa chức vụ" data-id="3">
                                                                            <i class="fas fa-trash ml-2" style="color: red"></i>
                                                                        </a>
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <i class="fas fa-user-times bg-red" style="margin-top: 8px"></i>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="fas fa-clock"></i> <b>05/06/2020 - 05/06/2020</b></span>
                                                                    <h3 class="timeline-header no-border">
                                                                        <b class="labelTimelineItem">Phó Ban</b>
                                                                        <a href="" class="btnEditUgr" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                                           data-content="Thay đổi trạng thái chức vụ" data-id="2">
                                                                            <i class="fas fa-edit ml-2"></i>
                                                                        </a>
                                                                        <a href="" class="btnDeleteUgr" data-toggle="popover" data-trigger="hover" data-placement="right"
                                                                           data-content="Xóa chức vụ" data-id="2">
                                                                            <i class="fas fa-trash ml-2" style="color: red"></i>
                                                                        </a>
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <i class="fas fa-location-arrow bg-blue"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> <b>10/03/2019 - 05/06/2020</b></span>
                                                    <h3 class="timeline-header no-border">
                                                        <a href="" class="btnEditUserGroup">Cơ sở Nhân văn Tự nhiên UTT</a>
                                                    </h3>


                                                    <div class="timeline-body">
                                                        <div class="timeline">
                                                            <div>
                                                                <i class="fas fa-clock bg-indigo"></i>
                                                                <div class="timeline-item">
                                                                    <h3 class="timeline-header"><b class="labelTimelineItem">
                                                                            10/03/2019 - 24/08/2021
                                                                        </b></h3>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <i class="fas fa-times-circle bg-maroon"></i>
                                                                <div class="timeline-item">
                                                                    <h3 class="timeline-header">
                                                                        <b class="labelTimelineItem">
                                                                            Dừng hoạt động
                                                                        </b>
                                                                        <a href="" class="btnEditUserGroup" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                                           data-content="Thay đổi trạng thái hoạt động" data-id="1"><i class="fas fa-edit ml-2"></i></a>                                                        </h3>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <i class="fas fa-location-arrow bg-blue"></i>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="fas fa-clock"></i> <b>01/04/2019 - 05/06/2020</b></span>
                                                                    <h3 class="timeline-header no-border">
                                                                        <b class="labelTimelineItem">Ban ĐTTT CS UTT</b>
                                                                    </h3>
                                                                    <div class="timeline-body">
                                                                        <div class="timeline">
                                                                            <div>
                                                                                <i class="fas fa-user-times bg-red"></i>
                                                                                <div class="timeline-item">
                                                                                    <span class="time"><i class="fas fa-clock"></i> <b>13/12/2019 - 05/06/2020</b></span>
                                                                                    <h3 class="timeline-header no-border">
                                                                                        <b class="labelTimelineItem">Trưởng Ban</b>
                                                                                        <a href="" class="btnEditUgr" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                                                           data-content="Thay đổi trạng thái chức vụ" data-id="7">
                                                                                            <i class="fas fa-edit ml-2"></i>
                                                                                        </a>
                                                                                        <a href="" class="btnDeleteUgr" data-toggle="popover" data-trigger="hover" data-placement="right"
                                                                                           data-content="Xóa chức vụ" data-id="7">
                                                                                            <i class="fas fa-trash ml-2" style="color: red"></i>
                                                                                        </a>
                                                                                    </h3>
                                                                                </div>
                                                                            </div>
                                                                            <div>
                                                                                <i class="fas fa-user-times bg-red" style="margin-top: 8px"></i>
                                                                                <div class="timeline-item">
                                                                                    <span class="time"><i class="fas fa-clock"></i> <b>01/04/2019 - 13/12/2019</b></span>
                                                                                    <h3 class="timeline-header no-border">
                                                                                        <b class="labelTimelineItem">Thành viên</b>
                                                                                        <a href="" class="btnEditUgr" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                                                           data-content="Thay đổi trạng thái chức vụ" data-id="6">
                                                                                            <i class="fas fa-edit ml-2"></i>
                                                                                        </a>
                                                                                        <a href="" class="btnDeleteUgr" data-toggle="popover" data-trigger="hover" data-placement="right"
                                                                                           data-content="Xóa chức vụ" data-id="6">
                                                                                            <i class="fas fa-trash ml-2" style="color: red"></i>
                                                                                        </a>
                                                                                    </h3>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <i class="fas fa-location-arrow bg-blue"></i>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="fas fa-clock"></i> <b>10/03/2019 - 13/12/2019</b></span>
                                                                    <h3 class="timeline-header no-border">
                                                                        <b class="labelTimelineItem">Đội Nhân văn 3</b></h3>
                                                                    <div class="timeline-body">
                                                                        <div class="timeline">
                                                                            <div>
                                                                                <i class="fas fa-user-times bg-red"></i>
                                                                                <div class="timeline-item">
                                                                                    <span class="time"><i class="fas fa-clock"></i> <b>11/08/2019 - 13/12/2019</b></span>
                                                                                    <h3 class="timeline-header no-border">
                                                                                        <b class="labelTimelineItem">Đội trưởng</b>
                                                                                        <a href="" class="btnEditUgr"data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                                                           data-content="Thay đổi trạng thái chức vụ" data-id="5">
                                                                                            <i class="fas fa-edit ml-2"></i>
                                                                                        </a>
                                                                                        <a href="" class="btnDeleteUgr" data-toggle="popover" data-trigger="hover" data-placement="right"
                                                                                           data-content="Xóa chức vụ" data-id="5">
                                                                                            <i class="fas fa-trash ml-2" style="color: red"></i>
                                                                                        </a>
                                                                                    </h3>
                                                                                </div>
                                                                            </div>
                                                                            <div>
                                                                                <i class="fas fa-user-times bg-red" style="margin-top: 8px"></i>
                                                                                <div class="timeline-item">
                                                                                    <span class="time"><i class="fas fa-clock"></i> <b>10/03/2019 - 11/08/2019</b></span>
                                                                                    <h3 class="timeline-header no-border">
                                                                                        <b class="labelTimelineItem">Thành viên</b>
                                                                                        <a href="" class="btnEditUgr"data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                                                           data-content="Thay đổi trạng thái chức vụ" data-id="4">
                                                                                            <i class="fas fa-edit ml-2"></i>
                                                                                        </a>
                                                                                        <a href="" class="btnDeleteUgr" data-toggle="popover" data-trigger="hover" data-placement="right"
                                                                                           data-content="Xóa chức vụ" data-id="4">
                                                                                            <i class="fas fa-trash ml-2" style="color: red"></i>
                                                                                        </a>
                                                                                    </h3>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <i class="fas fa-circle bg-gray"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            <!-- END timeline-area -->
                                            <div>
                                                <i class="fas fa-circle bg-gray"></i>
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
