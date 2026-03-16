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

?>
<!DOCTYPE html>
<html dir="<?php echo $direction_layout; ?>" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon ?>">
    <title><?php echo $lang['report-general01'] ?> | <?php echo $core->site_name ?></title>
    <?php include 'views/inc/head_scripts.php'; ?>
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->


    <?php include 'views/inc/preloader.php'; ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
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
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <div class="tw-p-4 lg:tw-p-6 tw-space-y-6">

                <div class="tw-flex tw-items-center tw-gap-3">
                    <h1 class="tw-text-2xl tw-font-bold tw-text-gray-800"><?php echo $lang['report-general01'] ?></h1>
                </div>

                <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-3 tw-gap-4">

                    <!-- ONLINE SHIPPING -->
                    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-5">
                        <div class="tw-flex tw-items-center tw-gap-3 tw-mb-1">
                            <i data-lucide="shopping-cart" class="tw-w-5 tw-h-5 tw-text-gray-400"></i>
                            <h3 class="tw-font-semibold tw-text-gray-800"><?php echo $lang['report-general02'] ?></h3>
                        </div>
                        <p class="tw-text-xs tw-text-gray-500 tw-mb-3"><?php echo $lang['report-general07'] ?></p>
                        <ul class="tw-space-y-2">
                            <li><a href="report_packages_registered.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general03'] ?></a></li>
                            <?php if ($user->userlevel == 9 || $user->userlevel == 2) { ?>
                            <li><a href="report_packages_registered_employee.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general04'] ?></a></li>
                            <li><a href="report_packages_registered_agency.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general05'] ?></a></li>
                            <li><a href="report_packages_registered_driver.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general06'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>

                    <!-- SHIPMENT -->
                    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-5">
                        <div class="tw-flex tw-items-center tw-gap-3 tw-mb-1">
                            <i data-lucide="package" class="tw-w-5 tw-h-5 tw-text-gray-400"></i>
                            <h3 class="tw-font-semibold tw-text-gray-800"><?php echo $lang['report-general08'] ?></h3>
                        </div>
                        <p class="tw-text-xs tw-text-gray-500 tw-mb-3"><?php echo $lang['report-general09'] ?></p>
                        <ul class="tw-space-y-2">
                            <li><a href="report_general.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general010'] ?></a></li>
                            <?php if ($user->userlevel == 9 || $user->userlevel == 2) { ?>
                            <li><a href="report_customer.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general011'] ?></a></li>
                            <li><a href="report_employees.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general012'] ?></a></li>
                            <li><a href="report_agency.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general013'] ?></a></li>
                            <li><a href="report_driver_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general014'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>

                    <!-- PICK UP SHIPMENT -->
                    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-5">
                        <div class="tw-flex tw-items-center tw-gap-3 tw-mb-1">
                            <i data-lucide="send" class="tw-w-5 tw-h-5 tw-text-gray-400"></i>
                            <h3 class="tw-font-semibold tw-text-gray-800"><?php echo $lang['report-general015'] ?></h3>
                        </div>
                        <p class="tw-text-xs tw-text-gray-500 tw-mb-3"><?php echo $lang['report-general016'] ?></p>
                        <ul class="tw-space-y-2">
                            <li><a href="report_pickup_general_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general017'] ?></a></li>
                            <?php if ($user->userlevel == 9 || $user->userlevel == 2) { ?>
                            <li><a href="report_pickup_customers_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general018'] ?></a></li>
                            <li><a href="report_pickup_employees_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general019'] ?></a></li>
                            <li><a href="report_pickup_agency_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general020'] ?></a></li>
                            <li><a href="report_pickup_driver_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general021'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>

                    <?php if ($user->userlevel == 9 || $user->userlevel == 2) { ?>

                    <!-- CONSOLIDATE -->
                    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-5">
                        <div class="tw-flex tw-items-center tw-gap-3 tw-mb-1">
                            <i data-lucide="boxes" class="tw-w-5 tw-h-5 tw-text-gray-400"></i>
                            <h3 class="tw-font-semibold tw-text-gray-800"><?php echo $lang['left-menu-sidebar-87800334'] ?></h3>
                        </div>
                        <p class="tw-text-xs tw-text-gray-500 tw-mb-3"><?php echo $lang['report-general023'] ?></p>
                        <ul class="tw-space-y-2">
                            <li><a href="report_consolidate_general_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general024'] ?></a></li>
                            <?php if ($user->userlevel == 9 || $user->userlevel == 2) { ?>
                            <li><a href="report_consolidate_customers_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general025'] ?></a></li>
                            <li><a href="report_consolidate_employees_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general026'] ?></a></li>
                            <li><a href="report_consolidate_agency_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general027'] ?></a></li>
                            <li><a href="report_consolidate_driver_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general028'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>

                    <!-- CONSOLIDATE PACKAGES -->
                    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-5">
                        <div class="tw-flex tw-items-center tw-gap-3 tw-mb-1">
                            <i data-lucide="boxes" class="tw-w-5 tw-h-5 tw-text-gray-400"></i>
                            <h3 class="tw-font-semibold tw-text-gray-800"><?php echo $lang['left-menu-sidebar-87800333'] ?></h3>
                        </div>
                        <p class="tw-text-xs tw-text-gray-500 tw-mb-3"><?php echo $lang['report-general023'] ?></p>
                        <ul class="tw-space-y-2">
                            <li><a href="report_consolidate_packages_general_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general024'] ?></a></li>
                            <?php if ($user->userlevel == 9 || $user->userlevel == 2) { ?>
                            <li><a href="report_consolidate_packages_customers_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general025'] ?></a></li>
                            <li><a href="report_consolidate_packages_employees_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general026'] ?></a></li>
                            <li><a href="report_consolidate_packages_agency_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general027'] ?></a></li>
                            <li><a href="report_consolidate_packages_driver_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general028'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>

                    <?php } ?>

                    <!-- ACCOUNTS RECEIVABLE -->
                    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-5">
                        <div class="tw-flex tw-items-center tw-gap-3 tw-mb-1">
                            <i data-lucide="trending-up" class="tw-w-5 tw-h-5 tw-text-gray-400"></i>
                            <h3 class="tw-font-semibold tw-text-gray-800"><?php echo $lang['report-general029'] ?></h3>
                        </div>
                        <p class="tw-text-xs tw-text-gray-500 tw-mb-3"><?php echo $lang['report-general030'] ?></p>
                        <ul class="tw-space-y-2">
                            <li><a href="report_customers_balance_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general031'] ?></a></li>
                            <li><a href="report_summary_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general032'] ?></a></li>
                            <li><a href="report_payments_received_list.php" class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-700 hover:tw-text-blue-600 tw-transition-colors"><i data-lucide="chevron-right" class="tw-w-4 tw-h-4 tw-text-green-500"></i><?php echo $lang['report-general033'] ?></a></li>
                        </ul>
                    </div>

                </div>
            </div>

            <?php include 'views/inc/footer.php'; ?>
        </div>
    </div>

</body>

</html>