<?php
/**
 * Two-Panel Sidebar — shadcn-inspired, Tailwind tw- prefix + Alpine.js
 * Uses ONLY tw- utility classes and <div> elements to avoid Bootstrap interference.
 */

// Greeting logic
date_default_timezone_set("" . $core->timezone . "");
$t = date("H");
if ($t < 12) {
    $mensaje = $lang['message1'];
} elseif ($t < 18) {
    $mensaje = $lang['message2'];
} else {
    $mensaje = $lang['message3'];
}

$avatar = ($userData->avatar) ? $userData->avatar : "uploads/blank.png";
$current_page = basename($_SERVER['PHP_SELF']);

// Role detection
$is_admin    = ($userData->userlevel == 9);
$is_employee = ($userData->userlevel == 2);
$is_client   = ($userData->userlevel == 1);
$is_driver   = ($userData->userlevel == 3);
$is_staff    = ($is_admin || $is_employee);

$role_labels = [9 => 'Admin', 2 => 'Employé', 1 => 'Client', 3 => 'Chauffeur'];
$role_label  = $role_labels[$userData->userlevel] ?? 'Utilisateur';

// ── Helper functions (shadcn style, all tw- classes, no <button>) ──

function panel_group_start($icon, $label, $default_open = false) {
    $open = $default_open ? 'true' : 'false';
    echo '<div x-data="{ open: ' . $open . ' }" class="tw-mb-0.5">';
    echo '<div @click="open = !open" role="button" tabindex="0" class="tw-flex tw-items-center tw-gap-2 tw-w-full tw-px-3 tw-py-2 tw-rounded-md tw-text-[13px] tw-font-medium tw-text-gray-300 tw-cursor-pointer tw-select-none tw-transition-colors hover:tw-bg-white/[0.06] hover:tw-text-white">';
    echo '<i data-lucide="' . htmlspecialchars($icon) . '" class="tw-w-4 tw-h-4 tw-shrink-0 tw-text-gray-500"></i>';
    echo '<span class="tw-flex-1 tw-truncate">' . $label . '</span>';
    echo '<svg class="tw-w-3.5 tw-h-3.5 tw-shrink-0 tw-text-gray-500 tw-transition-transform tw-duration-200" :class="open && \'tw-rotate-180\'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>';
    echo '</div>';
    echo '<div x-show="open" x-collapse x-cloak class="tw-ml-4 tw-pl-3 tw-border-l tw-border-white/[0.08] tw-mt-0.5 tw-mb-1">';
}

function panel_group_end() {
    echo '</div></div>';
}

function panel_item($href, $label, $current_page) {
    $active = (basename($href) === $current_page);
    $base = 'tw-flex tw-items-center tw-gap-2 tw-px-2.5 tw-py-1.5 tw-rounded-md tw-text-[13px] tw-transition-colors tw-no-underline';
    if ($active) {
        $cls = $base . ' tw-text-teal-400 tw-font-medium tw-bg-teal-500/10';
    } else {
        $cls = $base . ' tw-text-gray-400 hover:tw-text-gray-200 hover:tw-bg-white/[0.04]';
    }
    echo '<a href="' . htmlspecialchars($href) . '" class="' . $cls . '">';
    if ($active) {
        echo '<span class="tw-w-1.5 tw-h-1.5 tw-rounded-full tw-bg-teal-400 tw-shrink-0"></span>';
    } else {
        echo '<span class="tw-w-1 tw-h-1 tw-rounded-full tw-bg-gray-600 tw-shrink-0"></span>';
    }
    echo '<span class="tw-truncate">' . htmlspecialchars($label) . '</span>';
    echo '</a>';
}

