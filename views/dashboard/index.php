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

// Obtener el mes y el año actual
$month = date('m');
$year = date('Y');

// Obtener el número del mes actual
$currentMonth = date('n');

// Obtener el nombre del mes actual
$monthName = obtenerNombreMes($currentMonth);

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
    <script src="assets/template/assets/extra-libs/chart.js-2.8/Chart.min.js"></script>

</head>

<body>
    <?php include 'views/inc/preloader.php'; ?>

    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->


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

            <!-- Modern Dashboard Content — Tailwind + Alpine.js -->
            <div class="tw-p-4 lg:tw-p-6 tw-space-y-6" x-data="{ activeTab: 'shipments' }">

                <!-- Page header -->
                <div class="tw-flex tw-flex-col sm:tw-flex-row sm:tw-items-center sm:tw-justify-between tw-gap-3">
                    <div>
                        <h1 class="tw-text-2xl tw-font-bold tw-text-gray-800"><?php echo $lang['left-menu-sidebar-2'] ?></h1>
                        <p class="tw-text-sm tw-text-gray-500"><?php echo $lang['messagesform90'] ?? 'Mois de'; ?> <?php echo $monthName; ?> <?php echo $year; ?></p>
                    </div>
                    <a href="courier_add.php" class="tw-inline-flex tw-items-center tw-gap-2 tw-px-4 tw-py-2 tw-bg-blue-600 tw-text-white tw-rounded-lg tw-text-sm tw-font-medium hover:tw-bg-blue-700 tw-transition-colors tw-shadow-sm">
                        <i data-lucide="plus" class="tw-w-4 tw-h-4"></i>
                        <?php echo $lang['left-menu-sidebar-1'] ?>
                    </a>
                </div>

                <!-- Row 1: Revenue + Monthly stats -->
                <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-4 tw-gap-4">

                    <!-- Revenue highlight -->
                    <div class="tw-bg-gradient-to-br tw-from-blue-600 tw-to-blue-700 tw-rounded-xl tw-p-5 tw-text-white tw-shadow-lg tw-relative tw-overflow-hidden">
                        <div class="tw-absolute tw-top-0 tw-right-0 tw-w-32 tw-h-32 tw-bg-white/10 tw-rounded-full tw--translate-y-8 tw-translate-x-8"></div>
                        <div class="tw-relative">
                            <div class="tw-flex tw-items-center tw-gap-2 tw-mb-3">
                                <i data-lucide="wallet" class="tw-w-5 tw-h-5 tw-opacity-80"></i>
                                <p class="tw-text-sm tw-font-medium tw-opacity-90"><?php echo $lang['messagesform84'] ?></p>
                            </div>
                            <p class="tw-text-3xl tw-font-bold tw-mb-1">
                                <?php
                                $sql = "SELECT IFNULL(SUM(total_order), 0) as total 
                                        FROM cdb_add_order 
                                        WHERE status_courier != 21 
                                        AND status_invoice != 0 
                                        AND order_payment_method > 1 
                                        AND MONTH(order_date) = :month 
                                        AND YEAR(order_date) = :year";
                                $db->cdp_query($sql);
                                $db->bind(':month', $month);
                                $db->bind(':year', $year);
                                $db->cdp_execute();
                                $count = $db->cdp_registro();
                                $revenue_total = $count->total;
                                echo $core->currency . ' ' . cdb_money_format($revenue_total);
                                ?>
                            </p>
                            <a href="dashboard_admin_account.php" class="tw-inline-flex tw-items-center tw-gap-1 tw-text-xs tw-font-medium tw-text-white/80 hover:tw-text-white tw-mt-2 tw-transition-colors">
                                <?php echo $lang['messagesform83'] ?>
                                <i data-lucide="arrow-right" class="tw-w-3 tw-h-3"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Pickup revenue -->
                    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-p-5 tw-shadow-sm">
                        <div class="tw-flex tw-items-center tw-gap-3">
                            <div class="tw-w-10 tw-h-10 tw-rounded-lg tw-bg-cyan-50 tw-flex tw-items-center tw-justify-center tw-shrink-0">
                                <i data-lucide="truck" class="tw-w-5 tw-h-5 tw-text-cyan-600"></i>
                            </div>
                            <div>
                                <p class="tw-text-xs tw-text-gray-500"><?php echo $lang['dash-general-11'] ?></p>
                                <p class="tw-text-lg tw-font-bold tw-text-gray-800">
                                    <?php echo $core->currency; ?>
                                    <?php
                                    $db->cdp_query('SELECT IFNULL(SUM(total_order),0) as total FROM cdb_add_order where status_courier != 21 and order_incomplete != 0 and is_pickup = 1 AND MONTH(order_date) = :month AND YEAR(order_date) = :year');
                                    $db->bind(':month', $month);
                                    $db->bind(':year', $year);
                                    $db->cdp_execute();
                                    $count = $db->cdp_registro();
                                    $sum2 = $count->total;
                                    echo cdb_money_format($sum2);
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Shipments revenue -->
                    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-p-5 tw-shadow-sm">
                        <div class="tw-flex tw-items-center tw-gap-3">
                            <div class="tw-w-10 tw-h-10 tw-rounded-lg tw-bg-blue-50 tw-flex tw-items-center tw-justify-center tw-shrink-0">
                                <i data-lucide="package" class="tw-w-5 tw-h-5 tw-text-blue-600"></i>
                            </div>
                            <div>
                                <p class="tw-text-xs tw-text-gray-500"><?php echo $lang['dash-general-10'] ?></p>
                                <p class="tw-text-lg tw-font-bold tw-text-gray-800">
                                    <?php echo $core->currency; ?>
                                    <?php
                                    $db->cdp_query('SELECT IFNULL(SUM(total_order),0) as total FROM cdb_add_order where status_courier != 21 and is_pickup = 0 AND MONTH(order_date) = :month AND YEAR(order_date) = :year');
                                    $db->bind(':month', $month);
                                    $db->bind(':year', $year);
                                    $db->cdp_execute();
                                    $count = $db->cdp_registro();
                                    $sum1 = $count->total;
                                    echo cdb_money_format($sum1);
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Packages revenue -->
                    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-p-5 tw-shadow-sm">
                        <div class="tw-flex tw-items-center tw-gap-3">
                            <div class="tw-w-10 tw-h-10 tw-rounded-lg tw-bg-green-50 tw-flex tw-items-center tw-justify-center tw-shrink-0">
                                <i data-lucide="shopping-bag" class="tw-w-5 tw-h-5 tw-text-green-600"></i>
                            </div>
                            <div>
                                <p class="tw-text-xs tw-text-gray-500"><?php echo $lang['messagesform85'] ?></p>
                                <p class="tw-text-lg tw-font-bold tw-text-gray-800">
                                    <?php echo $core->currency; ?>
                                    <?php
                                    $db->cdp_query('SELECT IFNULL(SUM(total_order),0) as total FROM cdb_customers_packages where status_courier != 21 AND MONTH(order_date) = :month AND YEAR(order_date) = :year');
                                    $db->bind(':month', $month);
                                    $db->bind(':year', $year);
                                    $db->cdp_execute();
                                    $count1 = $db->cdp_registro();
                                    $sum3 = $count1->total;
                                    echo cdb_money_format($sum3);
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Earning Reports + Counters + Users -->
                <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-4">

                    <!-- Earning Reports -->
                    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-5">
                        <div class="tw-flex tw-items-center tw-justify-between tw-mb-4">
                            <div>
                                <h3 class="tw-text-sm tw-font-semibold tw-text-gray-800"><?php echo $lang['messagesform95'] ?></h3>
                                <p class="tw-text-xs tw-text-gray-400"><?php echo $lang['messagesform96'] ?? ''; ?> <?php echo $monthName; ?></p>
                            </div>
                        </div>
                        <div class="tw-space-y-4">
                            <?php
                            // Pickup earnings
                            $db->cdp_query('SELECT IFNULL(SUM(total_order),0) as total FROM cdb_add_order where status_courier != 21 and order_incomplete != 0 and is_pickup = 1 AND MONTH(order_date) = :month AND YEAR(order_date) = :year');
                            $db->bind(':month', $month); $db->bind(':year', $year); $db->cdp_execute();
                            $total_orders = $db->cdp_registro()->total;
                            $totalDays = date('t');
                            $pct1 = min(100, ($total_orders / max(1, $totalDays)) * 100);
                            ?>
                            <div>
                                <div class="tw-flex tw-items-center tw-justify-between tw-mb-1">
                                    <span class="tw-text-xs tw-font-medium tw-text-gray-600"><?php echo $lang['dash-general-11'] ?></span>
                                    <span class="tw-text-xs tw-font-bold tw-text-gray-800"><?php echo $core->currency . ' ' . cdb_money_format($total_orders); ?></span>
                                </div>
                                <div class="tw-w-full tw-h-2 tw-bg-gray-100 tw-rounded-full tw-overflow-hidden">
                                    <div class="tw-h-full tw-bg-cyan-500 tw-rounded-full tw-transition-all" style="width: <?php echo $pct1; ?>%"></div>
                                </div>
                            </div>

                            <?php
                            // Shipments earnings
                            $db->cdp_query('SELECT IFNULL(SUM(total_order),0) as total FROM cdb_add_order where status_courier != 21 and is_pickup = 0 AND MONTH(order_date) = :month AND YEAR(order_date) = :year');
                            $db->bind(':month', $month); $db->bind(':year', $year); $db->cdp_execute();
                            $total_orders2 = $db->cdp_registro()->total;
                            $pct2 = min(100, ($total_orders2 / max(1, $totalDays)) * 100);
                            ?>
                            <div>
                                <div class="tw-flex tw-items-center tw-justify-between tw-mb-1">
                                    <span class="tw-text-xs tw-font-medium tw-text-gray-600"><?php echo $lang['dash-general-10'] ?></span>
                                    <span class="tw-text-xs tw-font-bold tw-text-gray-800"><?php echo $core->currency . ' ' . cdb_money_format($total_orders2); ?></span>
                                </div>
                                <div class="tw-w-full tw-h-2 tw-bg-gray-100 tw-rounded-full tw-overflow-hidden">
                                    <div class="tw-h-full tw-bg-blue-500 tw-rounded-full tw-transition-all" style="width: <?php echo $pct2; ?>%"></div>
                                </div>
                            </div>

                            <?php
                            // Consolidate earnings
                            $db->cdp_query('SELECT IFNULL(SUM(total_order),0) as total FROM cdb_consolidate where status_courier != 21 AND MONTH(c_date) = :month AND YEAR(c_date) = :year');
                            $db->bind(':month', $month); $db->bind(':year', $year); $db->cdp_execute();
                            $total_orders3 = $db->cdp_registro()->total;
                            $pct3 = min(100, ($total_orders3 / max(1, $totalDays)) * 100);
                            ?>
                            <div>
                                <div class="tw-flex tw-items-center tw-justify-between tw-mb-1">
                                    <span class="tw-text-xs tw-font-medium tw-text-gray-600"><?php echo $lang['messagesform94'] ?? 'Consolidés'; ?></span>
                                    <span class="tw-text-xs tw-font-bold tw-text-gray-800"><?php echo $core->currency . ' ' . cdb_money_format($total_orders3); ?></span>
                                </div>
                                <div class="tw-w-full tw-h-2 tw-bg-gray-100 tw-rounded-full tw-overflow-hidden">
                                    <div class="tw-h-full tw-bg-red-400 tw-rounded-full tw-transition-all" style="width: <?php echo $pct3; ?>%"></div>
                                </div>
                            </div>

                            <?php
                            // Consolidate packages earnings
                            $db->cdp_query('SELECT IFNULL(SUM(total_order),0) as total FROM cdb_consolidate_packages where status_courier != 21 AND MONTH(c_date) = :month AND YEAR(c_date) = :year');
                            $db->bind(':month', $month); $db->bind(':year', $year); $db->cdp_execute();
                            $total_orders4 = $db->cdp_registro()->total;
                            $pct4 = min(100, ($total_orders4 / max(1, $totalDays)) * 100);
                            ?>
                            <div>
                                <div class="tw-flex tw-items-center tw-justify-between tw-mb-1">
                                    <span class="tw-text-xs tw-font-medium tw-text-gray-600"><?php echo $lang['messagesform93'] ?? 'Colis consolidés'; ?></span>
                                    <span class="tw-text-xs tw-font-bold tw-text-gray-800"><?php echo $core->currency . ' ' . cdb_money_format($total_orders4); ?></span>
                                </div>
                                <div class="tw-w-full tw-h-2 tw-bg-gray-100 tw-rounded-full tw-overflow-hidden">
                                    <div class="tw-h-full tw-bg-orange-400 tw-rounded-full tw-transition-all" style="width: <?php echo $pct4; ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Counters -->
                    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-5">
                        <div class="tw-mb-4">
                            <h3 class="tw-text-sm tw-font-semibold tw-text-gray-800"><?php echo $lang['messagesform91'] ?? 'Statistiques'; ?></h3>
                            <p class="tw-text-xs tw-text-gray-400"><?php echo $lang['messagesform92'] ?? ''; ?></p>
                        </div>
                        <div class="tw-grid tw-grid-cols-2 tw-gap-3">
                            <!-- Shipments -->
                            <a href="dashboard_admin_shipments.php" class="tw-flex tw-items-center tw-gap-3 tw-p-3 tw-rounded-lg tw-border tw-border-gray-100 hover:tw-border-blue-200 hover:tw-bg-blue-50/50 tw-transition-colors">
                                <div class="tw-w-9 tw-h-9 tw-rounded-lg tw-bg-orange-50 tw-flex tw-items-center tw-justify-center tw-shrink-0">
                                    <i data-lucide="package" class="tw-w-4 tw-h-4 tw-text-orange-500"></i>
                                </div>
                                <div>
                                    <p class="tw-text-lg tw-font-bold tw-text-gray-800 tw-leading-none">
                                        <?php
                                        $db->cdp_query('SELECT COUNT(*) as total FROM cdb_add_order WHERE order_incomplete=1');
                                        $db->cdp_execute();
                                        echo $db->cdp_registro()->total;
                                        ?>
                                    </p>
                                    <p class="tw-text-[10px] tw-text-gray-400 tw-mt-0.5"><?php echo $lang['dash-general-1'] ?></p>
                                </div>
                            </a>

                            <!-- Pickups -->
                            <a href="pickup_list.php" class="tw-flex tw-items-center tw-gap-3 tw-p-3 tw-rounded-lg tw-border tw-border-gray-100 hover:tw-border-cyan-200 hover:tw-bg-cyan-50/50 tw-transition-colors">
                                <div class="tw-w-9 tw-h-9 tw-rounded-lg tw-bg-cyan-50 tw-flex tw-items-center tw-justify-center tw-shrink-0">
                                    <i data-lucide="truck" class="tw-w-4 tw-h-4 tw-text-cyan-500"></i>
                                </div>
                                <div>
                                    <p class="tw-text-lg tw-font-bold tw-text-gray-800 tw-leading-none">
                                        <?php
                                        $db->cdp_query('SELECT COUNT(*) as total FROM cdb_add_order WHERE order_incomplete != 0 and is_pickup=1');
                                        $db->cdp_execute();
                                        echo $db->cdp_registro()->total;
                                        ?>
                                    </p>
                                    <p class="tw-text-[10px] tw-text-gray-400 tw-mt-0.5"><?php echo $lang['dash-general-2'] ?></p>
                                </div>
                            </a>

                            <!-- Consolidates -->
                            <a href="consolidate_list.php" class="tw-flex tw-items-center tw-gap-3 tw-p-3 tw-rounded-lg tw-border tw-border-gray-100 hover:tw-border-red-200 hover:tw-bg-red-50/50 tw-transition-colors">
                                <div class="tw-w-9 tw-h-9 tw-rounded-lg tw-bg-red-50 tw-flex tw-items-center tw-justify-center tw-shrink-0">
                                    <i data-lucide="layers" class="tw-w-4 tw-h-4 tw-text-red-500"></i>
                                </div>
                                <div>
                                    <p class="tw-text-lg tw-font-bold tw-text-gray-800 tw-leading-none">
                                        <?php
                                        $db->cdp_query('SELECT COUNT(*) as total FROM cdb_consolidate');
                                        $db->cdp_execute();
                                        echo $db->cdp_registro()->total;
                                        ?>
                                    </p>
                                    <p class="tw-text-[10px] tw-text-gray-400 tw-mt-0.5"><?php echo $lang['dash-general-3'] ?></p>
                                </div>
                            </a>

                            <!-- Accounts receivable -->
                            <a href="accounts_receivable.php" class="tw-flex tw-items-center tw-gap-3 tw-p-3 tw-rounded-lg tw-border tw-border-gray-100 hover:tw-border-blue-200 hover:tw-bg-blue-50/50 tw-transition-colors">
                                <div class="tw-w-9 tw-h-9 tw-rounded-lg tw-bg-blue-50 tw-flex tw-items-center tw-justify-center tw-shrink-0">
                                    <i data-lucide="receipt" class="tw-w-4 tw-h-4 tw-text-blue-500"></i>
                                </div>
                                <div>
                                    <p class="tw-text-lg tw-font-bold tw-text-gray-800 tw-leading-none">
                                        <?php
                                        $db->cdp_query('SELECT COUNT(*) as total FROM cdb_add_order WHERE order_payment_method >1');
                                        $db->cdp_execute();
                                        echo $db->cdp_registro()->total;
                                        ?>
                                    </p>
                                    <p class="tw-text-[10px] tw-text-gray-400 tw-mt-0.5"><?php echo $lang['dash-general-4'] ?></p>
                                </div>
                            </a>

                            <!-- Pre-alerts -->
                            <a href="prealert_list.php" class="tw-flex tw-items-center tw-gap-3 tw-p-3 tw-rounded-lg tw-border tw-border-gray-100 hover:tw-border-amber-200 hover:tw-bg-amber-50/50 tw-transition-colors">
                                <div class="tw-w-9 tw-h-9 tw-rounded-lg tw-bg-amber-50 tw-flex tw-items-center tw-justify-center tw-shrink-0">
                                    <i data-lucide="bell-ring" class="tw-w-4 tw-h-4 tw-text-amber-500"></i>
                                </div>
                                <div>
                                    <p class="tw-text-lg tw-font-bold tw-text-gray-800 tw-leading-none">
                                        <?php
                                        $db->cdp_query('SELECT COUNT(*) as total FROM cdb_pre_alert where is_package=0');
                                        $db->cdp_execute();
                                        echo $db->cdp_registro()->total;
                                        ?>
                                    </p>
                                    <p class="tw-text-[10px] tw-text-gray-400 tw-mt-0.5"><?php echo $lang['dash-general-5'] ?></p>
                                </div>
                            </a>

                            <!-- Customer packages -->
                            <a href="customer_packages_list.php" class="tw-flex tw-items-center tw-gap-3 tw-p-3 tw-rounded-lg tw-border tw-border-gray-100 hover:tw-border-green-200 hover:tw-bg-green-50/50 tw-transition-colors">
                                <div class="tw-w-9 tw-h-9 tw-rounded-lg tw-bg-green-50 tw-flex tw-items-center tw-justify-center tw-shrink-0">
                                    <i data-lucide="box" class="tw-w-4 tw-h-4 tw-text-green-500"></i>
                                </div>
                                <div>
                                    <p class="tw-text-lg tw-font-bold tw-text-gray-800 tw-leading-none">
                                        <?php
                                        $db->cdp_query('SELECT COUNT(*) as total FROM cdb_customers_packages');
                                        $db->cdp_execute();
                                        echo $db->cdp_registro()->total;
                                        ?>
                                    </p>
                                    <p class="tw-text-[10px] tw-text-gray-400 tw-mt-0.5"><?php echo $lang['dash-general-661'] ?></p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Users / Team -->
                    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-5">
                        <div class="tw-mb-4">
                            <h3 class="tw-text-sm tw-font-semibold tw-text-gray-800"><?php echo $lang['messagesform97'] ?? 'Équipe'; ?></h3>
                            <p class="tw-text-xs tw-text-gray-400"><?php echo $lang['messagesform98'] ?? ''; ?></p>
                        </div>
                        <div class="tw-space-y-3">
                            <?php
                            $user_roles = [
                                ['level' => 9, 'label' => $lang['dash-general-14'], 'icon' => 'shield', 'color' => 'purple'],
                                ['level' => 2, 'label' => $lang['dash-general-15'], 'icon' => 'users', 'color' => 'blue'],
                                ['level' => 3, 'label' => $lang['dash-general-16'], 'icon' => 'car', 'color' => 'cyan'],
                                ['level' => 1, 'label' => $lang['dash-general-17'], 'icon' => 'user-plus', 'color' => 'green'],
                            ];
                            foreach ($user_roles as $role):
                                $db->cdp_query('SELECT COUNT(*) as total FROM cdb_users WHERE userlevel=' . intval($role['level']));
                                $db->cdp_execute();
                                $role_count = $db->cdp_registro()->total;
                            ?>
                            <div class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-rounded-lg tw-border tw-border-gray-100">
                                <div class="tw-flex tw-items-center tw-gap-3">
                                    <div class="tw-w-9 tw-h-9 tw-rounded-lg tw-bg-<?php echo $role['color']; ?>-50 tw-flex tw-items-center tw-justify-center">
                                        <i data-lucide="<?php echo $role['icon']; ?>" class="tw-w-4 tw-h-4 tw-text-<?php echo $role['color']; ?>-500"></i>
                                    </div>
                                    <span class="tw-text-sm tw-text-gray-600"><?php echo $role['label']; ?></span>
                                </div>
                                <span class="tw-text-lg tw-font-bold tw-text-gray-800"><?php echo $role_count; ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Row 3: Quick access tabs + search -->
                <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-overflow-hidden">
                    <!-- Tab navigation -->
                    <div class="tw-flex tw-items-center tw-gap-1 tw-px-4 tw-pt-4 tw-pb-0 tw-overflow-x-auto tw-border-b tw-border-gray-100">
                        <button @click="activeTab = 'shipments'" :class="activeTab === 'shipments' ? 'tw-text-blue-600 tw-border-blue-600' : 'tw-text-gray-500 tw-border-transparent hover:tw-text-gray-700'"
                                class="tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-border-b-2 tw-transition-colors tw-whitespace-nowrap">
                            <?php echo $lang['dash-general-19'] ?>
                        </button>
                        <a href="pickup_list.php" class="tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-500 tw-border-b-2 tw-border-transparent hover:tw-text-gray-700 tw-transition-colors tw-whitespace-nowrap">
                            <?php echo $lang['dash-general-20'] ?>
                        </a>
                        <a href="consolidate_list.php" class="tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-500 tw-border-b-2 tw-border-transparent hover:tw-text-gray-700 tw-transition-colors tw-whitespace-nowrap">
                            <?php echo $lang['dash-general-21'] ?>
                        </a>
                        <a href="prealert_list.php" class="tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-500 tw-border-b-2 tw-border-transparent hover:tw-text-gray-700 tw-transition-colors tw-whitespace-nowrap">
                            <?php echo $lang['dash-general-22'] ?>
                        </a>
                        <a href="customer_packages_list.php" class="tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-500 tw-border-b-2 tw-border-transparent hover:tw-text-gray-700 tw-transition-colors tw-whitespace-nowrap">
                            <?php echo $lang['dash-general-23'] ?>
                        </a>
                    </div>

                    <!-- Tab content -->
                    <div class="tw-p-4">
                        <!-- Shipments tab -->
                        <div x-show="activeTab === 'shipments'">
                            <div class="tw-mb-4">
                                <div class="tw-relative tw-max-w-md">
                                    <i data-lucide="search" class="tw-absolute tw-left-3 tw-top-1/2 tw--translate-y-1/2 tw-w-4 tw-h-4 tw-text-gray-400"></i>
                                    <input type="text" name="search_shipment" id="search_shipment" 
                                           class="tw-w-full tw-pl-10 tw-pr-4 tw-py-2 tw-border tw-border-gray-200 tw-rounded-lg tw-text-sm tw-text-gray-700 tw-placeholder-gray-400 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-500/20 focus:tw-border-blue-400 tw-transition-all" 
                                           placeholder="<?php echo $lang['left21551'] ?>" onkeyup="cdp_load(1);">
                                </div>
                            </div>
                            <div class="results_shipments"></div>
                        </div>
                    </div>
                </div>

            </div>
            <?php include 'views/inc/footer.php'; ?>
        </div>
    </div>

    <script src="dataJs/dashboard_index.js"></script>