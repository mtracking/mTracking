$(function() {
    // pagination page
    $("body").on("click",".pagination a",function(e) {
        e.preventDefault();
        var theUrl = $(this).attr('href') + '?sort_by=' + status_order;
        var search_email = $('#form-search-order').find("input[name='search_email']").val();
        $.get(theUrl, {search_email:search_email}, function( my_var ) {
            $('#page-content').replaceWith(my_var);
            backtoTop();
        });
    });

    $('body').on('click', '.sort-by', function(e){
        e.preventDefault();
        var theUrl = $(this).attr('href');
        var search_email = $('#form-search-order').find("input[name='search_email']").val();
        $.get(theUrl, {search_email:search_email}, function( my_var ) {
            $('#page-content').replaceWith(my_var);
        });
    })

    $('body').on('click', '.read-more', function(e) {
        e.preventDefault();
        var element = $(this).parent().find('.order-content');
        content = element.data('content');
        element.html((content));
        $(this).remove();
    })

    $('body').on('change', 'select[name=select-status-order]', function (e) {
        e.preventDefault();
        var order_id = $(this).data('order-id');
        var new_status_order = $(this).val();
        $.ajax({
            url: 'orders/change_status_order/' + order_id,
            type: 'post',
            dataType: 'json',
            data: {status_order: new_status_order},
            success: function (res) {
                if (res.status == true) {
                    $('#order-item-' + order_id).hide('slow', function() {
                        $.get(window.location.href + '?sort_by=' + status_order, function( my_var ) {
                            $('#page-content').replaceWith(my_var);
                        });
                    });
                }
            }
        })
    });

    $('body').on('click', '.btn-delete-order', function (e) {
        e.preventDefault();
        var order_id = $(this).data('order-id');
        $.ajax({
            url: 'orders/delete/' + order_id,
            type: 'post',
            dataType: 'json',
            data: {},
            success: function (res) {
                if (res.status == true) {
                    $('#order-item-' + order_id).hide('slow', function() {
                        $.get(window.location.href + '?sort_by=' + status_order, function( my_var ) {
                            $('#page-content').replaceWith(my_var);
                        });
                    });
                }
            }
        })
    })

})