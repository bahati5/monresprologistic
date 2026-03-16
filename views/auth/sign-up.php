<?php

?>
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="utf-8" />
    <title><?php echo $lang['langs_010112'] ?> | <?php echo $core->site_name; ?></title>
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

    <!-- Tom Select (modern searchable selects) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <link rel="stylesheet" href="assets/css/tailwind-custom.css">
    <link rel="stylesheet" href="assets/template/assets/libs/intlTelInput/intlTelInput.css">
    <link rel="stylesheet" href="assets/template/assets/libs/sweetalert2/sweetalert2.min.css">

    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.js"></script>
    <script src="assets/js/jquery.wysiwyg.js"></script>
    <script src="assets/js/global.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/checkbox.js"></script>

    <style>
        [x-cloak]{display:none!important;}
        /* Remove any white gap at top of auth pages */
        html, body { margin: 0 !important; padding: 0 !important; }
        /* Tom Select styling to match daisyUI */
        .ts-control {
            height: 42px !important;
            border-radius: var(--rounded-btn, 0.5rem) !important;
            background-color: hsl(var(--b1)) !important;
            border-color: hsl(var(--b3)) !important;
            color: hsl(var(--bc)) !important;
            padding: 0.5rem 0.75rem !important;
        }
        .ts-control:focus {
            border-color: #1a7fb5 !important;
            box-shadow: 0 0 0 2px rgba(26,127,181,0.2) !important;
        }
        .ts-dropdown {
            background-color: hsl(var(--b1)) !important;
            border-color: hsl(var(--b3)) !important;
            border-radius: var(--rounded-btn, 0.5rem) !important;
        }
        .ts-dropdown .active {
            background-color: #1a7fb5 !important;
            color: white !important;
        }
        .ts-dropdown .option {
            color: hsl(var(--bc)) !important;
        }
        /* Ensure form controls match daisyUI inputs */
        select.form-control {
            height: 42px !important;
            border-radius: var(--rounded-btn, 0.5rem) !important;
        }
    </style>
</head>

