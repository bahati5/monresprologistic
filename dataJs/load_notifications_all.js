"use strict";

$(function () {
    cdp_load_notifications();
});

const intervalMe = setInterval(cdp_load_notifications, 25000);

// Load notifications AJAX
function cdp_load_notifications() {
    var currentScroll = $('#currentScroll').val();

    $.ajax({
        url: './ajax/load_notifications_modern.php',
        beforeSend: function (objeto) {
        },
        success: function (data) {
            $("#ajax_response").html(data).fadeIn('slow');
            var scrollHeight = $('#messages').prop('scrollHeight');
            $('#messages').scrollTop(currentScroll);
        }
    })
}

// Dismiss single notification
function cdp_dismissNotification(notificationId, btnElement) {
    $.ajax({
        type: 'POST',
        url: './ajax/notifications_dismiss_ajax.php',
        data: { notification_id: notificationId },
        success: function(response) {
            if (response.status === 'success') {
                // Remove notification item with animation
                $(btnElement).closest('[data-notification-id]').fadeOut(300, function() {
                    $(this).remove();
                    // Reload notifications to update count
                    cdp_load_notifications();
                });
            }
        },
        error: function() {
            alert('Erreur lors de la suppression de la notification');
        }
    });
}

// Mark all notifications as read
function cdp_markAllNotificationsRead() {
    $.ajax({
        type: 'POST',
        url: './ajax/notifications_update_read_ajax.php',
        success: function(response) {
            // Reload notifications
            cdp_load_notifications();
        },
        error: function() {
            alert('Erreur lors de la mise à jour des notifications');
        }
    });
}
