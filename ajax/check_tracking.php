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

// Set JSON header first to prevent BOM issues
header('Content-Type: application/json; charset=utf-8');

require_once("../loader.php");
require_once("../helpers/querys.php");

$db = new Conexion;

// Load language files
if (isset($_SESSION['lang']) && file_exists("../helpers/languages/".$_SESSION['lang'].".php")) {
    require_once("../helpers/languages/".$_SESSION['lang'].".php");
} else {
    // Default to French if session lang not set
    require_once("../helpers/languages/fr.php");
}

// Debug logging
error_log("check_tracking.php: Tracking received - " . ($_POST['tracking'] ?? 'none'));
error_log("check_tracking.php: Session lang - " . ($_SESSION['lang'] ?? 'none'));

$response = []; // Inicializar la respuesta

// Verificar si se recibió un número de seguimiento (tracking) mediante POST
if (!empty($_POST['tracking'])) {
    // Sanitizar el número de seguimiento recibido
    $tracking = cdp_sanitize($_POST['tracking']);
    error_log("check_tracking.php: Sanitized tracking - " . $tracking);

    // Realizar la consulta en la base de datos para verificar si el número de seguimiento ya está en uso
    $existingPrealert = cdp_getPreAlertByTracking($tracking);
    error_log("check_tracking.php: DB result - " . ($existingPrealert ? 'found' : 'not found'));

    // Verificar si se encontró un registro con el número de seguimiento
    if ($existingPrealert) {
        $response['status'] = 'error';
        $response['message'] = $lang['messagesform43'] ?? 'Le numéro de suivi est déjà utilisé.';
        error_log("check_tracking.php: Response - tracking already exists");
    } else {
        $response['status'] = 'success';
        $response['message'] = 'Tracking available';
        error_log("check_tracking.php: Response - tracking available");
    }
} else {
    $response['status'] = 'error';
    $response['message'] = $lang['messagesform44'] ?? 'Le numéro de suivi est requis.';
    error_log("check_tracking.php: Response - no tracking received");
}

// Clean output buffer to prevent BOM issues
ob_clean();
echo json_encode($response);