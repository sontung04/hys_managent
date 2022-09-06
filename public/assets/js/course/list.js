$(function () {
    'use strict'
    CKEDITOR.replace( 'description' );
    let modalAddCourse = $('#modalAddCourse');

    $( "#btnAddCourse" ).click(function() {
        document.getElementById('modalAddCourseTitle').innerText = 'Thêm Khóa học mới';
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
            });

            CKEDITOR.instances['description'].setData(courseInfo['description']);
            if(courseInfo['status']) {
                modalAddCourse.find('#status1').prop('checked', true);
            } else {
                modalAddCourse.find('#status2').prop('checked', true);
            }
            modalAddCourse.modal('show');


        });
    });

    //Sự kiện Đóng modal
    $('.closeModal').on('click', function() {
        CKEDITOR.instances['description'].setData('');
        eventCloseHiddenModal(modalAddCourse);
    })

    //Sự kiện Ẩn modal
    modalAddCourse.on('hidden.bs.modal', function(){
        CKEDITOR.instances['description'].setData('');
        eventCloseHiddenModal(modalAddCourse);
    });


    /* Thêm validate kiểm tra học phí khóa học */
    $.validator.addMethod("checkFees", function (value) {
        if(value % 1000 == 0) {
            return true;
        } return false;
    }, "Học phí phải là 1 số chia hết cho 1000!");

    /* Submit form modal course */
    modalAddCourse.find('form').validate({
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
            fees: {
                required: true,
                min: 0,
                max: 100000000,
                checkFees: true
            },
        },
        messages: {
            name: {
                required: "Tên khóa học không được bỏ trống!",
                minlength: "Tên khóa học phải có tối thiểu 2 ký tự!",
                maxlength: "Tên khóa học phải có tối đa 255 ký tự!",
            },
            fees: {
                required: "Học phí khóa học không được bỏ trống!",
                min: "Học phí phải lớn hơn hoặc bằng 0!",
                max: "Học phí đắt thế ai học?"
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


