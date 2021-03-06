emojione.ascii = true;

function humanReadableSize(size) {

    var unit = 'b';

    if (size > 1073741824) {
        size = (size / 1073741824);
        unit = 'gb';
    } else if (size > 1048576) {
        size = (size / 1048576);
        unit = 'mb';
    } else if (size > 1024) {
        size = (size / 1024);
        unit = 'kb';
    }

    return (Math.round(size * 100) / 100) + ' ' + unit;
}

function getPost(post) {

    var element = $('<div class="post well" id="post_' + post.id + '" data-id="' + post.id + '" data-modified="' + post.modified + '"></div>');

    if (post.userId == currentUserId) {
        $('<a class="action_delete_post btn btn-default" href="#" data-post="' + post.id + '"><i class="fa fa-trash-o"></i></a>').appendTo(element);
    }

    var userDiv = $('<div class="row user"></div>');
    $('<div class="col-xs-2 feed_user_portrait"><a href="/profile/?user=' + post.userId + '"><img src="/file/?file=' + post.portraitFileId + '" /></a></div>').appendTo(userDiv);
    $('<span class="name"><a href="/profile/?user=' + post.userId + '">' + post.firstName + ' ' + post.lastName + '</a></span>').appendTo(userDiv);

    if (post.groupId) {
        $('<span class="in_group"> in <a href="/group/?id=' + post.groupId + '">' + post.group.name + '</a></span>').appendTo(userDiv);
    }

    $('<br><small><span class="created">' + post.created + '</span></small>').appendTo('<div class="col-xs-10"></div>').appendTo(userDiv);

    $(userDiv).appendTo(element);

    $('<div class="clear"></div>').appendTo(element);
    $('<div class="content">' + emojione.toImage(post.content) + '</div>').appendTo(element);

    if (post.imageFileId) {
        $('<div class="image"><a href="/file/image/?file=' + post.imageFileId + '" target="_blank"><img class="" src="/file/image/?file=' + post.imageFileId + '" /></a></div>').appendTo(element);
    }

    if (post.attachmentFileId) {
        $('<div class="file well well-sm"><a href="/file/?file=' + post.attachmentFileId + '" data-file-id="' + post.attachmentFileId + '"></a></div><div class="clearfix"></div>').appendTo(element);
    }

    var interactionLine = '<div class="interaction"><a class="action_like" href="#" data-post="' + post.id + '">';

    if (post.liked == 0) {
        interactionLine += globalTranslations.post_like;
    } else {
        interactionLine += globalTranslations.post_dislike;
    }

    interactionLine += '</a> &bull; <a class="action_comments" href="#" data-post="' + post.id + '">' + globalTranslations.post_comments + '</a>';

    if (post.likes > 0) {
        interactionLine += ' &bull; <i class="fa fa-thumbs-o-up"></i> ' + post.likes;
    }

    if (post.comments > 0) {
        interactionLine += ' &bull; <i class="fa fa-comments-o"></i> ' + post.comments;
    }

    interactionLine += '</div>';

    $(interactionLine).appendTo(element);

    var comments = $('<div class="comments"><div class="comments_inner"></div></div>');

    $('<div class="add_comment"><div class="comment_user_portrait"><img style="width: 32px; height: 32px;" src="/file/image/?file=' + currentUserPortraitFileId + '" /></div><div class="comment_message_box"><input type="text" class="form-control new_comment" data-post-id="' + post.id + '" placeholder="' + globalTranslations.post_comments_write_comment + '"></div></div>').appendTo(comments);

    $(comments).appendTo(element);
    $('<div class="clearfix"></div>').appendTo(comments);

    return element;
}

