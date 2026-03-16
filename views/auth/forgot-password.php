<!DOCTYPE html>
<html dir="<?php echo $direction_layout; ?>" lang="en" data-theme="light">

<head>
    <meta charset="utf-8" />
    <title><?php echo $lang['langs_010106'] ?> | <?php echo $core->site_name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Monrespro Logistics - Courier & Shipping System">
    <meta name="author" content="Monrespro">
    <meta name="description" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon ?>">

    <!-- daisyUI 5 + themes -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    <script>(function(){var t=localStorage.getItem('mrp-theme')||'light';document.documentElement.setAttribute('data-theme',t);})();</script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{colors:{primary:{50:'#eef8fc',100:'#d4eef7',200:'#a8dcf0',300:'#5bb8e0',400:'#2ea0d0',500:'#1a7fb5',600:'#15699a',700:'#105580',800:'#0c4167',900:'#082f4e'}},fontFamily:{sans:['Inter','system-ui','-apple-system','sans-serif']}}}}</script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@0.344.0/dist/umd/lucide.js"></script>

    <link rel="stylesheet" href="assets/css/tailwind-custom.css">

    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.js"></script>
    <script src="assets/js/jquery.wysiwyg.js"></script>
    <script src="assets/js/global.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/checkbox.js"></script>

    <style>[x-cloak]{display:none!important;}</style>
</head>

<body class="font-sans antialiased bg-base-200 min-h-screen">

    <!-- Preloader — couleurs MonResPro explicites -->
    <div id="preloader" class="fixed inset-0 z-50 flex items-center justify-center transition-opacity duration-300" style="background:#ffffff;">
        <div class="flex flex-col items-center gap-3">
            <span class="loading loading-spinner loading-lg" style="color:#1a7fb5;"></span>
            <span class="text-sm" style="color:#1a7fb5;opacity:0.7;"><?php echo $core->site_name; ?></span>
        </div>
    </div>
    <script>
        window.addEventListener('load', function() {
            var p = document.getElementById('preloader');
            if (p) { p.style.opacity = '0'; setTimeout(function() { p.style.display = 'none'; }, 300); }
        });
    </script>

    <div class="min-h-screen flex">
        <!-- Left side — Image -->
        <div class="hidden lg:flex lg:w-1/2 xl:w-[55%] relative overflow-hidden" style="background:linear-gradient(135deg, #1a7fb5, #105580, #082f4e);">
            <div class="absolute top-0 left-0 w-full h-full opacity-10">
                <div class="absolute top-20 left-10 w-32 h-32 rounded-full bg-white"></div>
                <div class="absolute bottom-32 right-20 w-48 h-48 rounded-full bg-white"></div>
            </div>
            <div class="relative z-10 flex flex-col justify-center items-center w-full p-12">
                <div class="text-center max-w-md">
                    <i data-lucide="key-round" class="w-16 h-16 text-white/80 mx-auto mb-6"></i>
                    <h2 class="text-2xl font-bold text-white mb-3">Réinitialisation du mot de passe</h2>
                    <p class="text-blue-200 text-sm leading-relaxed">
                        Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe en toute sécurité.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right side — Form -->
        <div class="w-full lg:w-1/2 xl:w-[45%] flex items-center justify-center p-6 sm:p-12 bg-base-100">
            <div class="w-full max-w-md">
                <!-- Theme toggle -->
                <div class="flex justify-between items-center mb-6" x-data="{ dark: localStorage.getItem('mrp-theme') === 'dark' }">
                    <a href="index.php" class="btn btn-ghost btn-sm gap-1">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i> Retour
                    </a>
                    <label class="swap swap-rotate btn btn-ghost btn-circle btn-sm">
                        <input type="checkbox" :checked="dark" @change="dark=!dark;localStorage.setItem('mrp-theme',dark?'dark':'light');document.documentElement.setAttribute('data-theme',dark?'dark':'light')" />
                        <i data-lucide="sun" class="swap-off w-5 h-5"></i>
                        <i data-lucide="moon" class="swap-on w-5 h-5"></i>
                    </label>
                </div>

                <!-- Logo -->
                <div class="text-center mb-6">
                    <a href="index.php" class="inline-block">
                        <?php echo ($core->logo_web) ? '<img src="assets/' . $core->logo_web . '" alt="' . $core->site_name . '" width="' . $core->thumb_web . '" height="' . $core->thumb_hweb . '" class="mx-auto"/>' : '<h1 class="text-2xl font-bold">' . $core->site_name . '</h1>'; ?>
                    </a>
                </div>

                <!-- Title -->
                <div class="text-center mb-6">
                    <h2 class="text-xl font-semibold"><?php echo $lang['left172'] ?></h2>
                    <p class="text-sm opacity-60 mt-1"><?php echo $lang['message_title_forgot1'] ?></p>
                </div>

                <div id="resultados_ajax"></div>
                <div id="loader" style="display:none"></div>

                <!-- Form -->
                <form name="forgotPassword" id="forgotPassword" method="post" class="space-y-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium"><?php echo $lang['lemailad'] ?> <span class="text-error">*</span></span>
                        </label>
                        <label class="input input-bordered flex items-center gap-2">
                            <i data-lucide="mail" class="w-4 h-4 opacity-40"></i>
                            <input type="email" name="email" id="email" required
                                   placeholder="<?php echo $lang['left176'] ?>"
                                   class="grow text-sm" />
                        </label>
                    </div>

                    <button type="submit" name="dosubmit" class="btn btn-primary w-full" style="background-color:#1a7fb5;border-color:#1a7fb5;">
                        <i data-lucide="send" class="w-4 h-4"></i>
                        <?php echo $lang['langs_010108'] ?>
                    </button>
                </form>

                <div class="divider text-xs uppercase opacity-50">Liens</div>

                <div class="flex flex-col gap-2 text-center text-sm">
                    <p class="opacity-60">
                        <?php echo $lang['langs_010109'] ?>
                        <?php if ($core->reg_allowed) : ?>
                            <a href="sign-up.php" class="font-semibold link link-primary"><?php echo $lang['langs_010110'] ?></a> |
                        <?php endif; ?>
                        <a href="index.php" class="font-semibold link link-primary"><?php echo $lang['langs_010111'] ?></a>
                    </p>
                </div>

                <p class="text-center text-xs opacity-40 mt-8">
                    &copy; <?php echo date('Y'); ?> <?php echo $core->site_name; ?>. Tous droits réservés.
                </p>
            </div>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>

    <script src="dataJs/forgot_password.js"></script>

</body>

</html>