<?php
/**
 * Stats Card Component
 * 
 * @param string $title     — Card title/label
 * @param string $value     — Main value to display
 * @param string $icon      — Lucide icon name
 * @param string $color     — Color theme: primary, success, warning, danger, info, secondary
 * @param string $trend     — Optional: 'up' or 'down'
 * @param string $trend_value — Optional: e.g. '+12%'
 * @param string $subtitle  — Optional: additional context text
 * @param string $link      — Optional: URL to navigate to
 * @param string $link_text — Optional: link button text
 */
function render_stats_card($params = []) {
    $title       = $params['title'] ?? '';
    $value       = $params['value'] ?? '0';
    $icon        = $params['icon'] ?? 'bar-chart-3';
    $color       = $params['color'] ?? 'primary';
    $trend       = $params['trend'] ?? '';
    $trend_value = $params['trend_value'] ?? '';
    $subtitle    = $params['subtitle'] ?? '';
    $link        = $params['link'] ?? '';
    $link_text   = $params['link_text'] ?? 'Voir détails';

    $color_map = [
        'primary'   => ['bg' => 'tw-bg-blue-50',   'text' => 'tw-text-blue-600',   'icon_bg' => 'tw-bg-blue-100',   'border' => 'tw-border-blue-100'],
        'success'   => ['bg' => 'tw-bg-green-50',  'text' => 'tw-text-green-600',  'icon_bg' => 'tw-bg-green-100',  'border' => 'tw-border-green-100'],
        'warning'   => ['bg' => 'tw-bg-amber-50',  'text' => 'tw-text-amber-600',  'icon_bg' => 'tw-bg-amber-100',  'border' => 'tw-border-amber-100'],
        'danger'    => ['bg' => 'tw-bg-red-50',    'text' => 'tw-text-red-600',    'icon_bg' => 'tw-bg-red-100',    'border' => 'tw-border-red-100'],
        'info'      => ['bg' => 'tw-bg-cyan-50',   'text' => 'tw-text-cyan-600',   'icon_bg' => 'tw-bg-cyan-100',   'border' => 'tw-border-cyan-100'],
        'secondary' => ['bg' => 'tw-bg-violet-50', 'text' => 'tw-text-violet-600', 'icon_bg' => 'tw-bg-violet-100', 'border' => 'tw-border-violet-100'],
    ];

    $c = $color_map[$color] ?? $color_map['primary'];
    ?>
    <div class="tw-bg-white tw-rounded-xl tw-border <?php echo $c['border']; ?> tw-p-5 card-hover animate-fade-slide-up tw-relative tw-overflow-hidden">
        <div class="tw-flex tw-items-start tw-justify-between">
            <div class="tw-flex-1 tw-min-w-0">
                <p class="tw-text-sm tw-font-medium tw-text-gray-500 tw-mb-1 tw-truncate"><?php echo htmlspecialchars($title); ?></p>
                <h3 class="tw-text-2xl tw-font-bold tw-text-gray-800 tw-mb-1" data-count-target="<?php echo strip_tags($value); ?>">
                    <?php echo $value; ?>
                </h3>
                <?php if ($trend && $trend_value): ?>
                    <div class="tw-flex tw-items-center tw-gap-1 tw-text-xs tw-font-medium <?php echo $trend === 'up' ? 'tw-text-green-600' : 'tw-text-red-600'; ?>">
                        <i data-lucide="<?php echo $trend === 'up' ? 'trending-up' : 'trending-down'; ?>" class="tw-w-3.5 tw-h-3.5"></i>
                        <span><?php echo htmlspecialchars($trend_value); ?></span>
                    </div>
                <?php endif; ?>
                <?php if ($subtitle): ?>
                    <p class="tw-text-xs tw-text-gray-400 tw-mt-1"><?php echo htmlspecialchars($subtitle); ?></p>
                <?php endif; ?>
            </div>
            <div class="<?php echo $c['icon_bg']; ?> tw-rounded-lg tw-p-2.5 tw-shrink-0">
                <i data-lucide="<?php echo htmlspecialchars($icon); ?>" class="tw-w-5 tw-h-5 <?php echo $c['text']; ?>"></i>
            </div>
        </div>
        <?php if ($link): ?>
            <a href="<?php echo htmlspecialchars($link); ?>" class="tw-mt-3 tw-inline-flex tw-items-center tw-gap-1 tw-text-xs tw-font-medium <?php echo $c['text']; ?> hover:tw-underline">
                <?php echo htmlspecialchars($link_text); ?>
                <i data-lucide="arrow-right" class="tw-w-3.5 tw-h-3.5"></i>
            </a>
        <?php endif; ?>
    </div>
    <?php
}