function getComment(post) {

    var element = $('<div class="post well well-sm" id="post_' + post.id + '" data-id="' + post.id + '" data-modified="' + post.modified + '"></div>');

    if (post.userId == currentUserId) {
        $('<a class="action_delete_post btn btn-default" href="#" data-post="' + post.id + '"><i class="fa fa-trash-o"></i></a>').appendTo(element);
    }

    var userDiv = $('<div class="row user"></div>');

    $('<div class="col-xs-2 feed_user_portrait"><a href="/profile/?user=' + post.userId + '"><img src="/file/image/?file=' + post.portraitFileId + '" /></a></div>').appendTo(userDiv);

    var colRight = $('<div class="col-xs-9"></div>');

    $('<span class="name"><a href="/profile/?user=' + post.userId + '">' + post.firstName + ' ' + post.lastName + '</a></span>').appendTo(colRight);

    if (post.groupId) {
        $('<span class="in_group"> in <a href="/group/?id=' + post.groupId + '">' + post.group.name + '</a></span>').appendTo(colRight);
    }

    $('<small><span class="created"> ' + post.created + '</span></small>').appendTo('<div class="col-xs-10"></div>').appendTo(colRight);

    $(colRight).appendTo(userDiv);

    $('<div class="content">' + emojione.toImage(post.content) + '</div>').appendTo(colRight);

    var interactionLine = '<div class="interaction"><a class="action_like_comment" href="#" data-post="' + post.id + '">';

    if (post.liked == 0) {
        interactionLine += globalTranslations.post_like;
    } else {
        interactionLine += globalTranslations.post_dislike;
    }

    if (post.likes > 0) {
        interactionLine += '</a> &bull; <i class="fa fa-thumbs-o-up"></i> ' + post.likes;
    }

    interactionLine += '</div>';

    $(interactionLine).appendTo(colRight);
    $(userDiv).appendTo(element);

    return element;
}

function loadAttachments() {

    $('.post .file a').each(function(index, element) {

        var fileTag = $(this);

        $.ajax({
            type: 'get',
            url: '/file/meta/',
            data: {
                file: $(fileTag).data('file-id')
            },
            dataType: 'json',
            success: function(result) {

                var icon = 'fa-file-o';

                switch (result.type) {

                    case 'application/pdf':
                        icon = 'fa-file-pdf-o';
                    break;

                }

                $(fileTag).html('<i class="fa ' + icon + '"></i><br />' + result.name + '<br />' + humanReadableSize(result.size));
            }
        });

    });

}

