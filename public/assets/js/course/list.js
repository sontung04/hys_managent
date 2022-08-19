$(document).ready(function () {
    $(function () {
        CKEDITOR.replace( 'description' );
    })
    $( ".editCourseModal" ).click(function() {
    $('#modalAddCourse').modal('show');
});
$.validator.setDefaults({
    submitHandler: function () {
    alert("Thêm mới thành công!");
    }
});
$('#formAddCourse').validate({
    rules: {
    name: {
        required: true,
    },

    },
    messages: {
    name: {
        required: "Tên khóa học không được bỏ trống"
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


