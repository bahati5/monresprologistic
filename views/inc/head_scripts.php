<!-- Preconnect to CDN for faster loading -->
<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
<link rel="preconnect" href="https://unpkg.com" crossorigin>
<link rel="dns-prefetch" href="https://fonts.googleapis.com">

<!-- daisyUI 5 — Component library (pure CSS, no build needed) -->
<link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />

<!-- CRITICAL: Neutralize daisyUI classes that conflict with Bootstrap 4.
     daisyUI .modal sets opacity:0, pointer-events:none, display:grid
     daisyUI .dropdown, .collapse, .tooltip also conflict.
     This MUST load immediately after daisyUI to prevent breakage. -->
<style>
/* --- Bootstrap 4 modal: neutralize daisyUI 5 display:grid, inset:0, visibility:hidden, overflow:clip --- */
.modal {
    display: none;                           /* daisyUI: grid → Bootstrap: none (NO !important — Bootstrap JS sets inline display:block) */
    position: fixed !important;              /* both frameworks agree, just ensure it */
    top: 0 !important;                       /* daisyUI uses inset:0 — we set explicit coords for Bootstrap */
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    overflow: hidden !important;             /* daisyUI: clip → Bootstrap: hidden */
    outline: 0 !important;
    z-index: 1050 !important;               /* daisyUI: 999 → Bootstrap: 1050 */
    opacity: 1 !important;                   /* daisyUI transitions opacity */
    visibility: visible !important;          /* daisyUI: hidden */
    pointer-events: auto !important;         /* daisyUI: none */
    background-color: transparent !important;
    place-items: unset !important;           /* daisyUI grid alignment */
    justify-items: unset !important;
    overscroll-behavior: unset !important;
    max-width: unset !important;
    max-height: unset !important;
    margin: 0 !important;
    padding: 0 !important;
    transition: opacity 0.15s linear !important;
}
.modal.show {
    overflow-x: hidden !important;
    overflow-y: auto !important;
}
.modal-backdrop { z-index: 1040 !important; }
.modal-backdrop.show { opacity: 0.5 !important; }
body.modal-open { overflow: hidden !important; }
/* --- Bootstrap .fade/.show — daisyUI must not interfere --- */
.fade { transition: opacity 0.15s linear !important; }
.fade:not(.show) { opacity: 0 !important; visibility: hidden !important; }
.fade.show { opacity: 1 !important; visibility: visible !important; }
/* --- Bootstrap tab content visibility --- */
.tab-content > .tab-pane { display: none !important; opacity: 0 !important; visibility: hidden !important; }
.tab-content > .tab-pane.active,
.tab-content > .tab-pane.show.active { display: block !important; opacity: 1 !important; visibility: visible !important; }
/* --- Prevent .card from clipping tab content --- */
.card { overflow: visible !important; }
.card-header { overflow: visible !important; }
/* --- Universal overflow override for payment pages --- */
.tab-content,
.tab-content div,
.tab-content * { overflow: visible !important; }
</style>

<!-- Dark/Light mode initializer — runs before paint to avoid flash -->
<script>
(function(){
    var t = localStorage.getItem('mrp-theme') || 'light';
    document.documentElement.setAttribute('data-theme', t);
    document.addEventListener('DOMContentLoaded', function() {
        if (document.body) {
            document.body.setAttribute('data-theme', t);
        }
    });
})();
</script>

<!-- Global theme sync — ensures all elements match the theme consistently -->
<script>
(function(){
    function syncTheme() {
        var theme = localStorage.getItem('mrp-theme') || 'light';
        document.documentElement.setAttribute('data-theme', theme);
        if (document.body) document.body.setAttribute('data-theme', theme);
        window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme: theme } }));
    }
    document.addEventListener('DOMContentLoaded', syncTheme);
    window.syncMonresproTheme = syncTheme;
})();
</script>

<!-- Tailwind CSS CDN (prefixed tw- to avoid conflicts with Bootstrap) -->
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

<!-- Lucide Icons (defer — not needed for initial paint) -->
<script defer src="https://unpkg.com/lucide@0.344.0/dist/umd/lucide.js"></script>

<!-- Lazy-load heavy libraries only when the page needs them -->
<script>
(function(){
    function loadCSS(href) {
        var l = document.createElement('link');
        l.rel = 'stylesheet'; l.href = href;
        document.head.appendChild(l);
    }
    function loadJS(src) {
        var s = document.createElement('script');
        s.src = src;
        document.head.appendChild(s);
    }
    document.addEventListener('DOMContentLoaded', function() {
        if (document.querySelector('[data-leaflet], #map, .leaflet-map')) {
            loadCSS('https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
            loadJS('https://unpkg.com/leaflet@1.9.4/dist/leaflet.js');
        }
        if (document.querySelector('[data-flatpickr], .flatpickr-input, input.flatpickr')) {
            loadCSS('https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
            loadJS('https://cdn.jsdelivr.net/npm/flatpickr');
        }
        if (document.querySelector('[data-tom-select], .tom-select')) {
            loadCSS('https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css');
            loadJS('https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js');
        }
    });
})();
</script>

<link href="assets/template/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet">
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap" rel="stylesheet">
<!-- Icons -->
<link rel="stylesheet" href="assets/vendor/fonts/fontawesome.css" />
<link rel="stylesheet" href="assets/vendor/fonts/tabler-icons.css" />
<link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css" />
<link rel="stylesheet" type="text/css" href="assets/template/dist/css/uicons-regular-rounded.css" />
<link href="assets/template/dist/css/style.min.css" rel="stylesheet">
<link href="assets/customClassPagination.css" rel="stylesheet">
<link href="assets/css/scroll-menu.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
<!-- Custom Design System (MUST load after style.min.css to override Bootstrap) -->
<link rel="stylesheet" href="assets/css/tailwind-custom.css">

<!-- NProgress loading bar -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.min.css">
<script defer src="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.min.js"></script>

<style>[x-cloak] { display: none !important; }</style>

<!-- NProgress on classic page navigation -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof NProgress !== 'undefined') NProgress.done();
        if (typeof lucide !== 'undefined') lucide.createIcons();
        if (typeof feather !== 'undefined') feather.replace();
        var t = localStorage.getItem('mrp-theme') || 'light';
        document.documentElement.setAttribute('data-theme', t);
    });
    // Start NProgress when navigating away
    window.addEventListener('beforeunload', function() {
        if (typeof NProgress !== 'undefined') NProgress.start();
    });
</script>

<!-- Alpine.js Collapse Plugin + Core (must load on ALL pages for sidebar) -->
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.14.3/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

<?php
if ($direction_layout == 'rtl') {
?>
    <link href="https://fonts.googleapis.com/css?family=Tajawal&subset=arabic" rel="stylesheet">
    <style>
        * {
            font-family: 'Tajawal';
        }
    </style>
<?php
}
?>