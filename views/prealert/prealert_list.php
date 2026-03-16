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
require_once('helpers/querys.php');


if (isset($_GET['id_notification'])) {
    # code...

    $user_log = $_SESSION['userid'];
    $id_notification = $_GET['id_notification'];

    $data = cdp_updateNotificationRead($user_log, $id_notification);
}



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
    <title><?php echo $lang['left-menu-sidebar-7'] ?> | <?php echo $core->site_name ?></title>
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
            <div class="tw-p-4 lg:tw-p-6 tw-space-y-4">

                <!-- Page header -->
                <div class="tw-flex tw-flex-col sm:tw-flex-row sm:tw-items-center sm:tw-justify-between tw-gap-3">
                    <h1 class="tw-text-2xl tw-font-bold tw-text-gray-800"><?php echo $lang['left-menu-sidebar-7'] ?></h1>
                    <?php if ($userData->userlevel == 1) { ?>
                    <a href="prealert_add.php" class="tw-inline-flex tw-items-center tw-gap-2 tw-px-4 tw-py-2 tw-bg-blue-600 tw-text-white tw-rounded-lg tw-text-sm tw-font-medium hover:tw-bg-blue-700 tw-transition-colors tw-shadow-sm">
                        <i data-lucide="plus" class="tw-w-4 tw-h-4"></i>
                        <?php echo $lang['left53'] ?>
                    </a>
                    <?php } ?>
                </div>

                <!-- Search & Data card -->
                <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-4">
                    <div class="tw-flex tw-flex-col sm:tw-flex-row tw-gap-3 tw-mb-4">
                        <div class="tw-relative tw-flex-1">
                            <i data-lucide="search" class="tw-absolute tw-left-3 tw-top-1/2 tw--translate-y-1/2 tw-w-4 tw-h-4 tw-text-gray-400"></i>
                            <input type="text" name="search" id="search" onkeyup="cdp_load(1);"
                                   class="tw-w-full tw-pl-10 tw-pr-4 tw-py-2 tw-border tw-border-gray-200 tw-rounded-lg tw-text-sm focus:tw-ring-2 focus:tw-ring-blue-500 focus:tw-border-blue-500 tw-outline-none tw-transition"
                                   placeholder="<?php echo $lang['left21551'] ?>">
                        </div>
                    </div>

                    <div class="outer_div"></div>
                </div>
            </div>

            <?php
            include('views/modals/modal_update_status_checked.php');
            ?>
            <?php include('views/modals/modal_send_email.php'); ?>

            <?php include('views/modals/modal_update_driver.php'); ?>

            <?php include('views/modals/modal_cancel_pickup.php'); ?>


            <?php include('views/modals/modal_charges_list.php'); ?>
            <?php include('views/modals/modal_charges_add.php'); ?>
            <?php include('views/modals/modal_charges_edit.php'); ?>
            <?php include 'views/inc/footer.php'; ?>
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->


    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <?php include('helpers/languages/translate_to_js.php'); ?>

    <script src="dataJs/prealert.js"></script>

</body>

</html>