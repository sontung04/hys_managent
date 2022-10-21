$(document).ready(function() {

    let divCheckIssetStudent = $('#divCheckIssetStudent');
    let divFormCheckinStudent = $('#divFormCheckinStudent');

    /* Validate form check isset student code */
    divCheckIssetStudent.find('form').validate({
        submitHandler: function() {
            let data = divCheckIssetStudent.find('form').serialize();

            callAjaxPost(BASE_URL + '/form/attendance/student/checkCodeStudentAjax', data).done(function(res){
                if (!res.status) {
                    notifyMessage('Cảnh báo!', res.msg, 'error', 5000);
                    return;
                }
                divCheckIssetStudent.attr('hidden', 'hidden');
                let student_type = divCheckIssetStudent.find('#student_type').val();
                if(student_type == 1) {
                    divFormCheckinStudent.find('#divStatusCheckin').attr('hidden', 'hidden');
                    divFormCheckinStudent.find('#divStudentNumber').removeAttr('hidden');
                } else if(student_type == 2) {
                    divFormCheckinStudent.find('#divStatusCheckin').attr('hidden', 'hidden');
                }
                divFormCheckinStudent.find('#student_type').val(student_type);
                divFormCheckinStudent.find('#student_code').val(student_code);
                divFormCheckinStudent.removeAttr('hidden');
            });
        },

        rules: {
            student_type: {
                required: true,
            },
            student_code: {
                required: true,
            },

        },
        messages: {
            student_type: {
                required: "Vui lòng xác định vai trò của bạn!",
            },
            student_code: {
                required: "Mã học viên không để trống!",
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

    /* Validate form student checkin */
    divFormCheckinStudent.find('form').validate({
        submitHandler: function() {
            let data = divFormCheckinStudent.find('form').serialize();

            callAjaxPost(BASE_URL + '/form/attendance/student/submitAjax', data).done(function(res){
                if (!res.status) {
                    notifyMessage('Cảnh báo!', res.msg, 'error', 5000);
                    return;
                }
                notifyMessage('Checkin thành công!', res.msg,'success');
                setTimeout(function(){ window.location.reload(); }, 5000);
            });
        },

        rules: {
            status: {
                required: true,
            },
            number_eat: {
                required: true,
            },
            number_learn: {
                required: true,
            },

        },
        messages: {
            status: {
                required: "Vui lòng chọn trạng thái checkin!",
            },
            number_eat: {
                required: "",
            },
            number_learn: {
                required: "",
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
});
