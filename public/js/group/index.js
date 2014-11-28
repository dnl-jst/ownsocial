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

    $('#group_user_add_search').keyup(function(event) {

        var search = $(this).val();

        if (search.length > 0) {

            $.ajax({
                method: 'post',
                url: '/group/suggest-members/?id=' + groupId,
                data: {
                    search: search
                },
                dataType: 'json',
                success: function(result) {

                    var suggestions = $('#group_user_add_suggestions');

                    suggestions.html('<h3>Suggestions:</h3>');

                    if (result.length === 0) {
                        suggestions.append('<div class="well well-sm">No users matched your search critera.</div>');
                    }

                    for (var i = 0; i < result.length; i++) {

                        var row = $('<div class="user row well well-sm" data-user-id="' + result[i].id + '"></div>');

                        row.append('<div class="col-xs-3"><img style="width: 80px; height: 80px;" src="/file/?file=' + result[i].portrait_file_id + '" /></div>');
                        row.append('<div class="col-xs-9"><h4 class="list-group-item-heading">' + result[i].first_name + ' ' + result[i].last_name + '</h4><p class="list-group-item-text">' + ((result[i].department) ? result[i].department : '') + '</p></div>');

                        suggestions.append(row);

                        $(row).click(function() {

                            var usersToAdd = [];

                            $('#group_user_add_selected .user').each(function(index, element) {
                                usersToAdd.push($(element).data('user-id'));
                            });

                            if (usersToAdd.length === 0) {
                                $('#group_user_add_selected').html('<h3>Selected:</h3>');
                            }

                            $(this).detach().appendTo('#group_user_add_selected');

                            var usersSuggested = [];

                            $('#group_user_add_suggestions .user').each(function(index, element) {
                                usersSuggested.push($(element).data('user-id'));
                            });

                            if (usersSuggested.length === 0) {
                                $('#group_user_add_suggestions').html('');
                            }
                        });
                    }

                }
            });

        }

    });

    $('#action_add_group_members').click(function(event) {

        event.preventDefault();

        var usersToAdd = [];

        $('#group_user_add_selected .user').each(function (index, element) {
            usersToAdd.push($(element).data('user-id'));
        });

        $.ajax({
            method: 'post',
            url: '/group/add-members/?id=' + groupId,
            data: {
                new_members: usersToAdd
            },
            dataType: 'json',
            success: function (result) {
                location.reload();
            }
        });
    });

});