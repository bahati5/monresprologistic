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
	<title><?php echo $lang['tools-config61'] ?> | <?php echo $core->site_name ?></title>
	<!-- This Page CSS -->
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css">
	<link href="assets/css/style.min.css" rel="stylesheet">

	<link href="assets/css/front.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.js"></script>
	<script src="assets/js/jquery.ui.touch-punch.js"></script>
	<script src="assets/js/jquery.wysiwyg.js"></script>
	<script src="assets/js/global.js"></script>
	<script src="assets/js/custom.js"></script>
	<link href="assets/customClassPagination.css" rel="stylesheet">


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
					<h1 class="tw-text-2xl tw-font-bold tw-text-gray-800">
						<i data-lucide="mail" class="tw-w-6 tw-h-6 tw-inline tw-mr-2"></i>
						<?php echo $lang['tools-template9'] ?>
					</h1>
				</div>

				<div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-p-4">
					<div class="tw-flex tw-flex-col sm:tw-flex-row tw-gap-3 tw-mb-4">
						<div class="tw-relative tw-flex-1">
							<i data-lucide="search" class="tw-absolute tw-left-3 tw-top-1/2 tw--translate-y-1/2 tw-w-4 tw-h-4 tw-text-gray-400"></i>
							<input type="text" name="search" id="search" onkeyup="cdp_load(1);"
								   class="tw-w-full tw-pl-10 tw-pr-4 tw-py-2 tw-border tw-border-gray-200 tw-rounded-lg tw-text-sm focus:tw-ring-2 focus:tw-ring-blue-500 focus:tw-border-blue-500 tw-outline-none tw-transition"
								   placeholder="search Template">
						</div>
					</div>
					<div class="outer_div"></div>
				</div>
			</div>

			<?php include 'views/inc/footer.php'; ?>
		</div>
	</div>

	<script src="dataJs/templates_email.js"></script>
</body>

</html>