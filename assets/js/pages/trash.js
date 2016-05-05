$(function () {
    $("body").on("click",".pagination a",function(e) {
        e.preventDefault();
        var theUrl = $(this).attr('href');
        var search_item = $('#form-search-item').find("input[name='search_item']").val();
        // var search_email = $('#form-search-order').find("input[name='search_email']").val();
        $.get(theUrl, {sort_by:kind_of_items, search_item:search_item}, function( my_var ) {
            $('#page-content').replaceWith(my_var);
            backtoTop();
        });
    });

    //delete one row of types table
    $('body').on('click', '.item-delete', function() {
        item_id = $(this).data('item-id');
        $("input[name='item-id']").val(item_id);
        url = $(this).data('action-url');
        console.log(url);
        $('#deleting-confirm').text($(this).data('inform-delete') + $(this).data('item'));
        $('#deleted-confirm-btn').attr('data-action-url', url);
    });

    $('body').on('click', '#deleted-confirm-btn', function() {
        item_id = $("input[name='item-id']").val();
        var actionUrl = $(this).data('action-url') + '/' + item_id;
        $.ajax({
            url: actionUrl,
            type: 'post',
            dataType: 'json',
            success: function(res) {
                console.log(res);
                if (res.status == true) {
                    row = $('tr#item-' + item_id);
                    row.hide('slow', function() {
                        row.remove();
                    });
                }
                else {
                    $(".messages").html("<div class='alert alert-warning'>" + res.messages + "</div>");
                }
            }
        }).error(function() {

        });
    });

    $("body").on("click", ".btn-restore", function (e) {
        e.preventDefault();
        var theUrl = $(this).attr('href');
        var row = $(this).closest('tr');
        console.log(theUrl);
        $.ajax({
            url: theUrl,
            type: 'post',
            dataType: 'json',
            success: function (res) {
                console.log(res);
                if (res.status == true)
                {
                    row.hide('slow', function() {
                        $.get(window.location.href, function(my_var) {
                           row.remove();
                        });
                    });
                }
                else
                {
                    $(".messages").html("<div class='alert alert-warning'>" + res.messages + "</div>");
                }
            }
        })
    })
})