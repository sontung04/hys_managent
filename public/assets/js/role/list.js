$(function () {
    'use strict'

    /* set ckeditor */
    CKEDITOR.replace( 'description' );

    let modalAddRole = $('#modalAddRole');

    //* Add new Role
    $('#btnAddRole').click(function () {
        document.getElementById('modalAddRoleTitle').innerText = 'Thêm chức vụ mới';
        modalAddRole.modal('show');
    });

    //* Edit Info 1 Role
    $('#tableRoleList').on('click', '.btnEdit', function () {
        document.getElementById('modalAddRoleTitle').innerText = 'Chỉnh sửa chức vụ';

        let id = $(this).attr('data-id');
        callAjaxGet(BASE_URL + '/role/getInfo/' + id).done(function (res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 5000);
                return;
            }
            let roleInfo = res.data;

            /* set field value */
            ['id','name'].forEach(field => {
                modalAddRole.find('#' + field).val(roleInfo[field]);
            });

            CKEDITOR.instances['description'].setData(roleInfo['description']);
            if(roleInfo['status']) {
                modalAddRole.find('#status1').prop('checked', true);
            } else {
                modalAddRole.find('#status2').prop('checked', true);
            }
            modalAddRole.find('#group_type').find(`option[value="${roleInfo['group_type']}"]`).prop('selected', true);

            modalAddRole.modal('show');
        });
    });

    //Sự kiện Đóng modal
    $('.closeModal').on('click', function () {
        CKEDITOR.instances['description'].setData('');
        eventCloseHiddenModal(modalAddRole, ['group_type']);
    });

    //Sự kiện Ẩn Modal
    modalAddRole.on('hidden.bs.modal', function(){
        eventCloseHiddenModal(modalAddRole, ['group_type']);
    });

    modalAddRole.find('form').validate({
        submitHandler: function () {
            modalAddRole.find('#description').val(CKEDITOR.instances['description'].getData());
            let data = modalAddRole.find('form').serialize();

            callAjaxPost(BASE_URL + '/role/saveInfo', data).done(function(res) {
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 5000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg,'success');
                modalAddRole.modal('hide');
                setTimeout(function(){ window.location.reload(); }, 1000);
            });
        },

        rules: {
            name: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Tên chức vụ không được để trống",
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

})
