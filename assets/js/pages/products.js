$(function() {

    // pagination page
    $("body").on("click",".pagination a",function(e) {
        e.preventDefault();
        var subtype_id = $("select[name='subtype']").val();
        var category_id = $("select[name='category']").val();
        var type_id = $("select[name='type']").val();
        var batch_id = $("select[name='batch']").val();
        var theUrl = $(this).attr('href');
        $.get(theUrl, {batch: batch_id, subtype: subtype_id, type: type_id, category: category_id}, function( my_var ) {
            $('#page-content').replaceWith(my_var);
            backtoTop();
        });
    });

    $("body").on('change', "select[name='category']", function(e) {
        chooseCategory();
    });
    $("body").on('change', "select[name='type']", function(e) {
        chooseType();
    });
    $("body").on('change', "select[name='subtype']", function(e) {
        chooseSubType();
    });
});

function chooseCategory()
{
    var category_id = $("select[name='category']").val();
    var sum = 0;
    var x = false;
    $("select[name='type']").find('option').css('display', 'block');
    if (category_id != 0)
    {
        $.each($("select[name='type']").find('option'), function(index, val) {
            if (category_id != $(this).data('category'))
            {
                sum ++;
                $(this).css('display', 'none');
            }
            else
            {
                if (x == false) $("select[name='type']").val($(this).val());
                x = true;
            }
        });
        if (sum == $("select[name='type']").find('option').length) $("select[name='type']").val('');
    }
    else $("select[name='type']").val($("select[name='type'] option:first").val());
    chooseType();
}

function chooseType()
{
    var type_id = $("select[name='type']").val();
    var sum = 0;
    var x = false;
    $("select[name='subtype']").find('option').css('display', 'block');
    if (type_id != 0)
    {
        $.each($("select[name='subtype']").find('option'), function(index, val) {
            if (type_id != $(this).data('type'))
            {
                sum ++;
                $(this).css('display', 'none');
            }
            else
            {
                if (x == false) $("select[name='subtype']").val($(this).val());
                x = true;
            }
        });
        if (sum == $("select[name='subtype']").find('option').length) $("select[name='subtype']").val('');
    }
    else $("select[name='subtype']").val($("select[name='subtype'] option:first").val());
    chooseSubType();
}

function chooseSubType()
{
    var subtype_id = $("select[name='subtype']").val();
    var sum = 0;
    var x = false;
    $("select[name='batch']").find('option').css('display', 'block');
    if (subtype_id != 0)
    {
        $.each($("select[name='batch']").find('option'), function(index, val) {
            if (subtype_id != $(this).data('subtype'))
            {
                sum ++;
                $(this).css('display', 'none');
            }
            else
            {
                if (x == false) $("select[name='batch']").val($(this).val());
                x = true;
            }
        });
        if (sum == $("select[name='batch']").find('option').length) $("select[name='batch']").val('');
    }
    else $("select[name='batch']").val($("select[name='batch'] option:first").val());
}
