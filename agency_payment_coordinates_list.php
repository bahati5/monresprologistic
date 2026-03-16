<?php
require_once("loader.php");
$user = new User();
$core = new Core();
if ($user->cdp_loginCheck() != true) {
    header("location: login.php");
    exit;
}
if (!$user->cdp_is_Admin()) {
    cdp_redirect_to("login.php");
}
include('views/tools/agency_payment_coordinates_list.php');
