$(function () {
    'use strict'
    CKEDITOR.replace( 'description' );
    let modalAddCourse = $('#modalAddCourse');
    $( "#btnAddCourse" ).click(function() {
        document.getElementById('modalAddCourseTitle').innerText='Thêm Khóa học mới';
        modalAddCourse.modal('show');
});
    $('#tableCourseList').on('click', '.btnEdit', function(){
        document.getElementById('modalAddCourseTitle').innerText = "Chỉnh sửa thông tin Khóa học";
        let id = $(this).attr('data-id');
        callAjaxGet(BASR_URL + '/course/list/getInfoAjax/' + id).done(function (res){
            if(!res.status){
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }
            let courseInfo = res.data;
            /* set field value */
            ['id', 'name', 'fees', 'length', 'description', 'status'].forEach(field => {
                modalAddCourse.find('#' + field).val(courseInfo[field]);
            })
                CKEDITOR.instances['description'].setData(courseInfo['description']);
                if(courseInfo['status']) {
                    modalAddCourse.find('#status1').prop('checked', true);
                } else {
                    modalAddCourse.find('#status2').prop('checked', true);
                }
                modalAddCourse.modal('show');

            
        });
    });

    $('.closeModal').on('click', function() {            CKEDITOR.instances['description'].setData('');
        eventCloseHiddenModal(modalAddCourse);    
    })
    modalAddCourse.on('hidden.bs.modal', function(){
        eventCloseHiddenModal(modalAddCourse);
    });
// $.validator.setDefaults({

// });
    $('#formAddCourse').validate({
        submitHandler: function () {
            modalAddCourse.find('#description').val(CKEDITOR.instances['description'].getData());
            let data = modalAddCourse.find('form').serialize();
            callAjaxPost(BASE_URL + '/course/saveInfoAjax', data).done(function(res){
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 5000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg,'success');
                modalAddCourse.modal('hide');
                setTimeout(function(){ window.location.reload(); }, 1000);               
            })       
        },
        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 255,
            },
        },
        messages: {
            name: {
                required: "Tên khóa học không được bỏ trống",
                minlength: "Tên khóa học phải có tối thiểu 2 ký tự",
                maxlength: "Tên khóa học phải có tối đa 255 ký tự",
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


