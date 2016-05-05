$(function () {
    $("select[name='category']").on('change', function() {
        getTypesByCategory();
    });
    $("#form-subtype").submit(function(e) {
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
                    if (form.data('request') == 'create') $('#form-subtype')[0].reset();
                    // $('#editGalleryModal .gallery row')
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
        var search = $('#form-search-type').find("input[name='search']").val();
        $.get(theUrl, {search:search}, function( my_var ) {
             $('#page-content').replaceWith(my_var);
             backtoTop();
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
            }
        }).error(function() {

        });
    }
}