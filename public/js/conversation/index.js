$(function() {

    $('#conversation_add_member_search').keyup(function(event) {

        var search = $(this).val();

        if (search.length > 0) {

            $.ajax({
                method: 'post',
                url: '/conversation/suggest-members/',
                data: {
                    conversation_id: currentConversation,
                    search: search
                },
                dataType: 'json',
                success: function(result) {

                    var suggestions = $('#conversation_add_member_suggestions');

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

                            $('#conversation_add_member_selected .user').each(function(index, element) {
                                usersToAdd.push($(element).data('user-id'));
                            });

                            if (usersToAdd.length === 0) {
                                $('#conversation_add_member_selected').html('<h3>Selected:</h3>');
                            }

                            $(this).detach().appendTo('#conversation_add_member_selected');

                            var usersSuggested = [];

                            $('#conversation_add_member_suggestions .user').each(function(index, element) {
                                usersSuggested.push($(element).data('user-id'));
                            });

                            if (usersSuggested.length === 0) {
                                $('#conversation_add_member_suggestions').html('');
                            }
                        });
                    }

                }
            });

        }

    });

    $('#action_conversation_add_member').click(function(event) {

        event.preventDefault();

        var usersToAdd = [];

        $('#conversation_add_member_selected .user').each(function (index, element) {
            usersToAdd.push($(element).data('user-id'));
        });

        $.ajax({
            method: 'post',
            url: '/conversation/add-members/',
            data: {
                conversation_id: currentConversation,
                new_members: usersToAdd
            },
            dataType: 'json',
            success: function (result) {
                location.reload();
            }
        });
    });

});