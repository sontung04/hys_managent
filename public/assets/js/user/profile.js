$(document).ready(function() {


    //form Update Info User
    let formUpdateInfoUser = $('#formUpdateInfoUser'),
        birthdayDate = formUpdateInfoUser.find('#birthday');

    /* set datepicker */
    formUpdateInfoUser.find('#birthdayDate').datetimepicker({
        format : datetimepicketFormat,
        locale : 'vi',
        // date   : settings.monthAgo,
        minDate: moment(birthdayDate.data('min'), datetimepicketFormat),
        maxDate: moment(currentMaxDate, datetimepicketFormat),
        ignoreReadonly: true,
    });
    birthdayDate.val(birthdayDate.data('value'));

    ['jointime', 'stoptime'].forEach(field => {
        formUpdateInfoUser.find('#' + field + 'Date').datetimepicker({
            format : datetimepicketFormat,
            locale : 'vi',
            useCurrent: false,
            minDate: moment(dateBirthdayHys, datetimepicketFormat),
            maxDate: moment(currentMaxDate, datetimepicketFormat),
        });

        if(formUpdateInfoUser.find('#' +field).data('value') != '') {
            formUpdateInfoUser.find('#' + field).val(formUpdateInfoUser.find('#' + field).data('value'));
        }
    });

    /* Thêm validate kiểm tra stoptime lớn hơn jointime */
    $.validator.addMethod("checkEmptyJointime", function () {
        let stopTimeVal = formUpdateInfoUser.find('#stoptime').val();
        let joinTimeVal = formUpdateInfoUser.find('#jointime').val();
        if(stopTimeVal != '' && joinTimeVal == '') {
            return false;
        }
        return true;
    }, "Thời gian tham gia không để trống!");

    $.validator.addMethod("checkStopTime", function () {
        let stopTimeVal = formUpdateInfoUser.find('#stoptime').val();
        if(stopTimeVal != '') {
            let joinTimeVal = formUpdateInfoUser.find('#jointime').val();
            if(moment(joinTimeVal, 'DD/MM/YYYY HH:mm').valueOf() > moment(stopTimeVal, 'DD/MM/YYYY HH:mm').valueOf()) {
                return false;
            }
        }
        return true;
    }, "Thời gian nghỉ phải lớn hơn thời gian tham gia!");


    formUpdateInfoUser.validate({
        submitHandler: function () {

            let data = formUpdateInfoUser.serialize()

            callAjaxPost(BASE_URL + '/user/saveInfo', data).done(function (res) {
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 5000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg,'success');
                setTimeout(function(){
                    location.reload();
                }, 2000);
            });
        },

        rules: {
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
                required: true,
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
            lastname: {
                required: "Họ người dùng không được để trống!",
                minlength: "Họ người dùng phải có độ dài ít nhất 2 ký tự!",
                maxlength: "Họ người dùng không dài quá 200 ký tự!"
            },
            firstname: {
                required: "Tên người dùng không được để trống!",
                minlength: "Tên người dùng phải có độ dài ít nhất 2 ký tự!",
                maxlength: "Tên người dùng không dài quá 200 ký tự!"
            },
            phone: {
                required: "Số điện thoại không để trống!",
            },
            email: {
                required: "Email không được được để trống!",
                email: "Định dạng email không đúng!"
            },
            facebook: {
                required: "Link Facebook không được được để trống!",
                url: "Định dạng link Facebook không đúng!"
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

});
