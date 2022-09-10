$(function() {
    'use strict'

    /* set ckeditor */
    // CKEDITOR.replace('description');

    let modalAddClass = $('#modalAddClass');

    //* Add new Student
    $('#btnAddClass').click(function() {
        document.getElementById('modalAddClassTitle').innerText = 'Thêm Lớp học mới';
        modalAddClass.modal('show');
    });

    //* Edit Info 1 Student
    $('#tableClassList').on('click', '.btnEdit', function() {
        document.getElementById('modalAddClassTitle').innerText = 'Chỉnh sửa thông tin';

        let id = $(this).attr('data-id');
        callAjaxGet(BASE_URL + '/class/getInfoAjax/' + id).done(function(res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }
            let classInfo = res.data;

            /* set field value */
            ['id', 'course_id', 'name', 'carer_staff', 'coach', 'starttime', 'finishtime', 'status'].forEach(field => {
                modalAddClass.find('#' + field).val(classInfo[field]);
            });


            if (classInfo['status']) {
                modalAddClass.find('#status1').prop('checked', true);
            } else {
                modalAddClass.find('#status2').prop('checked', true);
            }

            modalAddClass.modal('show');
        });
    });

    //Sự kiện Đóng modal
    $('.closeModal').on('click', function() {
        CKEDITOR.instances['description'].setData('');
        eventCloseHiddenModal(modalAddClass);
    });

    //Sự kiện Ẩn Modal
    modalAddClass.on('hidden.bs.modal', function() {
        eventCloseHiddenModal(modalAddClass);
    });

    modalAddClass.find('form').validate({
        submitHandler: function() {
            // modalAddClass.find('#description').val(CKEDITOR.instances['description'].getData());
            let data = modalAddClass.find('form').serialize();

            callAjaxPost(BASE_URL + '/class/saveInfoAjax', data).done(function(res) {
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 5000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg, 'success');
                modalAddClass.modal('hide');
                setTimeout(function() { window.location.reload(); }, 10);
            });
        },

        rules: {
            name: {
                required: true,
            },
            course_id: {
                required: true,
            },
            starttime: {
                required: true,
            },
            status: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Please fill in the blank",
            },
            course_id: {
                required: "Please fill in the blank",
            },
            starttime: {
                required: "Please fill in the blank",
            },
            status: {
                required: "Please fill in the blank",
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

    $("#tableClassList").on('click', '.btnView', function () {
        let id = $(this).attr('data-id');
        window.open(BASE_URL + '/class/listStd/' + id);
    });

})
