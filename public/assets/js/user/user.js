$(document).ready(function() {

    function saveInfoUser(form) {
        let data = form.serialize()

        callAjaxPost(BASE_URL + '/user/saveInfo', data).done(function (res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 5000);
                return;
            }
            notifyMessage('Thông báo!', res.msg,'success');
            setTimeout(function(){
                location.reload();
            }, 3000);
        });
    }

    // Form tạo user mới
    let formCreateUser = $('#formCreateUser'),
        birthdayDateCreate = formCreateUser.find('#birthday');

    /* set datepicker */
    formCreateUser.find('#birthdayDate').datetimepicker({
        format : birthdayDateCreate.data('format'),
        locale : 'vi',
        // date   : settings.monthAgo,
        minDate: moment(birthdayDateCreate.data('min'), birthdayDateCreate.data('format')),
        maxDate: moment(birthdayDateCreate.data('max'), birthdayDateCreate.data('format')),
        ignoreReadonly: true,
    });

    $.validator.addMethod("validatePhone", function (value, element) {
        return this.optional(element) || /((09|03|07|08|05)+([0-9]{8})\b)/g.test(value);
    }, "Định dạng số điện thoại không đúng!");

    $.validator.addMethod("checkBirthday", function (value, element) {
        let now = new Date();
        if( value.slice(6,10) < now.getFullYear() - 15) {
            return true;
        } return false;
    }, "Chưa đủ 15 tuổi mà đòi tham gia à?");

    formCreateUser.validate({
        submitHandler: function () {
            saveInfoUser(formCreateUser);
        },

        rules: {
            area: {
                required: true,
            },
            lastname: {
                required: true,
                minlength: 2,
                maxlength: 100,
            },
            firstname: {
                required: true,
                minlength: 2,
                maxlength: 200,
            },
            birthday: {
                checkBirthday: true,
            },
            phone: {
                required: true,
                validatePhone: true,
            },
            email: {
                required: true,
                email: true,
            },
        },
        messages: {
            area: {
                required: "Vui lòng chọn khu vực hoạt động",
            },
            lastname: {
                required: "Họ người dùng không được để trống!",
                minlength: "Họ người dùng phải có độ dài ít nhất 2 ký tự",
                maxlength: "Họ người dùng không dài quá 100 ký tự "
            },
            firstname: {
                required: "Tên người dùng không được để trống!",
                minlength: "Tên người dùng phải có độ dài ít nhất 2 ký tự",
                maxlength: "Tên người dùng không dài quá 200 ký tự "
            },
            phone: {
                required: "Số điện thoại không để trống",
            },
            email: {
                required: "Email không được được để trống!",
                email: "Định dạng email không đúng!"
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

    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    //form Update Info User
    let formUpdateInfoUser = $('#formUpdateInfoUser'),
        birthdayDateUpdate = formUpdateInfoUser.find('#birthday');

    /* set datepicker */
    formUpdateInfoUser.find('#birthdayDate').datetimepicker({
        format : birthdayDateUpdate.data('format'),
        locale : 'vi',
        // date   : settings.monthAgo,
        minDate: moment(birthdayDateUpdate.data('min'), birthdayDateUpdate.data('format')),
        maxDate: moment(birthdayDateUpdate.data('max'), birthdayDateUpdate.data('format')),
        ignoreReadonly: true,
    });

    formUpdateInfoUser.validate({
        submitHandler: function () {
            saveInfoUser(formUpdateInfoUser);
        },
        rules: {
            lastname: {
                required: true,
                minlength: 2,
                maxlength: 100,
            },
            firstname: {
                required: true,
                minlength: 2,
                maxlength: 200,
            },
            birthday: {
                checkBirthday: true,
            },
            phone: {
                required: true,
                validatePhone: true,
            },
            email: {
                required: true,
                email: true,
            },
        },
        messages: {
            lastname: {
                required: "Họ người dùng không được để trống!",
                minlength: "Họ người dùng phải có độ dài ít nhất 2 ký tự",
                maxlength: "Họ người dùng không dài quá 100 ký tự "
            },
            firstname: {
                required: "Tên người dùng không được để trống!",
                minlength: "Tên người dùng phải có độ dài ít nhất 2 ký tự",
                maxlength: "Tên người dùng không dài quá 200 ký tự "
            },
            phone: {
                required: "Số điện thoại không để trống",
            },
            email: {
                required: "Email không được được để trống!",
                email: "Định dạng email không đúng!"
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

    //đọc để làm nốt validate
    // https://viblo.asia/p/tim-hieu-ve-jquery-validation-phan-1-E375zEqRlGW

});
