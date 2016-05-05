/* Sidebar Menu active class */
$(function () {
    url = window.location.href;
    index = '/index';
    edit = '/edit/';
    add = '/add';
    details = '/details/';
    search = '?';
    hash = '/';
    // Delete char contain char "edit", "search" in url
    if (url.indexOf(edit) > 0) {
        url = url.substr(0, url.indexOf(edit));
    }
    if (url.indexOf(index) > 0) {
        url = url.substr(0, url.indexOf(index));
    }
    if (url.indexOf(add) > 0) {
        url = url.substr(0, url.indexOf(add));
    }
    if (url.indexOf(details) > 0) {
        url = url.substr(0, url.indexOf(details));
    }
    if (url.indexOf(search) > 0) {
        url = url.substr(0, url.indexOf(search));
    }
    if (url.lastIndexOf(hash) == url.length -1 ) {
        url = url.substr(0, url.lastIndexOf(hash));
    }
    console.log(url);
    // Get new url contain from 0 to number
    $('.sidebar-nav a[href="' + url + '"]').parent('li').addClass('active');
    $('.sidebar-nav a').filter(function () {
        return this.href == url;
    }).parent('li').addClass('active').parent('ul').slideDown().parent().addClass('active');

    $('body').on('click', '.btn-remove', function(e) {
        e.preventDefault();
        var theUrl = $(this).attr('href');
        var row = $(this).closest('tr');
        $.ajax({
            url: theUrl,
            type: 'post',
            dataType: 'json',
            success: function (res) {
                console.log(res);
                if (res.status == true)
                {
                    row.hide('slow', function() {
                        row.remove();
                    });
                }
                else
                {
                    $(".messages").html("<div class='alert alert-warning'>" + res.messages + "</div>");
                }
            }
        })
    });
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 400,                 // set editor height
            minHeight: 200,             // set minimum height of editor
            maxHeight: 600,             // set maximum height of editor
        });
    })
});

function backtoTop()
{
    $('html, body').animate({
        scrollTop: $('#page-content').offset().top
    }, 500);
}
