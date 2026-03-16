<?php
/**
 * Workflow Maps — Monrespro Logistics
 * 
 * Maps numeric status codes to human-readable workflow steps
 * Used by workflow_timeline.php component
 */

/**
 * Shipment/Courier workflow steps
 * Maps status_courier values to workflow data
 */
function get_courier_workflow_steps($current_status) {
    $steps = [
        ['status' => 0,  'label' => 'Créée',         'icon' => 'file-plus',      'color' => 'gray'],
        ['status' => 1,  'label' => 'Acceptée',      'icon' => 'check-circle',   'color' => 'blue'],
        ['status' => 2,  'label' => 'En préparation', 'icon' => 'package',        'color' => 'blue'],
        ['status' => 3,  'label' => 'Collectée',     'icon' => 'truck',          'color' => 'blue'],
        ['status' => 4,  'label' => 'En transit',    'icon' => 'navigation',     'color' => 'cyan'],
        ['status' => 5,  'label' => 'En douane',     'icon' => 'shield',         'color' => 'amber'],
        ['status' => 6,  'label' => 'Arrivée',       'icon' => 'map-pin',        'color' => 'blue'],
        ['status' => 7,  'label' => 'En livraison',  'icon' => 'truck',          'color' => 'blue'],
        ['status' => 8,  'label' => 'Livrée',        'icon' => 'check-circle-2', 'color' => 'green'],
    ];

    $result = [];
    foreach ($steps as $step) {
        $step_data = $step;
        if ($step['status'] < $current_status) {
            $step_data['state'] = 'completed';
        } elseif ($step['status'] == $current_status) {
            $step_data['state'] = 'active';
        } else {
            $step_data['state'] = 'pending';
        }
        $result[] = $step_data;
    }

    return $result;
}

/**
 * Customer Package workflow steps
 */
function get_customer_package_workflow_steps($current_status) {
    $steps = [
        ['status' => 0, 'label' => 'Pré-alerté',          'icon' => 'bell',          'color' => 'gray'],
        ['status' => 1, 'label' => 'Réceptionné au hub',   'icon' => 'inbox',         'color' => 'blue'],
        ['status' => 2, 'label' => 'En attente paiement',  'icon' => 'clock',         'color' => 'amber'],
        ['status' => 3, 'label' => 'Payé',                 'icon' => 'credit-card',   'color' => 'green'],
        ['status' => 4, 'label' => 'Intégré à expédition', 'icon' => 'package',       'color' => 'blue'],
        ['status' => 5, 'label' => 'En transit',           'icon' => 'navigation',    'color' => 'cyan'],
        ['status' => 8, 'label' => 'Livré',                'icon' => 'check-circle-2','color' => 'green'],
    ];

    $result = [];
    foreach ($steps as $step) {
        $step_data = $step;
        if ($step['status'] < $current_status) {
            $step_data['state'] = 'completed';
        } elseif ($step['status'] == $current_status) {
            $step_data['state'] = 'active';
        } else {
            $step_data['state'] = 'pending';
        }
        $result[] = $step_data;
    }

    return $result;
}

/**
 * Pickup workflow steps
 */
function get_pickup_workflow_steps($current_status) {
    $steps = [
        ['status' => 0, 'label' => 'Demandé',            'icon' => 'phone-call',    'color' => 'gray'],
        ['status' => 1, 'label' => 'Accepté',            'icon' => 'check',         'color' => 'blue'],
        ['status' => 2, 'label' => 'Chauffeur assigné',  'icon' => 'user-check',    'color' => 'blue'],
        ['status' => 3, 'label' => 'En route',           'icon' => 'truck',         'color' => 'cyan'],
        ['status' => 4, 'label' => 'Récupéré',           'icon' => 'package-check', 'color' => 'blue'],
        ['status' => 5, 'label' => 'Livré au hub',       'icon' => 'home',          'color' => 'green'],
    ];

    $result = [];
    foreach ($steps as $step) {
        $step_data = $step;
        if ($step['status'] < $current_status) {
            $step_data['state'] = 'completed';
        } elseif ($step['status'] == $current_status) {
            $step_data['state'] = 'active';
        } else {
            $step_data['state'] = 'pending';
        }
        $result[] = $step_data;
    }

    return $result;
}

/**
 * Consolidation workflow steps
 */
function get_consolidation_workflow_steps($current_status) {
    $steps = [
        ['status' => 0, 'label' => 'Créée',         'icon' => 'folder-plus',    'color' => 'gray'],
        ['status' => 1, 'label' => 'Colis ajoutés',  'icon' => 'package-plus',   'color' => 'blue'],
        ['status' => 2, 'label' => 'Fermée',         'icon' => 'lock',           'color' => 'blue'],
        ['status' => 3, 'label' => 'Expédiée',       'icon' => 'send',           'color' => 'cyan'],
        ['status' => 4, 'label' => 'En transit',     'icon' => 'navigation',     'color' => 'cyan'],
        ['status' => 5, 'label' => 'Arrivée',        'icon' => 'map-pin',        'color' => 'blue'],
        ['status' => 6, 'label' => 'Distribuée',     'icon' => 'check-circle-2', 'color' => 'green'],
    ];

    $result = [];
    foreach ($steps as $step) {
        $step_data = $step;
        if ($step['status'] < $current_status) {
            $step_data['state'] = 'completed';
        } elseif ($step['status'] == $current_status) {
            $step_data['state'] = 'active';
        } else {
            $step_data['state'] = 'pending';
        }
        $result[] = $step_data;
    }

    return $result;
}


/**
 * Get status badge classes for a given status
 */
function get_status_badge_classes($state) {
    switch ($state) {
        case 'completed':
            return 'bg-green-100 text-green-700 border-green-200';
        case 'active':
            return 'bg-blue-100 text-blue-700 border-blue-200';
        case 'pending':
            return 'bg-gray-100 text-gray-400 border-gray-200';
        case 'problem':
            return 'bg-red-100 text-red-700 border-red-200';
        case 'cancelled':
            return 'bg-gray-200 text-gray-500 border-gray-300';
        default:
            return 'bg-gray-100 text-gray-400 border-gray-200';
    }
}

/**
 * Get color utility class from color name
 */
function get_workflow_color_classes($color, $type = 'bg') {
    $colors = [
        'gray'   => ['bg' => 'bg-gray-100',   'text' => 'text-gray-500',   'border' => 'border-gray-200'],
        'blue'   => ['bg' => 'bg-blue-100',   'text' => 'text-blue-600',   'border' => 'border-blue-200'],
        'green'  => ['bg' => 'bg-green-100',  'text' => 'text-green-600',  'border' => 'border-green-200'],
        'amber'  => ['bg' => 'bg-amber-100',  'text' => 'text-amber-600',  'border' => 'border-amber-200'],
        'red'    => ['bg' => 'bg-red-100',    'text' => 'text-red-600',    'border' => 'border-red-200'],
        'cyan'   => ['bg' => 'bg-cyan-100',   'text' => 'text-cyan-600',   'border' => 'border-cyan-200'],
        'violet' => ['bg' => 'bg-violet-100', 'text' => 'text-violet-600', 'border' => 'border-violet-200'],
    ];

    return isset($colors[$color][$type]) ? $colors[$color][$type] : $colors['gray'][$type];
}
