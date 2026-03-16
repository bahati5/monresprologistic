<?php
// DEBUG TEMPORAIRE - À SUPPRIMER APRÈS DIAGNOSTIC
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>DEBUG: Starting login.php</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Current working directory: " . getcwd() . "</p>";

// Include loader.php
if (file_exists('loader.php')) {
    echo "<p>Including loader.php...</p>";
    require_once("loader.php");
    echo "<p>✅ loader.php included</p>";
} else {
    echo "<p>❌ loader.php NOT found</p>";
    die("Loader file missing");
}

echo "<p>Creating User and Core objects...</p>";

$login = new User;
$core = new Core;

echo "<p>✅ Objects created</p>";

if ($login->cdp_loginCheck() == true) {
    echo "<p>User already logged in, redirecting to index.php</p>";
    header("location: index.php");
    die("Redirecting...");
}

$login = new User;
$core = new Core;

if ($login->cdp_loginCheck() == true) {

    header("location: index.php");
}

$login_failed_message = '';
if (isset($_POST['login'])) {

    $result = $login->cdp_login($_POST['username'], $_POST['password']);
    if ($result) {
        header("location: index.php");
        exit;
    }
    // Message de secours si la classe n'affiche pas d'erreur (ex: problème BDD)
    if (empty($login->errors)) {
        $login_failed_message = 'Identifiants incorrects, compte inactif, ou problème de connexion à la base de données. Vérifiez config/config.php (nom de la BDD, utilisateur, mot de passe) et que la base contient la table cdb_users.';
    }
}
?>


<!DOCTYPE html>
<html lang="<?php echo $core->language ?? 'fr'; ?>" class="scroll-smooth" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Monrespro Logistics - Courier & Shipping System">
    <meta name="author" content="Monrespro">
    <meta name="description" content="Plateforme de logistique et d'expédition internationale">
    <title><?php echo $lang['message_title_login0'] ?> | <?php echo $core->site_name ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon ?>">

    <!-- daisyUI 5 + themes -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />

    <!-- Dark/Light mode initializer -->
    <script>
    (function(){
        var t = localStorage.getItem('mrp-theme') || 'light';
        document.documentElement.setAttribute('data-theme', t);
    })();
    </script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50:'#eef8fc', 100:'#d4eef7', 200:'#a8dcf0', 300:'#5bb8e0', 400:'#2ea0d0', 500:'#1a7fb5', 600:'#15699a', 700:'#105580', 800:'#0c4167', 900:'#082f4e' },
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
    <script src="https://unpkg.com/lucide@0.344.0/dist/umd/lucide.js"></script>

    <!-- Custom animations -->
    <link rel="stylesheet" href="assets/css/tailwind-custom.css">

    <style>
        [x-cloak] { display: none !important; }
        /* Remove any white gap at top */
        html, body { margin: 0 !important; padding: 0 !important; }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }
    </style>
</head>

