$(function() {
    'use strict'

    /* set ckeditor */
    // CKEDITOR.replace('description');

    let modalAddStudentClass = $('#modalAddStudentClass');

    //* Add new Student
    $('#btnAddStudentClass').click(function() {
        document.getElementById('modalAddStudentClassTitle').innerText = 'Thêm học viên mới';
        modalAddStudentClass.modal('show');
    });

    //* Edit Info 1 Student
    $('#listStdClassTable').on('click', '.btnEdit', function() {
        document.getElementById('modalAddStudentClassTitle').innerText = 'Chỉnh sửa thông tin';

        let id = $(this).attr('data-id');
        callAjaxGet(BASE_URL + '/student/getInfoAjax/' + id).done(function(res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }
            let studentInfo = res.data;

            /* set field value */
            ['id', 'name', 'gender', 'native_place', 'phone', 'email', 'starttime', 'finishtime', 'status'].forEach(field => {
                modalAddStudentClass.find('#' + field).val(studentInfo[field]);
            });


            switch (studentInfo['status']){
                case 0: modalAddStudentClass.find('#status0').prop('checked', true); break;
                case 1: modalAddStudentClass.find('#status1').prop('checked', true); break;
                case 2: modalAddStudentClass.find('#status2').prop('checked', true); break;
                case 3: modalAddStudentClass.find('#status3').prop('checked', true); break;
            }

            modalAddStudentClass.modal('show');
        });
    });

    //Sự kiện Đóng modal
    $('.closeModal').on('click', function() {
        CKEDITOR.instances['description'].setData('');
        eventCloseHiddenModal(modalAddStudentClass);
    });

    //Sự kiện Ẩn Modal
    modalAddStudentClass.on('hidden.bs.modal', function() {
        eventCloseHiddenModal(modalAddStudentClass);
    });

    /* Validate form Add students to class */
    modalAddStudentClass.ready(function (){
        $("#formAddStudentClass").validate({
            rules: {
                name: {
                    required: true,
                },
                birthday: {
                    required: true,
                },
                phone: {
                    required: true,
                },
                starttime: {
                    required: true,
                },

            },
            messages: {
                name: {
                    required: "Tên không được để trống",
                },
                birthday: {
                    required: "Ngày sinh không được để trống",
                },
                phone: {
                    required: "Số điện thoại không được để trống",
                },
                starttime: {
                    required: "Ngày bắt đầu không được để trống",
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

        $('#btnSave').click(function (){
            $("#formAddStudentClass").valid();
        });
    });

    /* Submit form modal add student to class */

    modalAddStudentClass.find('form').on('click', '#btnSave', function () {
        let data = modalAddStudentClass.find('form').serialize();

        callAjaxPost(BASE_URL + '/class/student/saveInfoAjax', data).done(function(res){
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 5000);
                return;
            }
            notifyMessage('Thông báo!', res.msg,'success');
            modalAddStudentClass.modal('hide');
            setTimeout(function(){ window.location.reload(); }, 1000);
        });
    });

})
