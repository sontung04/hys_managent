@extends('layouts.sidebar')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/role/manage.css') }}">
@endsection

@section('script')
    <script src="{{ asset('assets/js/role/manage.js') }}" defer></script>
@endsection

@section("content")
    <?php
    $iconList = [
        'userNow'  => '<i class="fas fa-user-check bg-green"></i>',
        'userStop' => '<i class="fas fa-user-times bg-red"></i>',
        'location' => '<i class="fas fa-location-arrow bg-blue"></i>',
        'circleEnd'    => '<i class="fas fa-circle bg-gray"></i>',
        'itemLastNow'  => '<i class="fas fa-user-check bg-green" style="margin-top: 8px"></i>',
        'itemLastStop' => '<i class="fas fa-user-times bg-red" style="margin-top: 8px"></i>',
        'ugStatusNow'  => '<i class="fas fa-check-circle bg-teal"></i>',
        'ugStatusStop' => '<i class="fas fa-times-circle bg-maroon"></i>',
    ];

    function htmlTagAEditPopover($type, $id) {
        $htmlText = '<a href="" class="btnEditStatus"';
        if($type == 'ugr') {
            $textContent = 'chức vụ';
        } else {
            $textContent = 'hoạt động';
        }
        $htmlText .= ' data-toggle="popover" data-trigger="hover" data-placement="bottom"
                            data-content="Cập nhập trạng thái ';
        $htmlText .= $textContent;
        $htmlText .= '" data-type="';
        $htmlText .= $type;
        $htmlText .= '" data-id="';
        $htmlText .= $id;

        $htmlText .= '"><i class="fas fa-edit ml-2"></i></a>';

        return $htmlText;
    }

    function htmlStatusLogGroup($data, $iconList) {

        $htmlText = '<div>';
        $htmlText .= $data['status'] ? $iconList['ugStatusNow'] : $iconList['ugStatusStop'];
        $htmlText .= '<div class="timeline-item">';
        $htmlText .= '<h3 class="timeline-header">';
        $htmlText .= '<b class="labelTimelineItem">';
        $htmlText .= 'Trạng thái: ';
        $htmlText .= $data['status'] ? 'Đang hoạt động' : 'Dừng hoạt động';
        $htmlText .= ' | ';
        $htmlText .= 'Thời gian: ';
        $htmlText .= date('d/m/Y', strtotime($data['startTime']));
        $htmlText .= !empty($data['endTime']) ? ' - ' . date('d/m/Y', strtotime($data['endTime'])) : '';
        $htmlText .= '</b>';
        $htmlText .= htmlTagAEditPopover('ug', $data['ugid']);
        $htmlText .= '</div>';
        $htmlText .= '</div>';

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
        echo '<h3 class="timeline-header no-border">';
        echo '<b class="labelTimelineItem">';
        echo (!$data['roleid'] ? 'Thành viên' : $roles[$data['roleid']]) . ': ';
        echo date('d/m/Y', strtotime($data['startTime']));
        echo !empty($data['endTime']) ? ' - ' . date('d/m/Y', strtotime($data['endTime'])) : '';
        echo '</b>';
        echo htmlTagAEditPopover('ugr', $data['ugrid']);
        echo '<a href="" class="btnDeleteUgr" data-toggle="popover" data-trigger="hover" data-placement="right"
                        data-content="Xóa chức vụ" data-id="' . $data['ugrid'] .'">
                            <i class="fas fa-trash ml-2" style="color: red"></i></a>';
        echo '</h3>';
        echo '</div></div>';
    }

    function showChildGroupRole($items, $iconList, $roles, $groupType) {

        foreach ($items as $item) {

            echo '<div>';

            echo $iconList['location'];
            echo '<div class="timeline-item">';
            echo '<h3 class="timeline-header no-border">';
            echo '<b class="labelTimelineItem">' . $groupType[$item['type']] . ' ' . $item ['name'] . '</b>';
            echo '</h3>';
            echo '<div class="timeline-body"><div class="timeline">';
            echo htmlStatusLogGroup($item, $iconList);

            if(count($item['roles']) == 0 && (!isset($item['list']) || empty($item['list']))) {

                echo '<div>';
                echo $item['status'] ? $iconList['itemLastNow'] : $iconList['itemLastStop'];
                echo '<div class="timeline-item">';
                echo '<h3 class="timeline-header no-border">';
                echo '<b class="labelTimelineItem">';
                echo 'Thành viên: ';
                echo date('d/m/Y', strtotime($item['startTime']));
                echo !empty($item['endTime']) ? ' - ' . date('d/m/Y', strtotime($item['endTime'])) : '';
                echo '</b>';
//                echo htmlTagAEditPopover('ug', $item['ugid']);
                echo '</h3>';
                echo '</div></div>';

            } else {
                $index = 1;
                foreach ($item['roles'] as $key => $role) {
                    if($index == count($item['roles']) && (!isset($item['list']) || empty($item['list']))) {
                        htmlTimelineItem($role, $iconList, $roles, true);
                    } else {
                        htmlTimelineItem($role, $iconList, $roles);
                    }
                    $index++;
                }

                if(isset($item['list']) && !empty($item['list'])) {
                    showChildGroupRole($item['list'], $iconList, $roles, $groupType);
                    echo '<div>' . $iconList['circleEnd'] . '</div>';
                }
            }
            echo '</div></div>';
            echo '</div>';
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
                                    <img class="img-circle img-bordered-sm" src="{{ !empty($userInfo->img) ? asset($userInfo->img) : asset(config('app.avatarDefault')) }}" alt="user image">
                                    <span class="username">
                                            <a href="#">{{$userInfo->lastname . ' ' . $userInfo->firstname }}</a>
                                        </span>
                                    <span class="description" style="font-size: 16px">
                                        Trạng thái:<strong> {{$userInfo->status ? 'Đang hoạt động' : 'Dừng hoạt động'}} </strong>
                                    </span>
                                </div>

                                <a class="btn btn-success text-white float-right" id="btnAddRoleUser">
                                    <i class="fas fa-user-cog"></i>
                                    Thêm Chức vụ
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
                                                <!-- /.End timeline time label -->

                                                <!-- timeline status log group -->
                                            <?php echo htmlStatusLogGroup($itemArea, $iconList); ?>
                                            <!-- /. End timeline status log group -->
                                                @if(empty($itemArea['roles']) && empty($itemArea['list']))
                                                    <div>
                                                        <?php echo $itemArea['status'] ? $iconList['itemLastNow'] : $iconList['itemLastStop']; ?>
                                                        <div class="timeline-item">
                                                            <h3 class="timeline-header no-border">
                                                                <b class="labelTimelineItem">
                                                                    <?php
                                                                    echo 'Thành viên: ' . date('d/m/Y', strtotime($itemArea['startTime']));
                                                                    echo !empty($itemArea['endTime']) ? ' - ' . date('d/m/Y', strtotime($itemArea['endTime'])) : '';
                                                                    ?>
                                                                </b>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                @endif

                                                @foreach($itemArea['roles'] as $areaRole)
                                                <!-- timeline item role area -->
                                                    <?php htmlTimelineItem($areaRole, $iconList, $roles); ?>
                                                <!-- END timeline item role area -->
                                                @endforeach

                                                <?php
                                                if(count($itemArea['list'])) {
                                                    showChildGroupRole($itemArea['list'], $iconList, $roles, $groupType);
                                                } ?>
                                            <!-- END timeline-area -->
                                            @endforeach
                                            <div>
                                                <?php echo $iconList['circleEnd']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal addUserGroupRoleModal -->
    <div class="modal fade" id="addUserGroupRoleModal" tabindex="-1" role="dialog" aria-labelledby="addUserGroupRoleLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserGroupRoleModalTitle">Thêm chức vụ thành viên</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="" method="post" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="userid" value="{{$userInfo->id}}">
                    <div class="modal-body">

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="area" id="">Khu vực: <span style="color: red">*</span></label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select" name="area" id="area">
                                    <option value="" selected disabled>--- Chọn Khu vực ---</option>
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
                                    <option value="" selected disabled>--- Chọn Cấp chức vụ ---</option>
                                    @foreach($groupType as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row" id="divGroup" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="name" id="selectGroupLabel">

                            </label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select" name="group_id" id="selectGroup">

                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="name" id="">Chức vụ: <span style="color: red">*</span></label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select" name="role_id" id="selectRole">

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

                        <div class="row">
                            <label class="col-sm-3 col-form-label" style="text-align: right">Ngày bắt đầu:</label>
                            <div class="form-group col-sm-9">
                                <div class="input-group date" id="addStarttime" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#addStarttime" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="inputAddStarttime"
                                           name="starttime" data-target="#addStarttime" data-toggle="datetimepicker"
                                           data-max="{{date("d/m/Y")}}" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" style="text-align: right">Ngày kết thúc:</label>
                            <div class="form-group col-sm-9">
                                <div class="input-group date" id="addFinishtime" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#addFinishtime" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="inputAddFinishtime"
                                           name="finishtime" data-target="#addFinishtime" data-toggle="datetimepicker"/>
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

    <!-- Modal editStatusModal -->
    <div class="modal fade" id="editStatusModal" tabindex="-1" role="dialog" aria-labelledby="editStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStatusModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="" method="post" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="type" name="type">
                        {{--                        <input type="hidden" id="groupParent" name="groupParent">--}}

                        <div class="row">
                            <label for="status" class="col-sm-3">Trạng thái: <span style="color: red">*</span></label>
                            <div class="form-group col-sm-9">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="statusU1" name="status" value="1" checked>
                                    <label for="statusU1" style="margin-right: 10px">
                                        Đang hoạt động
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="statusU2" name="status" value="0">
                                    <label for="statusU2">
                                        Dừng hoạt động
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" style="text-align: right">Ngày bắt đầu:</label>
                            <div class="form-group col-sm-9">
                                <div class="input-group date" id="updateStarttime" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#updateStarttime" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="inputUpdateStarttime"
                                           name="starttime" data-target="#updateStarttime" data-toggle="datetimepicker"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" style="text-align: right">Ngày kết thúc:</label>
                            <div class="form-group col-sm-9">
                                <div class="input-group date" id="updateFinishtime" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#updateFinishtime" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="inputUpdateFinishtime"
                                           name="finishtime" data-target="#updateFinishtime" data-toggle="datetimepicker"/>
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
