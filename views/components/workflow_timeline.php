<?php
/**
 * Workflow Timeline Component
 * 
 * @param array  $steps       — Array of workflow steps from workflow_maps.php
 * @param string $orientation — 'horizontal' or 'vertical'
 * @param bool   $compact     — If true, renders a smaller inline version
 */
function render_workflow_timeline($steps, $orientation = 'horizontal', $compact = false) {
    if (empty($steps)) return;

    $state_classes = [
        'completed' => [
            'circle' => 'tw-bg-green-500 tw-border-green-500 tw-text-white',
            'line'   => 'tw-bg-green-500',
            'label'  => 'tw-text-green-700 tw-font-medium',
        ],
        'active' => [
            'circle' => 'tw-bg-blue-600 tw-border-blue-600 tw-text-white tw-ring-4 tw-ring-blue-100',
            'line'   => 'tw-bg-gray-200',
            'label'  => 'tw-text-blue-700 tw-font-semibold',
        ],
        'pending' => [
            'circle' => 'tw-bg-white tw-border-gray-300 tw-text-gray-400',
            'line'   => 'tw-bg-gray-200',
            'label'  => 'tw-text-gray-400',
        ],
        'problem' => [
            'circle' => 'tw-bg-red-500 tw-border-red-500 tw-text-white tw-ring-4 tw-ring-red-100',
            'line'   => 'tw-bg-red-200',
            'label'  => 'tw-text-red-700 tw-font-semibold',
        ],
    ];

    // --- Compact inline badge version ---
    if ($compact) {
        $active_step = null;
        $active_index = 0;
        foreach ($steps as $i => $step) {
            if (($step['state'] ?? 'pending') === 'active') {
                $active_step = $step;
                $active_index = $i + 1;
                break;
            }
        }
        if (!$active_step) {
            // Find last completed
            foreach (array_reverse($steps, true) as $i => $step) {
                if (($step['state'] ?? 'pending') === 'completed') {
                    $active_step = $step;
                    $active_index = $i + 1;
                    break;
                }
            }
        }
        if ($active_step) {
            $total = count($steps);
            ?>
            <span class="tw-inline-flex tw-items-center tw-gap-1.5 tw-px-2 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-blue-50 tw-text-blue-700 tw-border tw-border-blue-200">
                <i data-lucide="<?php echo htmlspecialchars($active_step['icon'] ?? 'circle'); ?>" class="tw-w-3 tw-h-3"></i>
                <?php echo $active_index; ?>/<?php echo $total; ?> <?php echo htmlspecialchars($active_step['label']); ?>
            </span>
            <?php
        }
        return;
    }

    // --- Horizontal timeline ---
    if ($orientation === 'horizontal') {
        ?>
        <div class="tw-flex tw-items-start tw-w-full tw-overflow-x-auto tw-pb-2">
            <?php foreach ($steps as $i => $step):
                $state = $step['state'] ?? 'pending';
                $sc = $state_classes[$state] ?? $state_classes['pending'];
                $is_last = ($i === count($steps) - 1);
            ?>
                <div class="tw-flex tw-items-start tw-flex-1 tw-min-w-0 <?php echo !$is_last ? '' : ''; ?>">
                    <div class="tw-flex tw-flex-col tw-items-center tw-flex-shrink-0">
                        <!-- Circle -->
                        <div class="tw-w-8 tw-h-8 tw-rounded-full tw-border-2 tw-flex tw-items-center tw-justify-center tw-transition-all tw-duration-300 <?php echo $sc['circle']; ?> <?php echo $state === 'active' ? 'tw-animate-pulse' : ''; ?>">
                            <?php if ($state === 'completed'): ?>
                                <i data-lucide="check" class="tw-w-4 tw-h-4"></i>
                            <?php elseif ($state === 'problem'): ?>
                                <i data-lucide="alert-triangle" class="tw-w-4 tw-h-4"></i>
                            <?php else: ?>
                                <i data-lucide="<?php echo htmlspecialchars($step['icon'] ?? 'circle'); ?>" class="tw-w-4 tw-h-4"></i>
                            <?php endif; ?>
                        </div>
                        <!-- Label -->
                        <span class="tw-text-[10px] tw-mt-1.5 tw-text-center tw-leading-tight tw-max-w-[80px] <?php echo $sc['label']; ?>">
                            <?php echo htmlspecialchars($step['label']); ?>
                        </span>
                        <?php if (!empty($step['date'])): ?>
                            <span class="tw-text-[9px] tw-text-gray-400 tw-mt-0.5"><?php echo htmlspecialchars($step['date']); ?></span>
                        <?php endif; ?>
                    </div>
                    <!-- Connector line -->
                    <?php if (!$is_last): ?>
                        <div class="tw-flex-1 tw-h-0.5 tw-mt-4 tw-mx-1 tw-rounded-full <?php echo $sc['line']; ?>"></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
    // --- Vertical timeline ---
    else {
        ?>
        <div class="tw-flex tw-flex-col tw-gap-0">
            <?php foreach ($steps as $i => $step):
                $state = $step['state'] ?? 'pending';
                $sc = $state_classes[$state] ?? $state_classes['pending'];
                $is_last = ($i === count($steps) - 1);
            ?>
                <div class="tw-flex tw-gap-3">
                    <!-- Circle + Line -->
                    <div class="tw-flex tw-flex-col tw-items-center">
                        <div class="tw-w-8 tw-h-8 tw-rounded-full tw-border-2 tw-flex tw-items-center tw-justify-center tw-shrink-0 tw-transition-all tw-duration-300 <?php echo $sc['circle']; ?> <?php echo $state === 'active' ? 'tw-animate-pulse' : ''; ?>">
                            <?php if ($state === 'completed'): ?>
                                <i data-lucide="check" class="tw-w-4 tw-h-4"></i>
                            <?php elseif ($state === 'problem'): ?>
                                <i data-lucide="alert-triangle" class="tw-w-4 tw-h-4"></i>
                            <?php else: ?>
                                <i data-lucide="<?php echo htmlspecialchars($step['icon'] ?? 'circle'); ?>" class="tw-w-4 tw-h-4"></i>
                            <?php endif; ?>
                        </div>
                        <?php if (!$is_last): ?>
                            <div class="tw-w-0.5 tw-flex-1 tw-min-h-[24px] tw-rounded-full <?php echo $sc['line']; ?>"></div>
                        <?php endif; ?>
                    </div>
                    <!-- Content -->
                    <div class="tw-pb-4 <?php echo $is_last ? '' : ''; ?>">
                        <p class="tw-text-sm <?php echo $sc['label']; ?>"><?php echo htmlspecialchars($step['label']); ?></p>
                        <?php if (!empty($step['date'])): ?>
                            <p class="tw-text-xs tw-text-gray-400 tw-mt-0.5"><?php echo htmlspecialchars($step['date']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($step['description'])): ?>
                            <p class="tw-text-xs tw-text-gray-500 tw-mt-0.5"><?php echo htmlspecialchars($step['description']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
