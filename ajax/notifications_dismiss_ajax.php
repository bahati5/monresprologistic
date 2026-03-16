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

require_once("../loader.php");

$db = new Conexion;
$user = new User;
$userData = $user->cdp_getUserData();

header('Content-Type: application/json');

if (!isset($_POST['notification_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing notification ID']);
    exit;
}

$notification_id = intval($_POST['notification_id']);
$user_id = $_SESSION['userid'];

// Mark notification as read (soft delete)
$db->cdp_query("
    UPDATE cdb_notifications_users 
    SET notification_read = '1' 
    WHERE notification_id = :notification_id 
    AND user_id = :user_id
");

$db->bind(':notification_id', $notification_id);
$db->bind(':user_id', $user_id);

if ($db->cdp_execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Notification dismissed']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to dismiss notification']);
}
?>
