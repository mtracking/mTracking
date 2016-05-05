$(function () {
    // disable scroll
    $('table').on('focus', "input[type='number']", function (e) {
      $(this).on('mousewheel.disableScroll', function (e) {
        e.preventDefault()
      })
    })

    $('table').on('blur', "input[type='number']", function (e) {
      $(this).off('mousewheel.disableScroll')
    })

    totalMoney();

    $("input[type='number']").bind('keyup mouseup', function () {
        totalMoney();
    });

    $('body').on('click', '.btn-remove-cart', function () {
        var cart_item = $(this).data('cart-item');
        $('#removeCartModal').find("input[name='cart-item']").val(cart_item);
    });

    $('body').on('click', '.btn-confirm-remove', function () {
        var cart_item = new Array();
        cart_item.push($('#removeCartModal').find("input[name='cart-item']").val());
        var url = $(this).data('remove-cart-url');
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data:{cart_item:cart_item},
            success: function (res) {
                if (res.status === true)
                {
                    var row = $('table').find('#cart-item-' + cart_item);
                    row.hide('slow', function(){
                        row.remove();
                        row.promise().done(function(){
                            totalMoney();
                        });
                    });
                }
                else
                {
                    notie.alert(3, res.messages, 2.5);
                }
            }
        });
    });

    $("body").on("click",".pagination a",function(e){
        e.preventDefault();
        var theUrl = $(this).attr('href');
        $.get(theUrl, function( my_var ) {
            $('#page-content').replaceWith(my_var);
        });
    });

    $("#form-send-order").submit(function(e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var form = $(this);
        var rows = $('table').find('tr.cart-item');
        var total_money = $('.total-money').text();
        var types = new Array();
        $.each(rows, function(index, val) {
            var type = {
                name : $(this).find('.type-name').attr('title'),
                quantity : $(this).find("input[type='number']").val()
            }
            types.push(type);
        });
        var params = form.serialize();
        params +='&types=' + JSON.stringify(types) + '&total_money=' + total_money;
        console.log(params);
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: params,
            success: function (res) {
                console.log(res);
                if (res.status == true)
                {
                    $('.messages').html("<p class='alert alert-success'>" + res.messages + '</p>');
                    $('div.form-group').removeClass('has-error')
                                        .removeClass('has-success');
                    $('.text-danger').remove();
                    form[0].reset();
                    $('.table-responsive').remove();
                    $('.btn-order').remove();
                    $('#contactModal').modal('toggle');
                }
                else
                {
                    if (typeof res.messages === 'object')
                    {
                        $.each(res.messages, function(index, val) {
                            var ele = $('#' + index);
                            ele.closest('div.form-group')
                                .removeClass('has-error')
                                .addClass(val.length > 0 ? 'has-error' : 'has-success')
                                .find('.text-danger').remove();
                            ele.after(val);
                        });
                    }
                    else
                    {
                        notie.alert(3, res.messages, 2.5);
                        $('#contactModal').modal('toggle');
                    }
                }
            }
        });
    });
});

function totalMoney()
{
    var rows = $('table').find('tr.cart-item');
    var sum = 0;
    $.each(rows, function(index, val) {
        var price = $(this).find('.price').text();
        var quantity = $(this).find("input[type='number']").val();
        sum += price * quantity;
    });
    $('.total-money').text(sum.toFixed(2));
}