<body class="font-sans antialiased min-h-screen m-0 p-0" style="background:linear-gradient(135deg, #1a7fb5 0%, #15699a 50%, #105580 100%);overflow:hidden;">

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

    <div class="fixed inset-0 flex" style="background:transparent;">
        <!-- Left side — Branding (fixed, no scroll) -->
        <div class="hidden lg:flex lg:w-[42%] relative h-screen overflow-hidden" style="background:transparent;">
            <!-- Decorative elements -->
            <div class="absolute inset-0 opacity-[0.07]">
                <div class="absolute top-1/4 -left-20 w-96 h-96 rounded-full bg-white blur-3xl"></div>
                <div class="absolute bottom-1/4 -right-20 w-80 h-80 rounded-full bg-white blur-3xl"></div>
            </div>
            
            <div class="relative z-10 flex flex-col justify-between w-full p-12">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white/10 backdrop-blur-sm flex items-center justify-center">
                        <i data-lucide="package" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-white"><?php echo $core->site_name; ?></span>
                </div>

                <!-- Main content -->
                <div class="space-y-8">
                    <div>
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-sm mb-6">
                            <i data-lucide="user-plus" class="w-8 h-8 text-white"></i>
                        </div>
                        <h1 class="text-3xl font-bold text-white mb-4">Créez votre compte</h1>
                        <p class="text-white/80 text-base leading-relaxed">
                            Rejoignez notre plateforme de logistique internationale. Gérez vos expéditions, suivez vos colis en temps réel et accédez à votre casier virtuel.
                        </p>
                    </div>

                    <!-- Features -->
                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-lg bg-white/10 backdrop-blur-sm flex items-center justify-center shrink-0">
                                <i data-lucide="shield-check" class="w-5 h-5 text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-white mb-1">Sécurisé</h3>
                                <p class="text-sm text-white/70">Vos données sont protégées</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-lg bg-white/10 backdrop-blur-sm flex items-center justify-center shrink-0">
                                <i data-lucide="zap" class="w-5 h-5 text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-white mb-1">Rapide</h3>
                                <p class="text-sm text-white/70">Inscription en quelques minutes</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-lg bg-white/10 backdrop-blur-sm flex items-center justify-center shrink-0">
                                <i data-lucide="globe" class="w-5 h-5 text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-white mb-1">International</h3>
                                <p class="text-sm text-white/70">Expédiez partout dans le monde</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-white/60 text-sm">
                    &copy; <?php echo date('Y'); ?> <?php echo $core->site_name; ?>. Tous droits réservés.
                </p>
            </div>
        </div>

        <!-- Right side — Sign-up form (scrollable) -->
        <div class="w-full lg:w-[58%] bg-base-100 overflow-y-auto h-screen lg:shadow-2xl">
          <div class="flex items-start justify-center min-h-full">
            <div class="w-full max-w-2xl px-6 sm:px-8 py-8">
                <!-- Header -->
                <div class="flex justify-between items-center mb-8" x-data="{ dark: localStorage.getItem('mrp-theme') === 'dark' }">
                    <a href="index.php" class="btn btn-ghost btn-sm gap-2 hover:gap-3 transition-all">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        <span>Retour</span>
                    </a>
                    <label class="swap swap-rotate btn btn-ghost btn-circle btn-sm">
                        <input type="checkbox" :checked="dark" @change="dark=!dark;localStorage.setItem('mrp-theme',dark?'dark':'light');document.documentElement.setAttribute('data-theme',dark?'dark':'light')" />
                        <i data-lucide="sun" class="swap-off w-5 h-5"></i>
                        <i data-lucide="moon" class="swap-on w-5 h-5"></i>
                    </label>
                </div>

                <!-- Title -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-2"><?php echo $lang['left136'] ?></h2>
                    <p class="text-base-content/60"><?php echo $lang['left137'] ?></p>
                </div>

                <div id="resultados_ajax"></div>

                <?php if (!$core->reg_allowed) : ?>
                    <div role="alert" class="alert alert-warning">
                        <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0"></i>
                        <span><?php echo $lang['langs_010133']; ?></span>
                    </div>
                <?php else : ?>
                <form id="new_register" name="new_register" method="post" class="space-y-6">
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-semibold text-base-content/70 uppercase tracking-wide flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            Informations personnelles
                        </h3>
                        <div class="divider my-2"></div>
                    </div>

                    <!-- Name row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium"><?php echo $lang['left138'] ?> <span class="text-error">*</span></span></label>
                            <label class="input input-bordered flex items-center gap-2">
                                <i data-lucide="user" class="w-4 h-4 opacity-40"></i>
                                <input type="text" name="fname" id="fname" placeholder="<?php echo $lang['left139'] ?>" class="grow text-sm" />
                            </label>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium"><?php echo $lang['left140'] ?> <span class="text-error">*</span></span></label>
                            <label class="input input-bordered flex items-center gap-2">
                                <i data-lucide="user" class="w-4 h-4 opacity-40"></i>
                                <input type="text" name="lname" id="lname" placeholder="<?php echo $lang['left141'] ?>" class="grow text-sm" />
                            </label>
                        </div>
                    </div>

                    <!-- Document section -->
                    <div class="space-y-4 pt-2">
                        <h3 class="text-sm font-semibold text-base-content/70 uppercase tracking-wide flex items-center gap-2">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                            Document d'identité
                        </h3>
                        <div class="divider my-2"></div>
                    </div>

                    <!-- Document row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium"><?php echo $lang['leftorder164'] ?></span></label>
                            <select class="form-control" id="document_type" name="document_type">
                                <option value="DNI"><?php echo $lang['leftorder165'] ?></option>
                                <option value="RIC"><?php echo $lang['leftorder166'] ?></option>
                                <option value="CI"><?php echo $lang['leftorder167'] ?></option>
                                <option value="CIE"><?php echo $lang['leftorder168'] ?></option>
                                <option value="CIN"><?php echo $lang['leftorder169'] ?></option>
                                <option value="CIE"><?php echo $lang['leftorder170'] ?></option>
                                <option value="CC"><?php echo $lang['leftorder171'] ?></option>
                                <option value="TI"><?php echo $lang['leftorder172'] ?></option>
                                <option value="CE"><?php echo $lang['leftorder173'] ?></option>
                                <option value="PSP"><?php echo $lang['leftorder174'] ?></option>
                                <option value="NIT"><?php echo $lang['leftorder1745'] ?></option>
                            </select>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium"><?php echo $lang['leftorder175'] ?></span></label>
                            <label class="input input-bordered flex items-center gap-2">
                                <i data-lucide="hash" class="w-4 h-4 opacity-40"></i>
                                <input type="text" name="document_number" id="document_number" placeholder="<?php echo $lang['leftorder175'] ?>" class="grow text-sm" />
                            </label>
                        </div>
                    </div>

                    <!-- Contact section -->
                    <div class="space-y-4 pt-2">
                        <h3 class="text-sm font-semibold text-base-content/70 uppercase tracking-wide flex items-center gap-2">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                            Coordonnées
                        </h3>
                        <div class="divider my-2"></div>
                    </div>

                    <!-- Email + phone row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium"><?php echo $lang['left142'] ?> <span class="text-error">*</span></span></label>
                            <label class="input input-bordered flex items-center gap-2">
                                <i data-lucide="mail" class="w-4 h-4 opacity-40"></i>
                                <input type="email" name="email" id="email" placeholder="<?php echo $lang['left143'] ?>" class="grow text-sm" />
                            </label>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium"><?php echo $lang['user_manage9'] ?> <span class="text-error">*</span></span></label>
                            <input type="tel" class="input input-bordered w-full text-sm" name="phone_custom" id="phone_custom" autocomplete="off" data-intl-tel-input-id="0" placeholder="<?php echo $lang['user_manage9'] ?>">
                            <span id="valid-msg" class="hide"></span>
                            <div id="error-msg" class="hide text-error text-xs mt-1"></div>
                        </div>
                        <input type="hidden" name="phone" id="phone" />
                    </div>

                    <!-- Address section -->
                    <div class="space-y-4 pt-2">
                        <h3 class="text-sm font-semibold text-base-content/70 uppercase tracking-wide flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            Adresse
                        </h3>
                        <div class="divider my-2"></div>
                    </div>

                    <!-- Country/State/City row -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium"><?php echo $lang['translate_search_address_country'] ?> <span class="text-error">*</span></span></label>
                            <select class="form-control" name="country" id="country" placeholder="<?php echo $lang['translate_search_country'] ?>"></select>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium"><?php echo $lang['translate_search_address_state'] ?> <span class="text-error">*</span></span></label>
                            <select class="form-control" id="state" name="state" placeholder="<?php echo $lang['translate_search_state'] ?>" disabled></select>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium"><?php echo $lang['translate_search_address_city'] ?> <span class="text-error">*</span></span></label>
                            <select class="form-control" id="city" name="city" placeholder="<?php echo $lang['translate_search_city'] ?>" disabled></select>
                        </div>
                    </div>

                    <!-- Postal + Address row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium"><?php echo $lang['user_manage14'] ?> <span class="text-error">*</span></span></label>
                            <label class="input input-bordered flex items-center gap-2">
                                <i data-lucide="flag" class="w-4 h-4 opacity-40"></i>
                                <input type="text" name="postal" id="postal" placeholder="<?php echo $lang['user_manage14'] ?>" class="grow text-sm" />
                            </label>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium"><?php echo $lang['user_manage10'] ?> <span class="text-error">*</span></span></label>
                            <label class="input input-bordered flex items-center gap-2">
                                <i data-lucide="map-pin" class="w-4 h-4 opacity-40"></i>
                                <input type="text" name="address" id="address" placeholder="<?php echo $lang['user_manage10'] ?>" class="grow text-sm" />
                            </label>
                        </div>
                    </div>

                    <!-- Account section -->
                    <div class="space-y-4 pt-2">
                        <h3 class="text-sm font-semibold text-base-content/70 uppercase tracking-wide flex items-center gap-2">
                            <i data-lucide="key" class="w-4 h-4"></i>
                            Informations de connexion
                        </h3>
                        <div class="divider my-2"></div>
                    </div>

                    <!-- Username -->
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-medium"><?php echo $lang['left144'] ?> <span class="text-error">*</span></span></label>
                        <label class="input input-bordered flex items-center gap-2">
                            <i data-lucide="at-sign" class="w-4 h-4 opacity-40"></i>
                            <input type="text" name="username" id="username" placeholder="<?php echo $lang['left145'] ?>" class="grow text-sm" />
                        </label>
                    </div>

                    <!-- Password row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium"><?php echo $lang['left146'] ?> <span class="text-error">*</span></span></label>
                            <label class="input input-bordered flex items-center gap-2">
                                <i data-lucide="key" class="w-4 h-4 opacity-40"></i>
                                <input type="password" name="pass" id="pass" placeholder="<?php echo $lang['left147'] ?>" class="grow text-sm" />
                            </label>
                            <div id="password-strength-meter" class="mt-1"></div>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium"><?php echo $lang['left148'] ?> <span class="text-error">*</span></span></label>
                            <label class="input input-bordered flex items-center gap-2">
                                <i data-lucide="key" class="w-4 h-4 opacity-40"></i>
                                <input type="password" name="pass2" id="pass2" placeholder="<?php echo $lang['left149'] ?>" class="grow text-sm" />
                            </label>
                            <div id="passwordMatch" class="text-error text-xs mt-1"></div>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="form-control">
                        <label class="label cursor-pointer justify-start gap-3">
                            <input type="checkbox" class="checkbox checkbox-sm checkbox-primary" id="terms" name="terms" value="yes" />
                            <span class="label-text text-sm"><?php echo $lang['left164'] ?> <a href="#" class="link link-primary"><?php echo $lang['left165'] ?></a></span>
                        </label>
                    </div>

                    <!-- Submit -->
                    <button class="btn btn-primary w-full" name="dosubmit" style="background-color:#1a7fb5;border-color:#1a7fb5;">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <?php echo $lang['left166'] ?>
                    </button>

                    <?php
                    if ($core->code_number_locker == 1) {
                    ?>
                        <div style="display:none;">
                            <label><?php echo $lang['add-title24'] ?></label>
                            <input type="number" name="locker" id="locker" value="<?php echo $lockerauto; ?>" onchange="cdp_validateLockerNumber(this.value, '<?php echo $verifylocker; ?>');">
                            <input type="hidden" name="order_no_main" id="order_no_main" value="<?php echo $lockerauto; ?>">
                        </div>
                    <?php } elseif ($core->code_number_locker == 2) { ?>
                        <div style="display:none;">
                            <label><?php echo $lang['leftorder14442'] ?></label>
                            <input type="number" name="locker" id="locker" value="<?php print_r(cdp_generarCodigo('' . $core->digit_random_locker . '')); ?>" onchange="cdp_validateLockerNumber(this.value, '<?php echo $verifylocker; ?>');">
                            <input type="hidden" name="order_no_main" id="order_no_main" value="<?php echo $lockerauto; ?>">
                        </div>
                    <?php } ?>
                </form>

                <p class="text-center text-sm opacity-60 mt-4">
                    <?php echo $lang['left167'] ?>
                    <a href="index.php" class="font-semibold link link-primary"><?php echo $lang['left168'] ?></a>
                </p>

                <?php endif; ?>

                <p class="text-center text-xs opacity-40 mt-8">
                    &copy; <?php echo date('Y'); ?> <?php echo $core->site_name; ?>. Tous droits réservés.
                </p>
            </div>
          </div>
        </div>
    </div>

    <?php include('helpers/languages/translate_to_js.php'); ?>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <script src="assets/template/assets/libs/intlTelInput/intlTelInput.js"></script>
    <script src="assets/template/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    

    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>

    <script> 
        function cdp_validateLockerNumber(value, lockDigits) {
          cdp_convertStrPad(value, lockDigits);

          $.ajax({
            type: "POST",
            dataType: "json",
            url: "./ajax/validate_locker_virtual.php?track=" + value,
            success: function (data) {
              var main = $("#order_no_main").val();

              if (data) {
                alert(message_error_exist_locker);
                $("#digitslockers").val(main);
              }
            },
          });
        }

        function cdp_convertStrPad(value, dbDigits) {
          var pad = value.padStart(dbDigits, "0");

          $("#digitslockers").val(pad);
        }

        var input = document.getElementById("digitslockers");
    </script>

    <script src="dataJs/sign-up.js"></script>

</body>

</html>