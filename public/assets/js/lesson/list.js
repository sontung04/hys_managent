$(document).ready(function () {
    $(function () {
      CKEDITOR.replace('description');
      CKEDITOR.replace('document');
      CKEDITOR.replace('question');
      CKEDITOR.replace('homework');
    })

    $(".editModalLesson").click(function () {
      $('#modalAddLesson').modal('show');
    });
    $.validator.setDefaults({
      submitHandler: function () {
        alert("Thêm mới thành công!");
      }
    });
    $('#formAddLesson').validate({
      rules: {
        name: {
          required: true,
        },
        course_id: {
          required: true,
        },
      },
      messages: {
        name: {
          required: "Tên bài học không được bỏ trống!"
        },
        course_id: {
          required: "Mã khóa học không được bỏ trống!"
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