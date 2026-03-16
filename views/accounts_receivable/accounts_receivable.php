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



if (!$user->cdp_is_Admin())
    cdp_redirect_to("login.php");

$userData = $user->cdp_getUserData();
$statusrow = $core->cdp_getStatus();
$paymethodrow = $core->cdp_getPaymentMethod();



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
    <title><?php echo $lang['payment_text3'] ?></title>
    <link rel="stylesheet" href="assets/template/assets/libs/sweetalert2/sweetalert2.min.css">
    <?php include 'views/inc/head_scripts.php'; ?>

    <link rel="stylesheet" href="assets/template/assets/libs/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="assets/template/assets/libs/select2/dist/css/select2.min.css">


</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <?php $agencyrow = $core->cdp_getBranchoffices(); ?>


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
            <div class="tw-p-4 lg:tw-p-6 tw-space-y-4">

                <div class="tw-flex tw-items-center tw-gap-3">
                    <h1 class="tw-text-2xl tw-font-bold tw-text-gray-800"><?php echo $lang['payment_text3'] ?></h1>
                </div>

                <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-4">
                    <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 lg:tw-grid-cols-4 tw-gap-3 tw-mb-4">
                        <!-- Date range -->
                        <div class="tw-relative">
                            <i data-lucide="calendar" class="tw-absolute tw-left-3 tw-top-1/2 tw--translate-y-1/2 tw-w-4 tw-h-4 tw-text-gray-400"></i>
                            <input type="text" name="daterange" id="daterange"
                                   class="tw-w-full tw-pl-10 tw-pr-4 tw-py-2 tw-border tw-border-gray-200 tw-rounded-lg tw-text-sm focus:tw-ring-2 focus:tw-ring-blue-500 focus:tw-border-blue-500 tw-outline-none tw-transition">
                        </div>
                        <!-- Search -->
                        <div class="tw-relative">
                            <i data-lucide="search" class="tw-absolute tw-left-3 tw-top-1/2 tw--translate-y-1/2 tw-w-4 tw-h-4 tw-text-gray-400"></i>
                            <input type="text" name="search" id="search" onkeyup="cdp_load(1);"
                                   class="tw-w-full tw-pl-10 tw-pr-4 tw-py-2 tw-border tw-border-gray-200 tw-rounded-lg tw-text-sm focus:tw-ring-2 focus:tw-ring-blue-500 focus:tw-border-blue-500 tw-outline-none tw-transition"
                                   placeholder="<?php echo $lang['left21551'] ?>">
                        </div>
                        <!-- Customer select2 -->
                        <select class="select2 form-control custom-select" style="width: 100%; height:36px;" id="customer_id" name="customer_id" onchange="cdp_load(1);">
                        </select>
                        <!-- Agency filter -->
                        <select onchange="cdp_load(1);" id="agency_courier" name="agency_courier"
                                class="tw-px-3 tw-py-2 tw-border tw-border-gray-200 tw-rounded-lg tw-text-sm tw-bg-white focus:tw-ring-2 focus:tw-ring-blue-500 tw-outline-none">
                            <option value="0">--<?php echo $lang['left202'] ?>--</option>
                            <?php foreach ($agencyrow as $row) : ?>
                                <option value="<?php echo $row->id; ?>"><?php echo $row->name_branch; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Bulk actions -->
                    <div class="tw-hidden tw-items-center tw-gap-3 tw-mb-4 tw-p-3 tw-bg-blue-50 tw-rounded-lg tw-border tw-border-blue-100" id="div-actions-checked" x-data="{ open: false }">
                        <span class="tw-text-sm tw-text-gray-700"><strong><?php echo $lang['global-2'] ?></strong> <strong id="countChecked">0</strong></span>
                        <div class="tw-relative">
                            <button @click="open = !open" class="tw-inline-flex tw-items-center tw-gap-1 tw-px-3 tw-py-1.5 tw-bg-blue-600 tw-text-white tw-rounded-lg tw-text-xs tw-font-medium hover:tw-bg-blue-700 tw-transition-colors">
                                <?php echo $lang['global-1'] ?>
                                <i data-lucide="chevron-down" class="tw-w-3 tw-h-3"></i>
                            </button>
                            <div x-show="open" @click.outside="open = false" x-transition
                                 class="tw-absolute tw-left-0 tw-mt-1 tw-w-48 tw-bg-white tw-rounded-lg tw-shadow-lg tw-border tw-border-gray-200 tw-py-1 tw-z-20">
                                <a href="#" data-toggle="modal" data-target="#modalCheckboxStatus" class="tw-flex tw-items-center tw-gap-2 tw-px-3 tw-py-2 tw-text-sm tw-text-gray-700 hover:tw-bg-gray-50">
                                    <i data-lucide="refresh-cw" class="tw-w-3.5 tw-h-3.5 tw-text-green-500"></i>Edit Status
                                </a>
                                <a onclick="cdp_printMultipleLabel();" class="tw-flex tw-items-center tw-gap-2 tw-px-3 tw-py-2 tw-text-sm tw-text-gray-700 hover:tw-bg-gray-50 tw-cursor-pointer">
                                    <i data-lucide="printer" class="tw-w-3.5 tw-h-3.5 tw-text-gray-500"></i><?php echo $lang['toollabel'] ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="outer_div"></div>
                </div>
            </div>

            <?php include('views/modals/modal_update_status_checked.php'); ?>
            <?php include('views/modals/modal_charges_list.php'); ?>
            <?php include('views/modals/modal_charges_add.php'); ?>
            <?php include('views/modals/modal_charges_edit.php'); ?>
            <?php include 'views/inc/footer.php'; ?>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    <?php include('helpers/languages/translate_to_js.php'); ?>
    <script src="assets/template/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="assets/template/assets/libs/moment/moment.min.js"></script>
    <script src="assets/template/assets/libs/daterangepicker/daterangepicker.js"></script>
    <script src="assets/template/assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="assets/template/assets/libs/select2/dist/js/select2.min.js"></script>

    <script src="dataJs/cdp_soloNumeros.js"></script>
    <script src="dataJs/accounts_receivable.js"></script>

</body>

</html>