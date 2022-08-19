$(function () {
    'use strict'

    let addUserGroupRoleModal = $('#addUserGroupRoleModal');
    let editStatusModal = $('#editStatusModal');

    let settingDateTime = new function() {
        this.locale     = 'vi';
        this.dateFormat = 'DD/MM/YYYY';
        this.maxDate    = moment(addUserGroupRoleModal.find('#inputAddStarttime').data('max'), this.dateFormat);
        this.minDate    = moment('17/11/2013', this.dateFormat);
    };

    ['addStarttime', 'addFinishtime', 'updateStarttime', 'updateFinishtime'].forEach(field => {
        $('#' + field).datetimepicker({
            format : settingDateTime.dateFormat,
            locale : settingDateTime.locale,
            useCurrent: false,
            minDate: settingDateTime.minDate,
            maxDate: settingDateTime.maxDate,
            ignoreReadonly: true,
        });
    });

    $('#btnAddRoleUser').click(function () {
        // document.getElementById('addUserGroupRoleModalTitle').innerText = 'Thêm chức vụ thành viên';
        ['area', 'group_type'].forEach(field => {
            addUserGroupRoleModal.find('#' + field).find(`option[value=""]`).prop('selected', true);
        });

        setOptionSelectedDisable('selectRole', 'Chức vụ');
        setEmptySelectGroup();

        addUserGroupRoleModal.modal('show');
    });

    //Event change option select area
    $('#area').on('change', function () {
        let valArea = this.value;
        let valType = $('#group_type').val();

        showGroupChild(valArea, valType);

        if(valArea == 1 && ['3', '4', '5'].includes(valType)) {
            setEmptySelectGroup();
            setOptionSelectedDisable('selectRole', 'Chức vụ');
        }
    })

    //Event change option select group type
    $('#group_type').on('change', function () {
        let valType = this.value;
        let valArea = $('#area').val();

        if(valType == '1') {
            setEmptySelectGroup();
        }

        showGroupChild(valArea, valType);

        if(valArea == 1 && ['3', '4', '5'].includes(valType)) {
            setEmptySelectGroup();
            setOptionSelectedDisable('selectRole', 'Chức vụ');
        } else {
            callAjaxGet(BASE_URL + '/role/getListRole', {group_type: valType}).done(function(res) {
                checkErrorResAjax(res);

                let data = res.data;
                let html = '<option value="" selected disabled>--- Chọn Chức vụ ---</option>';
                html += '<option value="0">Thành viên</option>'

                for (const x in data) {
                    html += `<option value="${data[x].id}">${data[x].name}</option>`;
                }

                document.getElementById('selectRole').innerHTML = html;
            });
        }
    });

    //Xóa validate khi ẩn modal
    addUserGroupRoleModal.on('hidden.bs.modal', function(){
        eventCloseHiddenModal(addUserGroupRoleModal)
    });


    //Submit form thêm add UserGroupRole
    addUserGroupRoleModal.find('form').validate({
        submitHandler: function () {

            let data = addUserGroupRoleModal.find('form').serialize();
            let groupParent = addUserGroupRoleModal.find('#selectGroup').find(':selected').data('parent');
            data += '&parent=' + groupParent;

            callAjaxPost(BASE_URL + '/ugr/saveInfoUgr', data).done(function(res) {
                checkErrorResAjax(res);

                notifyMessage('Thông báo!', res.msg,'success');
                addUserGroupRoleModal.modal('hide');
                setTimeout(function(){ window.location.reload(); }, 1000);
            });
        },

        rules: {
            area: {
                required: true,
            },
            group_type: {
                required: true,
            },
            group_id: {
                required: true,
            },
            role_id: {
                required: true,
            },
        },
        messages: {
            area: {
                required: "Vui lòng chọn Khu vực",
            },
            group_type: {
                required: "Vui lòng chọn Cấp chức vụ",
            },
            group_id: {
                required: "Vui lòng chọn Nhóm, Phòng ban",
            },
            role_id: {
                required: "Vui lòng chọn chức vụ",
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

    //Update Status Record button click
    $('.btnEditStatus').on('click', function (event) {
        event.preventDefault();

        let id = $(this).attr('data-id');
        let type = $(this).attr('data-type');
        let content = $(this).attr('data-content');
        callAjaxGet(BASE_URL + '/ugr/getInfoAjax', {type: type, id: id}).done(function(res) {
            checkErrorResAjax(res);

            console.log(res.data)
            let data = res.data;
            editStatusModal.find('#id').val(id);
            editStatusModal.find('#type').val(type);

            if(data.status == '1') {
                editStatusModal.find('#statusU1').prop('checked', true);
            } else {
                editStatusModal.find('#statusU2').prop('checked', true);
            }

            editStatusModal.find('#inputUpdateStarttime').val(data.starttime);
            editStatusModal.find('#inputUpdateFinishtime').val(data.finishtime);

            document.getElementById('editStatusModalTitle').innerText = content;
            editStatusModal.modal('show');
        });

        /* set field value */

    });

    //Update Status Record submit form
    editStatusModal.on('submit', function (event) {
        event.preventDefault();

        let data = editStatusModal.find('form').serialize();

        callAjaxPost(BASE_URL + '/ugr/updateStatusUg', data).done(function(res) {
            checkErrorResAjax(res);

            notifyMessage('Thông báo!', res.msg,'success');
            editStatusModal.modal('hide');
            setTimeout(function(){ window.location.reload(); }, 1000);
        });
    });
    //End update Status Record

    // Delete record Ugr
    $('.btnDeleteUgr').on('click', function (event) {
        event.preventDefault();

        Swal.fire({
            title: 'Cảnh báo!',
            icon: 'warning',
            text: 'Bạn có chắc chắn muốn xóa chức vụ này?',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy bỏ',
        }).then((result) => {
            if (result.value) {
                let id = $(this).attr('data-id');
                callAjaxGet(BASE_URL + '/ugr/deleteAjax/' + id).done(function(res) {
                    if (!res.status) {
                        notifyMessage('Thông báo lỗi!', res.msg, 'error', 5000);
                        return;
                    }
                    notifyMessage('Thông báo!', res.msg,'success')
                    setTimeout(function(){ window.location.reload(); }, 1000);
                });
            }
        })
    });
    // End Delete record Ugr

    //Function làm trống Select Group và ẩn trường select
    function setEmptySelectGroup() {
        $('#selectGroup').empty();
        $('#divGroup').attr('hidden', 'hidden');
    }

    //Lấy ra các group con theo area + type và gắn vào option
    function showGroupChild(area, type) {
        if(area != null && type != null) {

            if (area == '1' && ['3', '4', '5'].includes(type)) {
                notifyMessage('Thông báo lỗi!', 'Dữ liệu trống. Vui lòng thử lại sau!', 'error', 2000);
            } else if (type != '1') {

                callAjaxGet(BASE_URL + '/group/getListGroupChild', {area: area, type: type}).done(function(res) {
                    document.getElementById('selectGroupLabel').innerHTML = `${groupType[type]}` + ' ' + '<span style="color: red">*</span>';
                    let html = '';
                    html += `<option selected disabled>--- Chọn ${groupType[type]} ---</option>`;
                    if (!res.status) {
                        notifyMessage('Thông báo lỗi!', res.msg, 'error', 2000);
                    } else {
                        let data = res.data;
                        let childs = data['child'];
                        for(let i = 0; i < childs.length; i++) {
                            html += `<option value="${childs[i].id}" data-parent="${childs[i].parent}">
                                    ${groupType[childs[i].type] + ' ' + childs[i].name}
                                </option>`;
                        }

                        for (let x in data) {
                            if(x != 'child') {
                                let dataChild = data[x];
                                // console.log(dataChild)
                                html += `<optgroup label="${groupType[dataChild.type] + ' ' + dataChild.name}">`;
                                for (let j = 0; j < dataChild['child'].length; j++) {
                                    html += `<option value="${dataChild['child'][j].id}" data-parent="${x}">
                                            ${groupType[dataChild['child'][j].type] + ' ' + dataChild['child'][j].name}
                                        </option>`;
                                }
                                html += `</optgroup>`;
                            }
                        }
                    }

                    document.getElementById('selectGroup').innerHTML = html;
                    $('#divGroup'). removeAttr('hidden');
                });
            }
        }
    }
})
