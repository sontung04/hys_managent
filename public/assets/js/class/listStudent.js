$(function() {
    'use strict'

    /* set ckeditor */
    // CKEDITOR.replace('description');

    let modalAddStudent = $('#modalAddStudent');

    //* Add new Student
    $('#btnAddStudent').click(function() {
        document.getElementById('modalAddStudentTitle').innerText = 'Thêm học viên mới';
        modalAddStudent.modal('show');
    });

    //* Edit Info 1 Student
    $('#listStdClassTable').on('click', '.btnEdit', function() {
        document.getElementById('modalAddStudentTitle').innerText = 'Chỉnh sửa thông tin';

        let id = $(this).attr('data-id');
        callAjaxGet(BASE_URL + '/student/getInfoAjax/' + id).done(function(res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }
            let studentInfo = res.data;

            /* set field value */
            ['id', 'name', 'gender', 'native_place', 'phone', 'email', 'starttime', 'finishtime', 'status'].forEach(field => {
                modalAddStudent.find('#' + field).val(studentInfo[field]);
            });


            switch (studentInfo['status']){
                case 0: modalAddStudent.find('#status0').prop('checked', true); break;
                case 1: modalAddStudent.find('#status1').prop('checked', true); break;
                case 2: modalAddStudent.find('#status2').prop('checked', true); break;
                case 3: modalAddStudent.find('#status3').prop('checked', true); break;
            }

            modalAddStudent.modal('show');
        });
    });

    //Sự kiện Đóng modal
    $('.closeModal').on('click', function() {
        CKEDITOR.instances['description'].setData('');
        eventCloseHiddenModal(modalAddStudent);
    });

    //Sự kiện Ẩn Modal
    modalAddStudent.on('hidden.bs.modal', function() {
        eventCloseHiddenModal(modalAddStudent);
    });

    modalAddStudent.find('form').validate({
        submitHandler: function() {
            // modalAddStudent.find('#description').val(CKEDITOR.instances['description'].getData());
            let data = modalAddStudent.find('form').serialize();

            callAjaxPost(BASE_URL + '/student/saveInfoAjax', data).done(function(res) {
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 5000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg, 'success');
                modalAddStudent.modal('hide');
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

})
