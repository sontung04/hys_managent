$(document).ready(function() {
    // $("#example1").DataTable({
    //     "responsive": true,
    //     "autoWidth": false,
    // });

    let formFilterUser = $('#formFilterUser');
    let filterJointime = formFilterUser.find('#jointime');

    /* set datepicker */
    formFilterUser.find('#filterJointime').datetimepicker({
        format : filterJointime.data('format'),
        locale : 'vi',
        useCurrent: false,
        // defaultDate: '',
        minDate: moment(filterJointime.data('min'), filterJointime.data('format')),
        maxDate: moment(filterJointime.data('max'), filterJointime.data('format')),
        // ignoreReadonly: true,
    });
    filterJointime.val(filterJointime.data('value'));


    //Xử lý phân trang bằng Ajax
    $('.pagination').on('click', '.page-item a', function(){
        $('#formFilterUser input[name="page"]').val(parseInt($(this).attr('data-page')));
        $('#formFilterUser #btnSubmit').trigger('click');
        return false;
    });

    $("#usersTable").on('click', '.btnViewProfile', function () {
        let id = $(this).attr('data-id');
        window.open(BASE_URL + '/user/profile/' + id);
    });

    $("#usersTable").on('click', '.btnViewUrg', function () {
        let id = $(this).attr('data-id');
        window.open(BASE_URL + '/role/manage/' + id);
    });

    //Đặt các trường dữ liệu về empty khi khi bấm reset form filter
    formFilterUser.on('click', '#btnReset', function () {
        formFilterUser.find('.form-control').val('');
        formFilterUser.find('#area').find(`option[value=""]`).prop('selected', true);
    })
});
