$(document).ready(function() {

    console.log('hello user');
    console.log(BASE_URL);
    let formUpdateInfoUser = $('#formUpdateInfoUser');

    formUpdateInfoUser.on('click', '#btnSubmit', function () {
        let data = formUpdateInfoUser.serialize()

        console.log(data);
        callAjaxPost(BASE_URL + '/user/saveInfo', data).done(function (res) {
            if (!res.status) {
                console.log(res);
                notifyMessage('Lỗi!', res.msg, 'error', 5000);
                return;
            }
            notifyMessage('Thông báo!', res.msg,'success');
            setTimeout(function(){
                location.reload();
                }, 3000);
        });

    })

});
