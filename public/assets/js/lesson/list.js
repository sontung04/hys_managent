$(function () {
  'use strict'
  CKEDITOR.replace('description');
  CKEDITOR.replace('document');
  CKEDITOR.replace('question');
  CKEDITOR.replace('homework');
  let modalAddLesson = $('#modalAddLesson');
  $( "#btnAddLesson" ).click(function() {
      document.getElementById('modalAddLessonTitle').innerText='Thêm Bài học mới';
      modalAddLesson.modal('show');
});
$('#tableLessonList').on('click', '.btnEdit', function(){
  document.getElementById('modalAddLessonTitle').innerText = "Chỉnh sửa thông tin Bài học";
  let id = $(this).attr('data-id');
  callAjaxGet(BASR_URL + '/lesson/list/getInfoAjax/' + id).done(function (res){
      if(!res.status){
          notifyMessage('Lỗi!', res.msg, 'error', 3000);
          return;
      }
      let lessonInfo = res.data;
      /* set field value */
      ['id', 'name', 'teacher_id',   'course_id'].forEach(field => {
          modalAddLesson.find('#' + field).val(lessonInfo[field]);
      })
          CKEDITOR.instances['description'].setData(LessonInfo['description']);
          CKEDITOR.instances['question'].setData(LessonInfo['question']);
          CKEDITOR.instances['document'].setData(LessonInfo['document']);
          CKEDITOR.instances['homework'].setData(LessonInfo['homework']);
          modalAddLesson.modal('show');
  });
});

$('.closeModal').on('click', function() {            CKEDITOR.instances['description'].setData('');
  eventCloseHiddenModal(modalAddLesson);    
})
modalAddLesson.on('hidden.bs.modal', function(){
  eventCloseHiddenModal(modalAddLesson);
});

$('#formAddLesson').validate({
  submitHandler: function () {
      modalAddLesson.find('#description').val(CKEDITOR.instances['description'].getData());
      let data = modalAddLesson.find('form').serialize();
      callAjaxPost(BASE_URL + '/Lesson/saveInfoAjax', data).done(function(res){
          if (!res.status) {
              notifyMessage('Lỗi!', res.msg, 'error', 5000);
              return;
          }
          notifyMessage('Thông báo!', res.msg,'success');
          modalAddLesson.modal('hide');
          setTimeout(function(){ window.location.reload(); }, 1000);               
      })       
  },
  rules: {
      name: {
          required: true,
          minlength: 2,
          maxlength: 255,
      },
      course_id: {
        required: true,
        minlength: 2,       
      },
      teacher_id: {
        required: true,
        minlength: 2,        
      },
  },
  messages: {
      name: {
          required: "Tên bài học không được bỏ trống",
          minlength: "Tên bài học phải có tối thiểu 2 ký tự",
          maxlength: "Tên bài học phải có tối đa 255 ký tự",
      },
      course_id: {
        required: "Mã khóa học không được bỏ trống",
        minlength: "Mã khóa học phải có tối thiểu 2 ký tự",
      },
      teacher_id: {
        required: "Tên giáo viên không được bỏ trống",
        minlength: "Tên giảng viên phải có tối thiểu 2 ký tự",
      }
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
