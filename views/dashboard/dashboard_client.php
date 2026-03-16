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


$sql = "SELECT * FROM cdb_add_order where status_courier!=21 and order_payment_method >1  and sender_id='" . $_SESSION['userid'] . "' ";



$db->cdp_query($sql);
$data = $db->cdp_registros();




$count = 0;
$sumador_pendiente = 0;
$sumador_total = 0;
$sumador_pagado = 0;

foreach ($data as $row) {



    $db->cdp_query('SELECT  IFNULL(sum(total), 0)  as total  FROM cdb_charges_order WHERE order_id=:order_id');

    $db->bind(':order_id', $row->order_id);

    $db->cdp_execute();

    $sum_payment = $db->cdp_registro();

    $pendiente = $row->total_order - $sum_payment->total;

    $sumador_pendiente += $pendiente;
    $sumador_total += $row->total_order;
    $sumador_pagado += $sum_payment->total;


    $count++;
}


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
            <!-- Modern Client Dashboard — Tailwind + Alpine.js -->
            <div class="tw-p-4 lg:tw-p-6 tw-space-y-6" x-data="{ activeTab: 'shipments' }">

                <!-- Welcome banner -->
                <div class="tw-bg-gradient-to-r tw-from-blue-600 tw-to-indigo-600 tw-rounded-xl tw-p-5 tw-text-white tw-relative tw-overflow-hidden">
                    <div class="tw-absolute tw-top-0 tw-right-0 tw-w-40 tw-h-40 tw-bg-white/10 tw-rounded-full tw--translate-y-12 tw-translate-x-12"></div>
                    <div class="tw-relative">
                        <h1 class="tw-text-xl tw-font-bold tw-mb-1"><?php echo $lang['left-menu-sidebar-2'] ?></h1>
                        <p class="tw-text-sm tw-text-blue-200"><?php echo htmlspecialchars($userData->fname ?? $userData->username); ?></p>
                    </div>
                </div>

                <!-- Row 1: Locker card + Financial summary -->
                <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-4">

                    <!-- Virtual Locker Card -->
                    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-5">
                        <div class="tw-flex tw-items-center tw-gap-3 tw-mb-4">
                            <div class="tw-w-10 tw-h-10 tw-rounded-lg tw-bg-blue-50 tw-flex tw-items-center tw-justify-center">
                                <i data-lucide="mail" class="tw-w-5 tw-h-5 tw-text-blue-600"></i>
                            </div>
                            <h3 class="tw-text-sm tw-font-semibold tw-text-gray-800"><?php echo $lang['dash-general-34'] ?></h3>
                        </div>
                        <div class="tw-space-y-3">
                            <div class="tw-flex tw-items-center tw-justify-between tw-py-2 tw-border-b tw-border-gray-100">
                                <span class="tw-text-xs tw-text-gray-500"><?php echo $lang['dash-general-38'] ?></span>
                                <span class="tw-text-xs tw-font-medium tw-text-gray-700"><?php echo $core->locker_address; ?></span>
                            </div>
                            <div class="tw-flex tw-items-center tw-justify-between tw-py-2 tw-border-b tw-border-gray-100">
                                <span class="tw-text-xs tw-text-gray-500"><?php echo $lang['dash-general-39'] ?></span>
                                <span class="tw-text-sm tw-font-bold tw-text-blue-600 tw-bg-blue-50 tw-px-2 tw-py-0.5 tw-rounded"><?php echo htmlspecialchars($userData->locker); ?></span>
                            </div>
                            <div class="tw-flex tw-items-center tw-justify-between tw-py-2 tw-border-b tw-border-gray-100">
                                <span class="tw-text-xs tw-text-gray-500"><?php echo $lang['left92'] ?></span>
                                <span class="tw-text-xs tw-font-medium tw-text-gray-700"><?php echo $core->c_city; ?></span>
                            </div>
                            <div class="tw-flex tw-items-center tw-justify-between tw-py-2">
                                <span class="tw-text-xs tw-text-gray-500"><?php echo $lang['left94'] ?></span>
                                <span class="tw-text-xs tw-font-medium tw-text-gray-700"><?php echo $core->c_postal; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Summary -->
                    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-5">
                        <h3 class="tw-text-sm tw-font-semibold tw-text-gray-800 tw-mb-4"><?php echo $lang['messagesform91'] ?? 'Résumé financier'; ?></h3>
                        <div class="tw-space-y-3">
                            <div class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-rounded-lg tw-bg-green-50 tw-border tw-border-green-100">
                                <div class="tw-flex tw-items-center tw-gap-2">
                                    <i data-lucide="check-circle" class="tw-w-4 tw-h-4 tw-text-green-500"></i>
                                    <span class="tw-text-xs tw-text-green-700">Payé</span>
                                </div>
                                <span class="tw-text-sm tw-font-bold tw-text-green-700"><?php echo $core->currency . ' ' . cdb_money_format($sumador_pagado); ?></span>
                            </div>
                            <div class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-rounded-lg tw-bg-amber-50 tw-border tw-border-amber-100">
                                <div class="tw-flex tw-items-center tw-gap-2">
                                    <i data-lucide="clock" class="tw-w-4 tw-h-4 tw-text-amber-500"></i>
                                    <span class="tw-text-xs tw-text-amber-700">En attente</span>
                                </div>
                                <span class="tw-text-sm tw-font-bold tw-text-amber-700"><?php echo $core->currency . ' ' . cdb_money_format($sumador_pendiente); ?></span>
                            </div>
                            <div class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-rounded-lg tw-bg-blue-50 tw-border tw-border-blue-100">
                                <div class="tw-flex tw-items-center tw-gap-2">
                                    <i data-lucide="wallet" class="tw-w-4 tw-h-4 tw-text-blue-500"></i>
                                    <span class="tw-text-xs tw-text-blue-700">Total</span>
                                </div>
                                <span class="tw-text-sm tw-font-bold tw-text-blue-700"><?php echo $core->currency . ' ' . cdb_money_format($sumador_total); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Counters -->
                    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-5">
                        <h3 class="tw-text-sm tw-font-semibold tw-text-gray-800 tw-mb-4"><?php echo $lang['messagesform92'] ?? 'Activité'; ?></h3>
                        <div class="tw-grid tw-grid-cols-2 tw-gap-2">
                            <?php
                            $uid = $_SESSION['userid'];
                            $client_counters = [
                                ['q' => "SELECT COUNT(*) as total FROM cdb_add_order WHERE order_incomplete=1 and sender_id='$uid'", 'label' => $lang['dash-general-1'], 'icon' => 'package', 'color' => 'orange', 'href' => 'courier_list.php'],
                                ['q' => "SELECT COUNT(*) as total FROM cdb_add_order WHERE order_incomplete != 0 and is_pickup=1 and sender_id='$uid'", 'label' => $lang['dash-general-2'], 'icon' => 'truck', 'color' => 'cyan', 'href' => 'pickup_list.php'],
                                ['q' => "SELECT COUNT(*) as total FROM cdb_consolidate WHERE sender_id='$uid'", 'label' => $lang['dash-general-3'], 'icon' => 'layers', 'color' => 'red', 'href' => 'consolidate_list.php'],
                                ['q' => "SELECT COUNT(*) as total FROM cdb_add_order WHERE status_courier=8 and sender_id='$uid'", 'label' => $lang['dash-general-25'], 'icon' => 'package-check', 'color' => 'green', 'href' => 'courier_list.php'],
                                ['q' => "SELECT COUNT(*) as total FROM cdb_pre_alert where is_package=0 and customer_id='$uid'", 'label' => $lang['dash-general-5'], 'icon' => 'bell-ring', 'color' => 'amber', 'href' => 'prealert_list.php'],
                                ['q' => "SELECT COUNT(*) as total FROM cdb_customers_packages where sender_id='$uid'", 'label' => $lang['dash-general-661'], 'icon' => 'box', 'color' => 'green', 'href' => 'customer_packages_list.php'],
                            ];
                            foreach ($client_counters as $cc):
                                $db->cdp_query($cc['q']); $db->cdp_execute();
                                $cc_total = $db->cdp_registro()->total;
                            ?>
                            <a href="<?php echo $cc['href']; ?>" class="tw-flex tw-items-center tw-gap-2 tw-p-2.5 tw-rounded-lg tw-border tw-border-gray-100 hover:tw-border-<?php echo $cc['color']; ?>-200 hover:tw-bg-<?php echo $cc['color']; ?>-50/50 tw-transition-colors">
                                <div class="tw-w-8 tw-h-8 tw-rounded-lg tw-bg-<?php echo $cc['color']; ?>-50 tw-flex tw-items-center tw-justify-center tw-shrink-0">
                                    <i data-lucide="<?php echo $cc['icon']; ?>" class="tw-w-3.5 tw-h-3.5 tw-text-<?php echo $cc['color']; ?>-500"></i>
                                </div>
                                <div>
                                    <p class="tw-text-base tw-font-bold tw-text-gray-800 tw-leading-none"><?php echo $cc_total; ?></p>
                                    <p class="tw-text-[9px] tw-text-gray-400 tw-mt-0.5"><?php echo $cc['label']; ?></p>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Pickup Status -->
                <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-5">
                    <h3 class="tw-text-sm tw-font-semibold tw-text-gray-800 tw-mb-4"><?php echo $lang['dash-general-36'] ?? 'Statut des ramassages'; ?></h3>
                    <div class="tw-grid tw-grid-cols-2 sm:tw-grid-cols-4 tw-gap-3">
                        <?php
                        $pickup_statuses = [
                            ['q' => "SELECT COUNT(*) as total FROM cdb_add_order WHERE is_pickup=1 and order_incomplete=1 and sender_id='$uid'", 'label' => $lang['dash-general-2'], 'icon' => 'clock', 'color' => 'cyan'],
                            ['q' => "SELECT COUNT(*) as total FROM cdb_add_order WHERE is_pickup=1 and status_courier=12 and sender_id='$uid'", 'label' => $lang['dash-general-221'], 'icon' => 'loader', 'color' => 'amber'],
                            ['q' => "SELECT COUNT(*) as total FROM cdb_add_order WHERE is_pickup=1 and status_courier=21 and sender_id='$uid'", 'label' => $lang['dash-general-222'], 'icon' => 'x-circle', 'color' => 'red'],
                            ['q' => "SELECT COUNT(*) as total FROM cdb_add_order WHERE status_courier=8 and is_pickup=1 and sender_id='$uid'", 'label' => $lang['dash-general-220'], 'icon' => 'check-circle', 'color' => 'green'],
                        ];
                        foreach ($pickup_statuses as $ps):
                            $db->cdp_query($ps['q']); $db->cdp_execute();
                            $ps_total = $db->cdp_registro()->total;
                        ?>
                        <div class="tw-flex tw-items-center tw-gap-3 tw-p-3 tw-rounded-lg tw-border tw-border-gray-100">
                            <div class="tw-w-9 tw-h-9 tw-rounded-lg tw-bg-<?php echo $ps['color']; ?>-50 tw-flex tw-items-center tw-justify-center tw-shrink-0">
                                <i data-lucide="<?php echo $ps['icon']; ?>" class="tw-w-4 tw-h-4 tw-text-<?php echo $ps['color']; ?>-500"></i>
                            </div>
                            <div>
                                <p class="tw-text-lg tw-font-bold tw-text-gray-800 tw-leading-none"><?php echo $ps_total; ?></p>
                                <p class="tw-text-[10px] tw-text-gray-400 tw-mt-0.5"><?php echo $ps['label']; ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Row 3: Shipments list with tabs -->
                <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-overflow-hidden">
                    <div class="tw-flex tw-items-center tw-gap-1 tw-px-4 tw-pt-4 tw-pb-0 tw-overflow-x-auto tw-border-b tw-border-gray-100">
                        <button @click="activeTab = 'shipments'" :class="activeTab === 'shipments' ? 'tw-text-blue-600 tw-border-blue-600' : 'tw-text-gray-500 tw-border-transparent hover:tw-text-gray-700'"
                                class="tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-border-b-2 tw-transition-colors tw-whitespace-nowrap">
                            <?php echo $lang['dash-general-19'] ?>
                        </button>
                        <a href="prealert_list.php" class="tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-500 tw-border-b-2 tw-border-transparent hover:tw-text-gray-700 tw-transition-colors tw-whitespace-nowrap">
                            <?php echo $lang['dash-general-22'] ?>
                        </a>
                        <a href="customer_packages_list.php" class="tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-500 tw-border-b-2 tw-border-transparent hover:tw-text-gray-700 tw-transition-colors tw-whitespace-nowrap">
                            <?php echo $lang['dash-general-23'] ?>
                        </a>
                        <a href="consolidate_list.php" class="tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-500 tw-border-b-2 tw-border-transparent hover:tw-text-gray-700 tw-transition-colors tw-whitespace-nowrap">
                            <?php echo $lang['dash-general-21'] ?>
                        </a>
                    </div>
                    <div class="tw-p-4">
                        <input type="hidden" name="userid" id="userid" value="<?php echo $_SESSION['userid']; ?>">
                        <div x-show="activeTab === 'shipments'">
                            <div class="outer_div"></div>
                        </div>
                    </div>
                </div>

            </div>
            <?php include 'views/inc/footer.php'; ?>
        </div>
    </div>

    <script src="dataJs/dashboard_client.js"></script>