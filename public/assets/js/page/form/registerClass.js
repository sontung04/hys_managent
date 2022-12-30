$(document).ready(function() {
    console.log('ádasdasdad');

    let divCheckStudentInfo  = $('#divCheckStudentInfo');
    let divFormRegisterClass = $('#divFormRegisterClass');

    /* set date range  picker */
    ['birthday', 'date_of_issue', 'father_birthday', 'mother_birthday'].forEach(field => {
        divFormRegisterClass.find('#' + field).daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: datetimepicketFormat,
                cancelLabel: 'Clear'
            },
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1950,
            maxYear: parseInt(moment().format('YYYY'),10),

        });
        divFormRegisterClass.find('#' + field).val('');

        divFormRegisterClass.find('#' + field).on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format(datetimepicketFormat));
        });

        divFormRegisterClass.find('#' + field).on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });


    /* Trường hợp học viên không có mã học viên */
    $('#btnEmptyCodeStudent').on('click', function () {
        document.getElementById('formTitle').innerText = 'Vui lòng điền đủ các trường thông tin!';

        divCheckStudentInfo.attr('hidden', 'hidden');
        divFormRegisterClass.removeAttr('hidden');
    });

    /* Validate form check isset student code */
    divCheckStudentInfo.find('form').validate({
        submitHandler: function() {
            let data = divCheckStudentInfo.find('form').serialize();

            callAjaxPost(BASE_URL + '/form/class/register/student/checkInfoByCodeAjax', data).done(function(res){
                if (!res.status) {
                    notifyMessage('Cảnh báo!', res.msg, 'error', 5000);
                    return;
                }
                let studentInfo = res.data;

                document.getElementById('formTitle').innerText = 'Vui lòng kiểm tra thông tin của bạn!';

                /* set field value */
                ['id', 'name', 'birthday', 'email', 'phone', 'facebook', 'native_place', 'address', 'school', 'major',
                    'guardian_name', 'guardian_phone', 'religion', 'nation',  'level', 'job',
                    'father', 'father_job', 'father_birthday', 'mother', 'mother_birthday', 'mother_job',
                    'course_where', 'place_of_issue', 'date_of_issue', 'citizen_identify'].forEach(field => {
                    divFormRegisterClass.find('#' + field).val(studentInfo[field]);
                });

                if (studentInfo['gender']) {
                    divFormRegisterClass.find('#gender1').prop('checked', true);
                } else {
                    divFormRegisterClass.find('#gender2').prop('checked', true);
                }

                divCheckStudentInfo.attr('hidden', 'hidden');
                divFormRegisterClass.removeAttr('hidden');
            });
        },

        rules: {
            code: {
                required: true,
            },

        },
        messages: {
            code: {
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

    /* Sự kiện Btn reset form nhập thông tin học viên */
    divFormRegisterClass.on('click', '#btnReset', function () {

        divFormRegisterClass.find('.is-invalid').removeClass('is-invalid');
    })

    /* Validate form register student to class */
    jQuery.validator.addMethod("validDate", function(value, element) {
        return this.optional(element) || moment(value,"DD/MM/YYYY").isValid();
    }, "Định dạng ngày tháng chưa đúng! (Ngày/Tháng/Năm)");

    $.validator.addMethod("validatePhone", function (value, element) {
        return this.optional(element) || /((09|03|07|08|05)+([0-9]{8})\b)/g.test(value);
    }, "Định dạng số điện thoại không đúng!");

    divFormRegisterClass.find('form').validate({
        submitHandler: function() {
            let data = divFormRegisterClass.find('form').serialize();

            callAjaxPost(BASE_URL + '/form/class/register/submitAjax', data).done(function(res){
                if (!res.status) {
                    notifyMessage('Cảnh báo!', res.msg, 'error', 5000);
                    return;
                }
                Swal.fire({
                    title: 'Đăng ký thành công!',
                    icon: 'success',
                    html:`${res.msg} <br><b>Mã học viên của bạn: <span class="text-primary">${res.data}</span></b>`,
                    showConfirmButton: true,
                    confirmButtonText: 'Đóng',
                }).then(function(){
                    window.location.reload();
                });
            });
        },

        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 250,
            },
            birthday: {
                required: true,
                validDate: true,
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
                email: true
            },
            guardian_name: {
                required: true,
            },
            guardian_phone: {
                required: true,
                validatePhone: true,
            },
            school: {
                required: true
            },
            major: {
                required: true
            },
            citizen_identify: {
                required: true,
            },
            date_of_issue: {
                validDate: true,
            },
            facebook: {
                required: true,
                url: true
            },
            native_place: {
                required: true,
            },

            father_birthday: {
                validDate: true,
            },

            mother_birthday: {
                validDate: true,
            },

            desire: {
                required: true,
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
            school: {
                required: "Trường học không được để trống!"
            },
            major: {
                required: "Ngành học không được để trống!"
            },
            citizen_identify: {
                required: "Số CCCD học viên không được để trống!",
            },
            facebook: {
                required: "Link Facebook cá nhân không được để trống!",
                url: "Link Facebook không đúng định dạng!"
            },
            native_place: {
                required: "Quê quán không được để trống!",
            },

            desire: {
                required: "Bạn có thể chia sẻ mục đích tham gia khóa học được chứ?",
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
