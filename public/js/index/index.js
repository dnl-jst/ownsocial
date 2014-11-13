function getPost(post) {

    var element = $('<div class="post well" id="post_' + post.id + '" data-id="' + post.id + '" data-modified="' + post.modified + '"></div>');

    if (post.userId == currentUserId) {
        $('<a class="action_delete_post btn btn-default" href="#" data-post="' + post.id + '"><i class="fa fa-trash-o"></i></a>').appendTo(element);
    }

    var userP = $('<div class="row user"></p>');
    $('<div class="col-xs-2"><a href="/profile/?user=' + post.userId + '"><img class="img-responsive" src="/file/?file=' + post.portraitFileId + '" /></a></div>').appendTo(userP);
    $('<span class="name"><a href="/profile/?user=' + post.userId + '">' + post.firstName + ' ' + post.lastName + '</a></span>').appendTo(userP);

    if (post.groupId) {
        $('<span class="in_group"> in <a href="/group/?id=' + post.groupId + '">' + post.group.name + '</a></span>').appendTo(userP);
    }

    $('<br><small><span class="created">' + post.created + '</span></small></p>').appendTo('<div class="col-xs-10"></div>').appendTo(userP);

    $(userP).appendTo(element);

    $('<div class="clear"></p>').appendTo(element);
    $('<hr><p class="content">' + post.content + '</p>').appendTo(element);

    var interactionLine = '<hr><p class="interaction"><a class="action_like" href="#" data-post="' + post.id + '">';

    if (post.liked == 0) {
        interactionLine += 'Like';
    } else {
        interactionLine += 'Dislike';
    }

    interactionLine += '</a> &bull; <a class="action_comments" href="#" data-post="' + post.id + '">Comments</a>';

    if (post.likes > 0) {
        interactionLine += ' &bull; <i class="fa fa-thumbs-o-up"></i> ' + post.likes;
    }

    if (post.comments > 0) {
        interactionLine += ' &bull; <i class="fa fa-comments-o"></i> ' + post.comments;
    }

    interactionLine += '</p>';

    $(interactionLine).appendTo(element);

    var comments = $('<div class="comments" style="display: none;"><hr></div>');

    $('<div class="add_comment"><form class="" role="form"><div class="col-xs-10"><input type="text" class="form-control" id="new_comment_' + post.id + '" placeholder="Write comment"></div><button type="submit" class="col-xs-2 btn btn-primary">Send</button></form></div>').appendTo(comments);

    $(comments).appendTo(element);
    $('<div class="clearfix"></div>').appendTo(comments);

    return element;
}

$(function() {

    var postsLoaded = false;

    $.ajax({
        method: 'get',
        url: '/feed/',
        dataType: 'json',
        success: function(result) {

            console.log(result);

            for (var i = 0; i < result.posts.length; i++) {

                $(getPost(result.posts[i])).appendTo('.posts');
            }

            $('body').data('last-update', result.last_update);

            postsLoaded = true;

        }
    });

    $('#create_post_form').submit(function(event) {

        event.preventDefault();

        if ($('#post_content').val()) {

            $.ajax({
                method: 'post',
                url: '/post/add/',
                data: {
                    content: $('#post_content').val()
                },
                dataType: 'json',
                success: function(result) {
                    $(getPost(result)).prependTo('.posts');
                    $('#post_content').val('');
                }
            });

        } else {
            $('#post_content').parent('.form-group').addClass('has-error');
        }

    });

    $('body').on('click', '.action_like', function(event) {

        event.preventDefault();

        var postId = $(this).data('post');

        $.ajax({
            method: 'post',
            url: '/post/toggle-like/',
            data: {
                post: postId
            },
            dataType: 'json',
            success: function(result) {
                $('#post_' + postId).replaceWith(getPost(result));
            }
        });

    });

    $('body').on('click', '.action_comments', function(event) {

        event.preventDefault();

        var postId = $(this).data('post');

        $('#post_' + postId + '>.comments').show();

        $.ajax({
            method: 'post',
            url: '/feed/',
            data: {
                parent_post: postId
            },
            dataType: 'json',
            success: function(result) {

                console.log(result);

                for (var i = 0; i < result.posts.length; i++) {

                    var theComment = $('#post_' + postId + '>.comments #post_' + result.posts[i].id);

                    if ($(theComment).length > 0) {
                        $(theComment).replaceWith(getPost(result.posts[i]));
                    } else {
                        $('#post_' + postId + '>.comments').append(getPost(result.posts[i]));
                    }
                }
            }
        })

    });

    $('body').on('click', '.action_delete_post', function() {

        event.preventDefault();

        var postId = $(this).data('post');

        $.ajax({
            method: 'post',
            url: '/post/delete/',
            data: {
                post: postId
            },
            dataType: 'json',
            success: function(result) {
                $('#post_' + postId).remove();
            }
        })

    });

    $('body').on('click', '.add_request', function(event) {

        event.preventDefault();

        var aTag = $(this);
        var relUserId = $(this).data('id');

        $.ajax({
            method: 'post',
            url: '/relation/create-request/',
            data: {
                user: relUserId
            },
            dataType: 'json',
            success: function(result) {

                // todo!

            }
        });
    });

    $('body').on('click', '.accept_request', function(event) {

        event.preventDefault();

        var aTag = $(this);
        var relUserId = $(this).data('id');

        $.ajax({
            method: 'post',
            url: '/relation/accept-request/',
            data: {
                user: relUserId
            },
            dataType: 'json',
            success: function(result) {

                $(aTag).closest('.unconfirmed_contact').fadeOut(function() {
                    var unconfirmedContacts = $('.unconfirmed_contacts .unconfirmed_contact');

                    if (unconfirmedContacts.length == 0) {
                        $('.unconfirmed_contacts').fadeOut();
                    }
                });

            }
        });

    });

    $('body').on('click', '.decline_request', function(event) {

        event.preventDefault();

        var aTag = $(this);
        var relUserId = $(this).data('id');

        $.ajax({
            method: 'post',
            url: '/relation/decline-request/',
            data: {
                user: relUserId
            },
            dataType: 'json',
            success: function(result) {

                $(aTag).closest('.unconfirmed_contact').fadeOut(function() {
                    var unconfirmedContacts = $('.unconfirmed_contacts .unconfirmed_contact');

                    if (unconfirmedContacts.length == 0) {
                        $('.unconfirmed_contacts').fadeOut();
                    }
                });

            }
        });

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

    setInterval(updatePosts, 3000);

});