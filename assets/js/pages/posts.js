$(function() {

    $("#form-post").submit(function(e) {
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
        var search = $('#form-search-post').find("input[name='search']").val();
        $.get(theUrl, {search:search}, function( my_var ) {
            $('#post-content').replaceWith(my_var);
            backtoTop();
        });
    });

    $("select[name='category']").on('change', function() {
        getTypesByCategory();
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

        var title = $("input[name='post_title']").val();
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
        var checkBoxes = $("input[name='select-posts[]']");
        checkBoxes.prop("checked", $(this).prop("checked"));
    });

    $('body').on('click', '.btn-apply', function(e) {
        e.preventDefault();
        var url = $(this).data('update-status-url');
        var post_ids = new Array();
        var update_status = $("select[name='update_status']").val();
        $.each($("input[name='select-posts[]']"), function(index, val) {
            if ($(this).is(':checked'))
            {
                var post_id = $(this).data('post-id');
                post_ids.push(post_id);
            }
        });
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: {post_ids: post_ids, update_status},
            success: function (res) {
                console.log(res);
                if (res.status == true)
                {
                    $.each($("input[name='select-posts[]']"), function(index, val) {
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
function getTypesByCategory()
{
    var select_category = $("select[name='category']");
    var id = select_category.val();
    if (id != undefined && select_category.disabled == null) {
        var url = select_category.data('category-get-types-url') + '/' + id;
        $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            data: {},
            success: function(res) {
                var options = new Array();
                $.each(res.data, function(index, val) {
                    var option;
                    selected = (index == 0) ? 'selected="selected"' : '';
                    option = "<option value='" + val.id + "' " + selected +">" + val.name + "</option>";
                    options.push(option);
                });
                $("select[name='type']").html(options);
            }
        }).error(function() {

        });
    }
}
