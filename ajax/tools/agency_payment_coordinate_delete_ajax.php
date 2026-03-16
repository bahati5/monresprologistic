<?php
require_once("../../loader.php");
require_once("../../helpers/querys.php");
header('Content-Type: application/json');
if (!$user->cdp_loginCheck() || !$user->cdp_is_Admin()) {
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit;
}
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if (!$id) {
    echo json_encode(['success' => false, 'message' => 'ID invalide']);
    exit;
}
$ok = cdp_deleteAgencyPaymentCoordinate($id);
echo json_encode(['success' => (bool)$ok]);
