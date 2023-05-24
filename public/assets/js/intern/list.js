$(function (){
   'use strict'

    let modalUpdateIntern = $('#modalUpdateIntern');

    let inputBirthday = modalUpdateIntern.find('#birthday');

    let internInfo = [];

    /* set datetimepicker */
    ['birthdayDate', 'starttimeDate', 'finishtimeDate'].forEach(field => {
        modalUpdateIntern.find('#' + field).datetimepicker({
            format : datetimepicketFormat,
            locale : 'vi',
            useCurrent: false,
            minDate: moment(inputBirthday.data('min'), datetimepicketFormat),
            maxDate: moment(currentMaxDate, datetimepicketFormat),
        });
    });

    $('#tableInternList').on('click', '.btnEdit', function() {
        document.getElementById('modalUpdateInternTitle').innerText = 'Chỉnh sửa thông tin thực tập sinh ';

        let id = $(this).attr('data-id'); //student_id
        let code = $(this).attr('data-code'); //student_code
        callAjaxGet(BASE_URL + '/student/getInfoAjax/' + id).done(function(res) {

            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }
            let studentInfo = res.data;

            /* set field value */
            modalUpdateIntern.find('#student_code').val(studentInfo['code']);
            [ 'name', 'gender', 'birthday', 'email', 'phone'].forEach(field => {
                modalUpdateIntern.find('#' + field).val(studentInfo[field]);
            });

            if (studentInfo['gender']) {
                modalUpdateIntern.find('#gender1').prop('checked', true);
            }  else {
                modalUpdateIntern.find('#gender2').prop('checked', true);
            }

            $('#gender1:radio:not(:checked)').attr('disabled', true);
            $('#gender2:radio:not(:checked)').attr('disabled', true);
            // $(':radio:not(:checked)').attr('disabled', true);
        });

        callAjaxGet(BASE_URL + '/intern/getInfoAjax/' + code).done(function (res) {
            if (!res.status) {
                notifyMessage('Lỗi!', res.msg, 'error', 3000);
                return;
            }

            internInfo = res.data;

            /* set field value */
            [ 'starttime', 'finishtime', 'status'].forEach(field => {
                modalUpdateIntern.find('#' + field).val(internInfo[field]);
            });

            if (internInfo['status']) {
                modalUpdateIntern.find('#status1').prop('checked', true);
            } else {
                modalUpdateIntern.find('#status2').prop('checked', true);
            }
            modalUpdateIntern.modal('show');
        });

    });

    $('.btnUpdateIntern').on('click', function (){

        let data = modalUpdateIntern.find('form').serializeArray();

        let useData = [];
        for (let i = 0; i < data.length; i++) {
            if (data[i]['name'] == 'status'){
                useData['status'] = data[i]['value'];
            }
            if (data[i]['name'] == 'finishtime'){
                useData['finishtime'] = data[i]['value'];
                if (useData['finishtime'] == ''){
                    useData['finishtime'] = null;
                }
            }
        }
        if (internInfo['status'] == useData['status'] && internInfo['finishtime'] == useData['finishtime']){
            notifyMessage('Lỗi!', 'Dữ liệu không đổi','error', 5000);
            return;
            // setTimeout(function (){window.location.reload(); }, 1000);
        }else {
            callAjaxPost(BASE_URL + '/intern/updateInfoAjax', data).done(function(res){
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 5000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg,'success');
                modalUpdateIntern.modal('hide');
                setTimeout(function(){ window.location.reload(); }, 1000);
            });
        }
    });

    //Sự kiện Ẩn Modal
    modalUpdateIntern.on('hidden.bs.modal', function() {
        eventCloseHiddenModal(modalUpdateIntern);
    });

    //Sự kiện Đóng modal
    $('.closeModal').on('click', function() {
        eventCloseHiddenModal(modalUpdateIntern);
    });


});
