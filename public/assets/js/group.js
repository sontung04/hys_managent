$(document).ready(function() {
    let modalAddGroup = $('#modalAddGroup');

    /* Add new group */
    $('.btnAddGroup').on('click', function(){
        let type = $(this).data('type');
        if(type == 1) {
            ['inputBirthday', 'inputSong', 'inputColor', 'inputAddress', 'inputSlogan'].forEach(field => {
                modalAddGroup.find('#' + field).removeAttr('hidden');
            });
            document.getElementById('modalAddTitle').innerText = 'Thêm Khu vực';
            document.getElementById('inputNameTitle').innerHTML = 'Tên Khu vực: <span class="text-danger">*</span>';
        }

        if(type == 2) {
            ['inputBirthday', 'inputSong', 'inputColor', 'inputAddress', 'inputSlogan'].forEach(field => {
                modalAddGroup.find('#' + field).attr('hidden', 'hidden');
            });
            document.getElementById('modalAddTitle').innerText = 'Thêm Ban chuyên môn';
            document.getElementById('inputNameTitle').innerHTML = 'Tên Ban: <span class="text-danger">*</span>';
        }
        modalAddGroup.find('#type').val(type)
        modalAddGroup.modal('show');
    });

    $('.closeModal').on('click', function () {
        modalAddGroup.find('.form-control').val('');
    });

    let inputBirthday = modalAddGroup.find('#birthday');

    /* set datepicker */
    modalAddGroup.find('#birthdayDate').datetimepicker({
        format : inputBirthday.data('format'),
        locale : 'vi',
        minDate: moment(inputBirthday.data('min'), inputBirthday.data('format')),
        maxDate: moment(inputBirthday.data('max'), inputBirthday.data('format')),
        ignoreReadonly: true,
    });

    modalAddGroup.find('form').validate({
        submitHandler: function () {
            modalAddGroup.find('#description').val(CKEDITOR.instances['description'].getData());

            let data = modalAddGroup.find('form').serialize();

            callAjaxPost(BASE_URL + '/group/saveInfo', data).done(function (res) {
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 5000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg,'success');
                modalAddGroup.modal('hide');
                setTimeout(function(){
                    location.reload();
                }, 3000);
            });
        },

        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 100,
            },
            email: {
                email: true,
            },
        },
        messages: {
            name: {
                required: "Trường này không được để trống!",
                minlength: "Tên nhóm phải dài ít nhất 2 ký tự",
                maxlength: "Tên nhóm không dài quá 255 ký tự "
            },
            email: {
                email: "Định dạng email không đúng!"
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

    /* set ckeditor */
    CKEDITOR.replace( 'description' );

    /* Edit Info group */
    let modalUpdateInfoGroup = $('#modalUpdateInfoGroup');

    /* set datepicker */
    let updateInputBirthday = modalUpdateInfoGroup.find('#birthday');

    modalUpdateInfoGroup.find('#birthdayDate').datetimepicker({
        format : updateInputBirthday.data('format'),
        locale : 'vi',
        date   : moment(updateInputBirthday.val(), updateInputBirthday.data('format')),
        minDate: moment(updateInputBirthday.data('min'), updateInputBirthday.data('format')),
        maxDate: moment(updateInputBirthday.data('max'), updateInputBirthday.data('format')),
        ignoreReadonly: true,
    });
    /* End set datepicker */

    $('#updateInfoGroup').on('click', function(){
        let type = modalUpdateInfoGroup.find('#type').val();
        let desc = modalUpdateInfoGroup.find('#description').val();

        if(type == 1) {
            ['inputBirthday', 'inputSong', 'inputColor', 'inputAddress', 'inputSlogan'].forEach(field => {
                modalUpdateInfoGroup.find('#' + field).removeAttr('hidden');
            });
            document.getElementById('modalUpdateTitle').innerText = 'Cập nhật thông tin Khu vực';
            document.getElementById('labelNameTitle').innerHTML = 'Tên Khu vực: <span class="text-danger">*</span>';
        }

        if(type == 2) {
            ['inputBirthday', 'inputSong', 'inputColor', 'inputAddress', 'inputSlogan'].forEach(field => {
                modalUpdateInfoGroup.find('#' + field).attr('hidden', 'hidden');
            });
            document.getElementById('modalUpdateTitle').innerText = 'Cập nhật thông tin Ban chuyên môn';
            document.getElementById('labelNameTitle').innerHTML = 'Tên Ban: <span class="text-danger">*</span>';
        }


        CKEDITOR.instances['description'].setData(desc);
        modalUpdateInfoGroup.modal('show');
    });

    $('#btnUpdateInfoGroup').on('click', function (){
        modalUpdateInfoGroup.find('#description').val(CKEDITOR.instances['description'].getData());

        let data = modalUpdateInfoGroup.find('form').serialize();

        callAjaxPost(BASE_URL + '/group/saveInfo', data).done(function (res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 5000);
                return;
            }
            notifyMessage('Thông báo!', res.msg,'success');
            modalUpdateInfoGroup.modal('hide');
            setTimeout(function(){
                location.reload();
            }, 3000);
        });
    });
});
