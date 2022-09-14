$(function() {
    'use strict'

    /* set ckeditor */
    // CKEDITOR.replace('description');

    let modalAddClass = $('#modalAddClass');

    /* Gọi Ajax lấy ra danh sách các khóa học */
    callAjaxGet(BASE_URL + '/course/getListCourseAjax').done(function (res){
        let courses = res.data;
        let html = '';
        for (let x in courses) {
            html += `<option value="${courses[x].id}">${courses[x].name}</option>`;
        }
        $('#course_id').append(html);
    });

    /* set datetimepicker */
    ['starttimeDate', 'finishtimeDate'].forEach(field => {
        modalAddClass.find('#' +field).datetimepicker({
            format : datetimepicketFormat,
            locale : 'vi',
            useCurrent: false,
            minDate: moment(dateBirthdayHys, datetimepicketFormat),
        });
    });

    //* Add new Class
    $('#btnAddClass').click(function() {
        document.getElementById('modalAddClassTitle').innerText = 'Thêm lớp học mới';
        modalAddClass.modal('show');
    });

    //* Edit Info a Class
    $('#tableListClassBody').on('click', '.btnEdit', function() {
        document.getElementById('modalAddClassTitle').innerText = 'Chỉnh sửa thông tin lớp học';

        let id = $(this).attr('data-id');
        callAjaxGet(BASE_URL + '/class/getInfoAjax/' + id).done(function(res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }
            let classInfo = res.data;

            /* set field value */
            ['id', 'name', 'carer_staff', 'coach', 'starttime', 'finishtime'].forEach(field => {
                modalAddClass.find('#' + field).val(classInfo[field]);
            });

            modalAddClass.find('#course_id').find(`option[value="${classInfo['course_id']}"]`).prop('selected', true);

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
                    notifyMessage('Lỗi!', res.msg, 'error', 3000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg, 'success');
                modalAddClass.modal('hide');
                setTimeout(function() { window.location.reload(); }, 1000);
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

        },
        messages: {
            name: {
                required: "Tên lớp học không được để trống",
            },
            course_id: {
                required: "Khóa học không được để trống",
            },
            starttime: {
                required: "Ngày khai giảng không được để trống",
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

    $("#tableListClassBody").on('click', '.btnView', function () {
        let id = $(this).attr('data-id');
        window.open(BASE_URL + '/class/listStudent/' + id, "_self");
    });
    $("#tableListClassBody").on('click', '.btnViewStudy', function () {
        let id = $(this).attr('data-id');
        window.open(BASE_URL + '/class/listStudy/' + id, "_self");
    });

})
