@extends('layouts.sidebar')

@section('style')

    <link rel="stylesheet" href="{{ asset('themes/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/class/diary.css') }}">
@endsection

@section('script')
    <script type="text/javascript">
        let listTeacher = <?php echo isset($listTeacher) ? json_encode($listTeacher) : '{}'; ?>;
        let listLesson  = <?php echo isset($listLesson) ? json_encode($listLesson) : '{}'; ?>;
    </script>
    <script src="{{ asset('themes/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/class/diary.js') }}" defer></script>
@endsection

@section('content')

    <?php
        function showHtmlAttenStatus($studyData, $empty = true, $data = []) {
            $iconList = [
                'empty' => '<i class="fa-solid fa-minus text-black-50"></i>',
                0 => '<i class="fa fa-close text-danger"></i>',
                1 => '<i class="fa fa-check text-success"></i>',
                2 => '<i class="fa-regular fa-clock text-warning"></i>',
                3 => '<i class="fa-solid fa-exclamation text-blue"></i>',
            ];

            $statusList = [
                0 => 'Nghỉ học',
                1 => 'Đi học',
                2 => 'Đi học muộn',
                3 => 'Học bù',
            ];

            echo '<td style="text-align: center; vertical-align: middle">';
            echo '<a href="javascript:void(0);" class="btnAttenUpdate" data-html="true" data-toggle="popover"
                        data-trigger="hover" data-placement="right" ';
            echo 'data-studyid="' . $studyData->id . '" ';
            echo 'data-lessonid="' . $studyData->lesson_id . '" ';
            echo 'data-lessonname="' . $studyData->lesson_name . '" ';
            echo 'data-teacher="' . $studyData->teacher . '" ';
            echo 'data-content="';
            if($empty) {
                echo 'Học viên chưa điểm danh!';
                echo '" data-id="" >';
                echo $iconList['empty'];
                echo '</a></td>';
                return;
            }

            echo '<div><b>Trạng thái: </b>';
            echo $statusList[$data['status']];
            echo '<br> <b>Ghi chú: </b>';
            echo $data['note'];
            echo '</div>';
            echo '" ';
            echo 'data-id="' . $data['id'] . '" >';
            echo $iconList[$data['status']];
            echo '</a></td>';
        }
    ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{$class->name}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Nhật ký lớp học</li>
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

                            <!-- card-header -->
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
                                                 src="{{asset($class->coach_img)}}" >
                                            <span class="username">
                                                <a href="#">{{$class->coach_name}}</a>
                                            </span>
                                            <span class="description" style="font-size: 16px"><strong> Trợ giảng </strong></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="user-block float-right mr-3">
                                            <img class="img-circle img-bordered-sm" alt="user image"
                                                 src="{{asset($class->carer_staff_img)}}" >
                                            <span class="username">
                                                <a href="#">{{$class->carer_staff_name}}</a>
                                            </span>
                                            <span class="description" style="font-size: 16px"><strong> Chủ Nhiệm </strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->

                            <!-- card-body -->
                            <div class="card-body">
                                <div class="tab-content">

                                    {{-- Tab List Student: Danh sách học viên của lớp --}}
                                    <div class="tab-pane active" id="listStudentClass">
                                        <div class="row">
                                            <div class="col-md-12" style="text-align: right">
                                                <a class="btn btn-info text-white mr-2" id="btnGetLinkRegister"
                                                   data-url="{{url('') . '/form/class/register/' . base64_encode('class' . $class->id)}}" >
                                                    <i class="fa-solid fa-pen-nib"></i>
                                                    Lấy link đăng ký lớp
                                                </a>
                                                <a class="btn btn-success text-white" id="btnAddStudentClass">
                                                    <i class="fa-solid fa-user-plus"></i>
                                                    Thêm học viên
                                                </a>
                                            </div>
                                        </div>

                                        <br>

                                        <table class="table table-bordered table-striped" id="tableListStudentClass">
                                            <thead>
                                            <tr style="text-align: center">
                                                <th style="width: 15%">Học viên</th>
                                                <th style="width: 5%">Mã</th>
                                                <th style="width: 6%">SĐT</th>
                                                <th>Email</th>
                                                <th style="width: 6%">Ngày sinh</th>
                                                <th style="width: 15%">Quê quán</th>
                                                <th style="width: 9%">Trạng thái</th>
                                                <th style="width: 15%">Biết tới khóa học từ</th>
                                                <th style="width: 15%">Mong muốn khi học</th>
                                                <th style="width: 3%"></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @forelse($listStudent as $student)
                                                <tr>
                                                    <td class="setMinWidth">
                                                        <img src="{{!empty($student->img) ? asset($student->img) : asset(config('app.avatarDefault'))}}"
                                                             alt="Product 1" class="img-circle img-size-32 mr-2">
                                                        {{$student->name}}
                                                    </td>
                                                    <td style="text-align: center">{{$student->code}}</td>
                                                    <td style="text-align: center;">{{$student->phone}}</td>
                                                    <td class="cell-table-scroll" style="max-width: 210px">{{$student->email}}</td>
                                                    <td style="text-align: center">{{date('d/m/Y', strtotime($student->birthday))}}</td>
                                                    <td class="cell-table-scroll setMinWidth" style="max-width: 225px">{{$student->native_place}}</td>

                                                    <th style="text-align: center">
                                                        <span style="color:@if($student->status == 1 || $student->status == 2) green @else red @endif;">
                                                            {{$studentClassStatus[$student->status]}}
                                                        </span>
                                                    </th>
                                                    <td class="cell-table-scroll setMinWidth" style="max-width: 240px">{{$student->course_where}}</td>
                                                    <td class="cell-table-scroll setMinWidth" style="max-width: 240px">{{$student->desire}}</td>
                                                    <td style="text-align: center">
                                                        <button type="button" class="btn btn-outline-success btnEdit" data-id="{{$student->csid}}"
                                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <th colspan="10" style="text-align: center">Chưa có học viên tham gia lớp!</th>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- End Tab List Student --}}

                                    {{-- Tab Diary Class: Nhật ký lớp học --}}
                                    <div class="tab-pane" id="diaryClass">
                                        <a class="btn btn-success text-white float-right" id="btnAddStudyClass">
                                            <i class="fa-solid fa-folder-plus"></i>
                                            Thêm buổi học
                                        </a>

                                        <br>
                                        <br>

                                        <table class="table table-bordered table-striped" id="diaryClassTable">
                                            <thead>
                                            <tr>
                                                <th style="width: 3%">Buổi</th>
                                                <th>Tên bài học</th>
                                                <th>Giảng viên</th>
                                                <th>Trợ giảng</th>
                                                <th>Chủ nhiệm</th>
                                                <th>Ngày học</th>
                                                <th>Địa điểm</th>
                                                <th style="width: 10%">Số học viên <br>(Dùng bữa/Đi học)</th>
                                                <th style="width: 10%">Hành động</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $indexStudy = 0; ?>
                                            @forelse($listStudy as $study)
                                                <tr>
                                                    <td style="text-align: center">{{++$indexStudy}}</td>
                                                    <td class="lesson_name">
                                                        @if($study->lesson_id == 0)
                                                            {{$study->lesson_name}}
                                                        @else
                                                            {{$listLesson[$study->lesson_id]['name']}}
                                                        @endif
                                                    </td>
                                                    <td>{{$listTeacher[$study->teacher]}}</td>
                                                    <td class="coach_name">{{$study->coach_name}}</td>
                                                    <td class="carerstaff_name">{{$study->carer_staff_name}}</td>
                                                    <td style="text-align: center">
                                                        @if(!empty($study->daylearn))
                                                            {{date('d/m/Y', strtotime($study->daylearn))}}
                                                        @endif
                                                    </td>
                                                    <td>{{$study->location}}</td>
                                                    <td style="text-align: center">{{$study->number_eat . '/' . $study->number_learn}}</td>
                                                    <td style="text-align: center">
                                                        <button type="button" class="btn btn-outline-info btnFeedbackIntern"
                                                                data-id="{{$study->id}}" data-coach="{{$study->coach}}" data-carerstaff="{{$study->carer_staff}}"
                                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Nhận xét buổi học">
                                                            <i class="fas fa-comment"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-success btnEdit" data-id="{{$study->id}}"
                                                                data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Chỉnh sửa">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-primary btnGetLinkAtten" data-toggle="popover"
                                                                data-trigger="hover" data-placement="bottom" data-content="Lấy link điểm danh"
                                                                data-url="{{url('') . '/form/attendance/student/' . base64_encode('study' . $study->id)}}" >
                                                            <i class="fa-solid fa-clipboard-user"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <th colspan="9" style="text-align: center">Chưa có dữ liệu buổi học!</th>
                                                </tr>
                                            @endforelse
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
                                                    if(count($listStudy) < $class->length) {
                                                        $classLength = $class->length;
                                                    } else {
                                                        $classLength = count($listStudy);
                                                    }
                                                    for ($i = 0; $i < $classLength; $i++) {

                                                        $textHtml = '<td style="text-align: center">';
                                                        $textHtml .= 'Buổi ' . ($i + 1);
                                                        $textHtml .= '<a href="javascript:void(0);" class="btnViewStudyInfo"
                                                            data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                            data-content="Xem thông tin buổi học"  data-studyid="';
                                                        if(isset($listStudy[$i])) {
                                                            $textHtml .= $listStudy[$i]->id;
                                                        }
                                                        $textHtml .= '">';
                                                        $textHtml .= ' <i class="fa-regular fa-eye"></i>';
                                                        $textHtml .= '</a></td>';

                                                        echo $textHtml;
                                                    }
                                                    ?>


                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($listStuAtten as $key => $stuAtten)
                                                    <tr data-studentcode="{{$key}}">
                                                        <td>
                                                            <img src="{{asset($stuAtten['img'])}}" alt="Product 1" class="img-circle img-size-32 mr-2">
                                                            <span class="studentNameVal">{{$stuAtten['name']}}</span>
                                                        </td>
                                                        <?php
                                                        for ($i = 0; $i < $classLength; $i++) {
                                                            if(!isset($listStudy[$i])) {
                                                                echo '<td></td>';
                                                            } elseif (!$stuAtten['inClass'] && !isset($stuAtten['atten'][$listStudy[$i]->id])) {
                                                                echo '<td></td>';
                                                            } else {
                                                                if(!isset($stuAtten['atten'][$listStudy[$i]->id])) {
                                                                    showHtmlAttenStatus($listStudy[$i]);
                                                                } else {
                                                                    showHtmlAttenStatus($listStudy[$i], false, $stuAtten['atten'][$listStudy[$i]->id]);
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </tr>
                                                @endforeach
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

    <!------------------------------------- The List Modal Tab List Student ------------------------------------------->
    <!-- The Modal Add New Student To Class Tab List Student-->
    <div class="modal fade" id="modalAddStudentClass">
        <div class="modal-dialog modal-lg" style="width: 50%; max-width: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddStudentClassTitle">Modal default</h4>
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="formAddStudentClass" class="form-horizontal" method="post">
                @csrf
                <!-- Change students status in class -->
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control" name="id">
                        <input type="hidden" name="student_id" id="student_id" class="form-control">
                        <input type="hidden" name="class_id" value="{{$class->id}}" >
                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="student_code"> Mã học viên:  <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="text" name="student_code" id="student_code" class="form-control">
                            </div>
                        </div>

                        <div class="row" id="rowInputName" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="name"> Tên học viên:  <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>

                        <div class="row" id="rowInputBirthday" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="birthday"> Ngày sinh: </label>
                            <div class="col-sm-9">
                                <div class="form-group input-group date" id="birthdayDate" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#birthdayDate" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="birthday" name="birthday"
                                           data-target="#birthdayDate" data-toggle="datetimepicker" />
                                </div>
                            </div>
                        </div>

                        <div class="row" id="rowInputPhone" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="phone"> SĐT học viên:  <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="number" name="phone" id="phone" class="form-control">
                            </div>
                        </div>

                        <div class="row" id="rowInputEmail" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="email"> Email học viên:  <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                        </div>

                        <div class="row" id="rowInputNativeplace" hidden="hidden">
                            <label class="col-lg-3 col-form-label" for="native_place"> Quê quán: </label>
                            <div class="form-group col-lg-9">
                                <textarea type="text" name="native_place" id="native_place" class="form-control" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="starttime"> Ngày bắt đầu học:  <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="form-group input-group date" id="starttimeDate" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#starttimeDate" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="starttime" name="starttime"
                                           data-target="#starttimeDate" data-toggle="datetimepicker" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="finishtime"> Ngày kết thúc: </label>
                            <div class="col-sm-9">
                                <div class="form-group input-group date" id="finishtimeDate" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#finishtimeDate" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="finishtime" name="finishtime"
                                           data-target="#finishtimeDate" data-toggle="datetimepicker" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="notr"> Ghi chú: </label>
                            <div class="form-group col-lg-9">
                                <input type="text" name="note" id="note" class="form-control">
                            </div>
                        </div>

                        <div class="row" >
                            <label class="col-lg-3 col-form-label" for="status">Trạng thái: </label>
                            <div class="form-group col-lg-9">

                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status0" name="status" value="0">
                                    <label for="status0" style="margin-right: 10px">
                                        Nghỉ học
                                    </label>
                                </div>

                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status1" name="status" value="1" checked>
                                    <label for="status1" style="margin-right: 10px">
                                        Đang học
                                    </label>
                                </div>

                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status2" name="status" value="2">
                                    <label for="status2">
                                        Đã hoàn thành
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status3" name="status" value="3">
                                    <label for="status3">
                                        Bảo lưu
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="rowInputCoursewhere">
                            <label class="col-lg-3 col-form-label" for="course_where"> Biết đến khóa học từ: </label>
                            <div class="form-group col-lg-9">
                                <textarea type="text" name="course_where" id="course_where" class="form-control" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="row" id="rowInputDesire">
                            <label class="col-lg-3 col-form-label" for="desire"> Mong muốn khi học: </label>
                            <div class="form-group col-lg-9">
                                <textarea type="text" name="desire" id="desire" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-default closeModal " data-dismiss="modal" >Đóng</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu thông tin </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End Modal Add New Student To Class Tab List Student -->
    <!-------------------------------------- End List Modal Tab List Student ------------------------------------------>


    <!------------------------------------- The List Modal Tab Diary Class -------------------------------------------->
    <!-- The Modal Add New, Edit Info Study of Class -->
    <div class="modal fade" id="modalAddStudyClass">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddStudyClassTitle">Modal default</h4>
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="" class="form-horizontal" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control" name="id">
                        <input type="hidden" name="class_id" value="{{$class->id}}">

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="lesson_id"> Tên bài học: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select" name="lesson_id" id="lesson_id">
                                    <option value=""></option>
                                    @foreach($listLesson as $key => $value)
                                        <option value="{{$key}}">{{$value['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="teacher_id"> Giảng viên: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <select class="form-control custom-select" name="teacher" id="teacher">
                                    <option value="" selected>--- Chọn Giảng viên ---</option>
                                    @foreach($listTeacher as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="coach"> Trợ giảng: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="number" name="coach" id="coach" class="form-control" placeholder="Nhập mã TTS Trợ giảng lớp">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="carer_staff"> Chủ nhiệm: <span class="text-danger">*</span></label>
                            <div class="form-group col-lg-9">
                                <input type="number" name="carer_staff" id="carer_staff" class="form-control" placeholder="Nhập mã TTS Chủ nhiệm lớp">
                            </div>
                        </div>

                        <div class="row">
                            <label for="daylearn" class="col-sm-3"> Ngày học: <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="form-group input-group date" id="daylearnDate" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#daylearnDate" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" id="daylearn" name="daylearn"
                                           data-target="#daylearnDate" data-toggle="datetimepicker" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="status">Hình thức học: </label>
                            <div class="form-group col-lg-9">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status1" name="status" value="1" checked>
                                    <label for="status1" style="margin-right: 10px">
                                        Offline
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="status2" name="status" value="0">
                                    <label for="status2">
                                        Online
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-4 col-form-label" for=""> Số học viên (Dùng bữa/Đi học): </label>
                            <div class="form-group col-lg-4">
                                <input type="number" name="number_eat" id="number_eat" class="form-control" placeholder="Số HV dùng bữa">
                            </div>
                            <div class="form-group col-lg-4">
                                <input type="number" name="number_learn" id="number_learn" class="form-control" placeholder="Số HV đi học">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="location"> Địa điểm học: </label>
                            <div class="form-group col-lg-9">
                                <input type="text" name="location" id="location" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-3 col-form-label" for="description"> Ghi chú: </label>
                            <div class="form-group col-lg-9">
                                <textarea type="text" name="description" id="description" class="form-control" rows="2"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-default closeModal" data-dismiss="modal" >Đóng</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu thông tin </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End Modal Add New, Edit Info Study of Class -->

    <!-- The Modal Feedback Coach Study Tab Diary Class-->
    <div class="modal fade" id="modalFeedbackIntern">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modalFeedbackInternTitle"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <!-- Feedback of Coach -->
                    <div class="card">
                        <div class="card-header" style="text-align: center">
                            <b> Nhận xét của Trợ giảng </b>
                        </div>

                        <h5 style="text-align: center; padding: 10px" id="coachNoFeedback" hidden="hidden">Chưa có nhận xét nào!</h5>

                        <form action="" id="formFeedbackCoach" class="form-horizontal" method="post">
                            @csrf
                            <input type="hidden" id="id" name="id" class="form-control">
                            <input type="hidden" id="study_id" name="study_id" class="form-control">
                            <input type="hidden" id="student_code" name="student_code" class="form-control">
                            <input type="hidden" id="student_type" name="student_type" value="2">
                            <div class="card-body">
                                <div class="row">
                                    <label class="col-lg-3" for="name" id=""> Tên Trợ giảng: </label>
                                    <div class="col-lg-9 form-group" id="namecoachRow">

                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3" for="name" id=""> Ghi chú về buổi học: </label>
                                    <div class="col-lg-9 form-group" id="notecoachRow">

                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3" for="name" id=""> Nhận xét về buổi học: </label>
                                    <div class="col-lg-9 form-group" id="feedbackcoachRow">

                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3" for="name" id=""> Câu hỏi, thắc mắc cần được tư vấn thêm: </label>
                                    <div class="col-lg-9 form-group" id="questioncoachRow">

                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3" for="name" id=""> Ý kiến đóng góp cho CiT: </label>
                                    <div class="col-lg-9 form-group" id="commentcoachRow">

                                    </div>
                                </div>

                            </div>
                            <div class="card-footer" style="text-align: right">
                                <button type="button" class="btn btn-primary" id="coachBtnAdd"><i class="fa-sharp fa-solid fa-comment-medical"></i> Thêm nhận xét </button>
                                <button type="button" class="btn btn-primary" id="coachBtnEdit"><i class="far fa-edit"></i> Chỉnh sửa </button>
                                <div id="coachBtnSave" hidden="hidden">
                                    <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu thông tin </button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- End Feedback of Coach -->

                    <!-- Feedback of Carer_staff -->
                    <div class="card">
                        <div class="card-header" style="text-align: center">
                            <b> Nhận xét của Chủ Nhiệm </b>
                        </div>

                        <h5 style="text-align: center; padding: 10px" id="carerstaffNoFeedback" hidden="hidden">Chưa có nhận xét nào!</h5>

                        <form action="" id="formFeedbackCarerstaff" class="form-horizontal" method="post">
                            @csrf
                            <input type="hidden" id="id" name="id" class="form-control">
                            <input type="hidden" id="study_id" name="study_id" class="form-control">
                            <input type="hidden" id="student_code" name="student_code" class="form-control">
                            <input type="hidden" id="student_type" name="student_type" value="1">
                            <div class="card-body">
                                <div class="row">
                                    <label class="col-lg-3" for="name" id=""> Tên Chủ Nhiệm: </label>
                                    <div class="col-lg-9 form-group" id="namecarerstaffRow">

                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3" for="name" id=""> Ghi chú về buổi học: </label>
                                    <div class="col-lg-9 form-group" id="notecarerstaffRow">

                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3" for="name" id=""> Nhận xét về buổi học: </label>
                                    <div class="col-lg-9 form-group" id="feedbackcarerstaffRow">

                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3" for="name" id=""> Câu hỏi, thắc mắc cần được tư vấn thêm: </label>
                                    <div class="col-lg-9 form-group" id="questioncarerstaffRow">

                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-lg-3" for="name" id=""> Ý kiến đóng góp cho CiT: </label>
                                    <div class="col-lg-9 form-group" id="commentcarerstaffRow">

                                    </div>
                                </div>

                            </div>
                            <div class="card-footer" style="text-align: right">
                                <button type="button" class="btn btn-primary" id="carerstaffBtnAdd"><i class="fa-sharp fa-solid fa-comment-medical"></i> Thêm nhận xét </button>
                                <button type="button" class="btn btn-primary" id="carerstaffBtnEdit"><i class="far fa-edit"></i> Chỉnh sửa </button>
                                <div id="carerstaffBtnSave" hidden="hidden">
                                    <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu thông tin </button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- End Feedback of Carer_staff -->

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                </div>


            </div>
        </div>
    </div>
    <!-- End Modal Feedback Coach Study -->
    <!-------------------------------------- End List Modal Tab Diary Class ------------------------------------------->


    <!---------------------------------- The List Modal Tab Attendance Student ---------------------------------------->
    <!-- The Modal Study Info Tab Attendance Student-->
    <div class="modal fade" id="modalStudyInfo">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="">Thông tin buổi học</h4>
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" id="" class="form-horizontal" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-lg-2 col-form-label" for="lesson_name" id=""> Tên bài học <span style="float: right">:</span> </label>
                            <div class="col-form-label col-lg-10" id="lessonRow">

                            </div>
                        </div>
                        <div class="row">
                            <label class="col-lg-2 col-form-label" for="teacher">Giảng viên <span style="float: right">:</span> </label>
                            <div class="col-form-label col-lg-10" id="teacherRow">

                            </div>
                        </div>
                        <div class="row">
                            <label class="col-lg-2 col-form-label" for="coach">Trợ giảng <span style="float: right">:</span> </label>
                            <div class="col-form-label col-lg-10" id="coach_nameRow">

                            </div>

                        </div>
                        <div class="row" >
                            <label class="col-lg-2 col-form-label" for="carer_staff">Chủ nhiệm <span style="float: right">:</span> </label>
                            <div class="col-form-label col-lg-10" id="carer_staff_nameRow">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-2 col-form-label" for="daylearn">Ngày học <span style="float: right">:</span> </label>
                            <div class="col-form-label col-lg-4" id="daylearnRow">

                            </div>

                            <label class="col-lg-2 col-form-label" for="status">Hình thức học <span style="float: right">:</span> </label>
                            <div class="col-form-label col-lg-4" id="statusRow">

                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-4 col-form-label" for="status">Số học viên (Dùng bữa/Đi học) <span style="float: right">:</span> </label>
                            <div class="col-form-label col-lg-8" id="numberStudentRow">

                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-2 col-form-label" for="status">Địa điểm học <span style="float: right">:</span> </label>
                            <div class="col-form-label col-lg-10" id="locationRow">

                            </div>
                        </div>

                        <div class="row">
                            <label class="col-lg-2 col-form-label" for="status">Ghi chú <span style="float: right">:</span> </label>
                            <div class="col-form-label col-lg-10" id="descriptionRow">

                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
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
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input type="hidden" id="student_type" name="student_type" value="0">
                        <input type="hidden" id="student_code" name="student_code" class="form-control">
                        <input type="hidden" id="study_id" name="study_id" class="form-control">
                        <div class="row">
                            <label class="col-form-label col-lg-3" for="lessonNameRow" id=""> Tên bài học: </label>
                            <div class="col-form-label col-lg-9" id="lessonNameRow">

                            </div>
                        </div>

                        <div class="row">
                            <label class="col-form-label col-lg-3" for="teacherRow" > Giảng viên: </label>
                            <div class="col-form-label col-lg-9" id="teacherRow">

                            </div>
                        </div>

                        <div class=" row">
                            <label class="col-form-label col-lg-3" for="studentNameRow">Tên học viên: </label>
                            <div class="col-form-label col-lg-9" id="studentNameRow">

                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <label class="col-lg-3" for="status">Trạng thái: </label>
                            <div class="form-group col-lg-9" id="statusRow">
                                <select class="form-control custom-select" name="status" id="status">
                                    <option value="" selected disabled>--- Chọn trạng thái ---</option>
                                    <option value="0">Nghỉ học</option>
                                    <option value="1">Đi học</option>
                                    <option value="2">Đi học muộn</option>
                                    <option value="3">Học bù</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" >
                            <label class="col-lg-3 col-form-label" for="note">Ghi chú:</label>
                            <div class="col-lg-9" id="noteRow">
                                <textarea type="text" name="note" id="note" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row" id="feedbackDiv" hidden="hidden">
                            <label class="col-lg-3" for="note">Cảm nhận:</label>
                            <div class="col-lg-9" id="feedbackRow">

                            </div>
                        </div>

                        <div class="row" id="questionDiv" hidden="hidden">
                            <label class="col-lg-3" for="note">Câu hỏi:</label>
                            <div class="col-lg-9" id="questionRow">

                            </div>
                        </div>

                        <div class="row" id="commentDiv" hidden="hidden">
                            <label class="col-lg-3 " for="note">Góp ý:</label>
                            <div class="col-lg-9" id="commentRow">
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" id="btnUpdateAtten" hidden="hidden">
                            <i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa </button>
                        <button type="submit" class="btn btn-primary" id="btnSave"><i class="fas fa-save"></i> Lưu thông tin </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End Modal Attendance Student -->
    <!------------------------------------- End List Modal Tab Attendance Student ------------------------------------>

@endsection
