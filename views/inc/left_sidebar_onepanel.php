<?php
/**
 * Single-Panel Sidebar — shadcn-inspired, Tailwind tw- prefix + Alpine.js
 * Clean one-panel navigation with collapsible groups.
 * All styling via tw- classes + inline styles to bypass Bootstrap.
 */

date_default_timezone_set("" . $core->timezone . "");
$t = date("H");
if ($t < 12) { $mensaje = $lang['message1']; }
elseif ($t < 18) { $mensaje = $lang['message2']; }
else { $mensaje = $lang['message3']; }

$avatar = ($userData->avatar) ? $userData->avatar : "uploads/blank.png";
$current_page = basename($_SERVER['PHP_SELF']);

$is_admin    = ($userData->userlevel == 9);
$is_employee = ($userData->userlevel == 2);
$is_client   = ($userData->userlevel == 1);
$is_driver   = ($userData->userlevel == 3);
$is_staff    = ($is_admin || $is_employee);

$role_labels = [9 => 'Admin', 2 => 'Employé', 1 => 'Client', 3 => 'Chauffeur'];
$role_label  = $role_labels[$userData->userlevel] ?? 'Utilisateur';

// ── Helper functions ──
function sb_group_start($icon, $label, $default_open = false) {
    $open = $default_open ? 'true' : 'false';
    echo '<div x-data="{ open: ' . $open . ' }" class="tw-mb-0.5">';
    echo '<div @click="open = !open" role="button" tabindex="0" class="sb-nav-group-btn tw-flex tw-items-center tw-gap-2.5 tw-w-full tw-px-3 tw-py-[7px] tw-rounded-lg tw-text-[13px] tw-font-medium tw-cursor-pointer tw-select-none tw-transition-all tw-duration-150 tw-no-underline" style="color:#cbd5e1;background:transparent;" onmouseover="this.style.background=\'rgba(255,255,255,0.06)\';this.style.color=\'#f1f5f9\'" onmouseout="if(!this.parentElement.__x){this.style.background=\'transparent\';this.style.color=\'#cbd5e1\'}">';
    echo '<i data-lucide="' . htmlspecialchars($icon) . '" style="width:18px;height:18px;flex-shrink:0;color:#64748b;"></i>';
    echo '<span class="tw-flex-1 tw-truncate sb-hide-collapsed">' . $label . '</span>';
    echo '<svg class="tw-w-4 tw-h-4 tw-shrink-0 tw-transition-transform tw-duration-200 sb-hide-collapsed" :class="open && \'tw-rotate-180\'" style="color:#475569;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>';
    echo '</div>';
    echo '<div x-show="open" x-collapse x-cloak class="tw-mt-0.5 tw-mb-1 sb-hide-collapsed">';
}

function sb_group_end() {
    echo '</div></div>';
}

function sb_item($href, $icon, $label, $current_page) {
    $active = (basename($href) === $current_page);
    $bg = $active ? 'background:rgba(26,127,181,0.12);' : 'background:transparent;';
    $color = $active ? 'color:#5bb8e0;' : 'color:#94a3b8;';
    $weight = $active ? 'font-weight:500;' : '';
    $dot_bg = $active ? 'background:#5bb8e0;width:6px;height:6px;' : 'background:#475569;width:4px;height:4px;';
    echo '<a href="' . htmlspecialchars($href) . '" class="tw-flex tw-items-center tw-gap-2.5 tw-pl-10 tw-pr-3 tw-py-[6px] tw-rounded-lg tw-text-[13px] tw-no-underline tw-transition-all tw-duration-150" style="' . $bg . $color . $weight . '" onmouseover="if(!' . ($active ? 'true' : 'false') . '){this.style.background=\'rgba(255,255,255,0.04)\';this.style.color=\'#e2e8f0\'}" onmouseout="if(!' . ($active ? 'true' : 'false') . '){this.style.background=\'transparent\';this.style.color=\'#94a3b8\'}">';
    echo '<span class="tw-rounded-full tw-shrink-0" style="' . $dot_bg . '"></span>';
    echo '<span class="tw-truncate">' . htmlspecialchars($label) . '</span>';
    echo '</a>';
}

function sb_link($href, $icon, $label, $current_page) {
    $active = (basename($href) === $current_page);
    $bg = $active ? 'background:rgba(26,127,181,0.12);' : 'background:transparent;';
    $color = $active ? 'color:#5bb8e0;' : 'color:#cbd5e1;';
    $icon_color = $active ? 'color:#5bb8e0;' : 'color:#64748b;';
    echo '<a href="' . htmlspecialchars($href) . '" class="sb-rail-item tw-flex tw-items-center tw-gap-2.5 tw-px-3 tw-py-[7px] tw-rounded-lg tw-text-[13px] tw-font-medium tw-no-underline tw-transition-all tw-duration-150" style="' . $bg . $color . '" onmouseover="this.style.background=\'rgba(255,255,255,0.06)\';this.style.color=\'#f1f5f9\'" onmouseout="this.style.background=\'' . ($active ? 'rgba(26,127,181,0.12)' : 'transparent') . '\';this.style.color=\'' . ($active ? '#5bb8e0' : '#cbd5e1') . '\'">';
    echo '<i data-lucide="' . htmlspecialchars($icon) . '" style="width:18px;height:18px;flex-shrink:0;' . $icon_color . '"></i>';
    echo '<span class="tw-truncate sb-hide-collapsed">' . htmlspecialchars($label) . '</span>';
    echo '</a>';
}

