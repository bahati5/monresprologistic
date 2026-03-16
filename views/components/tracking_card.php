<?php
/**
 * Tracking Card Component — Card with vehicle illustration, ETA, progress
 * 
 * @param array $params
 *   - tracking: string — Tracking number
 *   - origin: string
 *   - destination: string
 *   - vehicle_type: string — truck, plane, ship
 *   - status_label: string
 *   - status: string — on_route, waiting, delivered, problem
 *   - progress: int — 0-100
 *   - eta: string — Estimated time of arrival
 *   - elapsed: string — Time elapsed
 *   - distance: string — Distance remaining
 *   - last_update: string — Last update datetime
 *   - last_location: string — Last known location
 */
function render_tracking_card($params = []) {
    $tracking      = $params['tracking'] ?? '';
    $origin        = $params['origin'] ?? '';
    $destination   = $params['destination'] ?? '';
    $vehicle_type  = $params['vehicle_type'] ?? 'truck';
    $status_label  = $params['status_label'] ?? 'En cours';
    $status        = $params['status'] ?? 'on_route';
    $progress      = min(100, max(0, intval($params['progress'] ?? 0)));
    $eta           = $params['eta'] ?? '';
    $elapsed       = $params['elapsed'] ?? '';
    $distance      = $params['distance'] ?? '';
    $last_update   = $params['last_update'] ?? '';
    $last_location = $params['last_location'] ?? '';

    $status_colors = [
        'on_route'   => 'tw-bg-blue-100 tw-text-blue-700 tw-border-blue-200',
        'waiting'    => 'tw-bg-amber-100 tw-text-amber-700 tw-border-amber-200',
        'delivered'  => 'tw-bg-green-100 tw-text-green-700 tw-border-green-200',
        'problem'    => 'tw-bg-red-100 tw-text-red-700 tw-border-red-200',
        'pending'    => 'tw-bg-gray-100 tw-text-gray-600 tw-border-gray-200',
    ];

    $vehicle_icons = [
        'truck' => 'truck',
        'plane' => 'plane',
        'ship'  => 'ship',
        'van'   => 'truck',
    ];

    $badge_class = $status_colors[$status] ?? $status_colors['pending'];
    $v_icon = $vehicle_icons[$vehicle_type] ?? 'truck';
    ?>
    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-overflow-hidden animate-fade-slide-up">
        <!-- Header gradient -->
        <div class="tw-bg-gradient-to-r tw-from-blue-600 tw-to-blue-700 tw-px-5 tw-py-4">
            <div class="tw-flex tw-items-center tw-justify-between">
                <div>
                    <p class="tw-text-blue-200 tw-text-xs tw-font-medium tw-uppercase tw-tracking-wider">Suivi expédition</p>
                    <p class="tw-text-white tw-text-lg tw-font-bold tw-mt-0.5"><?php echo htmlspecialchars($tracking); ?></p>
                </div>
                <div class="tw-w-12 tw-h-12 tw-rounded-xl tw-bg-white/10 tw-flex tw-items-center tw-justify-center">
                    <i data-lucide="<?php echo $v_icon; ?>" class="tw-w-6 tw-h-6 tw-text-white"></i>
                </div>
            </div>
        </div>

        <div class="tw-p-5">
            <!-- Route -->
            <div class="tw-flex tw-items-center tw-gap-3 tw-mb-4">
                <div class="tw-flex tw-flex-col tw-items-center tw-gap-0.5">
                    <div class="tw-w-2.5 tw-h-2.5 tw-rounded-full tw-bg-blue-500"></div>
                    <div class="tw-w-0.5 tw-h-8 tw-bg-gray-200"></div>
                    <div class="tw-w-2.5 tw-h-2.5 tw-rounded-full tw-border-2 tw-border-green-500 tw-bg-white"></div>
                </div>
                <div class="tw-flex-1">
                    <p class="tw-text-sm tw-font-medium tw-text-gray-800"><?php echo htmlspecialchars($origin); ?></p>
                    <div class="tw-h-6"></div>
                    <p class="tw-text-sm tw-font-medium tw-text-gray-800"><?php echo htmlspecialchars($destination); ?></p>
                </div>
                <span class="tw-self-start tw-inline-flex tw-items-center tw-px-2.5 tw-py-1 tw-rounded-full tw-text-xs tw-font-medium tw-border <?php echo $badge_class; ?>">
                    <?php echo htmlspecialchars($status_label); ?>
                </span>
            </div>

            <!-- Progress -->
            <div class="tw-mb-4">
                <div class="tw-flex tw-items-center tw-justify-between tw-mb-1.5">
                    <span class="tw-text-xs tw-text-gray-500">Progression</span>
                    <span class="tw-text-xs tw-font-semibold tw-text-gray-700"><?php echo $progress; ?>%</span>
                </div>
                <div class="tw-w-full tw-h-2 tw-bg-gray-100 tw-rounded-full tw-overflow-hidden">
                    <div class="tw-h-full tw-rounded-full tw-transition-all tw-duration-1000 animate-progress-fill <?php echo $status === 'delivered' ? 'tw-bg-green-500' : ($status === 'problem' ? 'tw-bg-red-500' : 'tw-bg-blue-500'); ?>"
                         style="width: <?php echo $progress; ?>%"></div>
                </div>
            </div>

            <!-- Stats row -->
            <div class="tw-grid tw-grid-cols-3 tw-gap-3 tw-mb-4">
                <?php if ($elapsed): ?>
                <div class="tw-text-center tw-py-2 tw-px-1 tw-bg-gray-50 tw-rounded-lg">
                    <i data-lucide="clock" class="tw-w-4 tw-h-4 tw-text-gray-400 tw-mx-auto tw-mb-1"></i>
                    <p class="tw-text-sm tw-font-semibold tw-text-gray-800"><?php echo htmlspecialchars($elapsed); ?></p>
                    <p class="tw-text-[10px] tw-text-gray-400">Temps écoulé</p>
                </div>
                <?php endif; ?>
                <?php if ($distance): ?>
                <div class="tw-text-center tw-py-2 tw-px-1 tw-bg-gray-50 tw-rounded-lg">
                    <i data-lucide="map-pin" class="tw-w-4 tw-h-4 tw-text-gray-400 tw-mx-auto tw-mb-1"></i>
                    <p class="tw-text-sm tw-font-semibold tw-text-gray-800"><?php echo htmlspecialchars($distance); ?></p>
                    <p class="tw-text-[10px] tw-text-gray-400">Distance</p>
                </div>
                <?php endif; ?>
                <?php if ($eta): ?>
                <div class="tw-text-center tw-py-2 tw-px-1 tw-bg-gray-50 tw-rounded-lg">
                    <i data-lucide="timer" class="tw-w-4 tw-h-4 tw-text-gray-400 tw-mx-auto tw-mb-1"></i>
                    <p class="tw-text-sm tw-font-semibold tw-text-gray-800"><?php echo htmlspecialchars($eta); ?></p>
                    <p class="tw-text-[10px] tw-text-gray-400">ETA</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Last update -->
            <?php if ($last_location || $last_update): ?>
            <div class="tw-flex tw-items-center tw-gap-2 tw-text-xs tw-text-gray-500 tw-pt-3 tw-border-t tw-border-gray-100">
                <i data-lucide="radio" class="tw-w-3.5 tw-h-3.5 tw-text-green-500 tw-animate-pulse"></i>
                <span>
                    <?php if ($last_location): ?>Dernière position : <strong class="tw-text-gray-700"><?php echo htmlspecialchars($last_location); ?></strong><?php endif; ?>
                    <?php if ($last_update): ?> — <?php echo htmlspecialchars($last_update); ?><?php endif; ?>
                </span>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}
