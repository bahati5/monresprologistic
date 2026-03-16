<?php
/**
 * Filter Chips Component — Colored filter chips with counters
 * 
 * @param array $params
 *   - filters: array — [{id, label, count, color, active}]
 *   - name: string — Alpine.js x-model variable name
 *   - allow_multiple: bool — Allow multiple active filters
 *   - on_change: string — JS callback on filter change
 */
function render_filter_chips($params = []) {
    $filters        = $params['filters'] ?? [];
    $name           = $params['name'] ?? 'activeFilter';
    $allow_multiple = $params['allow_multiple'] ?? false;
    $on_change      = $params['on_change'] ?? '';
    $chip_id        = 'chips-' . uniqid();

    $color_map = [
        'blue'   => ['active' => 'tw-bg-blue-600 tw-text-white tw-border-blue-600', 'inactive' => 'tw-bg-white tw-text-blue-700 tw-border-blue-200 hover:tw-bg-blue-50'],
        'green'  => ['active' => 'tw-bg-green-600 tw-text-white tw-border-green-600', 'inactive' => 'tw-bg-white tw-text-green-700 tw-border-green-200 hover:tw-bg-green-50'],
        'amber'  => ['active' => 'tw-bg-amber-500 tw-text-white tw-border-amber-500', 'inactive' => 'tw-bg-white tw-text-amber-700 tw-border-amber-200 hover:tw-bg-amber-50'],
        'red'    => ['active' => 'tw-bg-red-600 tw-text-white tw-border-red-600', 'inactive' => 'tw-bg-white tw-text-red-700 tw-border-red-200 hover:tw-bg-red-50'],
        'cyan'   => ['active' => 'tw-bg-cyan-600 tw-text-white tw-border-cyan-600', 'inactive' => 'tw-bg-white tw-text-cyan-700 tw-border-cyan-200 hover:tw-bg-cyan-50'],
        'violet' => ['active' => 'tw-bg-violet-600 tw-text-white tw-border-violet-600', 'inactive' => 'tw-bg-white tw-text-violet-700 tw-border-violet-200 hover:tw-bg-violet-50'],
        'gray'   => ['active' => 'tw-bg-gray-700 tw-text-white tw-border-gray-700', 'inactive' => 'tw-bg-white tw-text-gray-700 tw-border-gray-200 hover:tw-bg-gray-50'],
    ];
    ?>
    <div class="tw-flex tw-flex-wrap tw-gap-2" 
         x-data="{ 
            <?php echo $name; ?>: <?php echo $allow_multiple ? '[]' : "'all'"; ?>,
            toggle(id) {
                <?php if ($allow_multiple): ?>
                    if (this.<?php echo $name; ?>.includes(id)) {
                        this.<?php echo $name; ?> = this.<?php echo $name; ?>.filter(f => f !== id);
                    } else {
                        this.<?php echo $name; ?>.push(id);
                    }
                <?php else: ?>
                    this.<?php echo $name; ?> = id;
                <?php endif; ?>
                <?php if ($on_change): ?><?php echo $on_change; ?><?php endif; ?>
            },
            isActive(id) {
                <?php if ($allow_multiple): ?>
                    return this.<?php echo $name; ?>.includes(id);
                <?php else: ?>
                    return this.<?php echo $name; ?> === id;
                <?php endif; ?>
            }
         }">
        
        <!-- "All" chip -->
        <button @click="toggle('all')"
                class="tw-inline-flex tw-items-center tw-gap-1.5 tw-px-3 tw-py-1.5 tw-rounded-full tw-text-xs tw-font-medium tw-border tw-transition-all tw-duration-200 tw-cursor-pointer"
                :class="isActive('all') ? 'tw-bg-gray-700 tw-text-white tw-border-gray-700' : 'tw-bg-white tw-text-gray-700 tw-border-gray-200 hover:tw-bg-gray-50'">
            Tous
            <?php 
            $total = 0;
            foreach ($filters as $f) $total += intval($f['count'] ?? 0);
            ?>
            <span class="tw-px-1.5 tw-py-0.5 tw-rounded-full tw-text-[10px] tw-font-bold"
                  :class="isActive('all') ? 'tw-bg-white/20' : 'tw-bg-gray-100'"><?php echo $total; ?></span>
        </button>

        <?php foreach ($filters as $filter):
            $fid    = $filter['id'] ?? '';
            $flabel = $filter['label'] ?? '';
            $fcount = intval($filter['count'] ?? 0);
            $fcolor = $filter['color'] ?? 'gray';
            $cm     = $color_map[$fcolor] ?? $color_map['gray'];
        ?>
            <button @click="toggle('<?php echo htmlspecialchars($fid); ?>')"
                    class="tw-inline-flex tw-items-center tw-gap-1.5 tw-px-3 tw-py-1.5 tw-rounded-full tw-text-xs tw-font-medium tw-border tw-transition-all tw-duration-200 tw-cursor-pointer"
                    :class="isActive('<?php echo htmlspecialchars($fid); ?>') ? '<?php echo $cm['active']; ?>' : '<?php echo $cm['inactive']; ?>'">
                <?php echo htmlspecialchars($flabel); ?>
                <span class="tw-px-1.5 tw-py-0.5 tw-rounded-full tw-text-[10px] tw-font-bold"
                      :class="isActive('<?php echo htmlspecialchars($fid); ?>') ? 'tw-bg-white/20' : 'tw-bg-gray-100'"><?php echo $fcount; ?></span>
            </button>
        <?php endforeach; ?>
    </div>
    <?php
}
