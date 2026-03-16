<?php
/**
 * Empty State Component
 * 
 * @param string $title       — Main title
 * @param string $description — Description text
 * @param string $icon        — Lucide icon name
 * @param string $cta_text    — Call to action button text
 * @param string $cta_link    — Call to action URL
 * @param string $type        — Type: 'empty', 'search', 'error', 'locker', 'pickup', 'consolidation', 'onboarding'
 */
function render_empty_state($params = []) {
    $title       = $params['title'] ?? 'Aucun résultat';
    $description = $params['description'] ?? '';
    $icon        = $params['icon'] ?? 'inbox';
    $cta_text    = $params['cta_text'] ?? '';
    $cta_link    = $params['cta_link'] ?? '';
    $type        = $params['type'] ?? 'empty';

    $svg_illustrations = [
        'empty' => '<svg class="tw-w-40 tw-h-40 tw-mx-auto tw-mb-4" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="100" cy="100" r="80" fill="#EFF6FF" stroke="#BFDBFE" stroke-width="2"/>
            <rect x="60" y="65" width="80" height="70" rx="8" fill="white" stroke="#93C5FD" stroke-width="2"/>
            <path d="M60 85h80" stroke="#DBEAFE" stroke-width="2"/>
            <rect x="70" y="95" width="40" height="4" rx="2" fill="#BFDBFE"/>
            <rect x="70" y="105" width="55" height="4" rx="2" fill="#DBEAFE"/>
            <rect x="70" y="115" width="30" height="4" rx="2" fill="#DBEAFE"/>
            <circle cx="130" cy="75" r="4" fill="#93C5FD"/>
        </svg>',

        'search' => '<svg class="tw-w-40 tw-h-40 tw-mx-auto tw-mb-4" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="100" cy="100" r="80" fill="#F5F3FF" stroke="#DDD6FE" stroke-width="2"/>
            <circle cx="90" cy="90" r="30" stroke="#A78BFA" stroke-width="3" fill="white"/>
            <line x1="112" y1="112" x2="135" y2="135" stroke="#A78BFA" stroke-width="3" stroke-linecap="round"/>
            <path d="M80 85h20" stroke="#DDD6FE" stroke-width="2" stroke-linecap="round"/>
            <path d="M85 95h10" stroke="#DDD6FE" stroke-width="2" stroke-linecap="round"/>
        </svg>',

        'error' => '<svg class="tw-w-40 tw-h-40 tw-mx-auto tw-mb-4" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="100" cy="100" r="80" fill="#FEF2F2" stroke="#FECACA" stroke-width="2"/>
            <path d="M70 80c0-16.569 13.431-30 30-30s30 13.431 30 30v20H70V80z" fill="white" stroke="#FCA5A5" stroke-width="2"/>
            <rect x="60" y="95" width="80" height="50" rx="8" fill="white" stroke="#FCA5A5" stroke-width="2"/>
            <path d="M95 115v10" stroke="#EF4444" stroke-width="3" stroke-linecap="round"/>
            <circle cx="95" cy="130" r="2" fill="#EF4444"/>
            <path d="M115 60l15-15" stroke="#FECACA" stroke-width="2" stroke-linecap="round"/>
            <path d="M125 75l15-5" stroke="#FECACA" stroke-width="2" stroke-linecap="round"/>
        </svg>',

        'locker' => '<svg class="tw-w-40 tw-h-40 tw-mx-auto tw-mb-4" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="100" cy="100" r="80" fill="#EFF6FF" stroke="#BFDBFE" stroke-width="2"/>
            <rect x="55" y="55" width="90" height="95" rx="8" fill="white" stroke="#93C5FD" stroke-width="2"/>
            <rect x="65" y="68" width="35" height="30" rx="4" fill="#DBEAFE" stroke="#93C5FD" stroke-width="1.5"/>
            <rect x="105" y="68" width="35" height="30" rx="4" fill="#DBEAFE" stroke="#93C5FD" stroke-width="1.5"/>
            <rect x="65" y="108" width="35" height="30" rx="4" fill="#EFF6FF" stroke="#BFDBFE" stroke-width="1.5" stroke-dasharray="4 2"/>
            <rect x="105" y="108" width="35" height="30" rx="4" fill="#EFF6FF" stroke="#BFDBFE" stroke-width="1.5" stroke-dasharray="4 2"/>
            <rect x="78" y="78" width="10" height="10" rx="2" fill="#3B82F6"/>
            <rect x="118" y="78" width="10" height="10" rx="2" fill="#3B82F6"/>
        </svg>',

        'pickup' => '<svg class="tw-w-40 tw-h-40 tw-mx-auto tw-mb-4" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="100" cy="100" r="80" fill="#ECFEFF" stroke="#A5F3FC" stroke-width="2"/>
            <rect x="55" y="75" width="60" height="50" rx="6" fill="white" stroke="#22D3EE" stroke-width="2"/>
            <rect x="115" y="85" width="35" height="40" rx="4" fill="white" stroke="#22D3EE" stroke-width="2"/>
            <circle cx="75" cy="130" r="8" fill="white" stroke="#22D3EE" stroke-width="2"/>
            <circle cx="130" cy="130" r="8" fill="white" stroke="#22D3EE" stroke-width="2"/>
            <circle cx="75" cy="130" r="3" fill="#22D3EE"/>
            <circle cx="130" cy="130" r="3" fill="#22D3EE"/>
            <path d="M100 60l10-20" stroke="#A5F3FC" stroke-width="2" stroke-linecap="round"/>
            <path d="M110 65l15-10" stroke="#A5F3FC" stroke-width="2" stroke-linecap="round"/>
            <path d="M90 65l-15-10" stroke="#A5F3FC" stroke-width="2" stroke-linecap="round"/>
        </svg>',

        'consolidation' => '<svg class="tw-w-40 tw-h-40 tw-mx-auto tw-mb-4" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="100" cy="100" r="80" fill="#FFF7ED" stroke="#FED7AA" stroke-width="2"/>
            <rect x="60" y="60" width="80" height="80" rx="8" fill="white" stroke="#FB923C" stroke-width="2"/>
            <rect x="72" y="72" width="22" height="22" rx="3" fill="#FED7AA"/>
            <rect x="100" y="72" width="22" height="22" rx="3" fill="#FFEDD5"/>
            <rect x="72" y="100" width="22" height="22" rx="3" fill="#FFEDD5"/>
            <rect x="100" y="100" width="22" height="22" rx="3" fill="#FFF7ED" stroke="#FED7AA" stroke-width="1" stroke-dasharray="4 2"/>
            <path d="M140 85h15" stroke="#FED7AA" stroke-width="2" stroke-linecap="round"/>
            <path d="M140 95h10" stroke="#FFEDD5" stroke-width="2" stroke-linecap="round"/>
        </svg>',

        'onboarding' => '<svg class="tw-w-40 tw-h-40 tw-mx-auto tw-mb-4" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="100" cy="100" r="80" fill="#F0FDF4" stroke="#BBF7D0" stroke-width="2"/>
            <path d="M60 110l30-40 25 20 25-30" stroke="#22C55E" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="60" cy="110" r="5" fill="#22C55E"/>
            <circle cx="90" cy="70" r="5" fill="#22C55E"/>
            <circle cx="115" cy="90" r="5" fill="#22C55E"/>
            <circle cx="140" cy="60" r="5" fill="#22C55E"/>
            <rect x="55" y="125" width="90" height="4" rx="2" fill="#DCFCE7"/>
            <rect x="65" y="135" width="70" height="4" rx="2" fill="#F0FDF4"/>
        </svg>',
    ];

    $svg = $svg_illustrations[$type] ?? $svg_illustrations['empty'];
    ?>
    <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-py-12 tw-px-6 tw-text-center animate-fade-slide-up">
        <?php echo $svg; ?>
        <h3 class="tw-text-lg tw-font-semibold tw-text-gray-700 tw-mb-1"><?php echo htmlspecialchars($title); ?></h3>
        <?php if ($description): ?>
            <p class="tw-text-sm tw-text-gray-500 tw-max-w-sm tw-mb-4"><?php echo htmlspecialchars($description); ?></p>
        <?php endif; ?>
        <?php if ($cta_text && $cta_link): ?>
            <a href="<?php echo htmlspecialchars($cta_link); ?>" 
               class="tw-inline-flex tw-items-center tw-gap-2 tw-px-4 tw-py-2 tw-bg-blue-600 tw-text-white tw-text-sm tw-font-medium tw-rounded-lg hover:tw-bg-blue-700 tw-transition-colors tw-shadow-sm">
                <i data-lucide="plus" class="tw-w-4 tw-h-4"></i>
                <?php echo htmlspecialchars($cta_text); ?>
            </a>
        <?php endif; ?>
    </div>
    <?php
}
