$(function () {
    'use strict'

    $('#btnAddRole').click(function () {
        document.getElementById('addEditRoleModalTitle').innerText = 'Thêm chức vụ thành viên';
        $('#addEditRoleModal').modal('show');
    })

    $('.btnEditRole').click(function () {
        document.getElementById('addEditRoleModalTitle').innerText = 'Chỉnh sửa chức vụ thành viên';
        $('#addEditRoleModal').modal('show');
    })
})
