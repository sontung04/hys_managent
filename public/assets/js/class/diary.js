$(document).ready(function () {
    /* Tab List Student */
    let modalAddStudentClass = $('#modalAddStudentClass');

    let listRowInputHidden = ['rowInputName', 'rowInputPhone', 'rowInputEmail', 'rowInputEmail', 'rowInputNativeplace'];

    /* set datetimepicker */
    ['birthdayDate', 'starttimeDate', 'finishtimeDate', 'datepaymentDate'].forEach(field => {
        modalAddStudentClass.find('#' +field).datetimepicker({
            format : datetimepicketFormat,
            locale : 'vi',
            useCurrent: false,
            minDate: moment(dateBirthdayHys, datetimepicketFormat),
        });
    });

    //Sự kiện Đóng modal
    modalAddStudentClass.on('click', '.closeModal', function() {
        console.log('close')
        eventCloseHiddenModal(modalAddStudentClass);
        listRowInputHidden.forEach(field => {
            modalAddStudentClass.find('#' + field).attr('hidden', 'hidden');
        });
        modalAddStudentClass.find('#student_code').removeAttr('disabled');
    });

    //Sự kiện Ẩn Modal
    modalAddStudentClass.on('hidden.bs.modal', function() {
        eventCloseHiddenModal(modalAddStudentClass);
        listRowInputHidden.forEach(field => {
            modalAddStudentClass.find('#' + field).attr('hidden', 'hidden');
        });
        modalAddStudentClass.find('#student_code').removeAttr('disabled');
    });

    /* Add new Student to class */
    $('#btnAddStudentClass').on('click', function () {
        document.getElementById('modalAddStudentClassTitle').innerText = 'Thêm học viên mới vào lớp';
        modalAddStudentClass.modal('show');
    });

    //* Edit Info 1 Student of class
    $('#tableListStudentClass').on('click', '.btnEdit', function() {
        document.getElementById('modalAddStudentClassTitle').innerText = 'Chỉnh sửa thông tin học viên';

        let id = $(this).attr('data-id'); //class_student_id
        callAjaxGet(BASE_URL + '/student/class/getInfoAjax/' + id).done(function(res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }
            let studentInfo = res.data;

            listRowInputHidden.forEach(field => {
                modalAddStudentClass.find('#' + field).removeAttr('hidden');
            });

            // /* set field value */
            ['student_id', 'student_code', 'id', 'name', 'phone', 'email', 'birthday', 'native_place',
                'starttime', 'finishtime', 'datepayment', 'course_where', 'desire'].forEach(field => {
                modalAddStudentClass.find('#' + field).val(studentInfo[field]);
            });
            modalAddStudentClass.find('#student_code').attr('disabled', 'disabled');

            switch (changeTypeNumberText(studentInfo['status'])) {
                case 0: modalAddStudentClass.find('#status0').prop('checked', true); break;
                case 1: modalAddStudentClass.find('#status1').prop('checked', true); break;
                case 2: modalAddStudentClass.find('#status2').prop('checked', true); break;
                case 3: modalAddStudentClass.find('#status3').prop('checked', true); break;
            }

            modalAddStudentClass.modal('show');
        });
    });

    /* Validate Form modal Add Student to Class */
    modalAddStudentClass.find('form').validate({
        submitHandler: function() {
            let data = modalAddStudentClass.find('form').serialize();
            let id = modalAddStudentClass.find('#id').val();

            if(id == '') {
                callAjaxPost(BASE_URL + '/student/class/addStudentToClassAjax', data).done(function(res){
                    if (!res.status) {
                        notifyMessage('Lỗi!', res.msg, 'error', 5000);
                        return;
                    }
                    notifyMessage('Thông báo!', res.msg,'success');
                    modalAddStudentClass.modal('hide');
                    setTimeout(function(){ window.location.reload(); }, 1000);
                });
            } else {
                callAjaxPost(BASE_URL + '/student/class/updateInfoAjax', data).done(function(res){
                    if (!res.status) {
                        notifyMessage('Lỗi!', res.msg, 'error', 5000);
                        return;
                    }
                    notifyMessage('Thông báo!', res.msg,'success');
                    modalAddStudentClass.modal('hide');
                    setTimeout(function(){ window.location.reload(); }, 1000);
                });
            }

        },

        rules: {
           student_code: {
                required: true,
            },
            name: {
                required: true,
            },
            birthday: {
                required: true,
            },
            phone: {
                required: true,
            },
            email: {
                required: true,
            },
            starttime: {
                required: true,
            },

        },
        messages: {
            student_code: {
                required: "Mã học viên không được để trống!",
            },
            name: {
                required: "Tên học viên không được để trống!",
            },
            birthday: {
                required: "Ngày sinh học viên không được để trống!",
            },
            phone: {
                required: "Số điện thoại học viên không được để trống!",
            },
            email: {
                required: "Email học viên không được để trống!",
            },
            starttime: {
                required: "Ngày bắt đầu học không được để trống!",
            },
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

    /* Sự kiện Button lấy link điểm danh học viên */
    $('#btnGetLinkRegister').on('click', function () {
        let valUrl = $(this).attr('data-url');
        Swal.fire({
            html:`<div class="input-group">
                  <input type="text" class="form-control" id="inputUrlRegister" value="${valUrl}">
                  <div class="input-group-append">
                    <button class="btn btn-outline-primary" id="btnCopyLinkRegister"><i class="fa-solid fa-copy"></i></button>
                  </div>
                </div>`,
            showConfirmButton: false,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            cancelButtonText: 'Đóng',
            onOpen: () => {
                $("#btnCopyLinkRegister").click(() => {
                    let copyUrl = document.getElementById("inputUrlRegister");

                    // Select the text field
                    copyUrl.select();
                    copyUrl.setSelectionRange(0, 99999); // For mobile devices

                    // Copy the text inside the text field
                    navigator.clipboard.writeText(copyUrl.value);
                });
            }
        })
    });
    /* End Tab List Student */
    /* -------------------------------------------------------------------------------------------------------------- */


    /* Tab Diary Class */
    let diaryClassTable    = $('#diaryClassTable');
    let modalAddStudyClass = $('#modalAddStudyClass');

    /* set select2 */
    $('#lesson_id').select2({
        theme: 'bootstrap4',
        placeholder: "Chọn hoặc thêm bài học mới",
        tags: true,
        // allowClear: true
    });

    $('#coach').select2({
        theme: 'bootstrap4'
    });

    $('#carer_staff').select2({
        theme: 'bootstrap4'
    });
    /* end set select2 */

    /* set datetimepicker daylearnDate */
    modalAddStudyClass.find('#daylearnDate').datetimepicker({
        format : datetimepicketFormat,
        locale : 'vi',
        useCurrent: false,
        minDate: moment(dateBirthdayHys, datetimepicketFormat),
    });

    /* Add new study class */
    $('#btnAddStudyClass').on('click', function () {
        document.getElementById('modalAddStudyClassTitle').innerText = 'Thêm buổi học mới';
        modalAddStudyClass.modal('show');
    });

    /* Update Info study of class */
    diaryClassTable.on('click', '.btnEdit', function() {
        document.getElementById('modalAddStudyClassTitle').innerText = 'Chỉnh sửa thông tin buổi học';

        let id = $(this).attr('data-id');
        callAjaxGet(BASE_URL + '/study/getInfoAjax/' + id).done(function(res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }
            let studyInfo = res.data;

            /* set field value */
            if(studyInfo['lesson_id'] == 0) {
                let $optionSel = $("<option class='otpAddClear' selected='selected'></option>").val(studyInfo['lesson_name']).text(studyInfo['lesson_name']);
                $("#lesson_id").append($optionSel).trigger('change');
            } else {
                $("#lesson_id").val(studyInfo['lesson_id']).trigger('change');
            }
            ['id', 'daylearn', 'location', 'number_eat', 'number_learn', 'description'].forEach(field => {
                modalAddStudyClass.find('#' + field).val(studyInfo[field]);
            });
            modalAddStudyClass.find('#teacher').find(`option[value="${studyInfo['teacher']}"]`).prop('selected', true);

            modalAddStudyClass.find('#coach').val(studyInfo['coach']).trigger('change');
            modalAddStudyClass.find('#carer_staff').val(studyInfo['carer_staff']).trigger('change');

            if(changeTypeNumberText(studyInfo['status'])) {
                modalAddStudentClass.find('#status1').prop('checked', true);
            } else {
                modalAddStudentClass.find('#status2').prop('checked', true);
            }

            modalAddStudyClass.modal('show');
        });
    });

    //Sự kiện Đóng modal Add Study Class
    modalAddStudyClass.on('click', '.closeModal', function() {
        ['lesson_id', 'coach', 'carer_staff'].forEach(field => {
            modalAddStudyClass.find('#' + field).val('').trigger('change');
        });
        $("#lesson_id").find('.otpAddClear').remove();
        eventCloseHiddenModal(modalAddStudyClass, [ 'teacher']);
    });

    //Sự kiện Ẩn Modal Add Study Class
    modalAddStudyClass.on('hidden.bs.modal', function() {
        ['lesson_id', 'coach', 'carer_staff'].forEach(field => {
            modalAddStudyClass.find('#' + field).val('').trigger('change');
        });
        $("#lesson_id").find('.otpAddClear').remove();
        eventCloseHiddenModal(modalAddStudyClass, [ 'teacher']);
    });

    /* Validate select2 */
    $("select").on("select2:close", function (e) {
        $(this).valid();
    });

    /* Validate form modal Add Student to Class */
    modalAddStudyClass.find('form').validate({
        submitHandler: function() {
            let data = modalAddStudyClass.find('form').serialize();

            callAjaxPost(BASE_URL + '/study/saveInfoAjax', data).done(function(res) {
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 3000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg, 'success');
                modalAddStudyClass.modal('hide');
                setTimeout(function() { window.location.reload(); }, 1000);
            });
        },

        rules: {
            lesson_id: {
                required: true,
            },

            teacher: {
                required: true,
            },
            coach: {
                required: true,
            },
            carer_staff: {
                required: true,
            },
            daylearn: {
                required: true,
            }
        },
        messages: {
            lesson_id: {
                required: "Tên Bài học không được để trống!"
            },
            teacher: {
                required: "Tên Giảng viên không được để trống!",
            },
            coach: {
                required: "Trợ giảng lớp không được để trống!"
            },
            carer_staff: {
                required: "Chủ nhiệm lớp không được để trống!"
            },
            daylearn: {
                required: "Ngày học không được để trống!"
            }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    /* --------------------------------------------------------------------------- */

    let modalFeedbackIntern    = $('#modalFeedbackIntern');
    let formFeedbackCoach      = $('#formFeedbackCoach');
    let formFeedbackCarerstaff = $('#formFeedbackCarerstaff');

    //Sự kiện Đóng modal Feedback Intern
    modalFeedbackIntern.on('click', '.closeModal', function() {
        eventCloseHiddenModal(modalFeedbackIntern);
    });

    //Sự kiện Ẩn Modal Feedback Intern
    modalFeedbackIntern.on('hidden.bs.modal', function() {
        eventCloseHiddenModal(modalFeedbackIntern);
    });

    let coachName     = '';
    let coachFeedback = {data: ''};
    let carerstaffName     = '';
    let carerstaffFeedback = {data: ''};
    /* View modal feedback study of Coach and Carer staff */
    diaryClassTable.on('click', '.btnFeedbackIntern', function () {

        let lessonName = $(this).closest("tr").find('.lesson_name').text();
        document.getElementById('modalFeedbackInternTitle').innerHTML= 'Tên bài: ' + lessonName;

        let study_id = $(this).attr('data-id');
        let coach    = $(this).attr('data-coach');
        coachName    = $(this).closest("tr").find('.coach_name').text();

        let carer_staff = $(this).attr('data-carerstaff');
        carerstaffName  = $(this).closest("tr").find('.carerstaff_name').text();

        /* get info feedback Coach */
        callAjaxGet(BASE_URL + '/attendance/getInfoAjax', {study_id: study_id, student_code: coach, student_type: 2})
            .done(function(res) {
                if(res.status) {
                    coachFeedback.data = res.data;

                    formFeedbackCoach.find('#study_id').val(study_id);
                    formFeedbackCoach.find('#student_code').val(coach);
                    document.getElementById('namecoachRow').innerText = coachName;

                    actionAfterCallAjaxFeedbackIntern('coach', formFeedbackCoach, coachFeedback.data);
                }
        });

        /* get info feedback Carer staff */
        callAjaxGet(BASE_URL + '/attendance/getInfoAjax', {study_id: study_id, student_code: carer_staff, student_type: 1})
            .done(function(res) {
                if(res.status) {
                    carerstaffFeedback.data = res.data;

                    formFeedbackCarerstaff.find('#study_id').val(study_id);
                    formFeedbackCarerstaff.find('#student_code').val(carer_staff);
                    document.getElementById('namecarerstaffRow').innerText = carerstaffName;

                    actionAfterCallAjaxFeedbackIntern('carerstaff', formFeedbackCarerstaff, carerstaffFeedback.data);
                }
            });

        modalFeedbackIntern.modal('show');
    });

    /* render code Add, Edit, Submit Feedback Coach */
    codeAddEditSubmitFeedbackIntern('coach', formFeedbackCoach, coachFeedback);

    /* render code Add, Edit, Submit Feedback Carer staff */
    codeAddEditSubmitFeedbackIntern('carerstaff', formFeedbackCarerstaff, carerstaffFeedback);

    /* Sự kiện Button lấy link điểm danh học viên */
    diaryClassTable.on('click', '.btnGetLinkAtten', function () {
        let valUrl = $(this).attr('data-url');
        Swal.fire({
            html:`<div class="input-group">
                  <input type="text" class="form-control" id="inputUrlAtten" value="${valUrl}">
                  <div class="input-group-append">
                    <button class="btn btn-outline-primary btnCopyLinkAtten"><i class="fa-solid fa-copy"></i></button>
                  </div>
                </div>`,
            showConfirmButton: false,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            cancelButtonText: 'Đóng',
            onOpen: () => {
                $(".btnCopyLinkAtten").click(() => {
                    let copyUrl = document.getElementById("inputUrlAtten");

                    // Select the text field
                    copyUrl.select();
                    copyUrl.setSelectionRange(0, 99999); // For mobile devices

                    // Copy the text inside the text field
                    navigator.clipboard.writeText(copyUrl.value);
                });
            }
        })
    });

    /* End Tab Diary Class */
    /* -------------------------------------------------------------------------------------------------------------- */


    /* Tab Attendance Student */
    let modalStudyInfo = $('#modalStudyInfo');
    let modalAttenStudent = $('#modalAttenStudent');

    /* Btn view info study of class */
    $('.btnViewStudyInfo').on('click', function () {
        let studyid = $(this).attr('data-studyid');
        if (studyid == '') {
            notifyMessage('Cảnh báo!', 'Chưa có dữ liệu buổi học!', 'warning', 3000);
            return;
        }

        callAjaxGet(BASE_URL + '/study/getInfoAjax/' + studyid).done(function(res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }
            let studyInfo = res.data;

            /* set field value */
            if(studyInfo['lesson_id'] == 0) {
                modalStudyInfo.find('#lessonRow').html(studyInfo['lesson_name']);
            } else {
                modalStudyInfo.find('#lessonRow').html(listLesson[studyInfo['lesson_id']]['name']);
            }

            modalStudyInfo.find('#teacherRow').html(listTeacher[studyInfo['teacher']]);

            [ 'coach_name', 'carer_staff_name', 'daylearn', 'location', 'description'].forEach(field => {
                modalStudyInfo.find('#' + field + 'Row').html(studyInfo[field]);
            });
            modalStudyInfo.find('#numberStudentRow').html(studyInfo['number_eat'] + '/' + studyInfo['number_learn']);
            if(changeTypeNumberText(studyInfo['status'])) {
                modalStudyInfo.find('#statusRow').html('Offline');
            } else {
                modalStudyInfo.find('#statusRow').html('Online');
            }

            modalStudyInfo.modal('show');
        });

    });


    let htmlSelStatusAtten = '<select class="form-control custom-select" name="status" id="status">\n' +
            '<option value="" selected disabled>--- Chọn trạng thái ---</option>\n' +
            '<option value="0">Nghỉ học</option>\n' +
            '<option value="1">Đi học</option>\n' +
            '<option value="2">Đi học muộn</option>\n' +
            '<option value="3">Học bù</option>\n' +
            '</select>';
    let attenInfo = '';

    /* Btn view, create, update info attendance student of study */
    $('.btnAttenUpdate').on('click', function () {
        let id           = $(this).attr('data-id');
        let study_id     = $(this).attr('data-studyid');
        let lesson_id    = $(this).attr('data-lessonid');
        let teacher_id   = $(this).attr('data-teacher');
        let student_code = $(this).closest("tr").attr('data-studentcode');
        let student_name = $(this).closest("tr").find('.studentNameVal').text();

        modalAttenStudent.find('#student_code').val(student_code);
        modalAttenStudent.find('#study_id').val(study_id);

        if(lesson_id == 0) {
            modalAttenStudent.find('#lessonNameRow').html($(this).attr('data-lessonname'));
        } else {
            modalAttenStudent.find('#lessonNameRow').html(listLesson[lesson_id]['name']);
        }
        modalAttenStudent.find('#teacherRow').html(listTeacher[teacher_id]);
        modalAttenStudent.find('#studentNameRow').html(student_name);

        if (id == '') {

            ['feedback', 'question', 'comment'].forEach(field => {
                modalAttenStudent.find('#' + field + 'Div').attr('hidden', 'hidden');
            });
            modalAttenStudent.find('#statusRow').html(htmlSelStatusAtten);
            modalAttenStudent.find('#noteRow').html('<textarea ' +
                'type="text" name="note" id="note" class="form-control" rows="3"></textarea>');

            modalAttenStudent.find('#btnUpdateAtten').attr('hidden', 'hidden');
            modalAttenStudent.find('#btnSave').removeAttr('hidden');

            modalAttenStudent.modal('show');
            return;
        }

        callAjaxGet(BASE_URL + '/attendance/getInfoAjax', {id: id}).done(function(res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }
            attenInfo = res.data;

            /* set field value */
            ['feedback', 'question', 'comment'].forEach(field => {
                modalAttenStudent.find('#' + field + 'Div').removeAttr('hidden');
                modalAttenStudent.find('#' + field + 'Row').text(attenInfo[field]);
            });

            modalAttenStudent.find('#id').val(attenInfo['id']);
            modalAttenStudent.find('#noteRow').text(attenInfo['note']);
            modalAttenStudent.find('#status').attr('hidden', 'hidden');

            switch (changeTypeNumberText(attenInfo['status'])){
                case 0: modalAttenStudent.find('#statusRow').text('Nghỉ học'); break;
                case 1: modalAttenStudent.find('#statusRow').text('Đi học'); break;
                case 2: modalAttenStudent.find('#statusRow').text('Đi học muộn'); break;
                case 3: modalAttenStudent.find('#statusRow').text('Học bù'); break;
            }

            modalAttenStudent.find('#btnUpdateAtten').removeAttr('hidden');
            modalAttenStudent.find('#btnSave').attr('hidden', 'hidden');

            modalAttenStudent.modal('show');
        });

    });

    //Sự kiện update phần điểm danh học viên
    $('#btnUpdateAtten').on('click', function () {
        modalAttenStudent.find('#btnUpdateAtten').attr('hidden', 'hidden');
        modalAttenStudent.find('#btnSave').removeAttr('hidden');

        modalAttenStudent.find('#statusRow').html(htmlSelStatusAtten);
        modalAttenStudent.find('#noteRow').html('<textarea ' +
            'type="text" name="note" id="note" class="form-control" rows="3"></textarea>');

        modalAttenStudent.find('#status').find(`option[value="${attenInfo['status']}"]`).prop('selected', true);
        modalAttenStudent.find('#note').val(attenInfo['note']);

        ['feedback', 'question', 'comment'].forEach(field => {
            modalAttenStudent.find('#' + field + 'Div').attr('hidden', 'hidden');
        });
    })

    //Sự kiện Đóng modal Attendance Student
    modalAttenStudent.on('click', '.closeModal', function() {
        eventCloseHiddenModal(modalAttenStudent, ['status']);
    });

    //Sự kiện Ẩn Modal Attendance Student
    modalAttenStudent.on('hidden.bs.modal', function() {
        eventCloseHiddenModal(modalAttenStudent, ['status']);
    });

    //Submit form và validate form
    modalAttenStudent.find('form').validate({
        submitHandler: function () {

            let data = modalAttenStudent.find('form').serialize();

            callAjaxPost(BASE_URL + '/attendance/saveInfoAjax', data).done(function(res) {
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 5000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg,'success');

                modalAttenStudent.modal('hide');

                setTimeout(function(){
                    window.location.reload();
                }, 1000);
            });
        },

        rules: {
            status: {
                required: true,
            },
        },
        messages: {
            status: {
                required: 'Vui lòng chọn trạng thái!',
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    /* End Tab Attendance Student */
    /* -------------------------------------------------------------------------------------------------------------- */


    /* Function xử lý code sau khi gọi Ajax lấy ra feedback của TTS */
    function actionAfterCallAjaxFeedbackIntern(intern, form, dataFeedback)
    {
        $('#' + intern + 'BtnSave').attr('hidden', 'hidden');

        if(dataFeedback == '') {
            $('#' + intern + 'NoFeedback').removeAttr('hidden');
            $('#' + intern + 'BtnAdd').removeAttr('hidden');
            form.find('.card-body').attr('hidden', 'hidden');
            $('#' + intern + 'BtnEdit').attr('hidden', 'hidden');
        } else {
            $('#' + intern + 'NoFeedback').attr('hidden', 'hidden');
            $('#' + intern + 'BtnAdd').attr('hidden', 'hidden');
            form.find('.card-body').removeAttr('hidden');
            $('#' + intern + 'BtnEdit').removeAttr('hidden');

            ['name', 'note', 'feedback', 'question', 'comment'].forEach(field => {
                document.getElementById(field + intern +'Row').innerText = dataFeedback[field];
            });
            form.find('#id').val(dataFeedback['id']);
        }
    }

    /* Function render code các tính năng Add, Edit, Submit form Feedback TTS */
    function codeAddEditSubmitFeedbackIntern(intern, form, dataFeedback) {

        $('#' + intern + 'BtnAdd').on('click', function () {

            ['note', 'feedback', 'question', 'comment'].forEach(field => {
                document.getElementById(field + intern + 'Row').innerHTML =
                    `<textarea type="text" name="${field}" id="${field}" class="form-control" rows="2"></textarea>`;
            });
            $('#' + intern + 'NoFeedback').attr('hidden', 'hidden');
            $('#' + intern + 'BtnAdd').attr('hidden', 'hidden');
            form.find('.card-body').removeAttr('hidden');
            $('#' + intern + 'BtnSave').removeAttr('hidden');
        });

        $('#' + intern + 'BtnEdit').on('click', function () {
            ['note', 'feedback', 'question', 'comment'].forEach(field => {
                if(dataFeedback.data[field] == null) dataFeedback.data[field] = '';
                document.getElementById(field + intern + 'Row').innerHTML =
                    `<textarea type="text" name="${field}" id="${field}" class="form-control" rows="2">${dataFeedback.data[field]}</textarea>`;
            });
            $('#' + intern + 'BtnEdit').attr('hidden', 'hidden');
            $('#' + intern + 'BtnSave').removeAttr('hidden');
        });

        form.on('submit', function (e) {
            e.preventDefault();

            let data = form.serialize();

            callAjaxPost(BASE_URL + '/attendance/saveInfoAjax', data).done(function(res) {
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 3000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg, 'success');
                dataFeedback.data = res.data;

                ['note', 'feedback', 'question', 'comment'].forEach(field => {
                    document.getElementById(field + intern + 'Row').innerText = dataFeedback.data[field];
                });
                form.find('#id').val(dataFeedback.data['id']);
                $('#' + intern + 'BtnEdit').removeAttr('hidden');
                $('#' + intern + 'BtnSave').attr('hidden', 'hidden');
            });
        });
    }
});
