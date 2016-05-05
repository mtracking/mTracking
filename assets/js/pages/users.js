$(document).ready(function() {

    $('body').on('change', "input[type='file']", function(e) {
        $('#form-upload-avatar').submit();
    })

    $("body").on("click", ".pagination a",function(e){
        e.preventDefault();
        var theUrl = $(this).attr('href');
        var search = $('#form-search-user').find("input[name='search']").val();
        $.get(theUrl, {search:search}, function( my_var ) {
            $('#page-content').replaceWith(my_var);
            backtoTop();
        });
    });

    $("#form-user").submit(function(e) {
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
                    if (form.data('request') == 'create') $('#form-user')[0].reset();
                }
                else {
                    $(".messages").html("<div class='alert alert-warning'>" + res.messages + "</div>");
                }
                backtoTop();
            }
        }).error(function() {

        });
    });

    $('#form-upload-avatar').submit(function(e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var form = $(this);
        var formData = new FormData();
        formData.append('file', $('#file')[0].files[0]);
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
                    $('.img-avatar').attr('src', res.data);
                }
                else
                {
                    $(".messages").html("<div class='alert alert-warning'>" + res.messages + "</div>");
                }
            }
        });
    });

    $('#change-pwd-form').submit(function(e) {
        e.preventDefault();
        $("#pwd-messages").html('');
        var form = $(this);
        $.ajax({
            url: $(this).data('action-url'),
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(res) {
                if (res.status == true) {
                    $("#pwd-messages").html("<div class='alert alert-success'>" + res.messages + "</div>");
                    if (form.data('request') == 'create') {
                            form[0].reset();
                    }
                }
                else {
                    console.log(res.messages);
                    $("#pwd_messages").html("<div class='alert alert-warning'>" + res.messages + "</div>");
                }
            }, 
        });
    });

    //delete one row of users table
    $('body').on('click', '.user-delete', function() {
        listIdChecked = [];
        listIdChecked.push($(this).data('user-id'));
        $('#deleting-confirm').text($(this).data('inform-delete') + $(this).data('user'));
    });

    //check all users
    $('body').on('change', '#general-checkbox', function() {
        if ($(this).is(":checked")) {
            $("input[name='picked_users[]']").prop('checked', true);
        } else {
            $("input[name='picked_users[]']").prop('checked', false);
        }
    });

    $('body').on('click', "input[name='want_to_change_password']", function() {
        if ($(this).is(':checked'))
        {
            $('.change-password-field').fadeIn('slow').css('display', 'block');
        }
        else $('.change-password-field').fadeOut('slow').css('display', 'none');
    });

    //delete selected users
    $('body').on('click','#delete-selected-btn', function() {
        listIdChecked = [];
        listNameChecked = [];
        var checkedString = '';
        $("input[name='picked_users[]']").each(function(index, value) {
            if ($(this).is(":checked")) {
                listIdChecked.push($(this).val());
                listNameChecked.push($(this).data('users'));
            }
        });
        for (i = 0, len = listNameChecked.length; i < len; i++) {
            checkedString += listNameChecked[i] + ', ';
        }
        if (listIdChecked.length > 0) {
            $('#deleting-confirm').text($(this).data('inform-delete') + checkedString);
        } else {
            $('#deleting-confirm').text($(this).data('inform-error-delete'));
        }
    });

    $('body').on('click', '#deleted-confirm-btn', function() {
        if (listIdChecked.length > 0) {
            var actionUrl = $(this).data('action-url');
            deleteURL(actionUrl);
        }
    });

    $('#update-profile-form').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: $(this).data('action-url'),
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(res) {
                if (res.status == true) {
                    $("#profile-messages").html("<div class='alert alert-success'>" + res.messages + "</div>");
                    if (form.data('request') == 'create') {
                            form[0].reset();
                    }
                }
                else {
                    console.log(res.messages);
                    $("#profile-messages").html("<div class='alert alert-warning'>" + res.messages + "</div>");
                }
            }, 
        });
    });
});

function deleteURL(actionUrl) {
    $.ajax({
        url: actionUrl,
        type: 'post',
        dataType: 'json',
        data: {listIdChecked:listIdChecked},
        success: function(res) {
            if (res.status == true) {
                $(".messages").html("<div class='alert alert-success'>" + res.messages + "</div>");
                $("input[name='picked_users[]']").each(function(index, value) {
                    if (listIdChecked.indexOf($(this).val()) > -1 ||
                    listIdChecked.indexOf(parseInt($(this).val())) > -1) {
                         $('#' + $(this).val()).hide('slow/400/fast', function() {
                             $(this).remove();
                         });
                    }
                });
            }
            else {
                $(".messages").html("<div class='alert alert-warning'>" + res.messages + "</div>");
            }
        }
    }).error(function() {

    });
}