//function validation
function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

function validName(name) {
    var rexName = /^[a-zA-Z0-9\á\à\?\ã\?\a\?\?\?\?\?\â\?\?\?\?\?\d\é\è\?\?\?\ê\?\?\?\?\?\í\ì\?\i\?\ó\ò\?\õ\?\ô\?\?\?\?\?\o\?\?\?\?\?\ú\ù\?\u\?\u\?\?\?\?\ý\?\?\?\?\Á\À\?\Ã\?\A\?\?\?\?\?\Â\?\?\?\?\?\Ð\É\È\?\?\?\Ê\?\?\?\?\?\Í\Ì\?\I\?\Ó\Ò\?\Õ\?\Ô\?\?\?\?\?\O\?\?\?\?\?\Ú\Ù\?\U\?\U\?\?\?\?\Ý\?\?\?\?\.\-\_\s]+$/;
    return rexName.test(name);
}

function isEmptyValues(value) {
    return value === undefined || value === null || value === NaN || (typeof value === 'object' && Object.keys(value).length === 0 || (typeof value === 'string' && value.trim().length === 0));
}

function validURL(string) {
    var res = string.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
    return (res !== null);
};


//confirm modal
function showConfirmModal(title, msg, func, data, callback){
    if (data){
        data = JSON.stringify(data);
    }
    var confirmModal;
    confirmModal = $('#confirmModalMsg');
    confirmModal.find('.modal-title').text(title);
    confirmModal.find('.modal-body').text(msg);
    confirmModal.find('#btnConfirm').attr({'rel': func, 'data' : data});
    if (typeof callback !== 'undefined') {
        confirmModal.find('#btnDisagree').attr({'rel': callback, 'data' : data});
    }
    confirmModal.modal('show');
}
//confirm
$('#confirmModalMsg').on('click', '#btnConfirm, #btnDisagree', function(){
    var func, data;
    func = $(this).attr('rel');
    data = $(this).attr('data');
    $('#confirmModalMsg').modal('hide');
    if (isEmptyValues(func)){
        return false;
    }
    window[func](data);
});

// sự kiện show popup
var popup_modal = $("#deleteModal");
function confirm_modal(txttitle = '',txtbody='', func = '',data = '') {
        if (popup_modal == "undefined") {
            return;
    }
    //conver data thành text
    var listdata = JSON.stringify(data);
    // show data lên modal
    popup_modal.find("#modalTitle").text(txttitle);
    popup_modal.find("#modalBody").text(txtbody);
    // gán giá trị modalYes
    popup_modal.find("#modalYes").attr("list-data", listdata);
    // gán giá trị cho function
    popup_modal.find("#modalYes").attr("func", func);
    // show modal
    popup_modal.modal("show");
};
//sư kiện bấm yes
popup_modal.on("click", "#modalYes", function () {
    // lấy giá trị attr khi click yes conver lại data thành json chuẩn
    var data_yes = JSON.parse(popup_modal.find("#modalYes").attr("list-data"));
    // lấy giá trị attr
    let func = $(this).attr('func');
    // gọi lại function attr và gán data
    window[func](data_yes);
});


// Expect input as d/m/y: check valid date
function isValidDate(s) {
  var bits = s.split('/');
  var d = new Date(bits[2], bits[1] - 1, bits[0]);
  return d && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[0]);
}

function isValidDateTime(d) {
    if ( Object.prototype.toString.call(d) === "[object Date]" ) {
      // it is a date
      if ( isNaN( d.getTime() ) ) {  // d.valueOf() could also work
        return false;
      } else {
        return true;
      }
    } else {
      return false;
    }
}

// Format curerency
function currencyFormat (num, unit, deci) {
    if (!deci) {
        deci = 0
    }
    if (typeof unit == 'undefined') {
        unit = 'đ';
    }
    return num.toFixed(deci).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.") + " "+ unit;
}


//loading img
function loadingImg(action){
    if (action === 'show') {
        $('#spinLoading').attr('hidden');
    } else {
        $('#spinLoading').removeAttr('hidden');
    }
}

//leading zero number
function padNumber(n) {
    n = parseInt(n);
    return (n < 10) ? ("0" + n) : n.toString();
}

//unique array()
function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
}
function arrayUnique(arr){
    return arr.filter(onlyUnique);
}

