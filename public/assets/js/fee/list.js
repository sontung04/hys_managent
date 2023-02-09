$(function() {
    'use strict'

    //Thêm dataTable vào Table Fee Student List
    $("#tableFeeStudentList").DataTable({
        "responsive": true,
        "autoWidth": false,
        "language": {
            "sProcessing":   "Đang xử lý...",
            "sLengthMenu":   "Xem _MENU_ học viên",
            "sZeroRecords":  "Không tìm thấy học viên phù hợp",
            "sInfo":         "Đang xem _START_ đến _END_ trên tổng số _TOTAL_ học viên",
            "sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 học viên",
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
        "lengthMenu": [[15, 25, 50], [15, 25, 50]],
        "pageLength": 25,
        "processing": true,
        // "order": [[0, 'ASC']],
        drawCallback: function() {
            $('[data-toggle="popover"]').popover();
        }
    });
    //------------------------------------------------------

    $("#tableFeeStudentList").on('click', '.btnViewDetail', function () {
        let id = $(this).attr('data-id');
        window.open(BASE_URL + '/student/fee/detail/' + id);
    });
})
