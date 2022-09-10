$(document).ready(function () {
  $(".table-hideable .hide-col").each(HideColumnIndex);

  // on click
  $(".hide-column").click(HideColumnIndex);

  function HideColumnIndex() {
    var $el = $(this);
    var $cell = $el.closest("th,td");
    var $table = $cell.closest("table");

    // get cell location - https://stackoverflow.com/a/4999018/1366033
    var colIndex = $cell[0].cellIndex + 1;
    // find and hide col index
    $table
      .find("tbody tr, thead tr")
      .children(":nth-child(" + colIndex + ")")
      .addClass("hide-col");

    // show restore footer
    $table.find(".footer-restore-columns").show();
  }

  // restore columns footer
  $(".restore-columns").click(function (e) {
    var $table = $(this).closest("table");
    $table.find(".footer-restore-columns").hide();
    $table.find("th, td").removeClass("hide-col");
  });

  $('[data-toggle="tooltip"]').tooltip({
    trigger: "hover",
  });

  let max = 0;
  let stt = 1;
  $("#insertCol").click(function () {
    let html1 = "";
    max++;
    html1 += `<th>Buổi ${stt} <button style="border: 0; background-color: #F8F9FC" data-stt="${stt}" class="checkBox${stt} select-all"><i
    class="fa-solid fa-check-double" style="color:green;"  data-toggle="tooltip" data-placement="right" title="Chọn tất cả"></i></button><br><button type="button"
    class="btn addNewInfo" data-toggle="modal" data-stt="${stt}" data-target="#exampleModal">
    Thêm
    </button>  <button class="pull-right btn btn-default btn-condensed hide-column" data-toggle="tooltip" data-placement="bottom" title="Ẩn cột">
    <i class="fa fa-eye-slash"></i>  
    </button> </th>`;
    $("#row1").append(html1);
    for (let i = 0; i < 5; i++) {
      $(`#row${i + 2}`)
        .append(`<td><input type="checkbox" id="checkBox${stt}" name="name" value="name">
      <select name="cars" id="cars" >
        <option value="saab" selected></option>
          <option value="saab" >Có phép</option>
          <option value="opel">Không phép</option>
          <option value="audi">Đi muộn</option>
        </select>
      </td>`);
    }

    // on init
    $(".table-hideable .hide-col").each(HideColumnIndex);

    // on click
    $(".hide-column").click(HideColumnIndex);

    function HideColumnIndex() {
      var $el = $(this);
      var $cell = $el.closest("th,td");
      var $table = $cell.closest("table");

      // get cell location - https://stackoverflow.com/a/4999018/1366033
      var colIndex = $cell[0].cellIndex + 1;
      // find and hide col index
      $table
        .find("tbody tr, thead tr")
        .children(":nth-child(" + colIndex + ")")
        .addClass("hide-col");

      // show restore footer
      $table.find(".footer-restore-columns").show();
    }

    // restore columns footer
    $(".restore-columns").click(function (e) {
      var $table = $(this).closest("table");
      $table.find(".footer-restore-columns").hide();
      $table.find("th, td").removeClass("hide-col");
    });

    $('[data-toggle="tooltip"]').tooltip({
      trigger: "hover",
    });

    let check = true;

    $(".select-all").click(function () {
      let sttt = $(this).attr("data-stt");
      console.log(sttt, $(this).hasClass("allChecked"));
      if (max % 2 === 1) {
        if ($(this).hasClass("allChecked") === false && sttt % 2 === 1) {
          $(`input:checkbox[id^="checkBox${sttt}"][type="checkbox"]`).prop(
            "checked",
            true
          );
        } else if ($(this).hasClass("allChecked") === true && sttt % 2 === 1) {
          $(`input:checkbox[id^="checkBox${sttt}"][type="checkbox"]`).prop(
            "checked",
            false
          );
        } else if (sttt % 2 === 0 && check === true) {
          $(`input:checkbox[id^="checkBox${sttt}"][type="checkbox"]`).prop(
            "checked",
            true
          );
          check = false;
        } else if (sttt % 2 === 0 && check === false) {
          $(`input:checkbox[id^="checkBox${sttt}"][type="checkbox"]`).prop(
            "checked",
            false
          );
          check = true;
        }
      } else {
        if ($(this).hasClass("allChecked") === false && sttt % 2 === 0) {
          $(`input:checkbox[id^="checkBox${sttt}"][type="checkbox"]`).prop(
            "checked",
            true
          );
        } else if ($(this).hasClass("allChecked") === true && sttt % 2 === 0) {
          $(`input:checkbox[id^="checkBox${sttt}"][type="checkbox"]`).prop(
            "checked",
            false
          );
        } else if (sttt % 2 === 1 && check === true) {
          $(`input:checkbox[id^="checkBox${sttt}"][type="checkbox"]`).prop(
            "checked",
            true
          );
          check = false;
        } else if (sttt % 2 === 1 && check === false) {
          $(`input:checkbox[id^="checkBox${sttt}"][type="checkbox"]`).prop(
            "checked",
            false
          );
          check = true;
        }
      }
      $(this).toggleClass("allChecked");
    });
    stt++;
    // $(".btn.btn-primary.addNewInfo").click(function (){
    //    let sttt = $(this).attr("data-stt");
    //    alert(sttt)
    //    $().hide(); 
      
    //   // $(".addNewInfo").prop("hidden", "true");
    // })
    $("#exampleModal").on('click', ".saveNewInfo", function(){
      $(".addNewInfo").hide(); 
      $('#btnClose-add').click();
      
  });

})
});