Array.prototype.removeElement = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};

// set get cookie
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

/*remove special char*/
function change_alias( alias ){
    var str = alias;
    str= str.toLowerCase();
    str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str= str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str= str.replace(/đ/g, "d");
    str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g, "-");
    /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
    str= str.replace(/-+-/g, "-"); //thay thế 2- thành 1-
    str= str.replace(/^\-+|\-+$/g, "");
    /*cắt bỏ ký tự - ở đầu và cuối chuỗi*/
    return str;
}

/* Xóa các dữ liệu, validate các trường khi ẩn Modal */
function eventCloseHiddenModal(modal, fieldSelect = []) {
    modal.find('.is-invalid').removeClass('is-invalid');
    modal.find('.form-control').val('');
    if(fieldSelect.length > 0) {
        fieldSelect.forEach(field => {
            modal.find('#' + field).find(`option[value=""]`).prop('selected', true);
        });
    }
}

function setOptionSelectedDisable(id, text) {
    document.getElementById(id).innerHTML = '<option value="" selected disabled>--- Chọn ' + text + ' ---</option>';
}

/* Chỉ sử dụng để đổi các giá trị chuỗi số từ string thành integer */
function changeTypeNumberText(value) {
      if(typeof value == 'string') {
          return Number(value);
      }
      return value;
}

try {
    //show notify message
    function notifyMessage(title = 'Lỗi!', message = '', type = 'error', timeout = 5000) {
        if (!timeout) {
            timeout = 5000;
        }

        if (['success', 'info', 'warning', 'error'].indexOf(type) > -1) {
            Swal.fire({
                title: title,
                icon: type,
                html: message,
                showConfirmButton: true,
                confirmButtonText: 'Đóng',
                timer: timeout
            });
            return;
        }
        Swal.fire({
            title: title,
            icon: 'error',
            html: message,
            showConfirmButton: true,
            confirmButtonText: 'Đóng',
            timer: timeout
        });
        return;
    }

    // scrollTo element
    $(function(){
        $.fn.scrollTo = function(speed){
            if (!speed) {
                speed = 1000;
            }
            $('html, body').animate({
                scrollTop: this.offset().top - 150
            }, speed);
        }
    });

    // ajax get
    function callAjaxGet(url, data, ajaxType, loading) {
        if (!data || typeof data == 'undefined') {
            data = {};
        }
        if (!ajaxType || typeof ajaxType == 'undefined') {
            ajaxType = 'json';
        }
        if (loading !== 'hide') {
            loading = 'show'
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        });
        return $.ajax({
            url: url,
            type: 'get',
            data: data,
            dataType: ajaxType,
            beforeSend: loadingImg(loading),
            timeout: 15000
        })
        .always(function() {
            loadingImg('hide');
        })
        .fail(function(data) {
            // console.log(data);
        })
        .done(function(res){
            /* if (!res.status) {
                checkToken();
            } */
        });
    }

    //ajax post
    function callAjaxPost(url, data, loading) {
        if (!data || typeof data == 'undefined'){
            data = {};
        }
        if (loading !== 'hide') {
            loading = 'show';
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        });
        return $.ajax({
            url: url,
            type: 'post',
            data: data,
            dataType: 'json',
            beforeSend: loadingImg(loading),
            timeout: 15000
        })
        .always(function() {
            loadingImg('hide');
        })
        .fail(function(data) {
            // console.log(data);
        })
        .done(function(res){
            /* if (!res.status) {
                checkToken();
            } */
        });
    }

    function checkErrorResAjax(res) {
        if (!res.status) {
            notifyMessage('Thông báo Lỗi!', res.msg, 'error', 3000);
            return;
        }
    }
} catch(err) {
    console.log(err);
}

$('[data-toggle="popover"]').popover();

$.validator.addMethod("validatePhone", function (value, element) {
    return this.optional(element) || /((09|03|07|08|05)+([0-9]{8})\b)/g.test(value);
}, "Định dạng số điện thoại không đúng!");

$.validator.addMethod("checkBirthday", function (value, element) {
    let now = new Date();
    if( value.slice(6,10) < now.getFullYear() - 15) {
        return true;
    } return false;
}, "Chưa đủ 15 tuổi mà đòi tham gia à?");
