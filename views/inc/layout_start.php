<!DOCTYPE html>
<html dir="<?php echo $direction_layout; ?>" lang="<?php echo $core->language ?? 'fr'; ?>" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Monrespro Logistics - Courier & Shipping System">
    <meta name="author" content="Monrespro">
    <title><?php echo $page_title ?? $lang['left-menu-sidebar-2']; ?> | <?php echo $core->site_name; ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon; ?>">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: 'tw-',
            corePlugins: { preflight: false },
            theme: {
                extend: {
                    colors: {
                        primary:   { 50:'#eff6ff', 100:'#dbeafe', 200:'#bfdbfe', 300:'#93c5fd', 400:'#60a5fa', 500:'#3b82f6', 600:'#2563eb', 700:'#1d4ed8', 800:'#1e40af', 900:'#1e3a8a' },
                        secondary: { 50:'#f5f3ff', 100:'#ede9fe', 200:'#ddd6fe', 300:'#c4b5fd', 400:'#a78bfa', 500:'#8b5cf6', 600:'#7c3aed', 700:'#6d28d9', 800:'#5b21b6', 900:'#4c1d95' },
                        success:   { 50:'#f0fdf4', 100:'#dcfce7', 200:'#bbf7d0', 300:'#86efac', 400:'#4ade80', 500:'#22c55e', 600:'#16a34a', 700:'#15803d', 800:'#166534', 900:'#14532d' },
                        warning:   { 50:'#fffbeb', 100:'#fef3c7', 200:'#fde68a', 300:'#fcd34d', 400:'#fbbf24', 500:'#f59e0b', 600:'#d97706', 700:'#b45309', 800:'#92400e', 900:'#78350f' },
                        danger:    { 50:'#fef2f2', 100:'#fee2e2', 200:'#fecaca', 300:'#fca5a5', 400:'#f87171', 500:'#ef4444', 600:'#dc2626', 700:'#b91c1c', 800:'#991b1b', 900:'#7f1d1d' },
                        info:      { 50:'#ecfeff', 100:'#cffafe', 200:'#a5f3fc', 300:'#67e8f9', 400:'#22d3ee', 500:'#06b6d4', 600:'#0891b2', 700:'#0e7490', 800:'#155e75', 900:'#164e63' },
                        sidebar:   { DEFAULT:'#0f172a', hover:'#1e293b', active:'#334155' },
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <!-- Leaflet.js for maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

    <!-- Chart.js 4 -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <!-- Flatpickr date picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Tom Select (replaces Select2) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <!-- SweetAlert2 (kept for compatibility) -->
    <link href="assets/template/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet">

    <!-- Legacy CSS (kept during transition) -->
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome.css">
    <link rel="stylesheet" href="assets/vendor/fonts/tabler-icons.css">
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/template/dist/css/uicons-regular-rounded.css">
    <link href="assets/template/dist/css/style.min.css" rel="stylesheet">
    <link href="assets/customClassPagination.css" rel="stylesheet">
    <link href="assets/css/scroll-menu.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css">

    <!-- Custom Design System -->
    <link rel="stylesheet" href="assets/css/tailwind-custom.css">

    <?php if (isset($direction_layout) && $direction_layout == 'rtl') { ?>
        <link href="https://fonts.googleapis.com/css?family=Tajawal&subset=arabic" rel="stylesheet">
        <style>* { font-family: 'Tajawal'; }</style>
    <?php } ?>

    <?php if (isset($extra_head)) echo $extra_head; ?>
</head>

<body class="tw-font-sans tw-bg-gray-50 tw-text-gray-800 tw-antialiased">

    <!-- Skeleton Preloader -->
    <div id="tw-preloader" class="tw-fixed tw-inset-0 tw-z-[9999] tw-bg-white tw-flex tw-items-center tw-justify-center tw-transition-opacity tw-duration-300">
        <div class="tw-flex tw-flex-col tw-items-center tw-gap-3">
            <div class="tw-w-10 tw-h-10 tw-border-4 tw-border-primary-200 tw-border-t-primary-600 tw-rounded-full tw-animate-spin"></div>
            <span class="tw-text-sm tw-text-gray-400"><?php echo $core->site_name; ?></span>
        </div>
    </div>
    <script>
        window.addEventListener('load', function() {
            var preloader = document.getElementById('tw-preloader');
            if (preloader) {
                preloader.style.opacity = '0';
                setTimeout(function() { preloader.style.display = 'none'; }, 300);
            }
        });
    </script>

    <!-- Legacy preloader (hidden, kept for compatibility) -->
    <div class="preloader" style="display:none;">
        <div class="lds-ripple"><div class="lds-pos"></div><div class="lds-pos"></div></div>
    </div>

    <div id="main-wrapper">
        <script>if(localStorage.getItem('sidebarPanel')==='false'){document.currentScript.parentElement.classList.add('sidebar-collapsed');}</script>

        <?php include 'views/inc/topbar.php'; ?>

        <?php include 'views/inc/left_sidebar.php'; ?>

        <div class="page-wrapper">
