$(function (){
    $('#form-register').submit(function(e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var form = $(this);
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: form.serialize(),
            success: function (res) {
                console.log(res);
                if (res.status == true)
                {
                    window.location.replace(res.redirect_url);
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
})