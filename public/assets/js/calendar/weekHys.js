$(document).ready(function() {
    $("#calendar").fullCalendar({
        header: {
            left: "prev,next today",
            center: "title",
            right: "agendaWeek"
        },

        defaultView: "basicWeek",
        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        selectHelper: true,
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        select: $('#btnAddCalendarWeekHys').on('click', function(start, end) {
            // Display the modal.
            // You could fill in the start and end fields based on the parameters


            $("#modalAddCalWeekHys")
                .find("#title")
                .val("");
            $("#modalAddCalWeekHys")
                .find("#description")
                .val("");
            $("#modalAddCalWeekHys")
                .find("#starts-at")
                .val("");
            $("#modalAddCalWeekHys")
                .find("#ends-at")
                .val("");

            $("#modalAddCalWeekHys").modal("show");

        }),

        eventRender: function(event, element) {
            //dynamically prepend close button to event
            element.find('.fc-title').append('<div class="hr-line-solid-no-margin"></div><span style="font-size: 10px">' + event.title2 + '</span></div>');
            element
                .find(".fc-content")
                .prepend("<span class='closeon material-icons'>&#xe5cd;</span>");
            element.find(".closeon").on("click", function() {
                $("#calendar").fullCalendar("removeEvents", event._id);
            });

        },

        eventClick: function(calEvent, jsEvent) {

            // Display the modal and set event values.
            // $(".modal").modal("show");
            $("#modalAddCalWeekHys")
                .find("#title")
                .val(calEvent.title);
            $("#modalAddCalWeekHys")
                .find("#id")
                .val(calEvent.id);
            $("#modalAddCalWeekHys")
                .find("#description")
                .val(calEvent.description);
            $("#modalAddCalWeekHys")
                .find("#starts-at")
                .val(calEvent.start);
            $("#modalAddCalWeekHys")
                .find("#ends-at")
                .val(calEvent.end);
            console.log(123);

            $("#modalAddCalWeekHys").modal('show')
            $("#edit").attr("hidden", "hidden");
            $("#save-event").attr("hidden", "hidden");

        }
    });

    // Bind the dates to datetimepicker.
    $("#starts-at, #ends-at").datetimepicker();

    //click to save "save"
    $("#save-event").on("click", function(event) {
        var title = $("#title").val();
        var title2 = $("#description").val();
        var start = $('#starts-at').val();
        var end = $('#ends-at').val();


        let id = Math.floor(Math.random() * 1000);
        console.log(id);

        if (title) {
            var eventData = {
                title: title,
                description: title2,
                id: id,
                start: start,
                end: end
            };
            $("#calendar").fullCalendar("renderEvent", eventData); // stick? = true
        }
        $("#calendar").fullCalendar("unselect");
        console.log(eventData);

        // Clear modal inputs
        $(".modal")
            .find("input")
            .val("");
        // hide modal
        $(".modal").modal("hide");
    });

    $(".editBtn").on("click", function(events, element) {
        var title3 = $("#title").val();
        var title4 = $("#description").val();
        var id = $("#id").val();
        var start2 = $("#starts-at").val();
        var end2 = $("#ends-at").val();
        console.log(id)
        $("#calendar").fullCalendar("removeEvents", events._id);
        if (title) {
            var events = {
                title: title3,
                description: title4,
                id: id,
                start: start2,
                end: end2,
            };
            console.log(123)
            console.log(events)
            $("#calendar").fullCalendar("renderEvent", events)
        }

        // Clear modal inputs
        $(".modal")
            .find("input")
            .val("");
        // hide modal
        $(".modal").modal("hide");
    });
});
