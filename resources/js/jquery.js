import $ from 'jquery';

$(function () {
    $('#myImage').on('change', function(e) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#preview").attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files[0]);
    });

    $('.image-size img').on('click', function() {
        $('.show-modal').fadeIn();
    });

    $('.close-btn, .modal-mask').on('click', function() {
        $('.show-modal').fadeOut();

    });

    $('#delete-btn').on('click', function() {
        if (!confirm('本当に削除しますか？')) {
            return false;
        }
    });

    $('#profile-delete-btn').on('click', function() {
        if (!confirm('本当にアカウントを削除しますか？')) {
            return false;
        }
    });

    $('#comment-delete-btn').on('click', function() {
        if (!confirm('本当に削除しますか？')) {
            return false;
        }
    });
});

