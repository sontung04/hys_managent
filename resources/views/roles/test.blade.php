@extends('layouts.sidebar')

{{--@section('script')--}}
{{--    <script src="{{ asset('assets/js/role/manage.js') }}" defer></script>--}}
{{--@endsection--}}

@section("content")

    <script src="{{ asset('assets/js/role/manage.js') }}" defer></script>
    <style>
        .labelTimelineItem {
            color: #007bff;
        }
        .labelTimelineItem:hover {
            color: #0056b3;
        }
    </style>
    <?php

        $iconList = [
            'clock'    => '<i class="fas fa-clock"></i>',
            'userNow'  => '<i class="fas fa-user-check bg-green"></i>',
            'userStop' => '<i class="fas fa-user-times bg-red"></i>',
            'location' => '<i class="fas fa-location-arrow bg-blue"></i>',
            'circleEnd'    => '<i class="fas fa-circle bg-gray"></i>',
            'itemLastNow'  => '<i class="fas fa-user-check bg-green" style="margin-top: 8px"></i>',
            'itemLastStop' => '<i class="fas fa-user-times bg-red" style="margin-top: 8px"></i>',
        ];

        function textHtmlTagPopover($type, $id) {
            $htmlText = '<a href="" class="';
            if($type == 'ugr') {
                $htmlText .= 'btnEditUgr"';
            } else {
                $htmlText .= 'btnEditUserGroup"';
            }
            $htmlText .= 'data-toggle="popover" data-trigger="hover" data-placement="bottom"
                            data-content="Thay đổi trạng thái chức vụ" data-id="';
            $htmlText .= $id;
            $htmlText .= '"><i class="fas fa-edit ml-2"></i></a>';

            return $htmlText;
        }

        function htmlTimelineItem($data, $iconList, $roles, $lastItem = false) {

            echo '<div>';
            if($lastItem) {
                echo $data['status'] ? $iconList['itemLastNow'] : $iconList['itemLastStop'];
            } else {
                echo $data['status'] ? $iconList['userNow'] : $iconList['userStop'];
            }

            echo '<div class="timeline-item">';
            echo '<span class="time">' . $iconList['clock'] . ' <b>';
            echo date('d/m/Y', strtotime($data['startTime']));
            echo !empty($data['endTime']) ? ' - ' . date('d/m/Y', strtotime($data['endTime'])) : '';
            echo '</b></span>';

//            echo '<h3 class="timeline-header no-border"><a href="" class="btnEditUgr">';
            echo '<h3 class="timeline-header no-border">';
            echo '<b class="labelTimelineItem">' . (!$data['roleid'] ? 'Thành viên' : $roles[$data['roleid']]). '</b>';
//            echo '<a href="" class="btnEditUserGroup" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Thay đổi trạng thái chức vụ"><i class="fas fa-edit ml-2"></i></a>';
            echo textHtmlTagPopover('ugr', $data['ugrid']);
            echo '<a href="" class="btnDeleteUgr" data-toggle="popover" data-trigger="hover" data-placement="right"
                        data-content="Xóa chức vụ" data-id="' . $data['ugrid'] .'">
                            <i class="fas fa-trash ml-2" style="color: red"></i></a>';
            echo '</h3>';
            echo '</div></div>';

        }

        function showChildGroupRole($items, $iconList, $roles, $groupType) {

            foreach ($items as $item) {

                echo '<div>';

                if((count($item['roles']) == 1) && (!isset($item['list']) || empty($item['list']))) {

                    $role = $item['roles'][0];

                    echo $role['status'] ? $iconList['userNow'] : $iconList['userStop'];

                    echo '<div class="timeline-item">';
                    echo '<span class="time">' . $iconList['clock'] . ' <b>';
                    echo date('d/m/Y', strtotime($role['startTime']));
                    echo !empty($role['endTime']) ? ' - ' . date('d/m/Y', strtotime($role['endTime'])) : '';
                    echo '</b></span>';

                    echo '<h3 class="timeline-header no-border"><b class="labelTimelineItem">';
                    echo  $groupType[$item['type']] . ' ' . $item ['name'] . ' - ' . (!$role['roleid'] ? 'Thành viên' : $roles[$role['roleid']]);
                    echo '</b>';
                    echo textHtmlTagPopover('ugr', $role['ugrid']);
                    echo '</h3></div>';

                } elseif(count($item['roles']) > 1) {

                    echo $iconList['location'];
                    echo '<div class="timeline-item">';

                    if(isset($item['startTime'])) {
                        echo '<span class="time">' . $iconList['clock'] . ' <b>';
                        echo date('d/m/Y', strtotime($item['startTime']));
                        echo !empty($item['endTime']) ? ' - ' . date('d/m/Y', strtotime($item['endTime'])) : '';
                        echo '</b></span>';
                    }

                    echo '<h3 class="timeline-header no-border">';
                    echo '<b class="labelTimelineItem">' . $groupType[$item['type']] . ' ' . $item ['name'] . '</b>';
//                    echo textHtmlTagPopover('ug', $item['ugrid']);

                    echo '</h3>';

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
                        echo '<div>' . $iconList['circleEnd'] . '</div>';
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
                    echo '<span class="time">' . $iconList['clock'] . ' <b>';
                    echo date('d/m/Y', strtotime($item['startTime']));
                    echo !empty($item['endTime']) ? ' - ' . date('d/m/Y', strtotime($item['endTime'])) : '';
                    echo '</b></span>';
                    echo '<h3 class="timeline-header no-border"><a href="" class="btnEditUserGroup">';

                    if(!isset($item['list']) || empty($item['list'])) {
                        echo  $groupType[$item['type']] . ' ' . $item ['name'] . ' - Thành viên';
                        echo '</a></h3>';
                        echo '</div>';
                    } else {
                        echo  $groupType[$item['type']] . ' ' . $item ['name'];
                        echo '</a></h3>';
                        echo '<div class="timeline-body"><div class="timeline">';

                        showChildGroupRole($item['list'], $iconList, $roles, $groupType);

                        echo '<div>' . $iconList['circleEnd'] . '</div>';
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

                                            @foreach($items as $key => $itemArea)
                                                <!-- timeline time label -->
                                                <div class="time-label">
                                                    <span class="bg-{{$areaColor[$key]}}">HYS {{$itemArea['name']}}</span>
                                                </div>
                                                <!-- /.timeline-label -->

                                                <!-- timeline-area -->
                                                <div>
                                                    <i class="fas fa-clock bg-indigo"></i>
                                                    <div class="timeline-item">
                                                        <h3 class="timeline-header"><b class="labelTimelineItem">
                                                                {{date('d/m/Y', strtotime($itemArea['startTime']))}}
                                                                @isset($itemArea['endTime'])
                                                                    -  {{date('d/m/Y', strtotime($itemArea['endTime']))}}
                                                                @endisset
                                                            </b></h3>
                                                    </div>
                                                </div>
                                                <div>
                                                    <?php echo $itemArea['status'] ? $iconList['userNow'] : $iconList['userStop'] ?>
                                                    <div class="timeline-item">
                                                        <h3 class="timeline-header"><b class="labelTimelineItem">
                                                                <?php echo $itemArea['status'] ? 'Đang hoạt động' : 'Dừng hoạt động' ?>
                                                            </b>
                                                            <?php echo textHtmlTagPopover('ug', $itemArea['ugid']) ?>
                                                        </h3>
                                                    </div>
                                                </div>

                                                @foreach($itemArea['roles'] as $areaRole)
                                                    <!-- timeline item role area -->
                                                    <?php htmlTimelineItem($areaRole, $iconList, $roles); ?>
                                                    <!-- END timeline item role area -->
                                                @endforeach

                                                <?php if(count($itemArea['list'])) {
                                                    showChildGroupRole($itemArea['list'], $iconList, $roles, $groupType);
                                                } ?>
                                                <!-- END timeline-area -->
                                            @endforeach
                                                <div>
                                                    <?php echo $iconList['circleEnd']; ?>
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
    <div class="modal fade" id="addUserGroupRoleModal" tabindex="-1" role="dialog" aria-labelledby="addUserGroupRoleLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserGroupRoleModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="" method="post" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="groupParent" name="groupParent">
                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="area" id="">Khu vực: <span style="color: red">*</span></label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select" name="area" id="area">
                                    <option selected disabled>--- Chọn Khu vực ---</option>
                                    @foreach($areaName as $key => $value)
                                        @if($key != 0)
                                            <option value="{{$key}}" data-name="{{$key.$value}}">{{'HYS ' . $value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="group_type" id="">Cấp: <span style="color: red">*</span></label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select" name="group_type" id="group_type">
                                    <option selected disabled>--- Chọn Cấp chức vụ ---</option>
                                    @foreach($groupType as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row" id="selectGroupChild" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="name" id="selectGroupChildLabel">

                            </label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select" name="groupChild" id="groupChild">

                                </select>
                            </div>
                        </div>

                        {{--                        <div class="row">--}}
                        {{--                            <label class="col-lg-3 col-form-label" for="name" id="">Ban: </label>--}}
                        {{--                            <div class="form-group col-lg-9">--}}
                        {{--                                <select class="form-control custom-select">--}}
                        {{--                                    <option>option 1</option>--}}
                        {{--                                </select>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="name" id="">Chức vụ: <span style="color: red">*</span></label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select" name="role_id" id="selectRole">
                                    {{--                                    <option>option 1</option>--}}
                                    {{--                                    <option>option 2</option>--}}
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
                    </div>

                    <div class="modal-footer" >
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu thông tin</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