function sb_sub_start($icon, $label) {
    echo '<div x-data="{ sub: false }" class="tw-mb-0.5">';
    echo '<div @click="sub = !sub" role="button" tabindex="0" class="tw-flex tw-items-center tw-gap-2 tw-pl-10 tw-pr-3 tw-py-[6px] tw-rounded-lg tw-text-[12px] tw-font-medium tw-cursor-pointer tw-select-none tw-transition-all tw-duration-150 tw-no-underline" style="color:#94a3b8;background:transparent;" onmouseover="this.style.background=\'rgba(255,255,255,0.04)\';this.style.color=\'#e2e8f0\'" onmouseout="this.style.background=\'transparent\';this.style.color=\'#94a3b8\'">';
    echo '<i data-lucide="' . htmlspecialchars($icon) . '" style="width:14px;height:14px;flex-shrink:0;color:#475569;"></i>';
    echo '<span class="tw-flex-1 tw-truncate">' . $label . '</span>';
    echo '<svg class="tw-w-3 tw-h-3 tw-shrink-0 tw-transition-transform tw-duration-200" :class="sub && \'tw-rotate-180\'" style="color:#475569;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>';
    echo '</div>';
    echo '<div x-show="sub" x-collapse x-cloak class="tw-ml-10 tw-pl-3 tw-mt-0.5" style="border-left:1px solid rgba(255,255,255,0.06);">';
}

function sb_sub_end() {
    echo '</div></div>';
}

function sb_sub_item($href, $label, $current_page) {
    $active = (basename($href) === $current_page);
    $color = $active ? 'color:#5bb8e0;font-weight:500;' : 'color:#64748b;';
    echo '<a href="' . htmlspecialchars($href) . '" class="tw-flex tw-items-center tw-gap-2 tw-px-2 tw-py-[5px] tw-rounded-md tw-text-[12px] tw-no-underline tw-transition-all tw-duration-150" style="' . $color . '" onmouseover="this.style.color=\'#e2e8f0\'" onmouseout="this.style.color=\'' . ($active ? '#5bb8e0' : '#64748b') . '\'">';
    echo '<span class="tw-w-1 tw-h-1 tw-rounded-full tw-shrink-0" style="background:' . ($active ? '#5bb8e0' : '#475569') . ';"></span>';
    echo '<span class="tw-truncate">' . htmlspecialchars($label) . '</span>';
    echo '</a>';
}
?>

<!-- Bulletproof sidebar styles — cannot be overridden by any template CSS -->
<style>
#app-sidebar {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    bottom: 0 !important;
    width: 260px !important;
    display: flex !important;
    flex-direction: column !important;
    z-index: 9999 !important;
    background: linear-gradient(180deg, #0d1421 0%, #0b1120 100%) !important;
    border-right: none !important;
    font-family: Inter, system-ui, -apple-system, sans-serif !important;
    transition: width 0.25s cubic-bezier(0.4,0,0.2,1) !important;
    overflow: hidden !important;
    color: #e2e8f0 !important;
    padding: 0 !important;
    margin: 0 !important;
    box-shadow: 2px 0 12px rgba(0,0,0,0.15) !important;
    visibility: visible !important;
    opacity: 1 !important;
}
#app-sidebar.sb-collapsed {
    width: 72px !important;
    min-width: 72px !important;
}
/* CRITICAL: Hide text labels when collapsed */
#app-sidebar.sb-collapsed .sb-hide-collapsed {
    display: none !important;
}
/* Show collapsed-only elements */
#app-sidebar.sb-collapsed .sb-show-collapsed {
    display: flex !important;
}
/* Force icons to be visible in collapsed state */
#app-sidebar.sb-collapsed i[data-lucide],
#app-sidebar.sb-collapsed svg {
    display: block !important;
    opacity: 1 !important;
    visibility: visible !important;
}
/* Center nav group buttons as icon-only pills */
#app-sidebar.sb-collapsed .sb-nav-group-btn {
    justify-content: center !important;
    padding: 0 !important;
    width: 48px !important;
    height: 42px !important;
    margin: 2px auto !important;
    border-radius: 10px !important;
}
/* Center footer items */
#app-sidebar.sb-collapsed .sb-rail-item {
    justify-content: center !important;
    padding: 0 !important;
    width: 48px !important;
    height: 42px !important;
    margin: 2px auto !important;
    border-radius: 10px !important;
}
/* Center nav and footer sections */
#app-sidebar.sb-collapsed nav {
    padding: 8px 12px !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
}
#app-sidebar.sb-collapsed .sb-footer-section {
    padding: 4px 12px !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
}
/* Logo area centered */
#app-sidebar.sb-collapsed .sb-logo-area {
    justify-content: center !important;
    padding: 16px 0 !important;
}
#app-sidebar.sb-collapsed .sb-logo-area > a {
    justify-content: center !important;
}
/* User card: avatar only, centered */
#app-sidebar.sb-collapsed .sb-user-card {
    justify-content: center !important;
    padding: 8px 0 !important;
}
/* Icon sizing */
#app-sidebar.sb-collapsed .sb-nav-group-btn i[data-lucide],
#app-sidebar.sb-collapsed .sb-rail-item i[data-lucide] {
    width: 20px !important;
    height: 20px !important;
    color: #94a3b8 !important;
}
#app-sidebar.sb-collapsed .sb-nav-group-btn:hover,
#app-sidebar.sb-collapsed .sb-rail-item:hover {
    background: rgba(255,255,255,0.08) !important;
}
#app-sidebar.sb-collapsed .sb-nav-group-btn:hover i[data-lucide],
#app-sidebar.sb-collapsed .sb-rail-item:hover i[data-lucide] {
    color: #f1f5f9 !important;
}
/* Notification/user dropdowns position to right of rail */
#app-sidebar.sb-collapsed .sb-notif-dropdown {
    left: 72px !important;
    right: auto !important;
    bottom: 0 !important;
    width: 320px;
}
#app-sidebar.sb-collapsed .sb-user-dropdown {
    left: 72px !important;
    right: auto !important;
    bottom: 0 !important;
    width: 200px;
}
#app-sidebar * {
    box-sizing: border-box;
}
</style>

