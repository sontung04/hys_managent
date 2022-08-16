$(document).ready(function() {

    //Thêm dataTable vào bảng Table Group
    $("#tableGroup").DataTable({
        "responsive": true,
        "autoWidth": false,
        "language": {
            "sProcessing":   "Đang xử lý...",
            "sLengthMenu":   "Xem _MENU_ bản ghi",
            "sZeroRecords":  "Không tìm thấy bản ghi phù hợp",
            "sInfo":         "Đang xem _START_ đến _END_ trên tổng số _TOTAL_ bản ghi",
            "sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 bản ghi",
            "sInfoFiltered": "",
            "sInfoPostFix":  "",
            "sSearch":       "Tìm kiếm:",
            "sUrl":          "",
            "oPaginate": {
                "sFirst":    "Trang đầu",
                "sPrevious": "Trang trước",
                "sNext":     "Trang sau",
                "sLast":     "Trang cuối"
            },

        },
        "columnDefs": [
            {
                "targets": [ 8 ],
                "orderable": false
            },
        ],
        "processing": true,
        "order": [[0, 'DESC']],
        drawCallback: function() {
            $('[data-toggle="popover"]').popover();
        }
    });
    //------------------------------------------------------

    // $("#tableGroup").find('[data-toggle="popover"]').popover();

    /* set ckeditor */
    CKEDITOR.replace( 'description', {
        height: 150,
    });

    $("#tableGroup").on('click', '.btnView', function () {
        let id = $(this).attr('data-id');
        window.open(BASE_URL + '/group/detail/' + id);
    });

    let modalAddGroup = $('#modalAddGroup');
    let inputBirthday = modalAddGroup.find('#birthday');

    /* set datepicker */
    modalAddGroup.find('#birthdayDate').datetimepicker({
        format : inputBirthday.data('format'),
        locale : 'vi',
        minDate: moment(inputBirthday.data('min'), inputBirthday.data('format')),
        maxDate: moment(inputBirthday.data('max'), inputBirthday.data('format')),
        ignoreReadonly: true,
    });

    $('#btnAddGroup').on('click', function () {
        modalAddGroup.modal('show');
    });

    //Event change Group-Type option select
    $('#type').on('change', function () {
        let valType = this.value;

        remoteSetOptionDefault('parent');
        remoteSetOptionDefault('depart');

        if(['3', '4'].includes(valType)) {
            modalAddGroup.find('#area').find(`option[value="1"]`).prop('disabled', true);
        }
        $('#inputSong').attr('hidden', 'hidden');
        $('#inputColor').attr('hidden', 'hidden');

        switch (valType) {
            case '1':
                ['selectArea', 'selectParent', 'selectDepart'].forEach(id => {
                    $('#' + id).attr('hidden', 'hidden');
                });
                ['area', 'parent', 'depart'].forEach(field => {
                    modalAddGroup.find('#' + field).find(`option[value="0"]`).prop('selected', true);
                });
                $('#inputSong').removeAttr('hidden');
                $('#inputColor').removeAttr('hidden');
                break;

            case '2':
                ['selectArea', 'selectParent', 'selectDepart'].forEach(id => {
                    $('#' + id).removeAttr('hidden');
                });
                ['area', 'parent', 'depart'].forEach(field => {
                    modalAddGroup.find('#' + field).find(`option[value=""]`).prop('selected', true);
                });
                modalAddGroup.find('#area').find(`option[value="1"]`).removeAttr('disabled');
                $('#inputSong').removeAttr('hidden');
                $('#inputColor').removeAttr('hidden');
                break;

            case '3':
                $('#selectArea').removeAttr('hidden');
                $('#selectParent').attr('hidden', 'hidden');
                $('#selectDepart').attr('hidden', 'hidden');
                ['parent', 'depart'].forEach(field => {
                    modalAddGroup.find('#' + field).find(`option[value="0"]`).prop('selected', true);
                });
                break;

            case '4':
                $('#selectArea').removeAttr('hidden');
                $('#selectParent').removeAttr('hidden');
                $('#selectDepart').attr('hidden', 'hidden');
                modalAddGroup.find('#depart').find(`option[value="0"]`).prop('selected', true);
                ['area', 'parent'].forEach(field => {
                    modalAddGroup.find('#' + field).find(`option[value=""]`).prop('selected', true);
                });
                break;

            case '5':
                ['selectArea', 'selectParent', 'selectDepart'].forEach(id => {
                    $('#' + id).removeAttr('hidden');
                });
                ['area', 'parent', 'depart'].forEach(field => {
                    modalAddGroup.find('#' + field).find(`option[value=""]`).prop('selected', true);
                });
                break;

            default:
                break;
        }

    });

    //Event change Area option select
    $('#area').on('change', function () {
        let valArea = this.value;
        let valType = $('#type').val();

        remoteSetOptionDefault('parent');

        if(valType == '2') {
            if(valArea == '1') {
                $('#selectParent').attr('hidden', 'hidden');
                $('#selectDepart').attr('hidden', 'hidden');
                ['parent', 'depart'].forEach(field => {
                    modalAddGroup.find('#' + field).find(`option[value="0"]`).prop('selected', true);
                });
                return;
            } else {
                $('#selectParent').removeAttr('hidden', 'hidden');
                $('#selectDepart').removeAttr('hidden', 'hidden');
                ['parent', 'depart'].forEach(field => {
                    modalAddGroup.find('#' + field).find(`option[value=""]`).prop('selected', true);
                });
            }
        }

        if(valType == '5' && valArea == '1') {
            $('#selectParent').attr('hidden', 'hidden');
            $('#selectDepart').removeAttr('hidden', 'hidden');
            $('#parent').append(`<option value="1" hidden="hidden"></option>`);
            modalAddGroup.find('#parent').find(`option[value="1"]`).prop('selected', true);
            modalAddGroup.find('#depart').find(`option[value=""]`).prop('selected', true);
            getListGroup(valArea, valType, 'depart', 0, 1);
            return;
        }

        getListGroup(valArea, valType, 'parent');

    });

    //Event change Parent option select
    $('#parent').on('change', function () {
        let valType = $('#type').val();

        remoteSetOptionDefault('depart');

        if(valType == '2' || valType == '5') {
            let valArea    = $('#area').val();
            let valParent  = $('#parent').val();
            getListGroup(valArea, valType, 'depart', 0, valParent);
        }
    });

    //Sự kiện Đóng modal
    $('.closeModal').on('click', function () {
        resetModalAddGroup();
        eventCloseHiddenModal(modalAddGroup, ['type', 'area']);
    });

    //Xóa validate khi ẩn modal
    modalAddGroup.on('hidden.bs.modal', function(){
        resetModalAddGroup();
        eventCloseHiddenModal(modalAddGroup, ['type', 'area']);
    });


    $("#tableGroup").on('click', '.btnEdit', function () {

        let id = $(this).attr('data-id');

        callAjaxGet(BASE_URL + '/group/getInfoGroupAjax/' + id).done(function (res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 5000);
                return;
            }
            let groupInfo = res.data;
            let fieldsGroup = ['id','name', 'email', 'slogan', 'song', 'color', 'address',
                                    'birthday', 'facebook', 'zalo', 'instagram', 'tiktok' ];
            // /* set field value */
            fieldsGroup.forEach(field => {
                modalAddGroup.find('#' + field).val(groupInfo[field]);
            });

            CKEDITOR.instances['description'].setData(groupInfo['description']);
            if(groupInfo['status']) {
                modalAddGroup.find('#status1').prop('checked', true);
            } else {
                modalAddGroup.find('#status2').prop('checked', true);
            }

            modalAddGroup.find('#type').find(`option[value="${groupInfo['type']}"]`).prop('selected', true);

            if(groupInfo['type'] != 1 ) {
                $('#selectArea').removeAttr('hidden');
                modalAddGroup.find('#area').find(`option[value="${groupInfo['area']}"]`).prop('selected', true);

                if(groupInfo['type'] != 3 && !(groupInfo['type'] == 2 && groupInfo['area'] == 1)) {
                    $('#selectParent').removeAttr('hidden');
                    getListGroup(groupInfo['area'], groupInfo['type'], 'parent', groupInfo['parent']);
                    modalAddGroup.find('#parent').find(`option[value="${groupInfo['parent']}"]`).prop('selected', true);

                    if (groupInfo['type'] != 4) {
                        $('#selectDepart').removeAttr('hidden');
                        getListGroup(groupInfo['area'], groupInfo['type'], 'depart', groupInfo['depart'], groupInfo['parent']);
                    }
                }
            } else {
                ['area', 'parent', 'depart'].forEach(field => {
                    modalAddGroup.find('#' + field).find(`option[value="0"]`).prop('selected', true);
                });
            }

            modalAddGroup.modal('show');
        });
    })

    //Submit form và validate form
    modalAddGroup.find('form').validate({
        submitHandler: function () {
            modalAddGroup.find('#description').val(CKEDITOR.instances['description'].getData());

            let data = modalAddGroup.find('form').serialize();

            callAjaxPost(BASE_URL + '/group/saveInfo', data).done(function(res) {
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 5000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg,'success');
                resetModalAddGroup();
                modalAddGroup.modal('hide');

                setTimeout(function(){
                    window.location.reload();
                    }, 1000);
            });
        },

        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 200,
            },
            type: {
                required: true
            },
            area: {
                required: true
            },
            parent: {
                required: true
            },
            depart: {
                required: true
            },
        },
        messages: {
            name: {
                required: 'Tên Group là bắt buộc',
                min: 'Tên Group phải có độ dài tối thiểu 2 ký tự',
                max: 'Tên Group không dài quá 200 ký tự'
            },
            type: {
                required: 'Bắt buộc phải lựa chọn loại Group'
            },
            area: {
                required: 'Bắt buộc phải lựa chọn khu vực'
            },
            parent: {
                required: 'Bắt buộc phải chọ group trực thuộc'
            },
            depart: {
                required: 'Bắt buộc phải chọn phòng ban'
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

    //function lấy ra danh sách các group để gán vào option
    function getListGroup(area, type, field, valSel = 0, parent = 0) {
        if(area != null && type != null) {
            if(type != '1' && type != '3') {

                let requestData = {
                    area: area,
                    type: type,
                    field: field,
                    parent: parent
                };

                callAjaxGet(BASE_URL + '/group/getListGroupOption', requestData)
                    .done(function(res) {
                        if (!res.status) {
                            notifyMessage('Lỗi!', res.msg, 'error', 2000);
                            return;
                        }

                        let html = '';
                        html = setHtmlSelectOption(res.data, html, valSel);
                        $('#' + field).append(html);
                });
            }
        }
    }

    /* function tạo code html Option */
    function setHtmlSelectOption(datas, html, valSel) {
        for (let x in datas) {

            html += `<option value="${datas[x].id}" `;
            if(valSel != 0 && datas[x].id == valSel) {
                html += 'selected';
            }
            html += ' >';
            for(let i = 0; i < datas[x].step ; i++) {
                html += `--- `;
            }
            if(datas[x].type == 1) {
                html += 'HYS ' + datas[x].name;
            } else {
                html += groupType[datas[x].type] + ' ' + datas[x].name;
            }

            html += `</option>`;
            if(typeof datas[x].child !== 'undefined' && Object.keys(datas[x].child).length > 0) {
                html = setHtmlSelectOption(datas[x].child, html);
            }
        }

        return html;
    }

    /* function xóa các Option Select và gán lại 2 option Default */
    function remoteSetOptionDefault(field, text = '') {
        $('#' + field).empty();
        let html = '';
        html += '<option value="" selected disabled>--- Chọn '
        if(field == 'parent') {
            html += 'Group trực thuộc';
        } else if(field == 'depart') {
            html += 'Phòng ban';
        } else {
            html += text;
        }
        html += ' ---</option>';
        html += '<option value="0" hidden="hidden"></option>';

        $('#' + field).append(html);
    }

    function resetModalAddGroup() {
        ['selectArea', 'selectParent', 'selectDepart'].forEach(id => {
            $('#' + id).attr('hidden', 'hidden');
        });
        remoteSetOptionDefault('parent');
        remoteSetOptionDefault('depart');

        CKEDITOR.instances['description'].setData('');
    }

});
