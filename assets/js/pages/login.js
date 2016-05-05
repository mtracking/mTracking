$(function(){
    $('#form-login').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(res) {
                if (res.status == true) {
                    window.location.replace(res.messages);
                }
                else {
                    console.log(res.messages);
                    $(".errors").html("<div class='alert alert-warning'>" + res.messages + "</div>");
                }
            }
        }).error(function() {
            
        });
    });
})