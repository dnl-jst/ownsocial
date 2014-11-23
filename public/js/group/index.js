$(function() {

    var postsLoaded = false;

    $.ajax({
        method: 'get',
        url: '/group/feed/?id=' + groupId,
        dataType: 'json',
        success: function(result) {

            for (var i = 0; i < result.posts.length; i++) {

                $(getPost(result.posts[i])).appendTo('.posts');
            }

            $('body').data('last-update', result.last_update);

            postsLoaded = true;

        }
    });

});