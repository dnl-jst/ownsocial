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

    if (post.imageFileId) {
        $('<p class="image"><img class="img-responsive" src="/file/?file=' + post.imageFileId + '" /></p>').appendTo(element);
    }

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

    var comments = $('<div class="comments" style="display: none;"><hr><div class="comments_inner"></div></div>');

    $('<div class="add_comment"><form class="" role="form"><div class="col-xs-9 form-group"><input type="text" class="form-control" id="new_comment_' + post.id + '" placeholder="Write comment"></div><div class="col-xs-3 form-group"><button type="submit" class="form-control action_add_comment" data-post-id="' + post.id + '" class="col-xs-2 btn btn-primary">Send</button></div></form></div>').appendTo(comments);

    $(comments).appendTo(element);
    $('<div class="clearfix"></div>').appendTo(comments);

    return element;
}

$(function() {

    var body = $('body');

    $(body).on('click', '.action_like', function(event) {

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

    $(body).on('click', '.action_comments', function(event) {

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

                for (var i = 0; i < result.posts.length; i++) {

                    var theComment = $('#post_' + postId + '>.comments #post_' + result.posts[i].id);

                    if ($(theComment).length > 0) {
                        $(theComment).replaceWith(getPost(result.posts[i]));
                    } else {
                        $('#post_' + postId + '>.comments .comments_inner').append(getPost(result.posts[i]));
                    }
                }
            }
        });

    });

    $(body).on('click', '.action_add_comment', function(event) {

        event.preventDefault();

        var postId = $(this).data('post-id');
        var content = $('#new_comment_' + postId).val();

        if (content == '') {
            $('#new_comment_' + postId).parent('.form-group').addClass('has-error');
            return;
        }

        $.ajax({
            method: 'post',
            url: '/post/add-comment/',
            data: {
                post: postId,
                content: content
            },
            dataType: 'json',
            success: function(result) {
                $('#new_comment_' + postId).val('');
                $('#post_' + postId + '>.comments .comments_inner').append(getPost(result));
            }
        });

    });

    $(body).on('click', '.action_delete_post', function() {

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
        });

    });

    $(body).on('click', '.add_request', function(event) {

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

                $(aTag).removeClass('add_request').html('<i class="fa fa-clock-o"></i> Request pending...');

            }
        });
    });

    $(body).on('click', '.accept_request', function(event) {

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

    $(body).on('click', '.accept_user', function(event) {

        event.preventDefault();

        var aTag = $(this);
        var relUserId = $(this).data('id');

        $.ajax({
            method: 'post',
            url: '/admin/accept-user/',
            data: {
                id: relUserId
            },
            dataType: 'json',
            success: function(result) {

                $(aTag).closest('.unconfirmed_user').fadeOut(function() {
                    var unconfirmedUsers = $('.unconfirmed_users .unconfirmed_user');

                    if (unconfirmedUsers.length == 0) {
                        $('.unconfirmed_users').fadeOut();
                    }
                });

            }
        });

    });

    $(body).on('click', '.decline_user', function(event) {

        event.preventDefault();

        var aTag = $(this);
        var relUserId = $(this).data('id');

        $.ajax({
            method: 'post',
            url: '/admin/decline-user/',
            data: {
                id: relUserId
            },
            dataType: 'json',
            success: function(result) {

                $(aTag).closest('.unconfirmed_user').fadeOut(function() {
                    var unconfirmedUsers = $('.unconfirmed_users .unconfirmed_user');

                    if (unconfirmedUsers.length == 0) {
                        $('.unconfirmed_users').fadeOut();
                    }
                });

            }
        });

    });

    $(body).on('click', '.decline_request', function(event) {

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

    $(body).on('click', '#action_add_group', function(event) {

        event.preventDefault();

        var groupName = $('#group_name').val();
        var groupType = $('#group_type').val();

        $.ajax({
            method: 'post',
            url: '/group/add/',
            data: {
                name: groupName,
                type: groupType
            },
            dataType: 'json',
            success: function(result) {

                if (result.status == 'success') {
                    window.location = result.redirect;
                }
            }
        })

    });

});