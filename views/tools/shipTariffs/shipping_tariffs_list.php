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
    <title> <?php echo $lang['leftorder288'] ?> | <?php echo $core->site_name ?></title>
    <?php include 'views/inc/head_scripts.php'; ?>
    <link rel="stylesheet" type="text/css" href="assets/template/assets/libs/select2/dist/css/select2.min.css">



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
                <div id="resultados_ajax"></div>

                <div class="tw-flex tw-flex-col sm:tw-flex-row sm:tw-items-center sm:tw-justify-between tw-gap-3">
                    <h1 class="tw-text-2xl tw-font-bold tw-text-gray-800"><?php echo $lang['leftorder288'] ?></h1>
                    <a href="shipping_tariffs_add.php" class="tw-inline-flex tw-items-center tw-gap-2 tw-px-4 tw-py-2 tw-bg-blue-600 tw-text-white tw-rounded-lg tw-text-sm tw-font-medium hover:tw-bg-blue-700 tw-transition-colors tw-shadow-sm">
                        <i data-lucide="plus" class="tw-w-4 tw-h-4"></i>
                        <?php echo $lang['leftorder289'] ?>
                    </a>
                </div>

                <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-4">
                    <div class="tw-flex tw-flex-col md:tw-flex-row tw-gap-3 tw-mb-4">
                        <div class="tw-flex-1">
                            <select onchange="cdp_load(1)" style="width: 100% !important;" class="select2 form-control tw-border tw-border-gray-200 tw-rounded-lg tw-text-sm" name="country_origin" id="country_origin">
                            </select>
                        </div>
                        <div class="tw-flex-1">
                            <select onchange="cdp_load(1)" style="width: 100% !important;" class="select2 form-control tw-border tw-border-gray-200 tw-rounded-lg tw-text-sm" name="country_destiny" id="country_destiny">
                            </select>
                        </div>
                    </div>
                    <div class="outer_div"></div>
                </div>
            </div>

            <?php include 'views/inc/footer.php'; ?>
        </div>
    </div>

    <?php include('helpers/languages/translate_to_js.php'); ?>
    <script src="assets/template/assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="assets/template/assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="dataJs/shipping_tariffs_list.js"></script>
</body>

</html>