<!-- ===== Single-Panel Sidebar ===== -->
<div id="app-sidebar" data-turbo-permanent
    x-data="{
        collapsed: localStorage.getItem('sidebarCollapsed') === 'true',
        toggle() {
            this.collapsed = !this.collapsed;
            localStorage.setItem('sidebarCollapsed', this.collapsed);
            document.getElementById('main-wrapper').classList.toggle('sidebar-collapsed', this.collapsed);
            document.getElementById('app-sidebar').classList.toggle('sb-collapsed', this.collapsed);
            // Recreate Lucide icons after state change
            setTimeout(() => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }, 50);
        },
        init() {
            // Force visible state on init
            this.$el.style.setProperty('display', 'flex', 'important');
            this.$el.style.setProperty('visibility', 'visible', 'important');
            this.$el.style.setProperty('opacity', '1', 'important');
            this.$el.style.setProperty('background-color', '#0b1120', 'important');
            
            if (this.collapsed) {
                document.getElementById('main-wrapper').classList.add('sidebar-collapsed');
                this.$el.classList.add('sb-collapsed');
            }
        }
    }"
    @toggle-sidebar.window="toggle()">

    <!-- Logo + collapse toggle -->
    <div class="sb-logo-area tw-flex tw-items-center tw-justify-between tw-px-4 tw-py-4 tw-shrink-0" style="border-bottom:1px solid rgba(255,255,255,0.06);">
        <a href="index.php" class="tw-flex tw-items-center tw-gap-2.5 tw-no-underline tw-min-w-0">
            <?php if ($core->logo): ?>
                <img src="assets/<?php echo $core->logo; ?>" alt="<?php echo $core->site_name; ?>" class="sb-hide-collapsed tw-h-8 tw-w-auto tw-object-contain tw-shrink-0 tw-rounded-lg" style="max-width:160px;">
                <div class="sb-show-collapsed tw-w-8 tw-h-8 tw-rounded-lg tw-flex tw-items-center tw-justify-center tw-text-white tw-font-bold tw-text-sm tw-shrink-0" style="background:linear-gradient(135deg,#1a7fb5,#5bb8e0);display:none;">
                    <?php echo strtoupper(substr($core->site_name, 0, 1)); ?>
                </div>
            <?php else: ?>
                <div class="tw-w-8 tw-h-8 tw-rounded-lg tw-flex tw-items-center tw-justify-center tw-text-white tw-font-bold tw-text-sm tw-shrink-0" style="background:linear-gradient(135deg,#1a7fb5,#5bb8e0);">
                    <?php echo strtoupper(substr($core->site_name, 0, 1)); ?>
                </div>
                <span class="tw-text-[15px] tw-font-bold tw-truncate sb-hide-collapsed" style="color:#5bb8e0;letter-spacing:-0.02em;">mon<span style="color:#ffffff;">res</span>pro</span>
            <?php endif; ?>
        </a>
        <div @click="toggle()" role="button" class="sb-hide-collapsed tw-w-7 tw-h-7 tw-rounded-md tw-flex tw-items-center tw-justify-center tw-cursor-pointer tw-transition-colors tw-shrink-0" style="color:#64748b;" onmouseover="this.style.background='rgba(255,255,255,0.08)';this.style.color='#f1f5f9'" onmouseout="this.style.background='transparent';this.style.color='#64748b'" title="Réduire">
            <i data-lucide="panel-left-close" class="tw-w-4 tw-h-4"></i>
        </div>
        <!-- Expand toggle (visible only when collapsed) -->
        <div @click="toggle()" role="button" class="sb-show-collapsed tw-w-8 tw-h-8 tw-rounded-md tw-items-center tw-justify-center tw-cursor-pointer tw-transition-colors tw-shrink-0" style="color:#64748b;display:none;" onmouseover="this.style.background='rgba(255,255,255,0.08)';this.style.color='#f1f5f9'" onmouseout="this.style.background='transparent';this.style.color='#64748b'" title="Ouvrir le menu">
            <i data-lucide="panel-left-open" class="tw-w-4 tw-h-4"></i>
        </div>
    </div>

    <!-- Search bar (hidden when collapsed) -->
    <div class="sb-hide-collapsed tw-px-3 tw-py-3 tw-shrink-0">
        <div class="tw-relative">
            <i data-lucide="search" class="tw-absolute tw-left-2.5 tw-top-1/2 tw--translate-y-1/2 tw-w-3.5 tw-h-3.5" style="color:#475569;"></i>
            <input type="text" placeholder="<?php echo $lang['search'] ?? 'Rechercher...'; ?>"
                   class="tw-w-full tw-py-2 tw-pl-8 tw-pr-16 tw-rounded-lg tw-text-[13px] tw-outline-none tw-transition-colors"
                   style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:#e2e8f0;"
                   onfocus="this.style.borderColor='rgba(26,127,181,0.5)';this.style.background='rgba(255,255,255,0.07)'"
                   onblur="this.style.borderColor='rgba(255,255,255,0.08)';this.style.background='rgba(255,255,255,0.04)'">
            <div class="tw-absolute tw-right-2 tw-top-1/2 tw--translate-y-1/2 tw-flex tw-gap-0.5">
                <kbd class="tw-inline-flex tw-items-center tw-justify-center tw-min-w-[20px] tw-h-[18px] tw-px-1 tw-text-[10px] tw-rounded tw-leading-none" style="color:#475569;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.08);">Ctrl</kbd>
                <kbd class="tw-inline-flex tw-items-center tw-justify-center tw-min-w-[20px] tw-h-[18px] tw-px-1 tw-text-[10px] tw-rounded tw-leading-none" style="color:#475569;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.08);">K</kbd>
            </div>
        </div>
    </div>
    <!-- Search icon only when collapsed -->
    <div class="sb-show-collapsed tw-flex tw-justify-center tw-py-2 tw-shrink-0" style="display:none;">
        <div class="tw-w-10 tw-h-10 tw-rounded-lg tw-flex tw-items-center tw-justify-center tw-cursor-pointer tw-transition-colors" style="color:#64748b;" onmouseover="this.style.background='rgba(255,255,255,0.06)';this.style.color='#f1f5f9'" onmouseout="this.style.background='transparent';this.style.color='#64748b'">
            <i data-lucide="search" class="tw-w-[18px] tw-h-[18px]"></i>
        </div>
    </div>

    <!-- MENU label -->
    <div class="sb-hide-collapsed tw-px-4 tw-pt-1 tw-pb-1.5">
        <span class="tw-text-[10px] tw-font-semibold tw-uppercase tw-tracking-[0.08em]" style="color:#475569;">Menu</span>
    </div>

    <!-- Navigation -->
    <nav class="tw-flex-1 tw-overflow-y-auto tw-px-2 tw-pb-2" style="scrollbar-width:thin;scrollbar-color:rgba(255,255,255,0.08) transparent;">

        <?php if ($is_admin): // =================== ADMIN =================== ?>

            <?php sb_group_start('layout-grid', $lang['left-menu-sidebar-2'] ?? 'Panneau de commande', true); ?>
                <?php sb_item('index.php', 'home', $lang['left-menu-sidebar-2'], $current_page); ?>
                <?php sb_item('reports.php', 'bar-chart-3', $lang['left-menu-sidebar-26'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('shopping-cart', $lang['left-menu-sidebar-5']); ?>
                <?php sb_item('dashboard_admin_packages_customers.php', 'box', $lang['left-menu-sidebar-6'], $current_page); ?>
                <?php sb_item('prealert_list.php', 'alert-circle', $lang['left-menu-sidebar-7'], $current_page); ?>
                <?php sb_item('customer_packages_add.php', 'plus', $lang['left-menu-sidebar-8'], $current_page); ?>
                <?php sb_item('customer_packages_multiple.php', 'copy', $lang['left-menu-sidebar-9'], $current_page); ?>
                <?php sb_item('customer_packages_list.php', 'list', $lang['left-menu-sidebar-11'], $current_page); ?>
                <?php sb_item('payments_gateways_list.php', 'credit-card', $lang['left-menu-sidebar-12'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('package', $lang['left-menu-sidebar-13']); ?>
                <?php sb_item('dashboard_admin_shipments.php', 'activity', $lang['left-menu-sidebar-14'], $current_page); ?>
                <?php sb_item('courier_add.php', 'plus', $lang['left-menu-sidebar-15'], $current_page); ?>
                <?php sb_item('courier_add_multiple.php', 'copy', $lang['left-menu-sidebar-17'], $current_page); ?>
                <?php sb_item('courier_list.php', 'list', $lang['left-menu-sidebar-16'], $current_page); ?>
                <?php sb_item('payments_gateways_courier_list.php', 'credit-card', $lang['left-menu-sidebar-12'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('truck', $lang['left-menu-sidebar-18']); ?>
                <?php sb_item('dashboard_admin_pickup.php', 'activity', $lang['left-menu-sidebar-19'], $current_page); ?>
                <?php sb_item('pickup_add_full.php', 'plus', $lang['left-menu-sidebar-20'], $current_page); ?>
                <?php sb_item('pickup_list.php', 'list', $lang['left-menu-sidebar-21'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('layers', $lang['left-menu-sidebar-22']); ?>
                <?php sb_sub_start('boxes', $lang['left-menu-sidebar-2233333310']); ?>
                    <?php sb_sub_item('dashboard_admin_consolidated.php', $lang['left-menu-sidebar-23'], $current_page); ?>
                    <?php sb_sub_item('consolidate_list.php', $lang['left-menu-sidebar-24'], $current_page); ?>
                    <?php sb_sub_item('consolidate_add.php', $lang['left-menu-sidebar-25'], $current_page); ?>
                    <?php sb_sub_item('payments_gateways_consolidate_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                <?php sb_sub_end(); ?>
                <?php sb_sub_start('package', $lang['left-menu-sidebar-2233333312']); ?>
                    <?php sb_sub_item('dashboard_admin_package_consolidated.php', $lang['left-menu-sidebar-23'], $current_page); ?>
                    <?php sb_sub_item('consolidate_package_list.php', $lang['left-menu-sidebar-24'], $current_page); ?>
                    <?php sb_sub_item('consolidate_package_add.php', $lang['left-menu-sidebar-25'], $current_page); ?>
                    <?php sb_sub_item('payments_gateways_package_consolidate_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                <?php sb_sub_end(); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('wallet', $lang['left-menu-sidebar-27']); ?>
                <?php sb_item('dashboard_admin_account.php', 'bar-chart', $lang['left-menu-sidebar-28'], $current_page); ?>
                <?php sb_item('accounts_receivable.php', 'receipt', $lang['left-menu-sidebar-29'], $current_page); ?>
                <?php sb_item('global_payments_gateways.php', 'credit-card', $lang['left-menu-sidebar-12'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('users', $lang['left-menu-sidebar-30']); ?>
                <?php sb_item('customers_list.php', 'contact', $lang['left-menu-sidebar-31'], $current_page); ?>
                <?php sb_item('recipients_admin_list.php', 'user-check', $lang['left-menu-sidebar-62'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('user-cog', $lang['left-menu-sidebar-33']); ?>
                <?php sb_item('users_list.php', 'list', $lang['left-menu-sidebar-34'], $current_page); ?>
                <?php sb_item('users_add.php', 'user-plus', $lang['left-menu-sidebar-35'], $current_page); ?>
            <?php sb_group_end(); ?>

            <!-- PARAMÈTRES section -->
            <div class="sb-hide-collapsed tw-px-2 tw-pt-4 tw-pb-1.5">
                <span class="tw-text-[10px] tw-font-semibold tw-uppercase tw-tracking-[0.08em]" style="color:#475569;"><?php echo $lang['left-menu-sidebar-37'] ?? 'Paramètres'; ?></span>
            </div>

            <?php sb_group_start('settings', $lang['left-menu-sidebar-38']); ?>
                <?php sb_item('tools.php', 'sliders', $lang['left-menu-sidebar-39'], $current_page); ?>

                <?php sb_sub_start('package', $lang['left-menu-sidebar-42']); ?>
                    <?php sb_sub_item('offices_list.php', $lang['left-menu-sidebar-43'], $current_page); ?>
                    <?php sb_sub_item('branchoffices_list.php', $lang['left-menu-sidebar-44'], $current_page); ?>
                    <?php sb_sub_item('courier_company_list.php', $lang['left-menu-sidebar-45'], $current_page); ?>
                    <?php sb_sub_item('packaging_list.php', $lang['left-menu-sidebar-54'], $current_page); ?>
                    <?php sb_sub_item('shipping_mode_list.php', $lang['left-menu-sidebar-55'], $current_page); ?>
                    <?php sb_sub_item('delivery_time_list.php', $lang['left-menu-sidebar-56'], $current_page); ?>
                    <?php sb_sub_item('status_courier_list.php', $lang['left-menu-sidebar-46'], $current_page); ?>
                    <?php sb_sub_item('category_list.php', $lang['left-menu-sidebar-47'], $current_page); ?>
                <?php sb_sub_end(); ?>

                <?php sb_sub_start('truck', $lang['left-menu-sidebar-48']); ?>
                    <?php sb_sub_item('taxesadnfees.php', $lang['left-menu-sidebar-49'], $current_page); ?>
                    <?php sb_sub_item('shipping_tariffs_list.php', $lang['left-menu-sidebar-53'], $current_page); ?>
                    <?php sb_sub_item('track_invoice.php', $lang['left-menu-sidebar-50'], $current_page); ?>
                    <?php sb_sub_item('info_ship_default.php', $lang['left-menu-sidebar-51'], $current_page); ?>
                <?php sb_sub_end(); ?>

                <?php sb_sub_start('credit-card', $lang['left-menu-sidebar-40']); ?>
                    <?php sb_sub_item('payment_mode_list.php', $lang['left-menu-sidebar-40'], $current_page); ?>
                    <?php sb_sub_item('payment_methods_list.php', $lang['left-menu-sidebar-41'], $current_page); ?>
                    <?php sb_sub_item('agency_payment_coordinates_list.php', 'Coordonnées paiement (agences)', $current_page); ?>
                <?php sb_sub_end(); ?>

                <?php sb_sub_start('map-pin', $lang['left-menu-sidebar-57']); ?>
                    <?php sb_sub_item('countries_list.php', $lang['left-menu-sidebar-58'], $current_page); ?>
                    <?php sb_sub_item('states_list.php', $lang['left-menu-sidebar-59'], $current_page); ?>
                    <?php sb_sub_item('cities_list.php', $lang['left-menu-sidebar-60'], $current_page); ?>
                <?php sb_sub_end(); ?>
            <?php sb_group_end(); ?>

        <?php elseif ($is_employee): // =================== EMPLOYEE =================== ?>

            <?php sb_group_start('layout-grid', $lang['left-menu-sidebar-2'] ?? 'Panneau de commande', true); ?>
                <?php sb_item('index.php', 'home', $lang['left-menu-sidebar-2'], $current_page); ?>
                <?php sb_item('reports.php', 'bar-chart-3', $lang['left-menu-sidebar-26'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('shopping-cart', $lang['left-menu-sidebar-5']); ?>
                <?php sb_item('dashboard_admin_packages_customers.php', 'box', $lang['left-menu-sidebar-6'], $current_page); ?>
                <?php sb_item('prealert_list.php', 'alert-circle', $lang['left-menu-sidebar-7'], $current_page); ?>
                <?php sb_item('customer_packages_add.php', 'plus', $lang['left-menu-sidebar-8'], $current_page); ?>
                <?php sb_item('customer_packages_multiple.php', 'copy', $lang['left-menu-sidebar-9'], $current_page); ?>
                <?php sb_item('customer_packages_list.php', 'list', $lang['left-menu-sidebar-11'], $current_page); ?>
                <?php sb_item('payments_gateways_list.php', 'credit-card', $lang['left-menu-sidebar-12'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('package', $lang['left-menu-sidebar-13']); ?>
                <?php sb_item('dashboard_admin_shipments.php', 'activity', $lang['left-menu-sidebar-14'], $current_page); ?>
                <?php sb_item('courier_add.php', 'plus', $lang['left-menu-sidebar-15'], $current_page); ?>
                <?php sb_item('courier_add_multiple.php', 'copy', $lang['left-menu-sidebar-17'], $current_page); ?>
                <?php sb_item('courier_list.php', 'list', $lang['left-menu-sidebar-16'], $current_page); ?>
                <?php sb_item('payments_gateways_courier_list.php', 'credit-card', $lang['left-menu-sidebar-12'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('truck', $lang['left-menu-sidebar-18']); ?>
                <?php sb_item('dashboard_admin_pickup.php', 'activity', $lang['left-menu-sidebar-19'], $current_page); ?>
                <?php sb_item('pickup_add.php', 'plus', $lang['left-menu-sidebar-20'], $current_page); ?>
                <?php sb_item('pickup_list.php', 'list', $lang['left-menu-sidebar-21'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('layers', $lang['left-menu-sidebar-22']); ?>
                <?php sb_sub_start('boxes', $lang['left-menu-sidebar-2233333310']); ?>
                    <?php sb_sub_item('dashboard_admin_consolidated.php', $lang['left-menu-sidebar-23'], $current_page); ?>
                    <?php sb_sub_item('consolidate_list.php', $lang['left-menu-sidebar-24'], $current_page); ?>
                    <?php sb_sub_item('consolidate_add.php', $lang['left-menu-sidebar-25'], $current_page); ?>
                    <?php sb_sub_item('payments_gateways_consolidate_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                <?php sb_sub_end(); ?>
                <?php sb_sub_start('package', $lang['left-menu-sidebar-2233333312']); ?>
                    <?php sb_sub_item('dashboard_admin_package_consolidated.php', $lang['left-menu-sidebar-23'], $current_page); ?>
                    <?php sb_sub_item('consolidate_package_list.php', $lang['left-menu-sidebar-24'], $current_page); ?>
                    <?php sb_sub_item('consolidate_package_add.php', $lang['left-menu-sidebar-25'], $current_page); ?>
                    <?php sb_sub_item('payments_gateways_package_consolidate_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                <?php sb_sub_end(); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('wallet', $lang['left-menu-sidebar-27']); ?>
                <?php sb_item('dashboard_admin_account.php', 'bar-chart', $lang['left-menu-sidebar-28'], $current_page); ?>
                <?php sb_item('accounts_receivable.php', 'receipt', $lang['left-menu-sidebar-29'], $current_page); ?>
                <?php sb_item('global_payments_gateways.php', 'credit-card', $lang['left-menu-sidebar-12'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('users', $lang['left-menu-sidebar-30']); ?>
                <?php sb_item('customers_list.php', 'contact', $lang['left-menu-sidebar-31'], $current_page); ?>
            <?php sb_group_end(); ?>

        <?php elseif ($is_client): // =================== CLIENT =================== ?>

            <?php sb_group_start('layout-grid', $lang['left-menu-sidebar-2'] ?? 'Mon espace', true); ?>
                <?php sb_item('index.php', 'home', $lang['left-menu-sidebar-2'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('shopping-cart', $lang['left-menu-sidebar-5']); ?>
                <?php sb_item('prealert_add.php', 'plus', $lang['left-menu-sidebar-10'], $current_page); ?>
                <?php sb_item('prealert_list.php', 'alert-circle', $lang['left-menu-sidebar-7'], $current_page); ?>
                <?php sb_item('customer_packages_list.php', 'list', $lang['left-menu-sidebar-11'], $current_page); ?>
                <?php sb_item('payments_gateways_list.php', 'credit-card', $lang['left-menu-sidebar-12'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('package', $lang['left-menu-sidebar-13']); ?>
                <?php sb_item('courier_add_client.php', 'plus', $lang['left-menu-sidebar-15'], $current_page); ?>
                <?php sb_item('courier_list.php', 'list', $lang['left-menu-sidebar-16'], $current_page); ?>
                <?php sb_item('payments_gateways_courier_list.php', 'credit-card', $lang['left-menu-sidebar-12'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('truck', $lang['left-menu-sidebar-18']); ?>
                <?php sb_item('pickup_add.php', 'plus', $lang['left-menu-sidebar-20'], $current_page); ?>
                <?php sb_item('pickup_list.php', 'list', $lang['left-menu-sidebar-21'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('layers', $lang['left-menu-sidebar-22']); ?>
                <?php sb_sub_start('boxes', $lang['left-menu-sidebar-2233333310']); ?>
                    <?php sb_sub_item('consolidate_list.php', $lang['left-menu-sidebar-24'], $current_page); ?>
                    <?php sb_sub_item('payments_gateways_consolidate_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                <?php sb_sub_end(); ?>
                <?php sb_sub_start('package', $lang['left-menu-sidebar-2233333312']); ?>
                    <?php sb_sub_item('consolidate_package_list.php', $lang['left-menu-sidebar-24'], $current_page); ?>
                    <?php sb_sub_item('payments_gateways_package_consolidate_list.php', $lang['left-menu-sidebar-12'], $current_page); ?>
                <?php sb_sub_end(); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('user', $lang['left-menu-sidebar-63'] ?? 'Profil de compte'); ?>
                <?php sb_item('recipients_list.php', 'users', $lang['left-menu-sidebar-62'], $current_page); ?>
                <?php sb_item('customers_profile_edit.php?user=' . $userData->id, 'user', $lang['left-menu-sidebar-63'] ?? 'Mon profil', $current_page); ?>
            <?php sb_group_end(); ?>

        <?php elseif ($is_driver): // =================== DRIVER =================== ?>

            <?php sb_group_start('layout-grid', $lang['left-menu-sidebar-2'] ?? 'Mon espace', true); ?>
                <?php sb_item('index.php', 'home', $lang['left-menu-sidebar-2'], $current_page); ?>
                <?php sb_item('reports.php', 'bar-chart-3', $lang['left-menu-sidebar-26'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('shopping-cart', $lang['left-menu-sidebar-5']); ?>
                <?php sb_item('customer_packages_list.php', 'list', $lang['left-menu-sidebar-11'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('package', $lang['left-menu-sidebar-13']); ?>
                <?php sb_item('courier_add.php', 'plus', $lang['left-menu-sidebar-15'], $current_page); ?>
                <?php sb_item('courier_list.php', 'list', $lang['left-menu-sidebar-16'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('truck', $lang['left-menu-sidebar-18']); ?>
                <?php sb_item('pickup_add_full.php', 'plus', $lang['left-menu-sidebar-20'], $current_page); ?>
                <?php sb_item('pickup_list.php', 'list', $lang['left-menu-sidebar-21'], $current_page); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('layers', $lang['left-menu-sidebar-22']); ?>
                <?php sb_sub_start('boxes', $lang['left-menu-sidebar-2233333310']); ?>
                    <?php sb_sub_item('consolidate_list.php', $lang['left-menu-sidebar-24'], $current_page); ?>
                <?php sb_sub_end(); ?>
                <?php sb_sub_start('package', $lang['left-menu-sidebar-2233333312']); ?>
                    <?php sb_sub_item('consolidate_package_list.php', $lang['left-menu-sidebar-24'], $current_page); ?>
                <?php sb_sub_end(); ?>
            <?php sb_group_end(); ?>

            <?php sb_group_start('user', $lang['leftorder195'] ?? 'Mon profil'); ?>
                <?php sb_item('drivers_edit.php?user=' . $userData->id, 'user', $lang['leftorder195'] ?? 'Mon profil', $current_page); ?>
            <?php sb_group_end(); ?>

        <?php endif; ?>

    </nav>

    <!-- Sidebar footer -->
    <div class="tw-shrink-0" style="border-top:1px solid rgba(255,255,255,0.06);">
        <!-- Quick action links -->
        <div class="sb-footer-section tw-px-2 tw-py-2 tw-flex tw-flex-col tw-gap-0.5">
            <!-- Notifications dropdown -->
            <div x-data="{ notifOpen: false }" @click.away="notifOpen = false" style="position:relative;">
                <div @click="notifOpen = !notifOpen" role="button" class="sb-rail-item tw-flex tw-items-center tw-gap-2.5 tw-px-3 tw-py-[7px] tw-rounded-lg tw-text-[13px] tw-font-medium tw-cursor-pointer tw-transition-all tw-duration-150" style="color:#cbd5e1;" onmouseover="this.style.background='rgba(255,255,255,0.06)';this.style.color='#f1f5f9'" onmouseout="if(!this.parentElement.__x || !this.parentElement.__x.$data.notifOpen){this.style.background='transparent';this.style.color='#cbd5e1'}">
                    <span class="tw-relative tw-shrink-0 tw-inline-flex" style="width:18px;height:18px;">
                        <i data-lucide="bell" style="width:18px;height:18px;color:#64748b;"></i>
                        <span id="sidebarNotifBadge" class="tw-absolute tw--top-1 tw--right-1 tw-min-w-[16px] tw-h-4 tw-flex tw-items-center tw-justify-center tw-text-[9px] tw-font-bold tw-text-white tw-rounded-full tw-px-0.5" style="background:#ef4444;display:none;z-index:10;">0</span>
                    </span>
                    <span class="tw-flex-1 sb-hide-collapsed">Notifications</span>
                    <svg class="tw-w-3.5 tw-h-3.5 tw-shrink-0 tw-transition-transform tw-duration-200 sb-hide-collapsed" :class="notifOpen && 'tw-rotate-180'" style="color:#475569;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </div>
                <!-- Notification dropdown panel -->
                <div x-show="notifOpen" x-cloak x-transition
                     class="sb-notif-dropdown tw-absolute tw-bottom-full tw-left-2 tw-right-2 tw-mb-1 tw-rounded-lg tw-overflow-hidden tw-shadow-xl"
                     style="background:#1e293b;border:1px solid rgba(26,127,181,0.2);z-index:200;max-height:400px;display:flex;flex-direction:column;box-shadow:0 8px 30px rgba(0,0,0,0.4);">
                    <!-- AJAX notifications container -->
                    <div id="ajax_response" style="overflow-y:auto;flex:1;"></div>
                </div>
            </div>
            <?php if ($is_admin): ?>
                <?php sb_link('tools.php', 'settings', $lang['left-menu-sidebar-38'] ?? 'Paramètres', $current_page); ?>
            <?php endif; ?>
            <?php sb_link('verify_update.php', 'help-circle', $lang['left-menu-sidebar-61'] ?? 'Aide', $current_page); ?>
            <!-- Dark/Light mode toggle -->
            <div x-data="{ dark: localStorage.getItem('mrp-theme') === 'dark' }" class="sb-rail-item tw-flex tw-items-center tw-gap-2.5 tw-px-3 tw-py-[7px] tw-rounded-lg tw-text-[13px] tw-font-medium tw-cursor-pointer tw-transition-all tw-duration-150" style="color:#cbd5e1;" 
                 @click="dark = !dark; localStorage.setItem('mrp-theme', dark ? 'dark' : 'light'); document.documentElement.setAttribute('data-theme', dark ? 'dark' : 'light')"
                 onmouseover="this.style.background='rgba(255,255,255,0.06)';this.style.color='#f1f5f9'" onmouseout="this.style.background='transparent';this.style.color='#cbd5e1'">
                <i x-show="!dark" data-lucide="moon" style="width:18px;height:18px;flex-shrink:0;color:#64748b;"></i>
                <i x-show="dark" data-lucide="sun" style="width:18px;height:18px;flex-shrink:0;color:#fbbf24;"></i>
                <span class="tw-truncate sb-hide-collapsed" x-text="dark ? 'Mode clair' : 'Mode sombre'"></span>
            </div>
        </div>
        <!-- User card with dropdown -->
        <div class="tw-px-2 tw-pb-2" x-data="{ userMenu: false }" @click.away="userMenu = false" style="position:relative;">
            <div @click="userMenu = !userMenu" role="button" class="sb-user-card tw-flex tw-items-center tw-gap-2.5 tw-px-2 tw-py-2 tw-rounded-lg tw-cursor-pointer tw-transition-all tw-duration-150" style="border-top:1px solid rgba(255,255,255,0.06);" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">
                <img src="assets/<?php echo $avatar; ?>" class="tw-w-8 tw-h-8 tw-rounded-full tw-object-cover tw-shrink-0" style="border:2px solid rgba(255,255,255,0.12);" alt="">
                <div class="tw-min-w-0 tw-flex-1 sb-hide-collapsed">
                    <p class="tw-text-[13px] tw-font-medium tw-truncate tw-leading-tight tw-m-0" style="color:#e2e8f0;"><?php echo htmlspecialchars($userData->fname); ?></p>
                    <p class="tw-text-[10px] tw-truncate tw-leading-tight tw-m-0" style="color:#64748b;"><?php echo $role_label; ?><?php if (!empty($userData->name_off)): ?> — <?php echo htmlspecialchars($userData->name_off); ?><?php endif; ?></p>
                </div>
                <svg class="tw-w-4 tw-h-4 tw-shrink-0 tw-transition-transform tw-duration-200 sb-hide-collapsed" :class="userMenu && 'tw-rotate-180'" style="color:#475569;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
            </div>
            <!-- User dropdown -->
            <div x-show="userMenu" x-cloak x-transition
                 class="sb-user-dropdown tw-absolute tw-bottom-full tw-left-2 tw-right-2 tw-mb-1 tw-rounded-lg tw-overflow-hidden tw-shadow-xl" style="background:#1e293b;border:1px solid rgba(255,255,255,0.08);z-index:200;">
                <?php if ($is_admin || $is_employee): ?>
                    <a href="users_edit.php?user=<?php echo $userData->id; ?>" class="tw-flex tw-items-center tw-gap-2 tw-px-3 tw-py-2 tw-text-[12px] tw-no-underline tw-transition-colors" style="color:#cbd5e1;" onmouseover="this.style.background='rgba(255,255,255,0.06)'" onmouseout="this.style.background='transparent'">
                        <i data-lucide="user" style="width:14px;height:14px;color:#64748b;"></i>
                        <?php echo $lang['miprofile'] ?? 'Mon profil'; ?>
                    </a>
                <?php elseif ($is_client): ?>
                    <a href="customers_profile_edit.php?user=<?php echo $userData->id; ?>" class="tw-flex tw-items-center tw-gap-2 tw-px-3 tw-py-2 tw-text-[12px] tw-no-underline tw-transition-colors" style="color:#cbd5e1;" onmouseover="this.style.background='rgba(255,255,255,0.06)'" onmouseout="this.style.background='transparent'">
                        <i data-lucide="user" style="width:14px;height:14px;color:#64748b;"></i>
                        <?php echo $lang['miprofile'] ?? 'Mon profil'; ?>
                    </a>
                <?php elseif ($is_driver): ?>
                    <a href="drivers_edit.php?user=<?php echo $userData->id; ?>" class="tw-flex tw-items-center tw-gap-2 tw-px-3 tw-py-2 tw-text-[12px] tw-no-underline tw-transition-colors" style="color:#cbd5e1;" onmouseover="this.style.background='rgba(255,255,255,0.06)'" onmouseout="this.style.background='transparent'">
                        <i data-lucide="user" style="width:14px;height:14px;color:#64748b;"></i>
                        <?php echo $lang['miprofile'] ?? 'Mon profil'; ?>
                    </a>
                <?php endif; ?>
                <div style="border-top:1px solid rgba(255,255,255,0.06);"></div>
                <a href="logout.php" data-turbo="false" class="tw-flex tw-items-center tw-gap-2 tw-px-3 tw-py-2 tw-text-[12px] tw-no-underline tw-transition-colors" style="color:#f87171;" onmouseover="this.style.background='rgba(248,113,113,0.06)'" onmouseout="this.style.background='transparent'">
                    <i data-lucide="log-out" style="width:14px;height:14px;"></i>
                    <?php echo $lang['logoouts'] ?? 'Déconnexion'; ?>
                </a>
            </div>
        </div>
    </div>
</div><!-- /app-sidebar -->

<!-- Mobile hamburger toggle (visible only on small screens) -->
<div id="mobile-sidebar-toggle"
     class="tw-fixed tw-top-3 tw-left-3 tw-w-10 tw-h-10 tw-rounded-lg tw-flex tw-items-center tw-justify-center tw-cursor-pointer tw-z-[102] tw-shadow-lg lg:tw-hidden"
     style="background:#1a7fb5;color:white;"
     onclick="document.getElementById('main-wrapper').classList.toggle('show-sidebar');"
     title="Menu">
    <i data-lucide="menu" class="tw-w-5 tw-h-5"></i>
</div>

<script>
// Emergency fallback to ensure sidebar is visible
document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.getElementById('app-sidebar');
    if (sidebar) {
        sidebar.style.setProperty('display', 'flex', 'important');
        sidebar.style.setProperty('visibility', 'visible', 'important');
        sidebar.style.setProperty('opacity', '1', 'important');
        sidebar.style.setProperty('background-color', '#0b1120', 'important');
        sidebar.style.setProperty('background', '#0b1120', 'important');
        
        // Sync collapsed state via CSS class (NO inline width — CSS handles it)
        var isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            sidebar.classList.add('sb-collapsed');
            var mw = document.getElementById('main-wrapper');
            if (mw) mw.classList.add('sidebar-collapsed');
        } else {
            sidebar.classList.remove('sb-collapsed');
        }
        
        // Reset localStorage if sidebar was stuck in bad state
        if (localStorage.getItem('sidebarCollapsed') === null) {
            localStorage.setItem('sidebarCollapsed', 'false');
        }
    }
    // Move sidebar + buttons OUTSIDE #main-wrapper so no template CSS can touch them
    var mobileBtn = document.getElementById('mobile-sidebar-toggle');
    if (sidebar && sidebar.closest('#main-wrapper')) {
        document.body.insertBefore(sidebar, document.body.firstChild);
    }
    if (mobileBtn && mobileBtn.closest('#main-wrapper')) {
        document.body.insertBefore(mobileBtn, document.body.firstChild);
    }
    // Force dark background (belt + suspenders)
    if (sidebar) {
        sidebar.style.setProperty('background', '#0b1120', 'important');
        sidebar.style.setProperty('display', 'flex', 'important');
        sidebar.style.setProperty('position', 'fixed', 'important');
    }
    // Sync notification badge: watch hidden #countNotifications for changes
    var srcBadge = document.getElementById('countNotifications');
    var destBadge = document.getElementById('sidebarNotifBadge');
    if (srcBadge && destBadge) {
        function syncBadge() {
            var count = parseInt(srcBadge.textContent) || 0;
            destBadge.textContent = count;
            destBadge.style.display = count > 0 ? 'flex' : 'none';
        }
        syncBadge();
        var observer = new MutationObserver(syncBadge);
        observer.observe(srcBadge, { childList: true, characterData: true, subtree: true });
    }
    // Init Lucide icons (one-time + single retry)
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    } else {
        // Single retry if Lucide wasn't loaded yet
        setTimeout(function() {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }, 300);
    }
});
</script>
