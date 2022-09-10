$(document).ready(function() {
    let calWeekHys = $("#calendarWeekHys");
    let modalCalWeekHys = $('#modalCalWeekHys');

    let areaColor = {
        0: '#007bff',
        1: '#007bff',
        2: '#ffc107',
        3: '#fd7e14',
        4: '#17a2b8',
        5: '#dc3545',
        6: '#e83e8c',
        7: '#28a745',
    }

    /* Tạo lịch tuần và render dữ liệu theo tuần */
    calWeekHys.fullCalendar({
        header: {
            left: "prev,next today",
            center: "title",
            right: ""
        },

        defaultView: "agendaWeek",

        navLinks: true, // can click day/week names to navigate views
        selectable: false,
        selectHelper: true,
        editable: false,
        eventLimit: true, // allow "more" link when too many events


        columnHeaderFormat: 'ddd D/MM',
        allDaySlot: false,
        // select: ,

        events: function (start, end, timezone, callback) {

            callAjaxGet(BASE_URL + '/calendar/weekHys/getListAjax', {starttime: start.toISOString(), finishtime: end.toISOString()})
                .done(function(res) {
                    if (!res.status) {
                        notifyMessage('Lỗi!', res.msg, 'error', 2000);
                        return;
                    }
                    let datas = res.data;

                    let events = [];

                    for (let x in datas) {
                        events.push({
                            id              : datas[x].id,
                            title           : datas[x].title,
                            description     : datas[x].description,
                            address         : datas[x].address,
                            area            : datas[x].area,
                            group_id        : datas[x].group_id,
                            group_name      : datas[x].group_name,
                            formality       : datas[x].formality,
                            start           : datas[x].starttime,
                            end             : datas[x].finishtime,
                            backgroundColor : areaColor[datas[x].area]
                        });
                    }

                    if (callback) callback(events);
                });
        },

        eventRender: function(event, element) {
            element.find('.fc-title').append('<div class="hr-line-solid-no-margin"></div><span>HYS ' + areaName[event.area] + '</span></div>');
            $(element).popover({
                title: event.title + '<a class="text-green btnEdit float-right" data-id="'+ event.id +'"><i class="fas fa-edit"></i></a>',
                placement: 'right',
                trigger: 'click',
                container: 'body',
                html:true,
                content: setHtmlContentPopover(event),
                sanitize  : false,
            });
        },

        eventClick: function(calEvent, jsEvent) {

        }
    });

    /* thêm option cho lịch */
    calWeekHys.fullCalendar('option', {
        locale: 'vi',
        slotLabelFormat: "HH:mm",
        timeFormat: 'H(:mm)',
    });

    let inputStarttime = modalCalWeekHys.find('#starttime');

    /* set datetimepicker input starttime */
    modalCalWeekHys.find('#inputStarttime').datetimepicker({
        format : inputStarttime.data('format'),
        locale : 'vi',
        minDate: moment(dateBirthdayHys, inputStarttime.data('format')),
        ignoreReadonly: true,
        icons: {
            time: "fa-solid fa-clock",
        }
    });

    /* set datepicker input finishtime */
    modalCalWeekHys.find('#inputFinishtime').datetimepicker({
        format : inputStarttime.data('format'),
        locale : 'vi',
        minDate: moment(dateBirthdayHys, inputStarttime.data('format')),
        ignoreReadonly: true,
        icons: {
            time: "fa-solid fa-clock",
        }
    });

    //Sự kiện Đóng modal
    $('.closeModal').on('click', function () {
        $('#selectGroup').attr('hidden','hidden');
        setEmptyOptionSelectGroup();
        eventCloseHiddenModal(modalCalWeekHys, ['area']);
    });

    //Sự kiện Ẩn Modal
    modalCalWeekHys.on('hidden.bs.modal', function(){
        $('#selectGroup').attr('hidden','hidden');
        setEmptyOptionSelectGroup();
        eventCloseHiddenModal(modalCalWeekHys, ['area']);
    });

    //click button add new calendar
    $('#btnAddCalendarWeekHys').on('click', function() {
        modalCalWeekHys.modal("show");
    });

    //Lấy danh sách Group con theo khu vực
    $('#area').on('change', function () {
        $('#selectGroup').removeAttr('hidden');
        setEmptyOptionSelectGroup();

        let valArea = this.value;
        if(valArea != '') {
            getOptionSelectGroup(valArea);
        }
    });

    /* Event click Btn Edit 1 Event Data */
    $(document).on("click", ".btnEdit", function(event) {
        let id = $(this).attr('data-id');

        let eventData = calWeekHys.fullCalendar("clientEvents", id);
        eventData = eventData[0];

        ['id', 'title', 'address', 'description'].forEach(field => {
            modalCalWeekHys.find('#' + field).val(eventData[field]);
        });
        if(eventData.formality) {
            modalCalWeekHys.find('#formality1').prop('checked', true);
        } else {
            modalCalWeekHys.find('#formality2').prop('checked', true);
        }

        modalCalWeekHys.find('#area').find(`option[value="${eventData['area']}"]`).prop('selected', true);

        $('#selectGroup').removeAttr('hidden');
        getOptionSelectGroup(eventData.area, eventData.group_id);

        modalCalWeekHys.find('#starttime').val($.fullCalendar.formatDate(eventData.start, 'DD/MM/YYYY HH:mm'));
        if(eventData.end != null) {
            modalCalWeekHys.find('#finishtime').val($.fullCalendar.formatDate(eventData.end, 'DD/MM/YYYY HH:mm'));
        }

        $('.popover').popover('hide');
        modalCalWeekHys.modal("show");
    });

    /* Thêm validate kiểm tra finishtime lớn hơn starttime */
    $.validator.addMethod("checkFinishTime", function () {
        let finishTimeVal = modalCalWeekHys.find('#finishtime').val();
        if(finishTimeVal != '') {
            let startTimeVal = modalCalWeekHys.find('#starttime').val();
            if(moment(startTimeVal, 'DD/MM/YYYY HH:mm').valueOf() > moment(finishTimeVal, 'DD/MM/YYYY HH:mm').valueOf()) {
                return false;
            }
        }
        return true;
    }, "Thời gian kết thúc phải lớn hơn thời gian bắt đầu!");

    //Submit form thêm mới 1 hoạt động tuần
    modalCalWeekHys.find('form').validate({
        submitHandler: function () {
            if($('#group_id').val() != '0') {
                $("#group_name").val($( "#group_id option:selected" ).attr('data-name'));
            } else {
                $("#group_name").val("")
            }

            let data = modalCalWeekHys.find('form').serialize();
            let id = $("#id").val();

            callAjaxPost(BASE_URL + '/calendar/weekHys/saveInfoAjax', data).done(function(res) {
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 5000);
                    return;
                }
                notifyMessage('Thông báo!', res.msg,'success');
                modalCalWeekHys.modal('hide');
                let data = res.data;
                if(id == '') {
                    let eventData = {
                        id              : data['id'],
                        title           : data['title'],
                        description     : data['description'],
                        address         : data['address'],
                        area            : data['area'],
                        group_id        : data['group_id'],
                        group_name      : data['group_name'],
                        formality       : data['formality'],
                        start           : changeValDateToIosString(data['starttime']),
                        end             : changeValDateToIosString(data['finishtime']),
                        backgroundColor : areaColor[data['area']]
                    };
                    calWeekHys.fullCalendar("renderEvent", eventData);
                } else {
                    let eventData = calWeekHys.fullCalendar("clientEvents", data['id']);
                    eventData[0].title           = data['title'];
                    eventData[0].description     = data['description'];
                    eventData[0].address         = data['address'];
                    eventData[0].group_id        = data['group_id'];
                    eventData[0].group_name      = data['group_name'];
                    eventData[0].formality       = data['formality'];
                    eventData[0].start           = changeValDateToIosString(data['starttime']);
                    eventData[0].end             = changeValDateToIosString(data['finishtime']);
                    eventData[0].backgroundColor = areaColor[data['area']];
                    calWeekHys.fullCalendar("updateEvent", eventData[0]);
                }
            });
        },

        rules: {
            area: {
                required: true,
            },
            title: {
                required: true,
            },
            starttime: {
                required: true,
            },
            finishtime: {
                checkFinishTime: true
            }
        },
        messages: {
            area: {
                required: "Khu vực không được để trống!",
            },
            title: {
                required: "Tiêu đề hoạt động không được để trống!",
            },
            starttime: {
                required: "Thời gian bắt đầu không được để trống!",
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

    /* function gọi Ajax để lấy ra các giá trị Option Select Group */
    function getOptionSelectGroup(valArea, valGroupId = 0) {
        callAjaxGet(BASE_URL + '/group/getListGroupOptionAjax', {area: valArea, type: 'all'})
            .done(function(res) {
                if (!res.status) {
                    notifyMessage('Lỗi!', res.msg, 'error', 2000);
                    setEmptyOptionSelectGroup();
                    return;
                }
                let html = '';

                html = setHtmlSelectOptionGroupId(res.data, html, valGroupId);
                $('#group_id').append(html);
            });
    }

    /* function tạo code html Option Select Group */
    function setHtmlSelectOptionGroupId(datas, html, valSel = 0) {
        for (let x in datas) {
            html += `<option value="${datas[x].id}" data-name="${groupType[datas[x].type]} ${datas[x].name}"`;

            if(valSel != 0 && datas[x].id == valSel) {
                html += ' selected';
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
                html = setHtmlSelectOptionGroupId(datas[x].child, html, valSel);
            }
        }
        return html;
    }

    /* function tạo code HTML cho phần body popover Event */
    function setHtmlContentPopover(eventData) {
        let html = '';
        html += '<strong>Hình thức: </strong>';
        if(eventData.formality) {
            html += 'Offline';
        } else {
            html += 'Online';
        }

        if(eventData.group_id != '0') {
            html += '<br><strong>Đơn vị: </strong>' + eventData.group_name;
        }

        if(eventData.address != null ) {
            html += '<br><strong>Địa diểm: </strong>' + eventData.address;
        }

        if(eventData.description != null) {
            html += '<br><strong>Nội dung: </strong>' + eventData.description;
        }

        return html;
    }

    /* function làm trống ô select group_id */
    function setEmptyOptionSelectGroup() {
        $('#group_id').empty();
        $('#group_id').append('<option value="0" selected>--- Chọn đơn vị phụ trách ---</option>');
    }

    /* function đổi format định dạng ngày tháng để khởi tạo event Cal */
    function changeValDateToIosString(date) {
        if(date !== null) {
            let arrDate = date.split(" ");
            let arrDay = arrDate[0].split("/");
            let dateReturn = new Date(arrDay[2] + '-' + arrDay[1] + '-' + arrDay[0] + ' ' + arrDate[1]);
            return new Date(dateReturn.getTime() - (dateReturn.getTimezoneOffset() * 60000)).toISOString();
        }
         return "";
    }
});
