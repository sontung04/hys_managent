$(function() {
    'use strict'

    /* set ckeditor */
    // CKEDITOR.replace('description');

    let modalAddStudent = $('#modalAddStudent');

    let formFilterStudent = $('#formFilterStudent');

    let modalAddIntern = $('#modalAddIntern');

    let inputBirthday = modalAddStudent.find('#birthday');

    /* set datetimepicker */
    ['birthdayDate', 'birthdayFather', 'birthdayMother', 'issueDate'].forEach(field => {
        modalAddStudent.find('#' +field).datetimepicker({
            format : datetimepicketFormat,
            locale : 'vi',
            useCurrent: false,
            minDate: moment(inputBirthday.data('min'), datetimepicketFormat),
            maxDate: moment(currentMaxDate, datetimepicketFormat),
        });
    });

    ['starttimeDate', 'finishtimeDate'].forEach(field => {
        modalAddIntern.find('#' +field).datetimepicker({
            format : datetimepicketFormat,
            locale : 'vi',
            useCurrent: false,
            // minDate: moment(inputBirthday.data('min'), datetimepicketFormat),
            // maxDate: moment(currentMaxDate, datetimepicketFormat),
        });
    });

    //* Add new Student
    $('#btnAddStudent').click(function() {
        document.getElementById('modalAddStudentTitle').innerText = 'Thêm Học viên mới ';
        modalAddStudent.modal('show');
    });

    //* Edit Info 1 Student
    $('#tableStudentList').on('click', '.btnEdit', function() {
        document.getElementById('modalAddStudentTitle').innerText = 'Chỉnh sửa thông tin Học viên';

        let id = $(this).attr('data-id');
        callAjaxGet(BASE_URL + '/student/getInfoAjax/' + id).done(function(res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }
            let studentInfo = res.data;

            /* set field value */
            ['id', 'name', 'birthday', 'email', 'phone', 'facebook', 'native_place', 'address', 'school', 'major',
                'guardian_name', 'guardian_phone', 'father', 'father_job', 'father_birthday', 'mother', 'mother_birthday', 'mother_job',
                'course_where', 'place_of_issue', 'date_of_issue', 'citizen_identify',
                'religion', 'nation',  'level', 'job', 'position', 'desire',].forEach(field => {
                modalAddStudent.find('#' + field).val(studentInfo[field]);
            });


            if (studentInfo['gender']) {
                modalAddStudent.find('#gender1').prop('checked', true);
            } else {
                modalAddStudent.find('#gender2').prop('checked', true);
            }

            modalAddStudent.modal('show');
        });
    });

    //Sự kiện Đóng modal
    $('.closeModal').on('click', function() {
        eventCloseHiddenModal(modalAddStudent);
        eventCloseHiddenModal(modalAddIntern);
    });

    //Sự kiện Ẩn Modal
    modalAddStudent.on('hidden.bs.modal', function() {
        eventCloseHiddenModal(modalAddStudent);
    });

    $.validator.addMethod("validatePhone", function (value, element) {
        return this.optional(element) || /((09|03|07|08|05)+([0-9]{8})\b)/g.test(value);
    }, "Định dạng số điện thoại không đúng!");

    modalAddStudent.find('form').validate({
        submitHandler: function() {
            // modalAddStudent.find('#description').val(CKEDITOR.instances['description'].getData());
            let data = modalAddStudent.find('form').serialize();

            callAjaxPost(BASE_URL + '/student/saveInfoAjax', data).done(function(res) {
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 3000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg, 'success');
                modalAddStudent.modal('hide');
                setTimeout(function() { window.location.reload(); }, 1000);
            });
        },

        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 250,
            },
            citizen_identify: {
                required: true,
            },
            birthday: {
                required: true,
            },
            address: {
                required: true,
            },
            phone: {
                required: true,
                validatePhone: true,
            },
            email: {
                required: true,
            },
            guardian: {
                required: true,
            },
            guardian_phone: {
                required: true,
                validatePhone: true,
            },
        },
        messages: {
            name: {
                required: "Tên học viên không được để trống!",
                minlength: "Tên học viên phải có độ dài ít nhất 2 ký tự!",
                maxlength: "Tên học viên không dài quá 250 ký tự!"
            },

            birthday: {
                required: "Ngày sinh không được để trống!",
            },
            address: {
                required: "Nơi ở hiện tại không được để trống!"
            },
            phone: {
                required: "Số điện thoại không được để trống!",
            },
            email: {
                required: "Email không được để trống",
                email: "Định dạng email không đúng!"
            },
            guardian_name: {
                required: "Họ tên người giám hộ không được để trống!"
            },
            guardian_phone: {
                required: "Số điện thoại người giám hộ không được để trống!"
            },
            citizen_identify: {
                required: "Số CCCD học viên không được để trống!",
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

    // Xử lý phân trang
    $('.pagination').on('click', '.page-item a', function (){
        $('#formFilterStudent input[name = "page"]').val(parseInt($(this).attr('data-page')));
        $('#formFilterStudent #btnSubmit').trigger('click');
        return false;
    });

    //Đặt các trường dữ liệu về empty khi khi bấm reset form filter
    formFilterStudent.on('click', '#btnReset', function (){
        formFilterStudent.find('.form-control').val('');
        formFilterStudent.find('option[value=""]').prop('selected');
    });

    //* Add new Intern
    $('.btnAddIntern').click(function() {
        document.getElementById('modalAddInternTitle').innerText = 'Thêm học viên vào danh sách thực tập sinh ';

        let id = $(this).attr('data-id'); //student_id
        callAjaxGet(BASE_URL + '/student/getInfoAjax/' + id).done(function(res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }
            let studentInfo = res.data;

            /* set field value */
            modalAddIntern.find('#student_id').val(id);
            [ 'name', 'gender', 'birthday', 'email', 'phone'].forEach(field => {
                modalAddIntern.find('#' + field).val(studentInfo[field]);
            });

            if (studentInfo['gender']) {
                modalAddIntern.find('#gender1').prop('checked', true);
            } else {
                modalAddIntern.find('#gender2').prop('checked', true);
            }

            modalAddIntern.modal('show');
        });

    });

    modalAddIntern.on('hidden.bs.modal', function() {
        eventCloseHiddenModal(modalAddIntern);
    });

    modalAddIntern.find('form').validate({
        submitHandler:function (){
            let data = modalAddIntern.find('form').serialize();

            callAjaxPost(BASE_URL + '/student/saveInternAjax', data).done(function(res){
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 5000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg,'success');
                modalAddIntern.modal('hide');
                setTimeout(function(){ window.location.reload(); }, 1000);
            });
        },
        rules: {
            starttime: {
                required: true,
            }
        },
        messages: {
            starttime: {
                required: 'Ngày bắt đầu không được để trống',
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

    $("#tableStudentList").on('click', '.btnView', function () {
        let id = $(this).attr('data-id');
        window.open(BASE_URL + '/student/detail/' + id);
    });
})
