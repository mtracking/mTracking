$(function() {
    // pagination page
    $("body").on("click",".pagination a",function(e) {
        e.preventDefault();
        var theUrl = $(this).attr('href') + '?sort_by=' + status_order;
        $.get(theUrl, function( my_var ) {
            $('#page-content').replaceWith(my_var);
        });
    });

    $('body').on('click', '.sort-by', function(e){
        e.preventDefault();
        var theUrl = $(this).attr('href');
        $.get(theUrl, function( my_var ) {
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
                else {
                    notie.alert(3, res.messages, 2.5);
                }
            }
        })
    })
})