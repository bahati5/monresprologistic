<?php
// *************************************************************************
// *                                                                       *
// * MONRESPRO - Integrated Logistics System                         *
// * Copyright (c) JAOMWEB. All Rights Reserved                            *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: support@jaom.info                                              *
// * Website: http://www.jaom.info                                         *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// * If you Purchased from Codecanyon, Please read the full License from   *
// * here- http://codecanyon.net/licenses/standard                         *
// *                                                                       *
// *************************************************************************


$userData = $user->cdp_getUserData();

$db = new Conexion;

?>
<!DOCTYPE html>
<html dir="<?php echo $direction_layout; ?>" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Monrespro Logistics - Courier & Shipping System" />
    <meta name="author" content="Jaomweb">
    <title><?php echo $lang['left-menu-sidebar-2'] ?> | <?php echo $core->site_name ?></title>

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon ?>">
    <?php include 'views/inc/head_scripts.php'; ?>
</head>

<body>

    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->

        <?php include 'views/inc/preloader.php'; ?>

        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->

        <?php include 'views/inc/topbar.php'; ?>

        <!-- End Topbar header -->


        <!-- Left Sidebar - style you can find in sidebar.scss  -->

        <?php include 'views/inc/left_sidebar.php'; ?>


        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <!-- Page wrapper  -->

        <div class="page-wrapper">
            <!-- Modern Driver Dashboard — Tailwind + Alpine.js -->
            <div class="tw-p-4 lg:tw-p-6 tw-space-y-6">

                <!-- Header -->
                <div class="tw-flex tw-flex-col sm:tw-flex-row sm:tw-items-center sm:tw-justify-between tw-gap-3">
                    <div>
                        <h1 class="tw-text-2xl tw-font-bold tw-text-gray-800"><?php echo $lang['left-menu-sidebar-2'] ?></h1>
                        <p class="tw-text-sm tw-text-gray-500"><?php echo htmlspecialchars($userData->fname ?? $userData->username); ?></p>
                    </div>
                </div>

                <?php $did = $_SESSION['userid']; ?>

                <!-- Row 1: Shipment counters -->
                <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-5">
                    <h3 class="tw-text-sm tw-font-semibold tw-text-gray-800 tw-mb-4"><?php echo $lang['dash-general-35'] ?></h3>
                    <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-3 tw-gap-4">
                        <!-- Shipments -->
                        <a href="courier_list.php" class="tw-flex tw-items-center tw-gap-3 tw-p-4 tw-rounded-lg tw-border tw-border-gray-100 hover:tw-border-orange-200 hover:tw-bg-orange-50/50 tw-transition-colors">
                            <div class="tw-w-11 tw-h-11 tw-rounded-lg tw-bg-orange-50 tw-flex tw-items-center tw-justify-center tw-shrink-0">
                                <i data-lucide="package" class="tw-w-5 tw-h-5 tw-text-orange-500"></i>
                            </div>
                            <div>
                                <p class="tw-text-2xl tw-font-bold tw-text-gray-800 tw-leading-none">
                                    <?php
                                    $db->cdp_query("SELECT COUNT(*) as total FROM cdb_add_order WHERE is_pickup=0 and driver_id='$did'");
                                    $db->cdp_execute();
                                    echo $db->cdp_registro()->total;
                                    ?>
                                </p>
                                <p class="tw-text-xs tw-text-gray-400 tw-mt-1"><?php echo $lang['dash-general-1'] ?></p>
                            </div>
                        </a>

                        <!-- Delivered -->
                        <a href="courier_list.php" class="tw-flex tw-items-center tw-gap-3 tw-p-4 tw-rounded-lg tw-border tw-border-gray-100 hover:tw-border-green-200 hover:tw-bg-green-50/50 tw-transition-colors">
                            <div class="tw-w-11 tw-h-11 tw-rounded-lg tw-bg-green-50 tw-flex tw-items-center tw-justify-center tw-shrink-0">
                                <i data-lucide="package-check" class="tw-w-5 tw-h-5 tw-text-green-500"></i>
                            </div>
                            <div>
                                <p class="tw-text-2xl tw-font-bold tw-text-gray-800 tw-leading-none">
                                    <?php
                                    $db->cdp_query("SELECT COUNT(*) as total FROM cdb_add_order WHERE status_courier=8 and is_pickup=0 and driver_id='$did'");
                                    $db->cdp_execute();
                                    echo $db->cdp_registro()->total;
                                    ?>
                                </p>
                                <p class="tw-text-xs tw-text-gray-400 tw-mt-1"><?php echo $lang['left20'] ?></p>
                            </div>
                        </a>

                        <!-- Consolidates -->
                        <a href="consolidate_list.php" class="tw-flex tw-items-center tw-gap-3 tw-p-4 tw-rounded-lg tw-border tw-border-gray-100 hover:tw-border-red-200 hover:tw-bg-red-50/50 tw-transition-colors">
                            <div class="tw-w-11 tw-h-11 tw-rounded-lg tw-bg-red-50 tw-flex tw-items-center tw-justify-center tw-shrink-0">
                                <i data-lucide="layers" class="tw-w-5 tw-h-5 tw-text-red-500"></i>
                            </div>
                            <div>
                                <p class="tw-text-2xl tw-font-bold tw-text-gray-800 tw-leading-none">
                                    <?php
                                    $db->cdp_query("SELECT COUNT(*) as total FROM cdb_consolidate WHERE driver_id='$did'");
                                    $db->cdp_execute();
                                    echo $db->cdp_registro()->total;
                                    ?>
                                </p>
                                <p class="tw-text-xs tw-text-gray-400 tw-mt-1"><?php echo $lang['dash-general-3'] ?></p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Row 2: Pickup status -->
                <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-5">
                    <h3 class="tw-text-sm tw-font-semibold tw-text-gray-800 tw-mb-4"><?php echo $lang['dash-general-36'] ?></h3>
                    <div class="tw-grid tw-grid-cols-2 sm:tw-grid-cols-4 tw-gap-3">
                        <?php
                        $driver_pickups = [
                            ['q' => "SELECT COUNT(*) as total FROM cdb_add_order WHERE is_pickup=1 and driver_id='$did'", 'label' => $lang['dash-general-1222'], 'icon' => 'clock', 'color' => 'cyan'],
                            ['q' => "SELECT COUNT(*) as total FROM cdb_add_order WHERE is_pickup=1 and status_courier=12 and driver_id='$did'", 'label' => $lang['dash-general-221'], 'icon' => 'loader', 'color' => 'amber'],
                            ['q' => "SELECT COUNT(*) as total FROM cdb_add_order WHERE is_pickup=1 and status_courier=21 and driver_id='$did'", 'label' => $lang['dash-general-222'], 'icon' => 'x-circle', 'color' => 'red'],
                            ['q' => "SELECT COUNT(*) as total FROM cdb_add_order WHERE status_courier=8 and is_pickup=1 and driver_id='$did'", 'label' => $lang['dash-general-220'], 'icon' => 'check-circle', 'color' => 'green'],
                        ];
                        foreach ($driver_pickups as $dp):
                            $db->cdp_query($dp['q']); $db->cdp_execute();
                            $dp_total = $db->cdp_registro()->total;
                        ?>
                        <a href="pickup_list.php" class="tw-flex tw-items-center tw-gap-3 tw-p-3 tw-rounded-lg tw-border tw-border-gray-100 hover:tw-border-<?php echo $dp['color']; ?>-200 hover:tw-bg-<?php echo $dp['color']; ?>-50/50 tw-transition-colors">
                            <div class="tw-w-10 tw-h-10 tw-rounded-lg tw-bg-<?php echo $dp['color']; ?>-50 tw-flex tw-items-center tw-justify-center tw-shrink-0">
                                <i data-lucide="<?php echo $dp['icon']; ?>" class="tw-w-4 tw-h-4 tw-text-<?php echo $dp['color']; ?>-500"></i>
                            </div>
                            <div>
                                <p class="tw-text-xl tw-font-bold tw-text-gray-800 tw-leading-none"><?php echo $dp_total; ?></p>
                                <p class="tw-text-[10px] tw-text-gray-400 tw-mt-0.5"><?php echo $dp['label']; ?></p>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Row 3: Recent shipments -->
                <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-5">
                    <h3 class="tw-text-sm tw-font-semibold tw-text-gray-800 tw-mb-4"><?php echo $lang['dash-general-19'] ?></h3>
                    <input type="hidden" name="userid" id="userid" value="<?php echo $_SESSION['userid']; ?>">
                    <div class="outer_div"></div>
                </div>

            </div>
            <?php include 'views/inc/footer.php'; ?>
        </div>
    </div>

    <script src="dataJs/dashboard_driver.js"></script>