<?php
/**
 * Vehicle Card Component
 * 
 * @param array $params — Card parameters
 */
function render_vehicle_card($params = []) {
    $tracking      = $params['tracking'] ?? '';
    $origin        = $params['origin'] ?? '';
    $destination   = $params['destination'] ?? '';
    $status        = $params['status'] ?? 'pending';
    $status_label  = $params['status_label'] ?? 'En attente';
    $client        = $params['client'] ?? '';
    $driver        = $params['driver'] ?? '';
    $weight        = $params['weight'] ?? '';
    $value         = $params['value'] ?? '';
    $progress      = $params['progress'] ?? 0;
    $eta           = $params['eta'] ?? '';
    $distance      = $params['distance'] ?? '';
    $elapsed       = $params['elapsed'] ?? '';
    $vehicle_type  = $params['vehicle_type'] ?? 'truck';
    $link          = $params['link'] ?? '';
    $selected      = $params['selected'] ?? false;

    $status_colors = [
        'on_route'   => 'tw-bg-blue-100 tw-text-blue-700',
        'waiting'    => 'tw-bg-amber-100 tw-text-amber-700',
        'delivered'  => 'tw-bg-green-100 tw-text-green-700',
        'problem'    => 'tw-bg-red-100 tw-text-red-700',
        'pending'    => 'tw-bg-gray-100 tw-text-gray-600',
        'in_customs' => 'tw-bg-violet-100 tw-text-violet-700',
        'cancelled'  => 'tw-bg-gray-200 tw-text-gray-500',
    ];

    $vehicle_icons = [
        'truck'  => 'truck',
        'plane'  => 'plane',
        'ship'   => 'ship',
        'van'    => 'truck',
    ];

    $badge_class = $status_colors[$status] ?? $status_colors['pending'];
    $v_icon = $vehicle_icons[$vehicle_type] ?? 'truck';
    $selected_class = $selected ? 'card-selected tw-border-blue-500' : 'tw-border-gray-200 hover:tw-border-gray-300';
    ?>
    <div class="tw-bg-white tw-rounded-xl tw-border <?php echo $selected_class; ?> tw-p-4 card-hover tw-cursor-pointer tw-transition-all tw-duration-200 animate-fade-slide-up"
         <?php if ($link): ?>onclick="window.location.href='<?php echo htmlspecialchars($link); ?>'"<?php endif; ?>>
        <!-- Header -->
        <div class="tw-flex tw-items-center tw-justify-between tw-mb-3">
            <div class="tw-flex tw-items-center tw-gap-2.5">
                <div class="tw-w-10 tw-h-10 tw-rounded-lg tw-bg-blue-50 tw-flex tw-items-center tw-justify-center">
                    <i data-lucide="<?php echo $v_icon; ?>" class="tw-w-5 tw-h-5 tw-text-blue-600"></i>
                </div>
                <div>
                    <p class="tw-text-sm tw-font-semibold tw-text-gray-800"><?php echo htmlspecialchars($tracking); ?></p>
                    <p class="tw-text-xs tw-text-gray-500"><?php echo htmlspecialchars($origin); ?> → <?php echo htmlspecialchars($destination); ?></p>
                </div>
            </div>
            <span class="tw-inline-flex tw-items-center tw-px-2 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium <?php echo $badge_class; ?>">
                <?php echo htmlspecialchars($status_label); ?>
            </span>
        </div>

        <!-- Progress bar -->
        <?php if ($progress > 0): ?>
        <div class="tw-mb-3">
            <div class="tw-flex tw-items-center tw-gap-2 tw-mb-1">
                <?php if ($elapsed): ?>
                    <span class="tw-text-xs tw-text-gray-500 tw-flex tw-items-center tw-gap-1">
                        <i data-lucide="clock" class="tw-w-3 tw-h-3"></i> <?php echo htmlspecialchars($elapsed); ?>
                    </span>
                <?php endif; ?>
                <?php if ($distance): ?>
                    <span class="tw-text-xs tw-text-gray-500 tw-flex tw-items-center tw-gap-1">
                        <i data-lucide="map-pin" class="tw-w-3 tw-h-3"></i> <?php echo htmlspecialchars($distance); ?>
                    </span>
                <?php endif; ?>
                <?php if ($eta): ?>
                    <span class="tw-text-xs tw-text-gray-500 tw-flex tw-items-center tw-gap-1 tw-ml-auto">
                        <i data-lucide="timer" class="tw-w-3 tw-h-3"></i> <?php echo htmlspecialchars($eta); ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="tw-w-full tw-h-1.5 tw-bg-gray-100 tw-rounded-full tw-overflow-hidden">
                <div class="tw-h-full tw-rounded-full tw-bg-blue-500 animate-progress-fill tw-transition-all tw-duration-500" style="width: <?php echo intval($progress); ?>%"></div>
            </div>
            <div class="tw-text-right tw-mt-0.5">
                <span class="tw-text-[10px] tw-text-gray-400"><?php echo intval($progress); ?>%</span>
            </div>
        </div>
        <?php endif; ?>

        <!-- Footer info -->
        <div class="tw-flex tw-items-center tw-justify-between tw-text-xs tw-text-gray-500">
            <div class="tw-flex tw-items-center tw-gap-3">
                <?php if ($client): ?>
                    <span class="tw-flex tw-items-center tw-gap-1">
                        <i data-lucide="user" class="tw-w-3 tw-h-3"></i> <?php echo htmlspecialchars($client); ?>
                    </span>
                <?php endif; ?>
                <?php if ($driver): ?>
                    <span class="tw-flex tw-items-center tw-gap-1">
                        <i data-lucide="car" class="tw-w-3 tw-h-3"></i> <?php echo htmlspecialchars($driver); ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="tw-flex tw-items-center tw-gap-3">
                <?php if ($weight): ?>
                    <span><?php echo htmlspecialchars($weight); ?></span>
                <?php endif; ?>
                <?php if ($value): ?>
                    <span class="tw-font-medium tw-text-gray-700"><?php echo htmlspecialchars($value); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}
