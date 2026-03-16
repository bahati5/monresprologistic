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



?>
<html lang="en">

<head>
        <meta charset="utf-8" />
        <title>Acheter sur Amazon en RDC et Livraison dans toutes les provinces | Monrespro Logistics</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="achat rdcongo, livraison rdcongo, achat fnac"> 
		<meta name="author" content="Monrespro">
		<meta name="description" content=" Achetez sur Amazon depuis la RD Congo avec facilité. Profitez d'une livraison rapide et d'un large choix de produits adaptés à vos besoins.">
        <!-- favicon -->
        <link rel="icon" type="image/png" sizes="56x56" href="uploads/favicon.png">
        <!-- Bootstrap -->
        <link href="assets/theme_monrespro/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons -->
        <link href="assets/theme_monrespro/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />  
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
        <!-- Main css --> 
        <link href="assets/theme_monrespro/css/style.css" rel="stylesheet" type="text/css" />
        <!-- tobii css -->
        <link href="assets/theme_monrespro/css/tobii.min.css" rel="stylesheet" type="text/css" />

        <!-- Style of the plugin -->
        <link rel="stylesheet" href="plugin/whatsapp-chat-support.css">
        <link rel="stylesheet" href="plugin/components/Font Awesome/css/font-awesome.min.css">


        <style>
            #example_2,
            #example_3,
            #example_4{
                display: none;
            }
        </style>

    </head>



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
        <section class="bg-half-170 d-table w-100" style="background: url('assets/theme_monrespro/images/company/aboutus.jpg');">
            <div class="bg-overlay"></div>
            <div class="container">
                <div class="row mt-5 justify-content-center">
                    <div class="col-lg-12 text-center">
                        <div class="pages-heading title-heading">
                            <h2 class="text-white title-dark"> SOLUTIONS LOGISTIQUES ET EXPÉRIENCE SPÉCIALE </h2>
                            
                        </div>
                    </div><!--end col-->
                </div><!--end row--> 
            </div> <!--end container-->
        </section><!--end section-->
        <div class="position-relative">
            <div class="shape overflow-hidden text-white">
                <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
                </svg>
            </div>
        </div>
        <!-- Hero End -->

        <!-- Start -->
         <section class="section">

            <div class="container">

                <div class="row">
                    <div class="col-md-4 mt-4 pt-2">
                        <ul class="nav nav-pills nav-justified flex-column bg-white rounded shadow p-3 mb-0 sticky-bar" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link rounded active" id="airfreight" data-bs-toggle="pill" href="#freight" role="tab" aria-controls="freight" aria-selected="false">
                                    <div class="text-start py-1 px-2">
                                        <h6 class="mb-0">Fret aérien</h6>
                                    </div>
                                </a><!--end nav link-->
                            </li><!--end nav item-->
                            
                            <li class="nav-item mt-2">
                                <a class="nav-link rounded" id="seafreight" data-bs-toggle="pill" href="#sea_freight" role="tab" aria-controls="sea_freight" aria-selected="false">
                                    <div class="text-start py-1 px-2">
                                        <h6 class="mb-0">Fret maritime</h6>
                                    </div>
                                </a><!--end nav link-->
                            </li><!--end nav item-->
                            
                            <li class="nav-item mt-2">
                                <a class="nav-link rounded" id="delivery_f" data-bs-toggle="pill" href="#de_f" role="tab" aria-controls="de_f" aria-selected="false">
                                    <div class="text-start py-1 px-2">
                                        <h6 class="mb-0">Courrier express</h6>
                                    </div>
                                </a><!--end nav link-->
                            </li><!--end nav item-->
                            
                            <li class="nav-item mt-2">
                                <a class="nav-link rounded" id="general-serve" data-bs-toggle="pill" href="#general" role="tab" aria-controls="general" aria-selected="false">
                                    <div class="text-start py-1 px-2">
                                        <h6 class="mb-0">Assistance d'achat</h6>
                                    </div>
                                </a><!--end nav link-->
                            </li><!--end nav item-->

                        </ul><!--end nav pills-->
                    </div><!--end col-->

                    <div class="col-md-8 col-12 mt-4 pt-2">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade bg-white show active p-4 rounded shadow" id="freight" role="tabpanel" aria-labelledby="airfreight">

                                <div class="row align-items-end mb-4 pb-2">
                                    <div class="col-md-12">
                                        <div class="section-title text-center text-md-start">
                                            <h6 class="text-primary">Services</h6>
                                            <h4 class="title mb-4">TRANSPORT PAR FRET AÉRIEN</h4>
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->

                                <img src="assets/theme_monrespro/images/service/air_freight.jpg" class="img-fluid rounded shadow" alt="">
                                <div class="mt-4">
                                    <h5>Fret aérien</h5>
                                    <p class="text-muted my-3">Nous pouvons transporter vos marchandises par fret aérien depuis ou vers n'importe quel point du globe grâce à nos propres bureaux et à notre réseau exclusif de partenaires partageant les mêmes valeurs.
                                    <br>
                                    Nous prenons en charge l'intégralité du processus, de porte à porte, en assurant un suivi proactif à chaque étape de l'expédition jusqu'à la livraison des marchandises en toute sécurité à nos clients.</p>

                                    <p class="text-muted my-3">Priorité, Vitesse, Économies, Réduction et Matières dangereuses ne représentent qu'une petite partie de notre gamme de services de fret aérien, de suivi des expéditions et de solutions informatiques sur mesure. Un personnel hautement expérimenté garantit une prise de décision optimale et une grande précision, évitant ainsi des erreurs potentiellement coûteuses.</p>
                                   
                                </div>
                            </div><!--end teb pane-->
                            
                            <div class="tab-pane fade bg-white p-4 rounded shadow" id="sea_freight" role="tabpanel" aria-labelledby="seafreight">

                                 <div class="row align-items-end mb-4 pb-2">
                                    <div class="col-md-12">
                                        <div class="section-title text-center text-md-start">
                                            <h6 class="text-primary">Services</h6>
                                            <h4 class="title mb-4">TRANSPORT MARITIME</h4>
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->

                                <img src="assets/theme_monrespro/images/service/sea_freight.jpg" class="img-fluid rounded shadow" alt="">
                                <div class="mt-4">
                                    <h5>Fret maritime</h5>
                                    <p class="text-muted my-3">Monrespro, sélectionne en toute neutralité les meilleurs transporteurs proposant des contrats à prix fixe avantageux et une grande flexibilité. Notre vaste expérience et notre système interne de gestion des commandes garantissent une visibilité et une communication optimales.
                                    <br>
                                   Nos contrats avec les principaux transporteurs mondiaux offrent à nos clients une flexibilité et des économies considérables, ainsi qu'une gamme complète de services porte-à-porte. Nous proposons également des services sur mesure, notamment des groupages d'achat, des chargements complets (FCL), des chargements partiels (LCL), des contrats à prix coûtant majoré, la gestion de la chaîne d'approvisionnement et d'autres initiatives uniques.</p>

                                    <p class="text-muted my-3">Priorité, Rapidité, Économies, Réduction et Transport de matières dangereuses ne représentent qu'une petite partie de notre gamme de services de fret aérien, de suivi des expéditions et de solutions informatiques sur mesure. Notre personnel hautement qualifié garantit une prise de décision optimale et une grande précision, évitant ainsi des erreurs potentiellement coûteuses.</p>
                                </div>
                            </div><!--end teb pane-->

                            <div class="tab-pane fade bg-white p-4 rounded shadow" id="de_f" role="tabpanel" aria-labelledby="delivery_f">
                                <div class="row align-items-end mb-4 pb-2">
                                    <div class="col-md-12">
                                        <div class="section-title text-center text-md-start">
                                            <h6 class="text-primary">Services</h6>
                                            <h4 class="title mb-4">COURSIER EXPRESS</h4>
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->

                                <img src="assets/theme_monrespro/images/service/delivery_freight.jpg" class="img-fluid rounded shadow" alt="">
                                <div class="mt-4">
                                    <h5>Courier express</h5>
                                    <p class="text-muted my-3">Nous proposons une gamme complète de services express, incluant les envois urgents, les transferts vers le prochain vol, les immobilisations d'avions au sol (AOG), les coursiers à bord (OBC) et les marchandises en bagage (MIB). Nous sommes toujours disponibles pour répondre à vos appels et intervenir immédiatement en cas de situation critique, en vous assurant une excellente communication et la garantie que vos intérêts sont protégés et entre de bonnes mains !</p>
                                    
                                </div>
                            </div><!--end teb pane-->
                            
                            <div class="tab-pane fade bg-white p-4 rounded shadow" id="general" role="tabpanel" aria-labelledby="general-serve">
                                <div class="row align-items-end mb-4 pb-2">
                                    <div class="col-md-12">
                                        <div class="section-title text-center text-md-start">
                                            <h6 class="text-primary">Services</h6>
                                            <h4 class="title mb-4">ASSISTANCE D'ACHAT</h4>
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->

                                <img src="assets/theme_monrespro/images/service/same_delivery.jpg" class="img-fluid rounded shadow" alt="">
                                <div class="mt-4">
                                    <h5>Assistance d'achat</h5>
                                    <p class="text-muted my-3">Avec notre service d'assistance d'achat, vous nous dites ce que vous souhaitez acheter et, moyennant une petite commission, nous effectuons les achats pour vous, que ce soit en ligne ou en vous rendant physiquement dans un magasin.
                                    <br>
                                    Fournissez-nous le lien ou les détails des articles que vous souhaitez acheter, et nous vous les confirmerons. Choisissez parmi nos options de paiement simplifiées pour régler vos achats. Nous achetons l'article et, dès réception, nous l'expédions immédiatement à votre adresse internationale.</p>
                                </div>
                            </div><!--end teb pane-->
                            
                        </div><!--end tab content-->
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- End -->



        <section class="bg-half-150 d-table w-100">
            <div class="container">
                <div class="row justify-content-center">

                   <div class="container mt-100 mt-60">
                        <div class="row justify-content-center">
                            <div class="col-12 text-center">
                                <div class="section-title mb-4 pb-2">
                                    <p class="text-muted para-desc mx-auto mb-0"><span class="text-danger fw-bold">Nous sommes toujours là pour vous</span> </p>
                                    <h4 class="title mb-4">Laissez-nous vous aider à trouver une solution<br> qui répond <span class="text-violet">à Vos besoins.</span></h4>
                                    
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->

                        <div class="row" id="counter">
                            <div class="col-md-3 col-6 mt-4 pt-2">
                                <div class="counter-box text-center">
                                    <img src="assets/theme_monrespro/images/illustrator/Asset190.png" class="avatar avatar-small" alt="">
                                    <h2 class="mb-0 mt-4 text-danger"><span class="counter-value" data-target="2500">2500</span>km</h2>
                                    <h6 class="counter-head text-muted">Colis livrés</h6>
                                </div><!--end counter box-->
                            </div>

                            <div class="col-md-3 col-6 mt-4 pt-2">
                                <div class="counter-box text-center">
                                    <img src="assets/theme_monrespro/images/illustrator/Asset189.png" class="avatar avatar-small" alt="">
                                    <h2 class="mb-0 mt-4 text-danger"><span class="counter-value" data-target="30">30</span>+</h2>
                                    <h6 class="counter-head text-muted">Pays couverts</h6>
                                </div><!--end counter box-->
                            </div>

                            <div class="col-md-3 col-6 mt-4 pt-2">
                                <div class="counter-box text-center">
                                    <img src="assets/theme_monrespro/images/illustrator/Asset186.png" class="avatar avatar-small" alt="">
                                    <h2 class="mb-0 mt-4 text-danger"><span class="counter-value" data-target="12">12</span>k</h2>
                                    <h6 class="counter-head text-muted">Clients satisfaits</h6>
                                </div><!--end counter box-->
                            </div>

                            <div class="col-md-3 col-6 mt-4 pt-2">
                                <div class="counter-box text-center">
                                    <img src="assets/theme_monrespro/images/illustrator/Asset187.png" class="avatar avatar-small" alt="">
                                    <h2 class="mb-0 mt-4 text-danger"><span class="counter-value" data-target="13">13</span>Ans</h2>
                                    <h6 class="counter-head text-muted">Années d'expérience</h6>
                                </div><!--end counter box-->
                            </div>
                        </div><!--end row-->
                    </div><!--end container-->
                </div>
             </div><!--end container--> 
        </section><!--end section-->
        <!-- Hero End -->

        <!-- Hero Start -->
        <section class="banner-blue bg-half-10 d-table w-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 order-2 order-md-1">
                        <div class="title-heading text-center mt-1">
                        
                            <h3 class="heading mb-1 text-violet">Nous proposons les meilleurs tarifs</h3>
					<table class="pricing-table">
						<tr>
							<th>DESTINATION </th>
							<th>FRET AERIEN <span> (Par kilo) </span></th>
							<th>FRET MARITIME <span> (Par volume) </span></th>
						</tr>
						
						<tr>
							<td>BELGIQUE - RDC</td>

							<td>A partir de 15$</td>
							<td>A partir de $16</td>
						</tr>
						<tr>
						  <td>FRANCE - RDC</td>
						  <td>A partir de 15$</td>
						  <td>A partir de $16</td>
						</tr>
						<tr>
						  <td>CHINE - RDC</td>
						  <td>A partir de $17</td>
						  <td>A partir de $12</td>
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