function panel_subgroup_start($icon, $label) {
    echo '<div x-data="{ subOpen: false }" class="tw-mt-0.5">';
    echo '<div @click="subOpen = !subOpen" role="button" tabindex="0" class="tw-flex tw-items-center tw-gap-2 tw-w-full tw-px-2.5 tw-py-1.5 tw-rounded-md tw-text-[12px] tw-font-medium tw-text-gray-400 tw-cursor-pointer tw-select-none tw-transition-colors hover:tw-bg-white/[0.04] hover:tw-text-gray-200">';
    echo '<i data-lucide="' . htmlspecialchars($icon) . '" class="tw-w-3.5 tw-h-3.5 tw-shrink-0 tw-text-gray-500"></i>';
    echo '<span class="tw-flex-1 tw-truncate">' . $label . '</span>';
    echo '<svg class="tw-w-3 tw-h-3 tw-shrink-0 tw-text-gray-600 tw-transition-transform tw-duration-200" :class="subOpen && \'tw-rotate-180\'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>';
    echo '</div>';
    echo '<div x-show="subOpen" x-collapse x-cloak class="tw-ml-3 tw-pl-2.5 tw-border-l tw-border-white/[0.06] tw-mt-0.5">';
}

function panel_subgroup_end() {
    echo '</div></div>';
}
?>

