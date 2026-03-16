        <!-- Footer Start -->
        <footer class="footer footer-bar">
            <div class="footer-py-30">
                <div class="container text-center">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="text-sm-start">
                                <p class="mb-0"> © <script>document.write(new Date().getFullYear())</script> Powered by Monrespro - Tous droits réservés <i class="mdi mdi-heart text-danger"></i> </p>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                            <ul class="list-unstyled footer-list terms-service mb-0">
                                <li class="list-inline-item mb-0"><a href="terms_and_conditions.php" class="text-foot me-2">Conditions générales</a></li>
                                <li class="list-inline-item mb-0"><a href="privacy_policy.php" class="text-foot me-2">Politique de confidentialité</a></li>
                            </ul>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end container-->
            </div>
        </footer><!--end footer-->
        <!-- Footer End -->


        <!-- Plugin Start Whatsapp -->
        <div class="whatsapp_chat_support wcs_fixed_right" id="example_1">
            <div class="wcs_button_label">
                Des questions ? Discutons-en !
            </div>  
            <div class="wcs_button wcs_button_circle">
                <span class="fa fa-whatsapp"></span>
            </div>  

            <div class="wcs_popup">
                <div class="wcs_popup_close">
                    <span class="fa fa-close"></span>
                </div>
                <div class="wcs_popup_header">
                    <strong>Besoin d'aide ?</strong>
                    <br>
                    <div class="wcs_popup_header_description">Cliquez pour démarrer la conversation</div>
                </div>  
                <div class="wcs_popup_person_container">
                    <div class="wcs_popup_person" data-number="#" data-availability='{"monday":"00:00-24:00", "tuesday":"00:00-24:00", "wednesday":"00:00-24:00", "thursday":"00:00-24:00", "friday":"00:00-24:00", "saturday":"00:00-24:00"}'>
                        <div class="wcs_popup_person_img"><img src="assets/theme_monrespro/images/icon-whatsapp/logo_wt.jpg" alt=""></div>
                        <div class="wcs_popup_person_content">
                            <div class="wcs_popup_person_name">Monrespro</div>
                            <div class="wcs_popup_person_description">Support commercial</div>
                            <div class="wcs_popup_person_status">Je suis en ligne</div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <!-- Plugin Whatsapp End -->

            

        <!-- javascript -->
        <script src="assets/theme_monrespro/js/jquery-3.1.0.min.js"></script>
        <script src="assets/theme_monrespro/js/bootstrap.bundle.min.js"></script>
        <!-- SLIDER -->
        <script src="assets/theme_monrespro/js/tiny-slider.js "></script>
        <!-- Icons -->
        <script src="assets/theme_monrespro/js/feather.min.js"></script>
        <!-- Main Js -->
        <script src="assets/theme_monrespro/js/plugins.init.js"></script><!--Note: All init js like tiny slider, counter, countdown, maintenance, lightbox, gallery, swiper slider, aos animation etc.-->
        <script src="assets/theme_monrespro/js/app.js"></script><!--Note: All important javascript like page loader, menu, sticky menu, menu-toggler, one page menu etc. -->

        <!-- Plugin JS file -->

        <script src="plugin/demo.js"></script>
        <script src="plugin/components/moment/moment.min.js"></script>
        <script src="plugin/components/moment/moment-timezone-with-data.min.js"></script>
        <script src="plugin/whatsapp-chat-support.js"></script>

        <script>
            $('#example_1').whatsappChatSupport();

            $('#example_2').whatsappChatSupport();

            $('#example_3').whatsappChatSupport({
                defaultMsg : '',
            });

            $('#example_4').whatsappChatSupport({
                defaultMsg : '',
            });

            
        </script>
       
    </body>

</html>