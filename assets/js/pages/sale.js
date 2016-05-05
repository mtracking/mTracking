$(function() {
    $("body").on("click",".pagination a",function(e){
        e.preventDefault();
        var theUrl = $(this).attr('href');
        var search = $('#form-search-type').find("input[name='search']").val();
        $.get(theUrl, {search:search}, function( my_var ) {
             $('#page-content').replaceWith(my_var);
             backtoTop();
        });
    });

    $('body').on('change', 'select[name=select-status-type]', function (e) {
        e.preventDefault();
        var type_id = $(this).data('type-id');
        var is_available = $(this).val();
        type_div = $(this).closest('.type-item');
        $.ajax({
            url: 'sale/update_type_available/' + type_id,
            type: 'post',
            dataType: 'json',
            data: {is_available: is_available},
            success: function (res) {
                if (res.status == true)
                {
                    $('.messages').html('');
                    type_div.find('.messages').html("<span class='text text-success'><i class='fa fa-check'></i></span>");
                    type_div.find('.text-success').delay(3000).fadeOut('slow');
                }
            }
        })
    });

    $('body').on('change', "input[name='price']", function (e) {
        e.preventDefault();
        var type_id = $(this).data('type-id');
        var price = $(this).val();
        type_div = $(this).closest('.type-item');
        $.ajax({
            url: 'sale/update_type_price/' + type_id,
            type: 'post',
            dataType: 'json',
            data: {price: price},
            success: function (res) {
                if (res.status == true)
                {
                    $('.messages').html('');
                    type_div.find('.messages').html("<span class='text text-success'><i class='fa fa-check'></i></span>");
                    type_div.find('.text-success').delay(3000).fadeOut('slow');
                }
            }
        });
    });

    $('body').on('change', "input[type='file']", function(e) {
        if ($(this).val() != '') {
            $(this).closest('.form-upload-picture').submit();
        }
    })

    $('.form-upload-picture').submit(function(e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var form = $(this);
        var formData = new FormData();
        formData.append('file', $(this).find('#file')[0].files[0]);
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
                    form.closest('.thumbnail').find('img').attr('src', res.data);
                }
                else
                {
                    notie.alert(4, res.messages, 2.5);
                }
            }
        });
    });

});
