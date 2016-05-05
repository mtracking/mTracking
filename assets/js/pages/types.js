$(function() {
    $("#form-type").submit(function(e) {
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
                    if (form.data('request') == 'create') form[0].reset();
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
