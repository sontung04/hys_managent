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
                let studentInfo = res.data;
                divCheckIssetStudent.attr('hidden', 'hidden');
                let student_type = divCheckIssetStudent.find('#student_type').val();
                let student_info = divCheckIssetStudent.find('#student_info').val();

                if(student_type == 1) {
                    document.getElementById('nameCodeStudentTitle').innerText = "Chủ nhiệm: ";
                    divFormCheckinStudent.find('#divStatusCheckin').attr('hidden', 'hidden');
                    divFormCheckinStudent.find('#divStudentNumber').removeAttr('hidden');
                    divFormCheckinStudent.find('#divStudentNote').removeAttr('hidden');
                } else if(student_type == 2) {
                    document.getElementById('nameCodeStudentTitle').innerText = "Trợ giảng: ";
                    divFormCheckinStudent.find('#divStatusCheckin').attr('hidden', 'hidden');
                    divFormCheckinStudent.find('#divStudentNote').removeAttr('hidden');
                }
                document.getElementById('nameCodeStudent').innerHTML = studentInfo.name + ' - ' + studentInfo.code;
                divFormCheckinStudent.find('#student_type').val(student_type);
                divFormCheckinStudent.find('#student_info').val(student_info);
                divFormCheckinStudent.removeAttr('hidden');
            });
        },

        rules: {
            student_type: {
                required: true,
            },
            student_info: {
                required: true,
            },

        },
        messages: {
            student_type: {
                required: "Vui lòng xác định vai trò của bạn!",
            },
            student_info: {
                required: "Email hoặc số điện thoại không để trống!",
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
            feedback: {
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
            feedback: {
                required: "",
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
