$(function() {
    // pagination page
    $("body").on("click",".pagination a",function(e) {
        e.preventDefault();
        var storage_id = $("select[name='storage']").val();
        var theUrl = $(this).attr('href') + '?storage=' + storage_id;
        $.get(theUrl, function( my_var ) {
            $('#page-content').replaceWith(my_var);
        });
    });

})