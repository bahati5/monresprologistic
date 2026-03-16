<?php
require_once("../../loader.php");
require_once("../../helpers/querys.php");
header('Content-Type: application/json');
if (!$user->cdp_loginCheck() || !$user->cdp_is_Admin()) {
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit;
}
$edit = !empty($_POST['edit']);
$branch_id = isset($_POST['branch_id']) ? (int)$_POST['branch_id'] : 0;
$label = isset($_POST['label']) ? trim($_POST['label']) : '';
$account_identifier = isset($_POST['account_identifier']) ? trim($_POST['account_identifier']) : '';
$currency = isset($_POST['currency']) ? trim($_POST['currency']) : null;
if (!$branch_id || !$label || !$account_identifier) {
    echo json_encode(['success' => false, 'message' => 'Champs requis manquants']);
    exit;
}
$datos = [
    'branch_id' => $branch_id,
    'label' => $label,
    'account_identifier' => $account_identifier,
    'currency' => $currency ?: null,
];
if ($edit && !empty($_POST['id'])) {
    $id = (int)$_POST['id'];
    $ok = cdp_updateAgencyPaymentCoordinate($id, $datos);
} else {
    $ok = cdp_insertAgencyPaymentCoordinate($datos) > 0;
}
echo json_encode(['success' => (bool)$ok]);