<!-- ============================================================== -->
<!-- Two-Panel Sidebar (shadcn-inspired, pure tw- classes) -->
<!-- ============================================================== -->
<div id="sidebar-two-panel"
     x-data="{
         panelOpen: localStorage.getItem('sidebarPanel') !== 'false',
         toggle() {
             this.panelOpen = !this.panelOpen;
             localStorage.setItem('sidebarPanel', this.panelOpen);
             document.getElementById('main-wrapper').classList.toggle('sidebar-collapsed', !this.panelOpen);
         },
         init() {
             if (!this.panelOpen) {
                 document.getElementById('main-wrapper').classList.add('sidebar-collapsed');
             }
         }
     }"
     @toggle-sidebar-panel.window="toggle()"
     class="sidebar-two-panel"
     style="position:fixed;top:0;left:0;bottom:0;display:flex;z-index:100;font-family:Inter,system-ui,-apple-system,sans-serif;">

    <!-- ===== RAIL ===== -->
    <div style="width:72px;background:#06101d;display:flex;flex-direction:column;align-items:center;flex-shrink:0;padding-top:16px;z-index:2;border-right:1px solid rgba(255,255,255,0.06);">

        <!-- Logo -->
        <div class="tw-mb-6 tw-px-2">
            <a href="index.php" title="<?php echo htmlspecialchars($core->site_name); ?>" class="tw-no-underline">
                <?php if ($core->logo): ?>
                    <img src="assets/<?php echo $core->logo; ?>" alt="<?php echo $core->site_name; ?>" class="tw-h-8 tw-w-8 tw-object-contain">
                <?php else: ?>
                    <div class="tw-w-10 tw-h-10 tw-rounded-xl tw-flex tw-items-center tw-justify-center tw-text-white tw-font-bold tw-text-lg" style="background:#0d9488;">
                        <?php echo strtoupper(substr($core->site_name, 0, 1)); ?>
                    </div>
                <?php endif; ?>
            </a>
        </div>

        <!-- Top rail icons -->
        <div class="tw-flex tw-flex-col tw-items-center tw-gap-1 tw-flex-1">
            <?php
            $rail_cls       = 'tw-flex tw-flex-col tw-items-center tw-justify-center tw-gap-1 tw-w-14 tw-py-2 tw-px-1 tw-rounded-xl tw-no-underline tw-transition-colors tw-cursor-pointer tw-border-0';
            $rail_default   = $rail_cls . ' tw-text-gray-500 hover:tw-text-white hover:tw-bg-white/[0.08]';
            $rail_active    = $rail_cls . ' tw-text-teal-400 tw-bg-teal-500/10';
            $rail_icon_cls  = 'tw-w-5 tw-h-5 tw-shrink-0';
            $rail_label_cls = 'tw-text-[10px] tw-font-medium tw-leading-none tw-whitespace-nowrap';
            ?>
            <a href="index.php" class="<?php echo ($current_page === 'index.php') ? $rail_active : $rail_default; ?>" title="<?php echo $lang['left-menu-sidebar-2']; ?>">
                <i data-lucide="home" class="<?php echo $rail_icon_cls; ?>"></i>
                <span class="<?php echo $rail_label_cls; ?>"><?php echo $lang['left-menu-sidebar-2'] ?? 'Home'; ?></span>
            </a>

            <div class="<?php echo $rail_default; ?>" onclick="document.querySelector('#sidebar-two-panel').dispatchEvent(new CustomEvent('toggle-notif'));" title="Notifications" style="position:relative;">
                <i data-lucide="bell" class="<?php echo $rail_icon_cls; ?>"></i>
                <span class="<?php echo $rail_label_cls; ?>">Notifs</span>
                <span id="railNotifBadge" class="tw-absolute tw-top-1 tw-right-1.5 tw-min-w-[16px] tw-h-4 tw-flex tw-items-center tw-justify-center tw-text-[9px] tw-font-bold tw-text-white tw-rounded-full tw-px-1 tw-leading-none" style="background:#14b8a6;display:none;">0</span>
            </div>

            <?php if ($is_staff): ?>
            <a href="courier_add.php" class="<?php echo $rail_default; ?>" title="<?php echo $lang['left-menu-sidebar-1']; ?>">
                <i data-lucide="plus-circle" class="<?php echo $rail_icon_cls; ?>"></i>
                <span class="<?php echo $rail_label_cls; ?>"><?php echo $lang['left-menu-sidebar-1'] ?? 'Nouveau'; ?></span>
            </a>
            <?php elseif ($is_client): ?>
            <a href="pickup_add.php" class="<?php echo $rail_default; ?>" title="Pickup">
                <i data-lucide="send" class="<?php echo $rail_icon_cls; ?>"></i>
                <span class="<?php echo $rail_label_cls; ?>">Pickup</span>
            </a>
            <?php endif; ?>
        </div>

        <!-- Bottom rail icons -->
        <div class="tw-flex tw-flex-col tw-items-center tw-gap-1 tw-pb-4">
            <?php if ($is_admin): ?>
            <a href="tools.php" class="<?php echo ($current_page === 'tools.php') ? $rail_active : $rail_default; ?>" title="<?php echo $lang['left-menu-sidebar-38'] ?? 'Settings'; ?>">
                <i data-lucide="settings" class="<?php echo $rail_icon_cls; ?>"></i>
                <span class="<?php echo $rail_label_cls; ?>">Settings</span>
            </a>
            <?php endif; ?>

            <a href="verify_update.php" class="<?php echo $rail_default; ?>" title="<?php echo $lang['left-menu-sidebar-61'] ?? 'Help'; ?>">
                <i data-lucide="help-circle" class="<?php echo $rail_icon_cls; ?>"></i>
                <span class="<?php echo $rail_label_cls; ?>">Help</span>
            </a>

            <a href="logout.php" class="<?php echo $rail_default; ?>" title="<?php echo $lang['logoouts'] ?? 'Sign Out'; ?>">
                <i data-lucide="log-out" class="<?php echo $rail_icon_cls; ?>"></i>
                <span class="<?php echo $rail_label_cls; ?>"><?php echo $lang['logoouts'] ?? 'Exit'; ?></span>
            </a>
        </div>
    </div>

    <!-- ===== PANEL ===== -->
    <div x-show="panelOpen"
         x-transition:enter="tw-transition tw-ease-out tw-duration-200"
         x-transition:enter-start="tw--translate-x-full tw-opacity-0"
         x-transition:enter-end="tw-translate-x-0 tw-opacity-100"
         x-transition:leave="tw-transition tw-ease-in tw-duration-150"
         x-transition:leave-start="tw-translate-x-0 tw-opacity-100"
         x-transition:leave-end="tw--translate-x-full tw-opacity-0"
         style="width:248px;background:linear-gradient(180deg,#0f1d2f 0%,#0a1628 100%);display:flex;flex-direction:column;overflow:hidden;flex-shrink:0;border-right:1px solid rgba(255,255,255,0.06);">

        <!-- Panel header with collapse toggle -->
        <div class="tw-flex tw-items-center tw-justify-between tw-px-4 tw-pt-4 tw-pb-2 tw-shrink-0">
            <span class="tw-text-[11px] tw-font-semibold tw-uppercase tw-tracking-widest tw-text-gray-500">Menu</span>
            <div @click="toggle()" role="button" class="tw-w-7 tw-h-7 tw-rounded-md tw-flex tw-items-center tw-justify-center tw-cursor-pointer tw-transition-colors tw-text-gray-400 hover:tw-text-white hover:tw-bg-white/[0.08]" title="Réduire le menu">
                <i data-lucide="panel-left-close" class="tw-w-4 tw-h-4"></i>
            </div>
        </div>

        <!-- Search bar -->
        <div class="tw-px-3 tw-pb-3 tw-shrink-0">
            <div class="tw-relative">
                <i data-lucide="search" class="tw-absolute tw-left-2.5 tw-top-1/2 tw--translate-y-1/2 tw-w-3.5 tw-h-3.5 tw-text-gray-500"></i>
                <input type="text" placeholder="<?php echo $lang['search'] ?? 'Rechercher...'; ?>"
                       class="tw-w-full tw-py-2 tw-pl-8 tw-pr-16 tw-rounded-lg tw-text-[13px] tw-text-white tw-border tw-outline-none tw-transition-colors"
                       style="background:rgba(255,255,255,0.04);border-color:rgba(255,255,255,0.08);"
                       onfocus="this.style.borderColor='rgba(20,184,166,0.4)';this.style.background='rgba(255,255,255,0.07)'"
                       onblur="this.style.borderColor='rgba(255,255,255,0.08)';this.style.background='rgba(255,255,255,0.04)'">
                <div class="tw-absolute tw-right-2 tw-top-1/2 tw--translate-y-1/2 tw-flex tw-gap-0.5">
                    <kbd class="tw-inline-flex tw-items-center tw-justify-center tw-min-w-[20px] tw-h-[18px] tw-px-1 tw-text-[10px] tw-rounded tw-leading-none" style="color:#6b7280;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.1);">Ctrl</kbd>
                    <kbd class="tw-inline-flex tw-items-center tw-justify-center tw-min-w-[20px] tw-h-[18px] tw-px-1 tw-text-[10px] tw-rounded tw-leading-none" style="color:#6b7280;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.1);">K</kbd>
                </div>
            </div>
        </div>

        <!-- Navigation scroll area -->
        <div class="tw-flex-1 tw-overflow-y-auto tw-px-2 tw-pb-2" style="scrollbar-width:thin;scrollbar-color:rgba(255,255,255,0.1) transparent;">

            <?php if ($is_admin): // =================== ADMIN =================== ?>

                <!-- Operations -->
                <?php panel_group_start('layout-grid', $lang['left-menu-sidebar-2'] ?? 'Operations', true); ?>
                    <?php panel_item('index.php', $lang['left-menu-sidebar-2'], $current_page); ?>
                    <?php panel_item('reports.php', $lang['left-menu-sidebar-26'], $current_page); ?>
                <?php panel_group_end(); ?>

                <!-- Packages clients -->
                <?php panel_group_start('shopping-cart', $lang['left-menu-sidebar-5']); ?>
                    <?php panel_item('dashboard_admin_packages_customers.php', $lang['left-menu-sidebar-6'], $current_page); ?>
                    <?php panel_item('prealert_list.php', $lang['left-menu-sidebar-7'], $current_page); ?>
                    <?php panel_item('customer_packages_add.php', $lang['left-menu-sidebar-8'], $current_page); ?>
                    <?php panel_item('customer_packages_multiple.php', $lang['left-menu-sidebar-9'], $current_page); ?>
                    <?php panel_item('customer_packages_list.php', $lang['left-menu-sidebar-11'], $current_page); ?>
                    <?php panel_item('payments_gateways_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                <?php panel_group_end(); ?>

                <!-- Shipments -->
                <?php panel_group_start('package', $lang['left-menu-sidebar-13']); ?>
                    <?php panel_item('dashboard_admin_shipments.php', $lang['left-menu-sidebar-14'], $current_page); ?>
                    <?php panel_item('courier_add.php', $lang['left-menu-sidebar-15'], $current_page); ?>
                    <?php panel_item('courier_add_multiple.php', $lang['left-menu-sidebar-17'], $current_page); ?>
                    <?php panel_item('courier_list.php', $lang['left-menu-sidebar-16'], $current_page); ?>
                    <?php panel_item('payments_gateways_courier_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                <?php panel_group_end(); ?>

                <!-- Pickup -->
                <?php panel_group_start('truck', $lang['left-menu-sidebar-18']); ?>
                    <?php panel_item('dashboard_admin_pickup.php', $lang['left-menu-sidebar-19'], $current_page); ?>
                    <?php panel_item('pickup_add_full.php', $lang['left-menu-sidebar-20'], $current_page); ?>
                    <?php panel_item('pickup_list.php', $lang['left-menu-sidebar-21'], $current_page); ?>
                <?php panel_group_end(); ?>

                <!-- Consolidation -->
                <?php panel_group_start('layers', $lang['left-menu-sidebar-22']); ?>
                    <?php panel_subgroup_start('boxes', $lang['left-menu-sidebar-2233333310']); ?>
                        <?php panel_item('dashboard_admin_consolidated.php', $lang['left-menu-sidebar-23'], $current_page); ?>
                        <?php panel_item('consolidate_list.php', $lang['left-menu-sidebar-24'], $current_page); ?>
                        <?php panel_item('consolidate_add.php', $lang['left-menu-sidebar-25'], $current_page); ?>
                        <?php panel_item('payments_gateways_consolidate_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                    <?php panel_subgroup_end(); ?>
                    <?php panel_subgroup_start('package', $lang['left-menu-sidebar-2233333312']); ?>
                        <?php panel_item('dashboard_admin_package_consolidated.php', $lang['left-menu-sidebar-23'], $current_page); ?>
                        <?php panel_item('consolidate_package_list.php', $lang['left-menu-sidebar-24'], $current_page); ?>
                        <?php panel_item('consolidate_package_add.php', $lang['left-menu-sidebar-25'], $current_page); ?>
                        <?php panel_item('payments_gateways_package_consolidate_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                    <?php panel_subgroup_end(); ?>
                <?php panel_group_end(); ?>

                <!-- Finance -->
                <?php panel_group_start('wallet', $lang['left-menu-sidebar-27']); ?>
                    <?php panel_item('dashboard_admin_account.php', $lang['left-menu-sidebar-28'], $current_page); ?>
                    <?php panel_item('accounts_receivable.php', $lang['left-menu-sidebar-29'], $current_page); ?>
                    <?php panel_item('global_payments_gateways.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                <?php panel_group_end(); ?>

                <!-- Customers -->
                <?php panel_group_start('users', $lang['left-menu-sidebar-30']); ?>
                    <?php panel_item('customers_list.php', $lang['left-menu-sidebar-31'], $current_page); ?>
                    <?php panel_item('recipients_admin_list.php', $lang['left-menu-sidebar-62'], $current_page); ?>
                <?php panel_group_end(); ?>

                <!-- Users -->
                <?php panel_group_start('user-cog', $lang['left-menu-sidebar-33']); ?>
                    <?php panel_item('users_list.php', $lang['left-menu-sidebar-34'], $current_page); ?>
                    <?php panel_item('users_add.php', $lang['left-menu-sidebar-35'], $current_page); ?>
                <?php panel_group_end(); ?>

                <!-- Configuration section label -->
                <div class="tw-px-3 tw-pt-5 tw-pb-1">
                    <p class="tw-text-[10px] tw-font-semibold tw-text-gray-500 tw-uppercase tw-tracking-wider"><?php echo $lang['left-menu-sidebar-37']; ?></p>
                </div>

                <?php panel_group_start('settings', $lang['left-menu-sidebar-38']); ?>
                    <?php panel_item('tools.php', $lang['left-menu-sidebar-39'], $current_page); ?>

                    <?php panel_subgroup_start('package', $lang['left-menu-sidebar-42']); ?>
                        <?php panel_item('offices_list.php', $lang['left-menu-sidebar-43'], $current_page); ?>
                        <?php panel_item('branchoffices_list.php', $lang['left-menu-sidebar-44'], $current_page); ?>
                        <?php panel_item('courier_company_list.php', $lang['left-menu-sidebar-45'], $current_page); ?>
                        <?php panel_item('packaging_list.php', $lang['left-menu-sidebar-54'], $current_page); ?>
                        <?php panel_item('shipping_mode_list.php', $lang['left-menu-sidebar-55'], $current_page); ?>
                        <?php panel_item('delivery_time_list.php', $lang['left-menu-sidebar-56'], $current_page); ?>
                        <?php panel_item('status_courier_list.php', $lang['left-menu-sidebar-46'], $current_page); ?>
                        <?php panel_item('category_list.php', $lang['left-menu-sidebar-47'], $current_page); ?>
                    <?php panel_subgroup_end(); ?>

                    <?php panel_subgroup_start('truck', $lang['left-menu-sidebar-48']); ?>
                        <?php panel_item('taxesadnfees.php', $lang['left-menu-sidebar-49'], $current_page); ?>
                        <?php panel_item('shipping_tariffs_list.php', $lang['left-menu-sidebar-53'], $current_page); ?>
                        <?php panel_item('track_invoice.php', $lang['left-menu-sidebar-50'], $current_page); ?>
                        <?php panel_item('info_ship_default.php', $lang['left-menu-sidebar-51'], $current_page); ?>
                    <?php panel_subgroup_end(); ?>

                    <?php panel_subgroup_start('credit-card', $lang['left-menu-sidebar-40']); ?>
                        <?php panel_item('payment_mode_list.php', $lang['left-menu-sidebar-40'], $current_page); ?>
                        <?php panel_item('payment_methods_list.php', $lang['left-menu-sidebar-41'], $current_page); ?>
                        <?php panel_item('agency_payment_coordinates_list.php', 'Coordonnées paiement (agences)', $current_page); ?>
                    <?php panel_subgroup_end(); ?>

                    <?php panel_subgroup_start('map-pin', $lang['left-menu-sidebar-57']); ?>
                        <?php panel_item('countries_list.php', $lang['left-menu-sidebar-58'], $current_page); ?>
                        <?php panel_item('states_list.php', $lang['left-menu-sidebar-59'], $current_page); ?>
                        <?php panel_item('cities_list.php', $lang['left-menu-sidebar-60'], $current_page); ?>
                    <?php panel_subgroup_end(); ?>
                <?php panel_group_end(); ?>

            <?php elseif ($is_employee): // =================== EMPLOYEE =================== ?>

                <?php panel_group_start('layout-grid', $lang['left-menu-sidebar-2'] ?? 'Operations', true); ?>
                    <?php panel_item('index.php', $lang['left-menu-sidebar-2'], $current_page); ?>
                    <?php panel_item('reports.php', $lang['left-menu-sidebar-26'], $current_page); ?>
                <?php panel_group_end(); ?>

                <?php panel_group_start('shopping-cart', $lang['left-menu-sidebar-5']); ?>
                    <?php panel_item('dashboard_admin_packages_customers.php', $lang['left-menu-sidebar-6'], $current_page); ?>
                    <?php panel_item('prealert_list.php', $lang['left-menu-sidebar-7'], $current_page); ?>
                    <?php panel_item('customer_packages_add.php', $lang['left-menu-sidebar-8'], $current_page); ?>
                    <?php panel_item('customer_packages_multiple.php', $lang['left-menu-sidebar-9'], $current_page); ?>
                    <?php panel_item('customer_packages_list.php', $lang['left-menu-sidebar-11'], $current_page); ?>
                    <?php panel_item('payments_gateways_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                <?php panel_group_end(); ?>

                <?php panel_group_start('package', $lang['left-menu-sidebar-13']); ?>
                    <?php panel_item('dashboard_admin_shipments.php', $lang['left-menu-sidebar-14'], $current_page); ?>
                    <?php panel_item('courier_add.php', $lang['left-menu-sidebar-15'], $current_page); ?>
                    <?php panel_item('courier_add_multiple.php', $lang['left-menu-sidebar-17'], $current_page); ?>
                    <?php panel_item('courier_list.php', $lang['left-menu-sidebar-16'], $current_page); ?>
                    <?php panel_item('payments_gateways_courier_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                <?php panel_group_end(); ?>

                <?php panel_group_start('truck', $lang['left-menu-sidebar-18']); ?>
                    <?php panel_item('dashboard_admin_pickup.php', $lang['left-menu-sidebar-19'], $current_page); ?>
                    <?php panel_item('pickup_add.php', $lang['left-menu-sidebar-20'], $current_page); ?>
                    <?php panel_item('pickup_list.php', $lang['left-menu-sidebar-21'], $current_page); ?>
                <?php panel_group_end(); ?>

                <?php panel_group_start('layers', $lang['left-menu-sidebar-22']); ?>
                    <?php panel_subgroup_start('boxes', $lang['left-menu-sidebar-2233333310']); ?>
                        <?php panel_item('dashboard_admin_consolidated.php', $lang['left-menu-sidebar-23'], $current_page); ?>
                        <?php panel_item('consolidate_list.php', $lang['left-menu-sidebar-24'], $current_page); ?>
                        <?php panel_item('consolidate_add.php', $lang['left-menu-sidebar-25'], $current_page); ?>
                        <?php panel_item('payments_gateways_consolidate_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                    <?php panel_subgroup_end(); ?>
                    <?php panel_subgroup_start('package', $lang['left-menu-sidebar-2233333312']); ?>
                        <?php panel_item('dashboard_admin_package_consolidated.php', $lang['left-menu-sidebar-23'], $current_page); ?>
                        <?php panel_item('consolidate_package_list.php', $lang['left-menu-sidebar-24'], $current_page); ?>
                        <?php panel_item('consolidate_package_add.php', $lang['left-menu-sidebar-25'], $current_page); ?>
                        <?php panel_item('payments_gateways_package_consolidate_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                    <?php panel_subgroup_end(); ?>
                <?php panel_group_end(); ?>

                <?php panel_group_start('wallet', $lang['left-menu-sidebar-27']); ?>
                    <?php panel_item('dashboard_admin_account.php', $lang['left-menu-sidebar-28'], $current_page); ?>
                    <?php panel_item('accounts_receivable.php', $lang['left-menu-sidebar-29'], $current_page); ?>
                    <?php panel_item('global_payments_gateways.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                <?php panel_group_end(); ?>

                <?php panel_group_start('users', $lang['left-menu-sidebar-30']); ?>
                    <?php panel_item('customers_list.php', $lang['left-menu-sidebar-31'], $current_page); ?>
                <?php panel_group_end(); ?>

            <?php elseif ($is_client): // =================== CLIENT =================== ?>

                <?php panel_group_start('layout-grid', $lang['left-menu-sidebar-2'] ?? 'Mon espace', true); ?>
                    <?php panel_item('index.php', $lang['left-menu-sidebar-2'], $current_page); ?>
                <?php panel_group_end(); ?>

                <?php panel_group_start('shopping-cart', $lang['left-menu-sidebar-5']); ?>
                    <?php panel_item('prealert_add.php', $lang['left-menu-sidebar-10'], $current_page); ?>
                    <?php panel_item('prealert_list.php', $lang['left-menu-sidebar-7'], $current_page); ?>
                    <?php panel_item('customer_packages_list.php', $lang['left-menu-sidebar-11'], $current_page); ?>
                    <?php panel_item('payments_gateways_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                <?php panel_group_end(); ?>

                <?php panel_group_start('package', $lang['left-menu-sidebar-13']); ?>
                    <?php panel_item('courier_add_client.php', $lang['left-menu-sidebar-15'], $current_page); ?>
                    <?php panel_item('courier_list.php', $lang['left-menu-sidebar-16'], $current_page); ?>
                    <?php panel_item('payments_gateways_courier_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                <?php panel_group_end(); ?>

                <?php panel_group_start('truck', $lang['left-menu-sidebar-18']); ?>
                    <?php panel_item('pickup_add.php', $lang['left-menu-sidebar-20'], $current_page); ?>
                    <?php panel_item('pickup_list.php', $lang['left-menu-sidebar-21'], $current_page); ?>
                <?php panel_group_end(); ?>

                <?php panel_group_start('layers', $lang['left-menu-sidebar-22']); ?>
                    <?php panel_subgroup_start('boxes', $lang['left-menu-sidebar-2233333310']); ?>
                        <?php panel_item('consolidate_list.php', $lang['left-menu-sidebar-24'], $current_page); ?>
                        <?php panel_item('payments_gateways_consolidate_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                    <?php panel_subgroup_end(); ?>
                    <?php panel_subgroup_start('package', $lang['left-menu-sidebar-2233333312']); ?>
                        <?php panel_item('consolidate_package_list.php', $lang['left-menu-sidebar-24'], $current_page); ?>
                        <?php panel_item('payments_gateways_package_consolidate_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                    <?php panel_subgroup_end(); ?>
                <?php panel_group_end(); ?>

                <?php panel_group_start('user', $lang['left-menu-sidebar-63'] ?? 'Mon compte'); ?>
                    <?php panel_item('recipients_list.php', $lang['left-menu-sidebar-62'], $current_page); ?>
                    <?php panel_item('customers_profile_edit.php?user=' . $userData->id, $lang['left-menu-sidebar-63'] ?? 'Mon profil', $current_page); ?>
                <?php panel_group_end(); ?>

            <?php elseif ($is_driver): // =================== DRIVER =================== ?>

                <?php panel_group_start('layout-grid', $lang['left-menu-sidebar-2'] ?? 'Mon espace', true); ?>
                    <?php panel_item('index.php', $lang['left-menu-sidebar-2'], $current_page); ?>
                    <?php panel_item('reports.php', $lang['left-menu-sidebar-26'], $current_page); ?>
                <?php panel_group_end(); ?>

                <?php panel_group_start('shopping-cart', $lang['left-menu-sidebar-5']); ?>
                    <?php panel_item('customer_packages_list.php', $lang['left-menu-sidebar-11'], $current_page); ?>
                <?php panel_group_end(); ?>

                <?php panel_group_start('package', $lang['left-menu-sidebar-13']); ?>
                    <?php panel_item('courier_add.php', $lang['left-menu-sidebar-15'], $current_page); ?>
                    <?php panel_item('courier_list.php', $lang['left-menu-sidebar-16'], $current_page); ?>
                <?php panel_group_end(); ?>

                <?php panel_group_start('truck', $lang['left-menu-sidebar-18']); ?>
                    <?php panel_item('pickup_add_full.php', $lang['left-menu-sidebar-20'], $current_page); ?>
                    <?php panel_item('pickup_list.php', $lang['left-menu-sidebar-21'], $current_page); ?>
                <?php panel_group_end(); ?>

                <?php panel_group_start('layers', $lang['left-menu-sidebar-22']); ?>
                    <?php panel_subgroup_start('boxes', $lang['left-menu-sidebar-2233333310']); ?>
                        <?php panel_item('consolidate_list.php', $lang['left-menu-sidebar-24'], $current_page); ?>
                    <?php panel_subgroup_end(); ?>
                    <?php panel_subgroup_start('package', $lang['left-menu-sidebar-2233333312']); ?>
                        <?php panel_item('consolidate_package_list.php', $lang['left-menu-sidebar-24'], $current_page); ?>
                    <?php panel_subgroup_end(); ?>
                <?php panel_group_end(); ?>

                <?php panel_group_start('user', $lang['leftorder195'] ?? 'Mon profil'); ?>
                    <?php panel_item('drivers_edit.php?user=' . $userData->id, $lang['leftorder195'] ?? 'Mon profil', $current_page); ?>
                <?php panel_group_end(); ?>

            <?php endif; ?>

        </div>

        <!-- Panel footer: User info -->
        <div class="tw-px-3 tw-py-3 tw-shrink-0" style="border-top:1px solid rgba(255,255,255,0.06);">
            <div class="tw-flex tw-items-center tw-gap-3">
                <img src="assets/<?php echo $avatar; ?>" class="tw-w-8 tw-h-8 tw-rounded-full tw-object-cover tw-shrink-0" style="border:2px solid rgba(255,255,255,0.15);" alt="">
                <div class="tw-min-w-0 tw-flex-1">
                    <p class="tw-text-[13px] tw-font-medium tw-text-white tw-truncate tw-leading-tight tw-m-0"><?php echo htmlspecialchars($userData->fname); ?></p>
                    <p class="tw-text-[10px] tw-text-gray-500 tw-truncate tw-leading-tight tw-m-0"><?php echo $role_label; ?><?php if (!empty($userData->name_off)): ?> — <?php echo htmlspecialchars($userData->name_off); ?><?php endif; ?></p>
                </div>
            </div>
        </div>

    </div>

    <!-- Expand button (visible when panel is collapsed) -->
    <div x-show="!panelOpen" x-cloak
         @click="toggle()"
         role="button"
         class="tw-fixed tw-flex tw-items-center tw-justify-center tw-w-7 tw-h-7 tw-rounded-md tw-cursor-pointer tw-transition-colors tw-text-white tw-z-[101]"
         style="top:16px;left:80px;background:#14b8a6;"
         title="Ouvrir le menu">
        <i data-lucide="panel-left-open" class="tw-w-4 tw-h-4"></i>
    </div>

</div>

<script>
// Initialize Lucide icons in sidebar (works on both old and new layout pages)
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
