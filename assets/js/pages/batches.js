$(function () {
    var batch_id;
    getTypesByCategory();
    $("select[name='category']").on('change', function() {
        getTypesByCategory();
    });
    $("select[name='type']").on('change', function() {
        getSubTypesByType();
    });

    //delete one row of types table
    $('body').on('click', '.batch-delete', function() {
        batch_id = $(this).data('batch-id');
        $('#deleting-confirm').text($(this).data('inform-delete') + $(this).data('batch'));
    });

    $('body').on('click', '#deleted-confirm-btn', function() {
        var actionUrl = $(this).data('action-url') + '/' + batch_id;
        row = $(this).closest('tr');
        $.ajax({
            url: actionUrl,
            type: 'post',
            dataType: 'json',
            success: function(res) {
                console.log(res);
                if (res.status == true) {
                    row.hide('slow', function() {
                        row.remove();
                    });
                }
                else {
                    $(".messages").html("<div class='alert alert-warning'>" + res.messages + "</div>");
                }
                backtoTop();
            }
        }).error(function() {

        });
    });

    $("#form-batches").submit(function(e) {
        e.preventDefault();
        $(".messages").html('');
        backtoTop();
        var form = $(this);
        var progress = $(".loading-progress").progressTimer({
            timeLimit: $(form).find("input[name='quantity']").val() * 5
        });
        $("input[type='submit']").prop('disabled', true);
        $("input[type='reset']").prop('disabled', true);
        $(".icon-loading").css('display', 'inline');
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            dataType: 'json',
            data: $(this).serialize() ,
            success: function (res) {
                $("input[type='submit']").prop('disabled', false);
                $("input[type='reset']").prop('disabled', false);
                $(".icon-loading").css('display', 'none');
                if (res.status == true) {
                    $(".messages").html("<div class='alert alert-success'>" + res.messages + "</div>");
                    if (form.data('request') == 'create') form[0].reset();
                    progress.progressTimer('complete');
                }
                else {
                    $(".messages").html("<div class='alert alert-warning'>" + res.messages + "</div>");
                    progress.progressTimer('error');
                }
            }
        }).error(function() {

        });
    });

    // pagination page
    $("body").on("click",".pagination a",function(e){
        e.preventDefault();
        var theUrl = $(this).attr('href');
        var search = $('#form-search-batches').find("input[name='search']").val();
        $.get(theUrl, {search:search}, function( my_var ) {
            $('#page-content').replaceWith(my_var);
            backtoTop();
        }).error(function() {

        });
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
                getSubTypesByType();
            }
        }).error(function() {

        });
    }
    else {
    }
}

function getSubTypesByType()
{
    var select_type = $("select[name='type']");
    var id = select_type.val();
    if (id != undefined && select_type.disabled == null) {
        var url = select_type.data('type-get-subtypes-url') + '/' + id;
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
                    option = "<option value='" + val.id + "' " + selected +">" + val.type_name + ' - ' + val.producing_year + "</option>";
                    options.push(option);
                });
                $("select[name='subtype']").html(options);
            }
        }).error(function() {

        });
    }
}
