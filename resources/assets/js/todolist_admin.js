$(document).ready(function(){
    $.ajax({
        type: "GET",
        url: "task/data",
        success: function (result) {
            $.each(result, function (i, item) {
                $('.list_of_items').append("<div class='todolist_list showactions list1' id='"+ item.id +"'>   " +
                    "<div class='col-md-8 col-sm-8 col-xs-8 nopadmar custom_textbox1'> <div class='todoitemcheck'>"+
                    "<input type='checkbox' class='striked'"+ ((item.finished==1)?"checked":"") + " autocomplete='off' />"+
                    "</div> <div class='todotext "+ ((item.finished==1)?"strikethrough":"")+" todoitemjs'>" + item.task_description + "</div> <span class='label label-default'>" +
                    item.task_deadline + "</span> <span class='label label-info'>"+ item.task_from+"</span></div>");
            });
        }
    });

});

$(document).on('click', '.striked', function (e) {
    var id = $(this).closest('.todolist_list').attr('id');
    var hasClass = $(this).closest('.todolist_list').find('.todotext').hasClass('strikethrough');
    $.ajax({
        type: "POST",
        url: "task/" + id + "/edit",
        data: { _token: $('meta[name="_token"]').attr('content'),'finished':((hasClass)?0:1)},
    });

    $(this).closest('.todolist_list').find('.todotext').toggleClass('strikethrough');
    $(this).closest('.todolist_list').find('.showbtns').toggle();
});
