<header id="topnav" class="defaultscroll">
	<div class="container">
		<!-- Logo container-->
		<div>
				<a class="logo" href="index.php">
                    <?php echo ($core->logo_web) ? '<img src="assets/' . $core->logo_web . '" alt="' . $core->site_name . '" width="' . $core->thumb_web . '" height="' . $core->thumb_hweb . '"/>' : $core->site_name; ?>


                </a>
			</div>
		
		<!--end login button-->
		<!-- End Logo container-->
        <div class="menu-extras">
            <div class="menu-item">
                <!-- Mobile menu toggle-->
                <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </div>
        </div>

        <div class="buy-button">
			<a href="login.php" class="btn btn-light-outline rounded"><i class="mdi mdi-account-alert ml-3 icons"></i>
				Se connecter</a>
		</div>

        <div id="navigation">
            <!-- Navigation Menu-->   
            <ul class="navigation-menu">
                <li><a href="index.php" class="sub-menu-item">Accueil</a></li>

                <li><a href="aboutus.php" class="sub-menu-item">Société</a></li>

                <li><a href="tracking.php" class="sub-menu-item"><i class="mdi mdi-package-variant-closed"></i> Suivi</a></li>

                <li><a href="services.php" class="sub-menu-item">Services</a></li>
                
                <li><a href="pays.php" class="sub-menu-item">Pays</a></li>

            </ul><!--end navigation menu-->
        </div><!--end navigation-->
	</div>
</header>

