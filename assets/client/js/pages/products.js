$(function() {
    $("#form-send-order").submit(function(e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var form = $(this);
        var params = form.serialize();
        params += '&total_money=' + total_money;
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
                }
                else
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
            }
        });
    });
});

function updateUserForProduct(update_user_url)
{
    $.ajax({
        url: update_user_url,
        type: 'post',
        dataType: 'json',
        data: {serial_no: serial_no},
        success: function (res) {
            console.log(res);
            if (res.status == true)
            {
                $('#LoginModal').modal('toggle');
                $('.messages').html(res.messages);
            }
            else
            {
                $('#LoginModal').modal('toggle');
                $('.messages').html(res.messages);
            }
            $('.btn-shop-now').css('display', 'inline');
            $('.btn-login').css('display', 'none');
        }
    });
}