<body class="font-sans antialiased min-h-screen m-0 p-0" style="background:linear-gradient(135deg, #1a7fb5, #105580, #082f4e);overflow:hidden;">

    <!-- Preloader — couleurs MonResPro explicites (pas de DaisyUI au début) -->
    <div id="login-preloader" class="fixed inset-0 z-50 flex items-center justify-center transition-opacity duration-300" style="background:#ffffff;">
        <div class="flex flex-col items-center gap-3">
            <span class="loading loading-spinner loading-lg" style="color:#1a7fb5;"></span>
            <span class="text-sm" style="color:#1a7fb5;opacity:0.7;"><?php echo $core->site_name; ?></span>
        </div>
    </div>
    <script>
        window.addEventListener('load', function() {
            var p = document.getElementById('login-preloader');
            if (p) { p.style.opacity = '0'; setTimeout(function() { p.style.display = 'none'; }, 300); }
        });
    </script>

    <div class="fixed inset-0 flex">
        <!-- Left side — Illustration -->
        <div class="hidden lg:flex lg:w-1/2 xl:w-[55%] relative overflow-hidden" style="background:transparent;">
            <!-- Decorative elements -->
            <div class="absolute top-0 left-0 w-full h-full opacity-10">
                <div class="absolute top-20 left-10 w-32 h-32 rounded-full bg-white"></div>
                <div class="absolute bottom-32 right-20 w-48 h-48 rounded-full bg-white"></div>
                <div class="absolute top-1/2 left-1/3 w-24 h-24 rounded-full bg-white"></div>
            </div>

            <div class="relative z-10 flex flex-col justify-center items-center w-full p-12">
                <!-- Illustration -->
                <div class="w-full max-w-md animate-float">
                    <?php include 'views/components/login_illustration.php'; render_login_illustration(); ?>
                </div>

                <!-- Text -->
                <div class="text-center mt-8 max-w-md">
                    <h2 class="text-2xl font-bold text-white mb-3">Logistique internationale simplifiée</h2>
                    <p class="text-blue-200 text-sm leading-relaxed">
                        Expéditions, suivi en temps réel, consolidation de colis et livraison vers l'Afrique. 
                        Tout en un seul endroit.
                    </p>
                </div>

                <!-- Feature badges -->
                <div class="flex flex-wrap justify-center gap-3 mt-8">
                    <span class="badge badge-lg badge-ghost text-white border-white/20 gap-1.5">
                        <i data-lucide="package" class="w-3.5 h-3.5"></i> Suivi colis
                    </span>
                    <span class="badge badge-lg badge-ghost text-white border-white/20 gap-1.5">
                        <i data-lucide="globe" class="w-3.5 h-3.5"></i> Multi-agences
                    </span>
                    <span class="badge badge-lg badge-ghost text-white border-white/20 gap-1.5">
                        <i data-lucide="truck" class="w-3.5 h-3.5"></i> Livraison Afrique
                    </span>
                </div>
            </div>
        </div>

        <!-- Right side — Login form -->
        <div class="w-full lg:w-1/2 xl:w-[45%] flex items-center justify-center p-6 sm:p-12 bg-base-100 overflow-y-auto">
            <div class="w-full max-w-md">
                <!-- Theme toggle -->
                <div class="flex justify-end mb-4" x-data="{ dark: localStorage.getItem('mrp-theme') === 'dark' }">
                    <label class="swap swap-rotate btn btn-ghost btn-circle btn-sm">
                        <input type="checkbox" :checked="dark" @change="dark = !dark; localStorage.setItem('mrp-theme', dark ? 'dark' : 'light'); document.documentElement.setAttribute('data-theme', dark ? 'dark' : 'light')" />
                        <i data-lucide="sun" class="swap-off w-5 h-5"></i>
                        <i data-lucide="moon" class="swap-on w-5 h-5"></i>
                    </label>
                </div>

                <!-- Logo -->
                <div class="text-center mb-8">
                    <a href="index.php" class="inline-block">
                        <?php echo ($core->logo_web) ? '<img src="assets/' . $core->logo_web . '" alt="' . $core->site_name . '" width="' . $core->thumb_web . '" height="' . $core->thumb_hweb . '" class="mx-auto"/>' : '<h1 class="text-2xl font-bold">' . $core->site_name . '</h1>'; ?>
                    </a>
                </div>

                <!-- Welcome text -->
                <div class="text-center mb-6">
                    <h2 class="text-xl font-semibold"><?php echo $lang['message_title_login2'] ?> <?php echo $core->site_name ?></h2>
                    <p class="text-sm opacity-60 mt-1"><?php echo $lang['message_title_login1'] ?></p>
                </div>

                <!-- Error messages -->
                <?php if (!empty($login_failed_message)): ?>
                    <div role="alert" class="alert alert-error mb-4">
                        <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                        <span class="text-sm"><?php echo htmlspecialchars($login_failed_message); ?></span>
                    </div>
                <?php endif; ?>
                <?php if (isset($login) && !empty($login->errors)): ?>
                    <div role="alert" class="alert alert-error mb-4">
                        <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                        <span class="text-sm"><?php foreach ($login->errors as $error) { echo $error; } ?></span>
                    </div>
                <?php endif; ?>

                <!-- Login form -->
                <form method="post" name="login_form" id="login-form" class="space-y-4">
                    <!-- Username -->
                    <div class="form-control w-full">
                        <label class="label" for="username">
                            <span class="label-text font-medium"><?php echo $lang['left115'] ?> <span class="text-error">*</span></span>
                        </label>
                        <label class="input input-bordered flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4 opacity-40"></i>
                            <input type="text" name="username" id="username" required
                                   placeholder="<?php echo $lang['left116'] ?>"
                                   class="grow text-sm" />
                        </label>
                    </div>

                    <!-- Password -->
                    <div class="form-control w-full" x-data="{ showPass: false }">
                        <label class="label" for="password">
                            <span class="label-text font-medium"><?php echo $lang['left117'] ?> <span class="text-error">*</span></span>
                        </label>
                        <label class="input input-bordered flex items-center gap-2">
                            <i data-lucide="lock" class="w-4 h-4 opacity-40"></i>
                            <input :type="showPass ? 'text' : 'password'" name="password" id="password" required
                                   placeholder="<?php echo $lang['left118'] ?>"
                                   class="grow text-sm" />
                            <button type="button" @click="showPass = !showPass" class="btn btn-ghost btn-xs btn-circle">
                                <i x-show="!showPass" data-lucide="eye" class="w-4 h-4 opacity-50"></i>
                                <i x-show="showPass" data-lucide="eye-off" class="w-4 h-4 opacity-50" x-cloak></i>
                            </button>
                        </label>
                    </div>

                    <!-- Remember me + Forgot password -->
                    <div class="flex items-center justify-between">
                        <label class="label cursor-pointer gap-2">
                            <input type="checkbox" id="flexCheckDefault" class="checkbox checkbox-sm checkbox-primary" />
                            <span class="label-text text-sm"><?php echo $lang['left120'] ?></span>
                        </label>
                        <a href="forgot-password.php" class="text-sm font-medium link link-primary no-underline hover:underline">
                            <?php echo $lang['left119'] ?>
                        </a>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary w-full" style="background-color:#1a7fb5;border-color:#1a7fb5;">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        <?php echo $lang['left121'] ?>
                    </button>
                    <input name="login" type="hidden" value="1">
                </form>

                <!-- Sign up -->
                <p class="text-center text-sm opacity-60 mt-4">
                    <?php echo $lang['left122'] ?>
                    <a href="sign-up.php" class="font-semibold link link-primary"><?php echo $lang['left123'] ?></a>
                </p>

                <!-- Divider -->
                <div class="divider text-xs uppercase opacity-50"><?php echo $lang['leftorder286'] ?? 'Ou'; ?></div>

                <!-- Tracking link -->
                <a href="tracking.php" class="btn btn-outline w-full gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    <?php echo $lang['langs_06'] ?>
                </a>

                <?php if (CDP_APP_MODE_DEMO === true): ?>
                <!-- Demo quick connect -->
                <div class="mt-6 p-4 rounded-lg bg-base-200 border border-base-300">
                    <p class="text-xs font-semibold opacity-50 uppercase tracking-wider mb-3 text-center">Connexion rapide (démo)</p>
                    <div class="flex flex-wrap justify-center gap-2">
                        <button type="button" onclick="document.getElementById('username').value='admin'; document.getElementById('password').value='09731';"
                                class="btn btn-sm btn-info">Admin</button>
                        <button type="button" onclick="document.getElementById('username').value='employee'; document.getElementById('password').value='09731';"
                                class="btn btn-sm btn-secondary">Employee</button>
                        <button type="button" onclick="document.getElementById('username').value='customer'; document.getElementById('password').value='09731';"
                                class="btn btn-sm btn-success">Customer</button>
                        <button type="button" onclick="document.getElementById('username').value='driver'; document.getElementById('password').value='09731';"
                                class="btn btn-sm btn-warning">Driver</button>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Footer -->
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
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>

</body>

</html>