$(function() {
    'use strict'

    /* set ckeditor */
    // CKEDITOR.replace('description');

    let modalAddStudy = $('#modalAddStudy');

    let inputDaylearn = modalAddStudy.find('#daylearn');
    let teachers = [];

    /* Gọi Ajax lấy ra danh sách các Giảng viên */
    callAjaxGet(BASE_URL + '/course/teacher/getListAjax').done(function (res){
        if(!res.status){
            notifyMessage('Lỗi!', res.msg, 'error', 3000);
            return;
        }
        teachers = res.data;
        let html = '';
        for (let x in teachers) {
            html += `<option value="${teachers[x].id}">${teachers[x].name}</option>`;
        }
        $('#teacher').append(html);
    });

    /* set datetimepicker */
    ['daylearnStudy'].forEach(field => {
        modalAddStudy.find('#' +field).datetimepicker({
            format : datetimepicketFormat,
            locale : 'vi',
            useCurrent: true,
            // minDate: moment(inputDaylearn.data('min'), datetimepicketFormat),
            // maxDate: moment(currentMaxDate, datetimepicketFormat),
        });
    });

    //* Add new Student
    $('#btnAddStudy').click(function() {
        document.getElementById('modalAddStudyTitle').innerText = 'Thêm Buổi học mới';
        modalAddStudy.modal('show');
    });

    //* Edit Info 1 Student
    $('#listStudyTable').on('click', '.btnEdit', function() {
        document.getElementById('modalAddStudyTitle').innerText = 'Chỉnh sửa thông tin buổi học';

        let id = $(this).attr('data-id');
        callAjaxGet(BASE_URL + '/class/getInfoStudyAjax/' + id).done(function(res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }
            let studyInfo = res.data;

            /* set field value */
            ['id', 'class_id', 'lesson_id', 'teacher', 'carer_staff', 'coach', 'daylearn', 'location'].forEach(field => {
                modalAddStudy.find('#' + field).val(studyInfo[field]);
            });
            modalAddStudy.modal('show');
        });
    });

    //Sự kiện Đóng modal
    $('.closeModal').on('click', function() {
        eventCloseHiddenModal(modalAddStudy);
    });

    //Sự kiện Ẩn Modal
    modalAddStudy.on('hidden.bs.modal', function() {
        eventCloseHiddenModal(modalAddStudy);
    });

    modalAddStudy.find('form').validate({
        submitHandler: function() {
            // modalAddStudy.find('#description').val(CKEDITOR.instances['description'].getData());
            let data = modalAddStudy.find('form').serialize();

            callAjaxPost(BASE_URL + '/class/saveInfoStudyAjax', data).done(function(res) {
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 3000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg, 'success');
                modalAddStudy.modal('hide');
                setTimeout(function() { window.location.reload(); }, 1000);
            });
        },

        rules: {
            lesson_id: {
                required: true,
            },
            class_id: {
                required: true,
            },
            teacher: {
                required: true,
                min: 1,
            },
            coach: {
                required: true,
                min: 1,
            },
            carer_staff: {
                required: true,
                min: 1,
            },
            daylearn: {
                required: true,
            }
        },
        messages: {
            class_id: {
                required: "Tên lớp học không được để trống!"
            },
            lesson_id: {
                required: "Tên bài học không được để trống!"
            },
            teacher: {
                required: "Thêm tên giảng viên nào!",
                min: 'Vui lòng chọn giảng viên'
            },
            coach: {
                required: "Tên trở giảng đâu rùi!"
            },
            carer_staff: {
                required: "Điền tên chủ nhiệm lớp đã nào!"
            },
            daylearn: {
                required: "Học ngày nào vậy?"
            }
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
