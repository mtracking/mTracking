$(function () {

    $("body").on("click",".pagination a",function(e){
        e.preventDefault();
        var theUrl = $(this).attr('href');
        $.get(theUrl, function( my_var ) {
            $('#page-content').replaceWith(my_var);
            $('html, body').animate({
                scrollTop: $('.store').find(".all-types").offset().top
            }, 1000);
        });
    });

    $("#form-search-type").submit(function(e) {
        e.preventDefault();
        var theUrl = $(this).attr('action');
        var search_type = $(this).find('input[name="search_type"]').val();
        console.log(theUrl);
        $.get(theUrl, {search_type:search_type}, function( my_var ) {
            $('.store').replaceWith(my_var);
            $('html, body').animate({
                scrollTop: $('.store').find(".all-types").offset().top
            }, 1000);
        });
    });
    $('body').on('click', '.btn-add-cart', function(event) {
        var url = $(this).data('add-cart-url');
        var type_id = $(this).data('type-id');
        var type_name = $(this).closest('div.thumbnail').find('.type-name').attr('title');
        var type_price = $(this).closest('div.thumbnail').find('.price-item').text();
        var type_image = $(this).closest('div.thumbnail').find('img').attr('src');
        addCart(url, type_id, type_name, type_price, type_image);
    });

    $('body').on('click', '.btn-buy', function(event) {
        var url = $(this).data('buy-now-url');
        var type_id = $(this)
                        .closest('div')
                        .find('.btn-add-cart')
                        .data('type-id');
        var type_name = $(this).closest('div.thumbnail').find('.type-name').attr('title');
        var type_price = $(this).closest('div.thumbnail').find('.price-item').text();
        var type_image = $(this).closest('div.thumbnail').find('img').attr('src');
        addCart(url, type_id, type_name, type_price, type_image)
    });
});

function addCart(url, type_id, type_name, type_price, type_image)
{
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: {type_id: type_id, type_name: type_name, type_price: type_price, type_image: type_image},
        success: function (res) {
            console.log(res);
            if (res.status == true) {
                notie.alert(1, res.messages, 2.5);
                var new_number_order = parseInt($('.number-order').text()) + 1;
                $('.number-order').text(new_number_order);
                if (res.redirect_url)
                {
                    notie.alert(1, res.messages, 2.5);
                    window.location.replace(res.redirect_url);
                }
            }
            else {
                notie.alert(2, res.messages, 2.5);
            }
        }
    })
}