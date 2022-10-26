$(function () {
    'use strict'

    CKEDITOR.replace('description');
    CKEDITOR.replace('document');
    CKEDITOR.replace('question');
    CKEDITOR.replace('homework');

    let courses  = [];
    let teachers = [];

    /* Gọi Ajax lấy ra danh sách các khóa học */
    callAjaxGet(BASE_URL + '/course/getListCourseAjax').done(function (res){
        if(!res.status){
            notifyMessage('Lỗi!', res.msg, 'error', 3000);
            return;
        }
        courses = res.data;
        let html = '';
        for (let x in courses) {
            html += `<option value="${courses[x].id}">${courses[x].name}</option>`;
        }
        $('#selectCourse').append(html);
        $('#course_id').append(html);
    });

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
        $('#teacher_id').append(html);
    });

    $('#selectCourse').select2({
        theme: 'bootstrap4'
    });

    let modalAddLesson = $('#modalAddLesson');
    let tableBodyLessonList = $('#tableBodyLessonList');

    /* Btn tìm kiếm bài học */
    $( "#btnFilterLesson" ).click(function() {
        let courseIds = $('#selectCourse').val();
        if(Array.isArray(courseIds) && courseIds.length == 0) {
            notifyMessage('Thông báo!', 'Vui lòng chọn khóa học trước!', 'warning', 1000);
            return;
        }

        callAjaxGet(BASE_URL + '/lesson/getListByCourseAjax', {courseIds: courseIds}).done(function (res){
            if(!res.status){
                notifyMessage('Lỗi!', res.msg, 'error', 2000);
                return;
            }
            let datas = res.data;
            let html  = '';
            let index = 0;

            for (let x in datas) {
                if(!isNaN(x)) {
                    html += `<tr id="lesson-${datas[x].id}" data-index="${++index}">`;
                    html += setHtmlRowTableLesson(datas[x], index);
                    html += `</tr>`;
                }
            }
            document.getElementById('tableBodyLessonList').innerHTML = html;
        });
    });

    /* Sự kiện thêm mới bản ghi */
    $( "#btnAddLesson" ).click(function() {
        document.getElementById('modalAddLessonTitle').innerText = 'Thêm Bài học mới';
        modalAddLesson.modal('show');
    });

    /* Sự kiện btnEdit bản ghi */
    tableBodyLessonList.on('click', '.btnEdit', function(){
        document.getElementById('modalAddLessonTitle').innerText = "Chỉnh sửa thông tin Bài học";
        let id = $(this).attr('data-id');
        callAjaxGet(BASE_URL + '/lesson/getInfoAjax/' + id).done(function (res){
            if(!res.status){
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }
            let lessonInfo = res.data;
            /* set field value */
            ['id', 'name', 'teacher_id','course_id'].forEach(field => {
                modalAddLesson.find('#' + field).val(lessonInfo[field]);
            });
            ['description', 'question', 'document', 'homework'].forEach(field => {
                CKEDITOR.instances[field].setData(lessonInfo[field]);
            });
            modalAddLesson.modal('show');
        });
    });

    //Sự kiện Đóng modal
    $('.closeModal').on('click', function() {
        ['description', 'question', 'document', 'homework'].forEach(field => {
            CKEDITOR.instances[field].setData('');
        });
        eventCloseHiddenModal(modalAddLesson);
    });

    //Sự kiện Ẩn modal
    modalAddLesson.on('hidden.bs.modal', function(){
        ['description', 'question', 'document', 'homework'].forEach(field => {
            CKEDITOR.instances[field].setData('');
        });
        eventCloseHiddenModal(modalAddLesson);
    });

    /* Submit form Modal */
    modalAddLesson.find('form').validate({
        submitHandler: function () {
            ['description', 'question', 'document', 'homework'].forEach(field => {
                modalAddLesson.find('#' + field).val(CKEDITOR.instances[field].getData());
            });
            let data = modalAddLesson.find('form').serialize();
            let id = modalAddLesson.find('#id').val();

            callAjaxPost(BASE_URL + '/lesson/saveInfoAjax', data).done(function(res){
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 5000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg,'success', 1000);
                modalAddLesson.modal('hide');
                let dataLesson = res.data;

                if( id == '' || id == null) {
                    /* Thêm mới 1 bản ghi */
                    let courseId = $('#course_id').val();
                    let courseIds = $('#selectCourse').val();
                    let checkRowTable = $('#tableBodyLessonList tr th').length;

                    if(courseIds.length !== 0 && courseIds.includes(courseId) && checkRowTable > 1) {
                        let html  = '';
                        let index = $('#tableBodyLessonList tr').length + 1;
                        html += `<tr id="lesson-${dataLesson.id}" data-index="${index}">`;
                        html += setHtmlRowTableLesson(dataLesson, index);
                        html += `</tr>`;
                        tableBodyLessonList.append(html);
                    }
                } else {
                    /* Cập nhật 1 bản ghi */
                    let html  = '';
                    let index = $('#lesson-' + id).attr('data-index');
                    html = setHtmlRowTableLesson(dataLesson, index);
                    document.getElementById('lesson-' + id).innerHTML = html;
                }
            });
        },
        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 255,
            },
            course_id: {
                required: true,
            },
            teacher_id: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Tên bài học không được bỏ trống!",
                minlength: "Tên bài học phải có tối thiểu 2 ký tự!",
                maxlength: "Tên bài học phải có tối đa 255 ký tự!",
            },
            course_id: {
                required: "Mã khóa học không được bỏ trống!",
            },
            teacher_id: {
                required: "Tên Giảng viên không được bỏ trống!",
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

    function setHtmlRowTableLesson(data, index) {
        let html = '';

        html += `<th style="text-align:center; ">${index}</th>`;
        html += `<th style="text-align:center;">${data.name}</th>`;
        html += `<th style="text-align:center;">${courses[data.course_id].name}</th>`;
        html += `<th style="text-align:center;">`;
        html += `${data.teacher_id == 0 ? '' : teachers[data.teacher_id].name}`;
        html += `</th>`;
        html += `<td>${data.description == null ? '' : data.description}</td>`;
        html += `<td>${data.question == null ? '' : data.question}</td>`;
        html += `<td>${data.document == null ? '' : data.document}</td>`;
        html += `<td>${data.homework == null ? '' : data.homework}</td>`;
        html += `<th>`;
        html += `<button type="button" class="btn btn-outline-success btn-sm btnEdit" data-id="${data.id}">Chỉnh sửa</button>`;
        html += `</th>`;

        return html;
    }
});
