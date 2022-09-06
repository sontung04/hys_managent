$(function () {
    'use strict'

    /* set ckeditor */
    CKEDITOR.replace( 'description' );

    let modalAddTeacher = $('#modalAddTeacher');

    /* set datepicker */
    modalAddTeacher.find('#birthdayDate').datetimepicker({
        format : datetimepicketFormat,
        locale : 'vi',
        // date   : settings.monthAgo,
        minDate: moment(modalAddTeacher.find('#birthday').data('min'), datetimepicketFormat),
        maxDate: moment(modalAddTeacher.find('#birthday').data('max'), datetimepicketFormat),
        ignoreReadonly: true,
    });

    //* Add new Teacher
    $('#btnAddTeacher').click(function () {
        document.getElementById('modalAddTeacherTitle').innerText = 'Thêm Giảng viên mới';
        modalAddTeacher.modal('show');
    });

    //* Edit Info 1 Teacher
    $('#tableTeacherList').on('click', '.btnEdit', function () {
        document.getElementById('modalAddTeacherTitle').innerText = 'Chỉnh sửa thông tin Giảng viên';

        let id = $(this).attr('data-id');
        callAjaxGet(BASE_URL + '/course/teacher/getInfoAjax/' + id).done(function (res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }
            let teacherInfo = res.data;

            /* set field value */
            ['id', 'name', 'subname', 'birthday', 'address', 'level', 'job', 'position'].forEach(field => {
                modalAddTeacher.find('#' + field).val(teacherInfo[field]);
            });

            CKEDITOR.instances['description'].setData(teacherInfo['description']);
            if(teacherInfo['status']) {
                modalAddTeacher.find('#status1').prop('checked', true);
            } else {
                modalAddTeacher.find('#status2').prop('checked', true);
            }

            modalAddTeacher.modal('show');
        });
    });

    //Sự kiện Đóng modal
    $('.closeModal').on('click', function () {
        CKEDITOR.instances['description'].setData('');
        eventCloseHiddenModal(modalAddTeacher);
    });

    //Sự kiện Ẩn Modal
    modalAddTeacher.on('hidden.bs.modal', function(){
        CKEDITOR.instances['description'].setData('');
        eventCloseHiddenModal(modalAddTeacher);
    });

    modalAddTeacher.find('form').validate({
        submitHandler: function () {
            modalAddTeacher.find('#description').val(CKEDITOR.instances['description'].getData());
            let data = modalAddTeacher.find('form').serialize();

            callAjaxPost(BASE_URL + '/course/teacher/saveInfoAjax', data).done(function(res) {
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 5000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg,'success');
                modalAddTeacher.modal('hide');
                setTimeout(function(){ window.location.reload(); }, 1000);
            });
        },

        rules: {
            name: {
                required: true,
            },
            birthday: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Tên Giảng viên không được để trống!",
            },
            birthday: {
                required: "Ngày sinh Giảng viên không được để trống!",
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

})
