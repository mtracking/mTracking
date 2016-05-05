$(function () {

    $('body').on('change', "input[type='file']", function(e) {
        $('#form-upload-header').submit();
    })

    $("#form-customize").submit(function(e) {
        e.preventDefault();
        $(".messages").html('');
        var form = $(this);
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(res) {
                if (res.status == true) {
                    $(".messages").html("<div class='alert alert-success'>" + res.messages + "</div>");
                    if (form.data('request') == 'create')
                    {
                        form[0].reset();
                        $('#summernote').summernote('code', null);
                    }
                }
                else {
                    $(".messages").html("<div class='alert alert-warning'>" + res.messages + "</div>");
                }
                backtoTop();
            }
        }).error(function() {

        });
    });

    $('#form-upload-header').submit(function(e) {
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
                backtoTop();
                if (res.status == true)
                {
                    $('.bg-header').attr('src', res.data);
                }
                else
                {
                    $(".messages").html("<div class='alert alert-warning'>" + res.messages + "</div>");
                }
            }
        });
    });
})