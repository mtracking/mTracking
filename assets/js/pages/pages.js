$(function() {

    $("#form-page").submit(function(e) {
        e.preventDefault();
        $(".messages").html('');
        var form = $(this);
        console.log($(this).serialize());
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

    $("body").on("click",".pagination a",function(e){
        e.preventDefault();
        var theUrl = $(this).attr('href');
        var search = $('#form-search-page').find("input[name='search']").val();
        $.get(theUrl, {search:search}, function( my_var ) {
             $('#page-content').replaceWith(my_var);
             backtoTop();
        });
    });

    $('body').on('change', "select[name='is_available']", function(e) {
        var is_available = $(this).val();
        var url = $(this).data('update-status-url');
        row = $(this).closest('tr');
        $.get(url, {is_available: is_available}, function(my_var) {
            row.find('.check-draft').toggleClass('is-draft');
        });
    });

    $('body').on('click', '.btn-preview', function(e) {
        e.preventDefault();
        var url = $(this).data('url');

        var title = $("input[name='page_title']").val();
        var content = $("textarea[name='content']").text();
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: {title: title, content: content},
            success: function (res) {
                window.open(res);
            }
        });
    });

    $('body').on('click', "input[name='select-all']", function(e) {
        var checkBoxes = $("input[name='select-pages[]']");
        checkBoxes.prop("checked", $(this).prop("checked"));
    });

    $('body').on('click', '.btn-apply', function(e) {
        e.preventDefault();
        var url = $(this).data('update-status-url');
        var page_ids = new Array();
        var update_status = $("select[name='update_status']").val();
        $.each($("input[name='select-pages[]']"), function(index, val) {
            if ($(this).is(':checked'))
            {
                var page_id = $(this).data('page-id');
                page_ids.push(page_id);
            }
        });
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: {page_ids: page_ids, update_status},
            success: function (res) {
                console.log(res);
                if (res.status == true)
                {
                    $.each($("input[name='select-pages[]']"), function(index, val) {
                        if ($(this).is(':checked'))
                        {
                            row = $(this).closest('tr');
                            if (res.is_remove == true)
                            {
                                row.hide('slow', function() {
                                    row.remove();
                                });
                            }
                            else if (res.is_draft == true)
                            {
                                row.find('.check-draft').addClass('is-draft');
                                row.find("select[name='is_available']").val(update_status);
                            }
                            else if (res.is_published == true)
                            {
                                row.find('.check-draft').removeClass('is-draft');
                                row.find("select[name='is_available']").val(update_status);
                            }
                        }
                    });
                }
            }
        })
    });

});
