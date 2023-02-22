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
    let formCreateUser = $('#formCreateUser');

    /* set datetimepicker */
    formCreateUser.find('#birthdayDate').datetimepicker({
        format : datetimepicketFormat,
        locale : 'vi',
        useCurrent: false,
        minDate: moment(formCreateUser.find('#birthday').data('min'), datetimepicketFormat),
        maxDate: moment(currentMaxDate, datetimepicketFormat),
    });

    ['jointimeDate', 'stoptimeDate'].forEach(field => {
        formCreateUser.find('#' +field).datetimepicker({
            format : datetimepicketFormat,
            locale : 'vi',
            useCurrent: false,
            minDate: moment(dateBirthdayHys, datetimepicketFormat),
            maxDate: moment(currentMaxDate, datetimepicketFormat),
        });
    });

    /* Thêm validate kiểm tra stoptime lớn hơn jointime */
    $.validator.addMethod("checkEmptyJointime", function () {
        let stopTimeVal = formCreateUser.find('#stoptime').val();
        let joinTimeVal = formCreateUser.find('#jointime').val();
        if(stopTimeVal != '' && joinTimeVal == '') {
            return false;
        }
        return true;
    }, "Thời gian tham gia không để trống!");

    $.validator.addMethod("checkStopTime", function () {
        let stopTimeVal = formCreateUser.find('#stoptime').val();
        if(stopTimeVal != '') {
            let joinTimeVal = formCreateUser.find('#jointime').val();
            if(moment(joinTimeVal, 'DD/MM/YYYY HH:mm').valueOf() > moment(stopTimeVal, 'DD/MM/YYYY HH:mm').valueOf()) {
                return false;
            }
        }
        return true;
    }, "Thời gian nghỉ phải lớn hơn thời gian tham gia!");

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
                maxlength: 200,
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
            facebook: {
                url: true
            },
            jointime: {
                checkEmptyJointime: true
            },
            stoptime: {
                checkStopTime: true
            },
        },
        messages: {
            area: {
                required: "Vui lòng chọn khu vực hoạt động",
            },
            lastname: {
                required: "Họ người dùng không được để trống!",
                minlength: "Họ người dùng phải có độ dài ít nhất 2 ký tự",
                maxlength: "Họ người dùng không dài quá 200 ký tự "
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
            facebook: {
                url: true
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

    //đọc để làm nốt validate
    // https://viblo.asia/p/tim-hieu-ve-jquery-validation-phan-1-E375zEqRlGW

});
