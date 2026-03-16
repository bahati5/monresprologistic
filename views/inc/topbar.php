	<!-- Topbar removed — all controls moved to sidebar -->
<!-- Legacy topbar kept hidden for JS compatibility (sidebarmenu.js etc.) -->
<header class="topbar" style="display:none !important;height:0 !important;overflow:hidden !important;">
	<nav class="navbar top-navbar navbar-expand-md navbar-dark">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php"><span class="logo-text"><?php echo $core->site_name; ?></span></a>
		</div>
		<div class="navbar-collapse collapse" id="navbarSupportedContent"></div>
	</nav>
</header>

<!-- Hidden span for notification count (used by AJAX script) -->
<span id="countNotifications" style="display:none;">0</span>

<audio id="chatAudio">
	<source src="assets/notify.mp3" type="audio/mpeg">
</audio>