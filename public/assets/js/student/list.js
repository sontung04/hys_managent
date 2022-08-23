$(function() {
    'use strict'

    /* set ckeditor */
    // CKEDITOR.replace('description');

    let modalAddStudent = $('#modalAddStudent');

    //* Add new Student
    $('#btnAddStudent').click(function() {
        document.getElementById('modalAddStudentTitle').innerText = 'Thêm Học viên mới';
        modalAddStudent.modal('show');
    });

    //* Edit Info 1 Student
    $('#tableStudentList').on('click', '.btnEdit', function() {
        document.getElementById('modalAddStudentTitle').innerText = 'Chỉnh sửa thông tin Giảng viên';

        let id = $(this).attr('data-id');
        callAjaxGet(BASE_URL + '/student/getInfoAjax/' + id).done(function(res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }
            let studentInfo = res.data;

            /* set field value */
            ['id', 'name', 'birthday', 'mother_job', 'father_birthday', 'desire', 'mother_birthday', 'native_place', 'father_job', 'mother', 'father', 'guardian_phone', 'guardian', 'majors', 'school', 'facebook', 'citizen_identify', 'course_where', 'email', 'phone', 'place_of_issue', 'date_of_issue', 'citizen_identify', 'religion', 'nations', 'address', 'level', 'job', 'position'].forEach(field => {
                modalAddStudent.find('#' + field).val(studentInfo[field]);
            });


            if (studentInfo['status']) {
                modalAddStudent.find('#status1').prop('checked', true);
            } else {
                modalAddStudent.find('#status2').prop('checked', true);
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
                setTimeout(function() { window.location.reload(); }, 1000);
            });
        },

        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 100,
            },
            citizen_identify: {
                required: true,
            },
            date_of_issue: {
                required: true,
            },
            place_of_issue: {
                required: true,
            },
            phone: {
                required: true,
            },
            email: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Tên Học viên không được để trống",
                minlength: "Họ người dùng phải có độ dài ít nhất 2 ký tự",
                maxlength: "Họ người dùng không dài quá 100 ký tự "
            },
            citizen_identify: {
                required: "Số CCCD không được để trống",
            },
            date_of_issue: {
                required: "Số ngày cấp CCCD không được để trống",
            },
            place_of_issue: {
                required: "Số nơi cấp CCCD không được để trống",
            },
            phone: {
                required: "Số điện thoại không được để trống",
            },
            email: {
                required: "Email không được để trống",
                email: "Định dạng email không đúng!"
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