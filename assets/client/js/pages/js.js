$(function(){
    
    var url = window.location.href;
    $('.sidebar-nav a[href="' + url + '"]').parent('li').addClass('active');

    $('.form-update-status').submit(function(e){
        e.preventDefault();
        var url = $(this).attr('action');
        var form = $(this);
        var update_user_url = form.data('update-user-url');
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: form.serialize(),
            success: function (res) {
                console.log(res);
                if (res.status == true)
                {
                    $('div.form-group').removeClass('has-error')
                    .removeClass('has-success');
                    $('.text-danger').remove();
                    form[0].reset();
                    if (typeof serial_no != 'undefined') {
                        updateUserForProduct(update_user_url);
                    }
                    else
                    {
                        $('#LoginModal').modal('toggle');
                        location.reload();
                    }
                }
                else
                {
                    $.each(res.messages, function(index, val) {
                        var ele = form.find('#' + index);
                        ele.closest('div.form-group')
                        .removeClass('has-error')
                        .addClass(val.length > 0 ? 'has-error' : 'has-success')
                        .find('.text-danger').remove();
                        ele.after(val);
                    });
                }
            }
        })
    });

    $('#form-forgot-password').submit(function(e) {
        $('button').prop( "disabled", true);
        e.preventDefault();
        var url = $(this).attr('action');
        form = $(this);
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: form.serialize(),
            success: function (res) {
                $('button').prop( "disabled", false);
                console.log(res);
                if (res.status == true)
                {
                    var all_forms = form.closest('.form');
                    all_forms.css('display', 'none');
                    $('#login').fadeIn('slow').css('display', 'block');
                    $(".messages").html("<div class='alert alert-success'>" + res.messages + "</div>");
                }
                else
                {
                    $.each(res.messages, function(index, val) {
                        var ele = form.find('#' + index);
                        ele.closest('div.form-group')
                        .removeClass('has-error')
                        .addClass(val.length > 0 ? 'has-error' : 'has-success')
                        .find('.text-danger').remove();
                        ele.after(val);
                    });
                }
            }
        })
    });

    $(".link-to-register").on('click', function () {
        var all_forms = $(this).closest('.form');
        $('.messages').html('');
        all_forms.css('display', 'none');
        $('#register').fadeIn('slow').css('display', 'block');
    });

    $(".link-to-login").on('click', function () {
        var all_forms = $(this).closest('.form');
        $('.messages').html('');
        all_forms.css('display', 'none');
        $('#login').fadeIn('slow').css('display', 'block');
    });

    $(".link-to-forgot-password").on('click', function () {
        var all_forms = $(this).closest('.form');
        $('.messages').html('');
        all_forms.css('display', 'none');
        $('#forgot-password').fadeIn('slow').css('display', 'block');
    });
})