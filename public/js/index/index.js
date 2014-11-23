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