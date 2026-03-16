<?php
/**
 * Locker Visual Component — Virtual mailbox for clients
 * 
 * @param array $params
 *   - locker_id: string — Locker reference (e.g. MRP-XXXX)
 *   - packages: array — List of packages in locker [{id, tracking, status, label}]
 *   - address: array — Hub address {name, street, city, country}
 *   - stats: array — {total, waiting, ready}
 */
function render_locker_visual($params = []) {
    $locker_id = $params['locker_id'] ?? '';
    $packages  = $params['packages'] ?? [];
    $address   = $params['address'] ?? [];
    $stats     = $params['stats'] ?? ['total' => 0, 'waiting' => 0, 'ready' => 0];

    $max_slots = max(4, count($packages));
    // Fill empty slots
    while (count($packages) < $max_slots) {
        $packages[] = ['id' => null, 'tracking' => '', 'status' => 'empty', 'label' => ''];
    }

    $slot_styles = [
        'received'  => 'tw-bg-green-50 tw-border-green-200 tw-text-green-700',
        'waiting'   => 'tw-bg-amber-50 tw-border-amber-200 tw-text-amber-700',
        'transit'   => 'tw-bg-blue-50 tw-border-blue-200 tw-text-blue-700',
        'empty'     => 'tw-bg-gray-50 tw-border-dashed tw-border-gray-200 tw-text-gray-300',
    ];

    $slot_icons = [
        'received'  => 'package-check',
        'waiting'   => 'clock',
        'transit'   => 'navigation',
        'empty'     => 'minus',
    ];
    ?>
    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-blue-100 tw-overflow-hidden animate-fade-slide-up" x-data="{ copied: false }">
        <!-- Header -->
        <div class="tw-bg-gradient-to-r tw-from-blue-600 tw-to-blue-700 tw-px-5 tw-py-3">
            <div class="tw-flex tw-items-center tw-gap-2">
                <i data-lucide="box" class="tw-w-5 tw-h-5 tw-text-blue-200"></i>
                <h3 class="tw-text-sm tw-font-semibold tw-text-white tw-uppercase tw-tracking-wider">Mon Casier Virtuel</h3>
            </div>
        </div>

        <div class="tw-p-5">
            <!-- Compartments grid -->
            <div class="tw-grid tw-grid-cols-4 tw-gap-2 tw-mb-4">
                <?php foreach (array_slice($packages, 0, 8) as $i => $pkg):
                    $st = $pkg['status'] ?? 'empty';
                    $cls = $slot_styles[$st] ?? $slot_styles['empty'];
                    $ico = $slot_icons[$st] ?? 'minus';
                ?>
                    <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-p-2.5 tw-rounded-lg tw-border tw-transition-all tw-duration-300 <?php echo $cls; ?> <?php echo ($st !== 'empty' && isset($pkg['is_new']) && $pkg['is_new']) ? 'animate-glow-new' : ''; ?>"
                         <?php if ($pkg['id']): ?>title="<?php echo htmlspecialchars($pkg['tracking']); ?>"<?php endif; ?>>
                        <i data-lucide="<?php echo $ico; ?>" class="tw-w-5 tw-h-5 tw-mb-1"></i>
                        <span class="tw-text-[10px] tw-font-medium">#<?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></span>
                        <?php if ($st === 'received'): ?>
                            <i data-lucide="check-circle" class="tw-w-3 tw-h-3 tw-mt-0.5 tw-text-green-500"></i>
                        <?php elseif ($st === 'waiting'): ?>
                            <i data-lucide="clock" class="tw-w-3 tw-h-3 tw-mt-0.5 tw-text-amber-500"></i>
                        <?php elseif ($st === 'transit'): ?>
                            <i data-lucide="navigation" class="tw-w-3 tw-h-3 tw-mt-0.5 tw-text-blue-500"></i>
                        <?php else: ?>
                            <span class="tw-text-[10px] tw-text-gray-300">—</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Address block -->
            <?php if (!empty($address)): ?>
            <div class="tw-bg-gray-50 tw-rounded-lg tw-p-3 tw-mb-3">
                <p class="tw-text-xs tw-font-medium tw-text-gray-500 tw-mb-1.5">Adresse de livraison :</p>
                <div class="tw-text-sm tw-text-gray-700 tw-leading-relaxed" id="locker-address">
                    <?php if (!empty($address['name'])): ?>
                        <p class="tw-font-semibold"><?php echo htmlspecialchars($address['name']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($address['street'])): ?>
                        <p><?php echo htmlspecialchars($address['street']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($address['city']) || !empty($address['country'])): ?>
                        <p><?php echo htmlspecialchars(trim(($address['city'] ?? '') . ', ' . ($address['country'] ?? ''), ', ')); ?></p>
                    <?php endif; ?>
                    <?php if ($locker_id): ?>
                        <p class="tw-font-medium tw-text-blue-600">Ref: <?php echo htmlspecialchars($locker_id); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Action buttons -->
            <div class="tw-flex tw-gap-2 tw-mb-3">
                <button @click="
                    const addr = document.getElementById('locker-address');
                    if (addr) { navigator.clipboard.writeText(addr.innerText); copied = true; setTimeout(() => copied = false, 2000); }
                " class="tw-flex-1 tw-flex tw-items-center tw-justify-center tw-gap-1.5 tw-px-3 tw-py-2 tw-text-xs tw-font-medium tw-rounded-lg tw-border tw-border-gray-200 tw-text-gray-700 hover:tw-bg-gray-50 tw-transition-colors">
                    <i data-lucide="clipboard-copy" class="tw-w-3.5 tw-h-3.5"></i>
                    <span x-text="copied ? 'Copié !' : 'Copier l\'adresse'"></span>
                </button>
                <a href="prealert_add.php" class="tw-flex-1 tw-flex tw-items-center tw-justify-center tw-gap-1.5 tw-px-3 tw-py-2 tw-text-xs tw-font-medium tw-rounded-lg tw-bg-blue-600 tw-text-white hover:tw-bg-blue-700 tw-transition-colors">
                    <i data-lucide="package-plus" class="tw-w-3.5 tw-h-3.5"></i>
                    Pré-alerter
                </a>
            </div>

            <!-- Stats footer -->
            <div class="tw-flex tw-items-center tw-gap-1 tw-text-xs tw-text-gray-500">
                <span class="tw-font-medium tw-text-gray-700"><?php echo intval($stats['total']); ?></span> colis en attente
                <span class="tw-mx-1">·</span>
                <span class="tw-font-medium tw-text-green-600"><?php echo intval($stats['ready']); ?></span> prêts à expédier
            </div>
        </div>
    </div>
    <?php
}