$(function() {

    var body = $('body');

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

        $('#post_select_image').html('<i class="fa fa-spinner fa-spin"></i> uploading...');

        $.ajax({
            type: 'post',
            url: '/file/add-image/',
            data: file,
            processData: false,
            dataType: 'json',
            success: function(result) {
                $('#post_image_id').val(result.file_id);
                $('#post_select_image').removeClass('btn-default').addClass('btn-danger').html('<i class="fa fa-times"></i> <i class="fa fa-file-image-o">');
                $('#image_area').html('<img class="img-responsive" src="/file/image/?file=' + result.file_id + '" />')
            }
        })

    });

    $('#post_select_file').click(function(event) {

        event.preventDefault();

        if ($('#post_file_id').val()) {

            $('#post_file_id').val('');
            $('#file_area').html('');
            $('#post_select_file').removeClass('btn-danger').addClass('btn-default').html('<i class="fa fa-plus"></i> <i class="fa fa-file-o">');

        } else {

            $('#file_upload').click();

        }

    });

    $('#file_upload').change(function(event) {

        var file = $(this)[0].files[0];

        $('#post_select_file').html('<i class="fa fa-spinner fa-spin"></i> uploading...');

        $.ajax({
            type: 'post',
            url: '/file/add/',
            data: file,
            processData: false,
            contentType: file.type,
            dataType: 'json',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('x-file-name', file.name);
            },
            success: function(result) {

                $('#post_file_id').val(result.file_id);

                $('#file_area').append('<div class="well well-sm"><div class="col-xs-3"><div class="file"><i class="fa fa-file-o"></i></div></div><div class="col-xs-9"><div class="file_name">' + file.name + '</div></div><div class="clearfix"></div></div>');

                $('#post_select_file').removeClass('btn-default').addClass('btn-danger').html('<i class="fa fa-times"></i> <i class="fa fa-file-image-o">');

            }
        })

    });

    $('#create_post_form').submit(function(event) {

        event.preventDefault();

        if ($('#post_content').val()) {

            var data = {
                content: emojione.toShort($('#post_content').val()),
                image: $('#post_image_id').val(),
                file: $('#post_file_id').val()
            };

            if (window.groupId != undefined) {
                data.group = window.groupId;
            }

            $.ajax({
                method: 'post',
                url: '/post/add/',
                data: data,
                dataType: 'json',
                success: function(result) {
                    $('#post_select_image').removeClass('btn-danger').addClass('btn-default').html('<i class="fa fa-plus"></i> <i class="fa fa-file-image-o">');
                    $('#post_select_file').removeClass('btn-danger').addClass('btn-default').html('<i class="fa fa-plus"></i> <i class="fa fa-file-o">');
                    $('#post_content').val('');
                    $('#image_area').html('');
                    $('#file_area').html('');
                    $('#post_image_id').val('');
                    $('#post_file_id').val('');

                    $(getPost(result)).prependTo('.posts');
                    loadAttachments();
                }
            });

        } else {
            $('#post_content').parent('.form-group').addClass('has-error');
        }

    });

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
                loadAttachments();
            }
        });

    });

    $(body).on('click', '.action_like_comment', function(event) {

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
                $('#post_' + postId).replaceWith(getComment(result));
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
                        $(theComment).replaceWith(getComment(result.posts[i]));
                    } else {
                        $('#post_' + postId + '>.comments>.comments_inner').append(getComment(result.posts[i]));
                    }
                }
            }
        });

    });

    $(body).on('keyup', '.new_comment', function(event) {

        event.preventDefault();

        var commentBox = $(this);

        if (event.keyCode == 13) {

            var postId = $(commentBox).data('post-id');
            var content = emojione.toShort($(commentBox).val());

            if (content == '') {
                $(commentBox).parent('.form-group').addClass('has-error');
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
                    $(commentBox).val('');
                    $('#post_' + postId + '>.comments .comments_inner').append(getComment(result));
                }
            });

        }

    });

    $(body).on('click', '.action_delete_post', function(event) {

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

    $(body).on('click', '.accept_group_request', function(event) {

        event.preventDefault();

        var aTag = $(this);
        var groupId = $(this).data('id');

        $.ajax({
            method: 'post',
            url: '/group/accept-invitation/',
            data: {
                group: groupId
            },
            dataType: 'json',
            success: function(result) {

                $(aTag).closest('.group_invitation').fadeOut(function() {
                    var groupInvitations = $('.group_invitations .group_invitation');

                    if (groupInvitations.length == 0) {
                        $('.group_invitations').fadeOut();
                    }
                });

            }
        });

    });

    $(body).on('click', '.decline_group_request', function(event) {

        event.preventDefault();

        var aTag = $(this);
        var groupId = $(this).data('id');

        $.ajax({
            method: 'post',
            url: '/group/decline-invitation/',
            data: {
                group: groupId
            },
            dataType: 'json',
            success: function(result) {

                $(aTag).closest('.group_invitation').fadeOut(function() {
                    var groupInvitations = $('.group_invitations .group_invitation');

                    if (groupInvitations.length == 0) {
                        $('.group_invitations').fadeOut();
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

    $(body).on('click', '#action_add_group', function(event) {

        event.preventDefault();

        var groupName = $('#group_name').val();
        var groupDescription = $('#group_description').val();
        var groupType = $('#group_type').val();

        $.ajax({
            method: 'post',
            url: '/group/add/',
            data: {
                name: groupName,
                description: groupDescription,
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

    $('.convert-emoji').each(function() {
        $(this).html(emojione.toImage($(this).html()));
    });

});