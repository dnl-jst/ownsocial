$(function() {

    var postsLoaded = false;

    $.ajax({
        method: 'get',
        url: '/feed/',
        dataType: 'json',
        success: function(result) {

            for (var i = 0; i < result.posts.length; i++) {

                $(getPost(result.posts[i])).appendTo('.posts');
            }

            $('body').data('last-update', result.last_update);

            postsLoaded = true;

        }
    });

    $('#post_select_image').click(function(event) {

        event.preventDefault();

        if ($('#post_image_id').val()) {

            $('#post_image_id').val('');
            $('#image_area').html('');

            $('#post_select_image').removeClass('btn-danger').addClass('btn-default').html('<i class="fa fa-plus"></i> <i class="fa fa-file-image-o">');

        } else {

            $('#image_upload').click();

        }

    });

    $('#image_upload').change(function(event) {

        var file = $(this)[0].files[0];

        $.ajax({
            type: 'post',
            url: '/file/add/',
            data: file,
            processData: false,
            dataType: 'json',
            success: function(result) {
                $('#post_image_id').val(result.file_id);
                $('#post_select_image').removeClass('btn-default').addClass('btn-danger').html('<i class="fa fa-times"></i> <i class="fa fa-file-image-o">');
                $('#image_area').html('<img class="img-responsive" src="/file/?file=' + result.file_id + '" />')
            }
        })

    });

    $('#create_post_form').submit(function(event) {

        event.preventDefault();

        if ($('#post_content').val()) {

            $.ajax({
                method: 'post',
                url: '/post/add/',
                data: {
                    content: $('#post_content').val(),
                    image: $('#post_image_id').val()
                },
                dataType: 'json',
                success: function(result) {
                    $(getPost(result)).prependTo('.posts');
                    $('#post_content').val('');
                    $('#image_area').html('');
                }
            });

        } else {
            $('#post_content').parent('.form-group').addClass('has-error');
        }

    });

    var updatePosts = function() {

        if (postsLoaded) {

            var oPosts = {};

            $('.post').each(function(index, element) {
                oPosts[$(element).data('id')] = $(element).data('modified');
            });

            $.ajax({
                method: 'post',
                url: '/feed/updates/',
                data: {
                    last_update: $('body').data('last-update'),
                    posts: oPosts
                },
                dataType: 'json',
                success: function(result) {

                    for (var i = 0; i < result.posts.length; i++) {

                        var thePost = $('#post_' + result.posts[i].id);

                        if (thePost.length > 0) {
                            $(thePost).replaceWith(getPost(result.posts[i]));
                        } else {
                            $(getPost(result.posts[i])).prependTo('.posts');
                        }
                    }

                    $('body').data('last-update', result.last_update);

                    postsLoaded = true;

                }
            });

        }

    };

    setInterval(updatePosts, 10000);

});