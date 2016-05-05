$(function () {

    $('body').on('change', "input[type='file']", function(e) {
        $('#form-upload-avatar').submit();
    })
    $('body').on('click', '.btn-update-profile', function(e) {
        e.preventDefault();
        $('#update-profile').css('display', 'block');
        $('#update-password').css('display', 'none');
    });
    $('body').on('click', '.btn-update-password', function(e) {
        e.preventDefault();
        $('#update-password').css('display', 'block');
        $('#update-profile').css('display', 'none');
    });

    $('#form-upload-avatar').submit(function(e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var form = $(this);
        var formData = new FormData();
        formData.append('file', $('#file')[0].files[0]);
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: formData,
            async : false,
            cache : false,
            contentType : false,
            processData : false,
            success: function (res) {
                console.log(res);
                if (res.status == true)
                {
                    notie.alert(1, res.messages, 2.5);
                    $('.img-avatar').attr('src', res.data.avatar);
                }
                else
                {
                    notie.alert(4, res.messages, 2.5);
                }
            }
        });
    });

    $('#form-update-profile').submit(function(e) {
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
                    notie.alert(1, res.messages, 2.5);
                    $('div.form-group').removeClass('has-error')
                    .removeClass('has-success');
                    $('.text-danger').remove();
                    $('.profile-name').text(res.data.full_name);
                    $('.profile-phone').text(res.data.phone);
                    $('.profile-address').text(res.data.address);
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

    $('#form-update-password').submit(function(e) {
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
                    notie.alert(1, res.messages, 2.5);
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
})