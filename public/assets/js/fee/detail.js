$(function() {
    'use strict'

    let modalAddPaymentLog = $('#modalAddPaymentLog');
    let modalAddCallLog    = $('#modalAddCallLog');

    /* set datetimepicker */
    modalAddPaymentLog.find('#date_paidDate').datetimepicker({
        format : datetimepicketFormat,
        locale : 'vi',
        minDate: moment(dateBirthdayHys, datetimepicketFormat),
        maxDate: moment(currentMaxDate, datetimepicketFormat),
    });

    modalAddCallLog.find('#date_callDate').datetimepicker({
        format : datetimepicketFormat,
        locale : 'vi',
        minDate: moment(dateBirthdayHys, datetimepicketFormat),
        maxDate: moment(currentMaxDate, datetimepicketFormat),
    });
    /* END set datetimepicker */

    /* Add new Record Payment Log */
    $('#btnAddPaymentLog').on('click', function () {
        document.getElementById('modalAddPaymentLogTitle').innerText = 'Thêm Lịch sử đóng tiền';
        modalAddPaymentLog.modal('show');
    });

    //Sự kiện Đóng modal
    modalAddPaymentLog.on('click', '.closeModal', function() {
        eventCloseHiddenModal(modalAddPaymentLog, ['course_id']);
        modalAddPaymentLog.find('#date_paid').val(currentMaxDate);
    });

    //Sự kiện Ẩn Modal
    modalAddPaymentLog.on('hidden.bs.modal', function() {
        eventCloseHiddenModal(modalAddPaymentLog, ['course_id']);
        modalAddPaymentLog.find('#date_paid').val(currentMaxDate);
    });

    /* Validate form modal Add Payment Log */
    modalAddPaymentLog.find('form').validate({
        submitHandler: function() {
            // modalAddClass.find('#description').val(CKEDITOR.instances['description'].getData());
            let data = modalAddPaymentLog.find('form').serialize();

            callAjaxPost(BASE_URL + '/student/fee/paymentLogCreateAjax', data).done(function(res) {
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 3000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg, 'success');
                modalAddPaymentLog.modal('hide');
                setTimeout(function() { window.location.reload(); }, 1000);
            });
        },

        rules: {
            course_id: {
                required: true,
            },
            money_paid: {
                required: true,
                min: 10000,
            },
            cashier: {
                required: true,
                minlength: 2
            },
            status: {
                required: true,
            },
            date_paid: {
                required: true,
            },
        },
        messages: {
            course_id: {
                required: "Vui lòng chọn khóa học!",
            },
            money_paid: {
                required: "Số tiền đóng không được để trống!",
                min: "Số tiền đóng phải tối thiểu 10,000 VNĐ!",
            },
            cashier: {
                required: "Tên người thu tiền không được để trống!",
                minlength: "Tên người thu tiền dài ít nhất 2 ký tự!"
            },
            status: {
                required: "Hình thức đóng tiền không để trống!",
            },
            date_paid: {
                required: "Ngày đóng tiền không để trống!",
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

    /* Add new Record Call Log */
    $('#btnAddCallLog').on('click', function () {
        document.getElementById('modalAddPaymentLogTitle').innerText = 'Thêm Lịch sử gọi điện';
        modalAddCallLog.modal('show');
    });

    //Sự kiện Đóng modal
    modalAddCallLog.on('click', '.closeModal', function() {
        modalAddCallLog.find('.is-invalid').removeClass('is-invalid');
        modalAddCallLog.find('#agent').val('Vũ Thị Mai Huế')
        modalAddCallLog.find('#date_call').val(currentMaxDate)
        modalAddCallLog.find('#channel0').prop('checked', true);
        modalAddCallLog.find('#status1').prop('checked', true);
        modalAddCallLog.find('#note').val('')
    });

    //Sự kiện Ẩn Modal
    modalAddCallLog.on('hidden.bs.modal', function() {
        modalAddCallLog.find('.is-invalid').removeClass('is-invalid');
        modalAddCallLog.find('#agent').val('Vũ Thị Mai Huế')
        modalAddCallLog.find('#date_call').val(currentMaxDate)
        modalAddCallLog.find('#channel0').prop('checked', true);
        modalAddCallLog.find('#status1').prop('checked', true);
        modalAddCallLog.find('#note').val('')
    });

    /* Validate form modal Add Payment Log */
    modalAddCallLog.find('form').validate({
        submitHandler: function() {
            // modalAddClass.find('#description').val(CKEDITOR.instances['description'].getData());
            let data = modalAddCallLog.find('form').serialize();

            callAjaxPost(BASE_URL + '/student/fee/callLogCreateAjax', data).done(function(res) {
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 3000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg, 'success');
                modalAddCallLog.modal('hide');
                setTimeout(function() { window.location.reload(); }, 1000);
            });
        },

        rules: {
            agent: {
                required: true,
                minlength: 2
            },
            date_call: {
                required: true,
            },
        },
        messages: {
            agent: {
                required: "Tên người gọi không được để trống!",
                minlength: "Tên người gọi phải dài ít nhất 2 ký tự!"
            },
            date_call: {
                required: "Ngày gọi không được để trống!",
            },
            channel: {
                required: "Kênh liên hệ không được để trống!",
            },
            status: {
                required: "Trạng thái liên hệ không được để trống!",
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
})
