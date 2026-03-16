<?php
// *************************************************************************
// *                                                                       *
// * MONRESPRO - Integrated Logistics System                                      *
// * Copyright (c) JAOMWEB. All Rights Reserved                            *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: osorio2380@yahoo.es                                            *
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

require_once("loader.php");



?>



<?php include("assets/templates/head_forgotpass.php");?>


<!-- Loader -->
<div id="preloader">
    <div id="status">
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
</div>
<!-- Loader -->

<!-- Navbar STart -->
<?php include("header_nav.php");?>
<!-- Navbar End -->

        <!-- Hero Start -->
        <section class="bg-home bg-half-150 d-table w-100">
            <div class="home-center">
                <div class="home-desc-center">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-7 col-md-5">
                                <div class="mr-lg-6">
                                    <div class="logoBanner">
                                        <img src="assets/theme_monrespro/images/envios.png" class="img-fluid" alt="">
                                    </div>   
                                </div>
                            </div>
                            
                            <div class="col-lg-5 col-md-5 order-2 order-md-2 mt-4 pt-2 mt-sm-0 pt-sm-0">
                                <div class="login_page bg-white shadow rounded p-4">
                                    <div class="text-center">
                                        <h3 class="mb-4">Password lost?</h3>  
                                    </div>
									
									<div id="msgholder2"></div>
		
                                    <form class="login-form" id="admin_form" method="post">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="form-group position-relative">
                                                    <label>Email <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-mail-ru ml-3 icons"></i>
                                                    <input type="email" class="form-control pl-5" placeholder="Email" name="email" required="">
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <button type="submit" name="dosubmit"  class="btn btn-primary rounded w-100">Send request</button>
                                            </div>
                                        </div>
                                    </form>
									
									<br><br>	
									<p>
										Don't have an account?  </br><a href="sign-up.php" class="text-primary">Register Account | <a href="index.php" class="text-primary">Login now</a>
									</p>
                                </div>
                            </div> <!--end col-->
                        </div><!--end row-->
                    </div> <!--end container-->
                </div>
            </div>
        </section><!--end section-->
        <!-- Hero End -->


        <!-- Hero Start -->
        <section class="bottome-banner bg-half-150 d-table w-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-7 order-1 order-md-2">
                        <div class="title-heading mt-2 ms-lg-5">
                            <h3 class="heading mb-3">Buy, send and bring with us <span class="text-danger"><strong>EASY, FAST AND SAFE</strong></span></h3>
                            
                        </div>
                    </div><!--end col-->
                    <div class="col-lg-5 col-md-5 order-2 order-md-1 mt-4 pt-2 mt-sm-0 pt-sm-0">
                        <img src="assets/theme_monrespro/images/recurso9.png" class="img-fluid" alt="">
                    </div>
                </div><!--end row-->
            </div><!--end container--> 
        </section><!--end section-->
        <!-- Hero End -->


        <!-- Hero Start -->
        <section class="banner-blue bg-half-10 d-table w-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 order-2 order-md-1">
                        <div class="title-heading text-center mt-1">
                        
                            <h3 class="headingbg mb-1 text-white">We have the best rates</h3>
                            <table class="pricing-table">
                                <tr>
                                    <th>DESTINY </th>
                                    <th>OCEAN CARGO <span> (CUBIC FOOT) </span></th>
                                    <th>AIR CARGO <span> (POUND) </span></th>
                                </tr>
                                
                                <tr>
                                    <td>CHINA - PANAMA</td>

                                    <td>From $15</td>
                                    <td>From $16</td>
                                </tr>
                                <tr>
                                  <td>China-Venezuela</td>
                                  <td>From $25</td>
                                  <td>From $16</td>
                                </tr>
                                <tr>
                                  <td>Panama-Venezuela</td>
                                  <td>From $17</td>
                                  <td>From $4,50</td>
                                </tr>
                            </table>
                        </div>

                    </div>

                    <div class="col-lg-6 col-md-6 order-1 order-md-2 mt-0 pt-0 mt-sm-0 pt-sm-0">
                        <img src="assets/theme_monrespro/images/phone_store.png" class="img-fluid" alt="">
                    </div>
                </div>

            </div>
        </section><!--end section-->
        <!-- Hero End -->

        <!--<a href="#" onclick="topFunction()" class="back-to-top rounded text-center" id="back-to-top"> 
            <i class="mdi mdi-chevron-up d-block"> </i> 
        </a> -->
        <!-- Back to top -->

        <?php include("assets/templates/footer.php");?>
