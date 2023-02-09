@extends('layouts.sidebar')

@section('title', 'HYS Manage - Chi tiết học phí học viên')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/student/fee/detail.css') }}">

@endsection

@section('script')
    <script src="{{ asset('assets/js/fee/detail.js') }}" defer></script>
@endsection

@section('content')
    <?php
        $listStatusClass = [
            0 => 'Nghỉ học',
            1 => 'Đang học',
            2 => 'Đã hoàn thành',
            3 => 'Bảo lưu',
        ];

        $statusClassColor = [
            0 => 'danger',
            1 => 'success',
            2 => 'info',
            3 => 'warning',
        ];

        $listChannelLog = [
            0 => 'SĐT',
            1 => 'Zalo',
            2 => 'FB/Messenger',
            3 => 'Kênh khác',
        ];

        $statusCallLog = [
            0 => 'Không liên hệ được',
            1 => 'Liên hệ được',
            2 => 'Thông tin liên hệ sai',
        ];

        $totalFees    = 0;
        $totalPayment = 0;
    ?>
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
                                         src="{{ asset($studentInfo->img) }}" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{ $studentInfo->name }}</h3>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Ngày sinh</b> <a class="float-right">{{date('d/m/Y', strtotime($studentInfo->birthday))}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Giới tính</b> <a class="float-right">{{ $studentInfo->gender ? 'Nam' : 'Nữ'}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Số điện thoại</b> <a class="float-right">{{ $studentInfo->phone }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Email</b> <a class="float-right">{{ $studentInfo->email }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Facebook</b> <a href="{{ $studentInfo->facebook }}" class="float-right"
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
                                    <li class="nav-item mr-2" id="liBtnAddPaymentLog">
                                        <a class="btn btn-success text-white" id="btnAddPaymentLog">
                                            <i class="fa-solid fa-credit-card"></i>
                                            Thêm LS đóng tiền
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="btn btn-success text-white" id="btnAddCallLog">
                                            <i class="fa-solid fa-phone"></i>
                                            Thêm LS gọi điện
                                        </a>
                                    </li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">

                                    <!-- Tab lịch sử các khóa học -->
                                    <div class="tab-pane active" id="timelineCourse">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="post">
                                                            <h4 style="text-align: center"><b>Khóa học</b></h4>
                                                        </div>

                                                        <div class="post">
                                                            <table class="table table-hover text-nowrap">
                                                                <thead>
                                                                <tr>
                                                                    <th>Khóa học</th>
                                                                    <th>Trạng thái</th>
                                                                    <th>Học phí cần đóng</th>
                                                                    <th>Học phí đã đóng</th>
                                                                    <th>Còn nợ</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>

                                                                @foreach($coursesInfo as $courseInfo)
                                                                    <tr>
                                                                        <td><b>{{$courseInfo['name']}}</b></td>
                                                                        <td>
                                                                            <b><span class="text-{{$statusClassColor[$courseInfo['status']]}}">
                                                                                {{$listStatusClass[$courseInfo['status']]}}
                                                                            </span></b>
                                                                        </td>
                                                                        <td>{{number_format($courseInfo['fees'])}}</td>
                                                                        <td>{{number_format($courseInfo['payment'])}}</td>
                                                                        <td>
                                                                            {{number_format($courseInfo['fees'] - $courseInfo['payment'])}}
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                        $totalFees += $courseInfo['fees'];
                                                                        $totalPayment += $courseInfo['payment'];
                                                                    ?>
                                                                @endforeach
                                                                    <tr>
                                                                        <th colspan="2">Tổng</th>
                                                                        <td>{{number_format($totalFees)}}</td>
                                                                        <td>{{number_format($totalPayment)}}</td>
                                                                        <td>{{number_format($totalFees - $totalPayment)}}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <br>

                                                        <div class="post">
                                                            <h4 style="text-align: center"><b>Các lớp</b></h4>
                                                        </div>

                                                        <div class="post">
                                                            <table class="table table-hover text-nowrap">
                                                                <thead>
                                                                <tr>
                                                                    <th>Lớp</th>
                                                                    <th>Số buổi học</th>
                                                                    <th>Trạng thái</th>
                                                                    <th>Ngày học</th>
                                                                    <th>Ngày nghỉ</th>
                                                                    <th>Ngày hẹn học phí</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>

                                                                @foreach($classesInfo as $classInfo)
                                                                    <tr>
                                                                        <td><b>{{$classInfo['name']}}</b></td>
                                                                        <td style="text-align: center; vertical-align: middle">
                                                                            {{$classInfo['learn'] . '/' . $classInfo['studies']}}
                                                                        </td>
                                                                        <td>
                                                                            <b><span class="text-{{$statusClassColor[$classInfo['status']]}}">
                                                                                {{$listStatusClass[$classInfo['status']]}}
                                                                            </span></b>
                                                                        </td>
                                                                        <td>{{date('d/m/Y', strtotime($classInfo['starttime']))}}</td>
                                                                        <td>
                                                                            @if(!is_null($classInfo['finishtime']))
                                                                                {{date('d/m/Y', strtotime($classInfo['finishtime']))}}
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if(!is_null($classInfo['date_payment']))
                                                                                {{date('d/m/Y', strtotime($classInfo['date_payment']))}}
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Tab lịch sử các khóa học -->


                                    <!-- Tab lịch sử các lần nộp tiền -->
                                    <div class="tab-pane" id="paymentLog">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="post">
                                                            <h4 style="text-align: center"><b>Lịch sử đóng tiền</b></h4>
                                                        </div>

                                                        @foreach($coursesInfo as $courseInfo)
                                                            <?php
                                                                if($courseInfo['fees'] <= $courseInfo['payment']) {
                                                                    $statusPayment = 1;
                                                                } else {
                                                                    $statusPayment = 0;
                                                                }
                                                            ?>
                                                            <div class="post">
                                                                <div class="user-block">
                                                                    <span style="font-weight: 600">
                                                                      <a href="#">
                                                                          Khóa: {{$courseInfo['name']}}  -
                                                                          @if($statusPayment) Đã hoàn thành
                                                                          @else Chưa hoàn thành
                                                                          @endif
                                                                      </a>
                                                                    </span>
                                                                    <span style="display: block; color: #28a745">
                                                                        <b>
                                                                            Học phí: {{number_format($courseInfo['fees']) . ' / ' . number_format($courseInfo['cost'])}}
                                                                        </b>
                                                                    </span>
                                                                    <span style="display: block; color: red">
                                                                        <b>
                                                                            Còn nợ: @if($statusPayment) 0
                                                                            @else {{number_format($courseInfo['fees'] - $courseInfo['payment'])}}
                                                                            @endif
                                                                        </b>
                                                                    </span>
                                                                </div>

                                                                @if(!empty($courseInfo['logs']))
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
                                                                        <?php $index = 1; ?>
                                                                    @foreach($courseInfo['logs'] as $log)
                                                                        <tr>
                                                                            <td>{{$index++}}</td>
                                                                            <td>{{number_format($log['money_paid'])}}</td>
                                                                            <td>{{$log['cashier']}}</td>
                                                                            <td><?php echo $log['status'] ? 'Online' : 'Offline'; ?></td>
                                                                            <td>{{date('d/m/Y', strtotime($log['date_paid']))}}</td>
                                                                            <td>{{$log['note']}}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                        </tbody>
                                                                    </table>

                                                                @else
                                                                    <p><b>Chưa đóng tiền khóa học</b></p>
                                                                @endif

                                                            </div>
                                                        @endforeach

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
                                                            <?php $index = 1; ?>
                                                            @forelse($callLogs as $callLog)
                                                                <tr>
                                                                    <td>{{$index++}}</td>
                                                                    <td>{{$callLog->agent}}</td>
                                                                    <td>{{date('d/m/Y', strtotime($callLog->date_call))}}</td>
                                                                    <td>{{$listChannelLog[$callLog->channel]}}</td>
                                                                    <td>{{$statusCallLog[$callLog->status]}}</td>
                                                                    <td>{{$callLog->note}}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <th colspan="" style="text-align: center">Không có dữ liệu hiển thị! Vui lòng thử lại!</th>
                                                                </tr>
                                                            @endforelse

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

    <!-- modal Add New Record Payment Log -->
    <div class="modal fade" id="modalAddPaymentLog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddPaymentLogTitle">Modal default</h4>
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="" class="form-horizontal" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control" name="id">
                        <input type="hidden" id="student_code" name="student_code" value="{{ $studentInfo->code }}">

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="course_id">Khoá học: <span
                                    class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select" name="course_id" id="course_id">
                                    <option value="" selected disabled="disabled">--- Chọn khóa học ---</option>
                                    @foreach($coursesInfo as $courseInfo)
                                        <option value="{{$courseInfo['id']}}"
                                                @if($courseInfo['cost'] == $courseInfo['payment']) disabled="disabled" @endif>
                                            {{$courseInfo['name']}} @if($courseInfo['cost'] == $courseInfo['payment']) (Đã thanh toán) @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="money_paid" id="">Số tiền: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="number" name="money_paid" id="money_paid" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="cashier" id="">Người thu: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="text" name="cashier" id="cashier" class="form-control" placeholder="Ghi tên người thu">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="status">Hình thức thu: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status0" name="status" value="0" checked>
                                    <label for="status0" style="margin-right: 10px">
                                        Offline
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status1" name="status" value="1" >
                                    <label for="status1" style="margin-right: 10px">
                                        Online
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="date_paid">Ngày thu: <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <div class="form-group input-group date" id="date_paidDate" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#date_paidDate" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="date_paid" name="date_paid"
                                           data-target="#date_paidDate" data-toggle="datetimepicker"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" >
                            <label class="col-lg-3 col-form-label" for="note">Ghi chú:</label>
                            <div class="col-lg-9">
                                <textarea type="text" name="note" id="note" class="form-control" rows="2"></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer ">
                        <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="btnSave"><i class="fas fa-save"></i> Lưu thông tin</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- /.END modal Add New Record Payment Log -->


    <!-- modal Add New Record Payment Log -->
    <div class="modal fade" id="modalAddCallLog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddCallLogTitle">Modal default</h4>
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="" class="form-horizontal" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control" name="id">
                        <input type="hidden" id="student_code" name="student_code" value="{{ $studentInfo->code }}">

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="agent" id="">Người gọi: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="text" name="agent" id="agent" class="form-control" value="Vũ Thị Mai Huế">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="date_call">Ngày gọi: <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <div class="form-group input-group date" id="date_callDate" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#date_callDate" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="date_call" name="date_call"
                                           data-target="#date_callDate" data-toggle="datetimepicker"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="channel">Kênh gọi: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="channel0" name="channel" value="0" checked>
                                    <label for="channel0" style="margin-right: 10px">
                                        Số điện thoại
                                    </label>
                                </div>

                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="channel1" name="channel" value="1" >
                                    <label for="channel1" style="margin-right: 10px">
                                        Zalo
                                    </label>
                                </div>

                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="channel2" name="channel" value="2">
                                    <label for="channel2">
                                        FB/Messenger
                                    </label>
                                </div>

                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="channel3" name="channel" value="3">
                                    <label for="channel3">
                                        Kênh khác
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="status">Trạng thái gọi: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status1" name="status" value="1" checked>
                                    <label for="status1" style="margin-right: 10px">
                                        Liên hệ được
                                    </label>
                                </div>

                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status0" name="status" value="0" >
                                    <label for="status0" style="margin-right: 10px">
                                        Không liên hệ được
                                    </label>
                                </div>

                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status2" name="status" value="2">
                                    <label for="status2">
                                        Thông tin liên hệ sai
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" >
                            <label class="col-lg-3 col-form-label" for="note">Ghi chú:</label>
                            <div class="col-lg-9">
                                <textarea type="text" name="note" id="note" class="form-control" rows="2"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="btnSave"><i class="fas fa-save"></i> Lưu thông tin</button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.END modal Add New Record Payment Log -->

@endsection
