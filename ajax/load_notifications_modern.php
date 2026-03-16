<?php
// *************************************************************************
// *                                                                       *
// * MONRESPRO - Integrated Logistics System                         *
// * Copyright (c) JAOMWEB. All Rights Reserved                            *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: support@jaom.info                                              *
// * Website: http://www.jaom.info                                         *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// * If you Purchased from Codecanyon, Please read the full License from   *
// * here- http://codecanyon.net/licenses/standard                         *
// *                                                                       *
// *************************************************************************

require_once("../helpers/querys.php");
require_once("../loader.php");

$user = new User;
$db = new Conexion;
$userData = $user->cdp_getUserData();

$sWhere = " and a.user_id ='" . $_SESSION['userid'] . "'";

$db->cdp_query("
    SELECT a.user_id, b.shipping_type, a.id_notifi_user, b.notification_description, 
           b.notification_date, b.order_id, a.notification_status, a.notification_read, b.notification_id
    FROM cdb_notifications_users as a
    INNER JOIN cdb_notifications as b ON a.notification_id = b.notification_id
    WHERE a.notification_read ='0'
    $sWhere
    order by b.notification_id desc
");

$db->cdp_execute();
$data = $db->cdp_registros();
$rowCount = $db->cdp_rowCount();

?>

<!-- Modern notification panel (Tailwind) -->
<div class="tw-flex tw-flex-col tw-h-full">
    <!-- Header -->
    <div class="tw-flex tw-items-center tw-justify-between tw-px-4 tw-py-3 tw-shrink-0" style="background:linear-gradient(135deg,#1a7fb5,#15699a);border-bottom:1px solid rgba(255,255,255,0.1);">
        <div class="tw-flex tw-items-center tw-gap-2">
            <i data-lucide="bell" class="tw-w-5 tw-h-5 tw-text-white"></i>
            <div>
                <h4 class="tw-text-sm tw-font-semibold tw-text-white tw-m-0"><?php echo $rowCount; ?> Notifications</h4>
                <p class="tw-text-[10px] tw-m-0" style="color:rgba(255,255,255,0.7);"><?php echo $lang['notification_title'] ?? 'Nouvelles notifications'; ?></p>
            </div>
        </div>
        <?php if ($rowCount > 0): ?>
            <button onclick="cdp_markAllNotificationsRead()" class="tw-text-[11px] tw-font-medium tw-text-white tw-transition-colors tw-px-2.5 tw-py-1 tw-rounded-md" style="background:rgba(255,255,255,0.15);" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                Tout marquer lu
            </button>
        <?php endif; ?>
    </div>

    <!-- Notification list -->
    <div class="tw-flex-1 tw-overflow-y-auto" id="messages" style="max-height:350px;">
        <?php if ($rowCount > 0): ?>
            <?php foreach ($data as $key): ?>
                <?php
                $fecha = strtotime($key->notification_date);
                $timeAgo = cdp_timeAgo($fecha);
                
                $href = '';
                switch ($key->shipping_type) {
                    case '1': $href = 'courier_view.php?id=' . $key->order_id . '&id_notification=' . $key->notification_id; break;
                    case '2': $href = 'consolidate_view.php?id=' . $key->order_id . '&id_notification=' . $key->notification_id; break;
                    case '3': $href = 'prealert_list.php?id_notification=' . $key->notification_id; break;
                    case '4': $href = 'customer_packages_view.php?id=' . $key->order_id . '&id_notification=' . $key->notification_id; break;
                    case '5': $href = 'consolidate_package_view.php?id=' . $key->order_id . '&id_notification=' . $key->notification_id; break;
                    default: $href = 'customers_edit.php?user=' . $key->order_id; break;
                }
                ?>
                
                <div class="tw-group tw-flex tw-items-start tw-gap-3 tw-px-4 tw-py-3 tw-border-b tw-border-gray-700 hover:tw-bg-slate-700/30 tw-transition-colors" data-notification-id="<?php echo $key->notification_id; ?>">
                    <div class="tw-shrink-0 tw-w-8 tw-h-8 tw-rounded-full tw-flex tw-items-center tw-justify-center" style="background:rgba(26,127,181,0.15);">
                        <i data-lucide="bell" class="tw-w-4 tw-h-4" style="color:#5bb8e0;"></i>
                    </div>
                    <div class="tw-flex-1 tw-min-w-0">
                        <a href="<?php echo $href; ?>" class="tw-block tw-no-underline hover:tw-underline">
                            <p class="tw-text-[13px] tw-font-medium tw-text-slate-200 tw-m-0 tw-leading-snug"><?php echo htmlspecialchars($key->notification_description); ?></p>
                        </a>
                        <p class="tw-text-[11px] tw-text-slate-400 tw-m-0 tw-mt-1"><?php echo $timeAgo; ?></p>
                    </div>
                    <button onclick="cdp_dismissNotification(<?php echo $key->notification_id; ?>, this)" class="tw-opacity-0 group-hover:tw-opacity-100 tw-shrink-0 tw-w-6 tw-h-6 tw-rounded tw-flex tw-items-center tw-justify-center hover:tw-bg-red-500/20 tw-transition-all" title="Supprimer">
                        <i data-lucide="x" class="tw-w-4 tw-h-4 tw-text-slate-400 hover:tw-text-red-400"></i>
                    </button>
                </div>

                <?php if ($key->notification_status == 0): ?>
                    <script>
                        $('#clickme').click();
                        $('#chatAudio')[0].play();
                    </script>
                    <?php cdp_updateNotificationStatus($_SESSION['userid'], $key->notification_id); ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-py-12 tw-px-4">
                <div class="tw-w-16 tw-h-16 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mb-3" style="background:rgba(100,116,139,0.1);">
                    <i data-lucide="bell-off" class="tw-w-8 tw-h-8 tw-text-slate-500"></i>
                </div>
                <p class="tw-text-sm tw-text-slate-400 tw-m-0">Aucune notification</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <div class="tw-shrink-0 tw-border-t tw-border-gray-700">
        <a href="notifications_list.php" class="tw-flex tw-items-center tw-justify-center tw-gap-2 tw-px-4 tw-py-2.5 tw-text-[12px] tw-font-medium tw-no-underline tw-transition-colors" style="color:#5bb8e0;" onmouseover="this.style.color='#7ecce8';this.style.background='rgba(26,127,181,0.08)'" onmouseout="this.style.color='#5bb8e0';this.style.background='transparent'">
            <span>Voir toutes les notifications</span>
            <i data-lucide="arrow-right" class="tw-w-3.5 tw-h-3.5"></i>
        </a>
    </div>
</div>

<input type="hidden" id="countNotificationsInput" value="<?php echo $rowCount; ?>">
<input type="hidden" id="lengthScroll" value="0">
<input type="hidden" id="currentScroll" value="0">

<script>
    $('#countNotifications').html('<?php echo $rowCount; ?>');
    var count = $('#countNotificationsInput').val();
    if (count > 0) {
        $('#countNotifications').addClass('bg-danger text-white').show();
        $('#railNotifBadge').html(count).show();
    } else {
        $('#countNotifications').removeClass('bg-danger').hide();
        $('#railNotifBadge').hide();
    }
    
    // Reinit Lucide icons after AJAX load
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>

<script>
    $("#messages").on('scroll', function() {
        currentScroll = $('#messages').scrollTop();
        $('#currentScroll').val(currentScroll);
    });
</script>

<?php
// Helper function for time ago
function cdp_timeAgo($timestamp) {
    $diff = time() - $timestamp;
    
    if ($diff < 60) return 'À l\'instant';
    if ($diff < 3600) return floor($diff / 60) . ' min';
    if ($diff < 86400) return floor($diff / 3600) . ' h';
    if ($diff < 604800) return floor($diff / 86400) . ' j';
    
    return date('d M Y', $timestamp);
}
?>
