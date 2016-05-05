
$(document).ready(function() {
	$('#form-category').submit(function(e) {
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
                    if (form.data('request') == 'create') {
                            form[0].reset();
                    }
                }
                else {
                    console.log(res.messages);
                    $(".messages").html("<div class='alert alert-warning'>" + res.messages + "</div>");
                }
            },
        });
	});
});