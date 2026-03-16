<?php
/**
 * Capacity Gauge Component — Circular gauge for container/consolidation fill level
 * 
 * @param array $params
 *   - percentage: int — Fill percentage (0-100)
 *   - label: string — Label text (e.g. "Capacité camion")
 *   - sublabel: string — Sublabel (e.g. "12.5 / 15 kg")
 *   - size: string — 'sm', 'md', 'lg'
 *   - color: string — 'primary', 'success', 'warning', 'danger'
 */
function render_capacity_gauge($params = []) {
    $percentage = min(100, max(0, intval($params['percentage'] ?? 0)));
    $label      = $params['label'] ?? '';
    $sublabel   = $params['sublabel'] ?? '';
    $size       = $params['size'] ?? 'md';
    $color      = $params['color'] ?? 'auto';

    // Auto color based on percentage
    if ($color === 'auto') {
        if ($percentage >= 90) $color = 'danger';
        elseif ($percentage >= 70) $color = 'warning';
        elseif ($percentage >= 40) $color = 'primary';
        else $color = 'success';
    }

    $color_map = [
        'primary' => ['stroke' => '#2563EB', 'bg' => 'tw-text-blue-600',  'track' => '#DBEAFE'],
        'success' => ['stroke' => '#16A34A', 'bg' => 'tw-text-green-600', 'track' => '#DCFCE7'],
        'warning' => ['stroke' => '#F59E0B', 'bg' => 'tw-text-amber-600', 'track' => '#FEF3C7'],
        'danger'  => ['stroke' => '#DC2626', 'bg' => 'tw-text-red-600',   'track' => '#FEE2E2'],
    ];

    $c = $color_map[$color] ?? $color_map['primary'];

    $sizes = [
        'sm' => ['svg' => 80,  'radius' => 30, 'stroke_w' => 6,  'text' => 'tw-text-lg',  'label_text' => 'tw-text-[10px]'],
        'md' => ['svg' => 120, 'radius' => 45, 'stroke_w' => 8,  'text' => 'tw-text-2xl', 'label_text' => 'tw-text-xs'],
        'lg' => ['svg' => 160, 'radius' => 60, 'stroke_w' => 10, 'text' => 'tw-text-3xl', 'label_text' => 'tw-text-sm'],
    ];

    $s = $sizes[$size] ?? $sizes['md'];
    $circumference = 2 * M_PI * $s['radius'];
    $dashoffset = $circumference * (1 - $percentage / 100);
    $half = $s['svg'] / 2;
    ?>
    <div class="tw-flex tw-flex-col tw-items-center animate-fade-slide-up">
        <div class="tw-relative tw-inline-flex tw-items-center tw-justify-center">
            <svg width="<?php echo $s['svg']; ?>" height="<?php echo $s['svg']; ?>" class="tw--rotate-90">
                <!-- Track -->
                <circle cx="<?php echo $half; ?>" cy="<?php echo $half; ?>" r="<?php echo $s['radius']; ?>"
                        fill="none" stroke="<?php echo $c['track']; ?>" stroke-width="<?php echo $s['stroke_w']; ?>"/>
                <!-- Value -->
                <circle cx="<?php echo $half; ?>" cy="<?php echo $half; ?>" r="<?php echo $s['radius']; ?>"
                        fill="none" stroke="<?php echo $c['stroke']; ?>" stroke-width="<?php echo $s['stroke_w']; ?>"
                        stroke-linecap="round"
                        stroke-dasharray="<?php echo $circumference; ?>"
                        stroke-dashoffset="<?php echo $circumference; ?>"
                        class="gauge-animate"
                        style="--gauge-target: <?php echo $dashoffset; ?>;">
                    <animate attributeName="stroke-dashoffset" 
                             from="<?php echo $circumference; ?>" 
                             to="<?php echo $dashoffset; ?>" 
                             dur="1.2s" 
                             fill="freeze" 
                             calcMode="spline" 
                             keySplines="0.25 0.46 0.45 0.94"/>
                </circle>
            </svg>
            <!-- Center text -->
            <div class="tw-absolute tw-inset-0 tw-flex tw-flex-col tw-items-center tw-justify-center">
                <span class="<?php echo $s['text']; ?> tw-font-bold <?php echo $c['bg']; ?>"><?php echo $percentage; ?>%</span>
            </div>
        </div>
        <?php if ($label): ?>
            <p class="<?php echo $s['label_text']; ?> tw-font-medium tw-text-gray-700 tw-mt-2"><?php echo htmlspecialchars($label); ?></p>
        <?php endif; ?>
        <?php if ($sublabel): ?>
            <p class="<?php echo $s['label_text']; ?> tw-text-gray-400"><?php echo htmlspecialchars($sublabel); ?></p>
        <?php endif; ?>
    </div>
    <?php
}
