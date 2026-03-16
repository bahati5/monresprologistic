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

// Verifica si el archivo de configuración existe
if (!file_exists('config/config.php')) {
    header("location: install");
    exit;
}

// Incluye el archivo loader.php
require_once("loader.php");

// Crea instancias de las clases User y Core
$user = new User();
$core = new Core();

// Verifica si estamos autenticados
if ($user->cdp_loginCheck() != true) {
    // Non connecté : redirection vers la page de connexion pour accéder au dashboard
    header("Location: login.php");
    exit;
}

// Utilisateur connecté : déterminer la vue selon le niveau (userlevel)
// 9 = Admin, 2 = Gestionnaire/Employé, 1 = Client, 3 = Chauffeur
$userlevel = isset($_SESSION['userlevel']) ? (int) $_SESSION['userlevel'] : 9;

if ($userlevel == 9 || $userlevel == 2) {
    include('views/dashboard/index.php');
    exit;
}
if ($userlevel == 1) {
    include('views/dashboard/dashboard_client.php');
    exit;
}
if ($userlevel == 3) {
    include('views/dashboard/dashboard_driver.php');
    exit;
}
// Niveau inconnu ou 0 : afficher le dashboard admin par défaut
include('views/dashboard/index.php');
exit;

?>
<?php include("assets/templates/head_login.php");?>


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
					<div class="col-lg-8 col-md-8 order-1 order-md-1">
						<div class="row align-items-center">
				            <div class="col-lg-7 col-md-7 order-1 order-md-2">
				                <div class="title-headingbg mt-1 ms-lg-5">
				                    <h3 class="headingbg mb-3 text-white">Achetez dans des boutiques internationales  <br><span class="text-white">et profitez de la livraison<br> <strong>à l'international</strong></span></h3>
				                    
				                </div>
				            </div><!--end col-->
				            <div class="col-lg-5 col-md-5 order-2 order-md-1 mt-4 pt-2 mt-sm-0 pt-sm-0">
				                <img src="assets/theme_monrespro/images/envios.png" class="img-fluid" alt="">
				            </div>
				        </div><!--end row-->
					</div>
					<div class="col-lg-4 col-md-4 order-2 order-md-2 mt-4 pt-2 mt-sm-0 pt-sm-0">
						<div class="login-page bg-white shadow rounded p-4">
							<div class="text-center">
								<!-- <h4 class="mb-4"><//?php echo $core->site_name ?>, <//?php echo $lang['left114'] ?></h4>  -->
								<h4 class="mb-4"> Bienvenue chez Monrespro</h4>
							</div>
							<div id="msgholder2">
								
							</div>
							<div id="loader" style="display:none"></div>
							
						</div>
						<!---->
					</div>
					<!--end col-->
				</div>
				<!--end row-->
			</div>
			<!--end container-->
		</div>
	</div>


</section>
<!--end section-->

<!-- Hero Start -->
<section class="bottome-banner bg-half-150 d-table w-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-7 order-1 order-md-2">
                <div class="title-heading mt-2 ms-lg-5">
                    <h3 class="heading mb-3">Faites vos achats dans les boutiques belges, françaises et europénnes et profitez de réductions importantes sur la livraison internationale. <span class="text-danger">
                        <strong>Monrespro vous livre vos marques préférés directement à domicile, avec des tarifs d'expéditions imbattables.</strong></span></h3>
                    
                </div>
            </div><!--end col-->
            <div class="col-lg-5 col-md-5 order-2 order-md-1 mt-4 pt-2 mt-sm-0 pt-sm-0">
                <img src="assets/theme_monrespro/images/recurso9.png" class="img-fluid" alt="">
            </div>
        </div><!--end row-->
    </div><!--end container--> 
</section><!--end section-->
<!-- Hero End -->

<section class="section bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="section-title text-center mb-4 pb-2">
                            <h6 class="text-primary">Comment ça marche ?</h6>
                            <h4 class="title mb-4">Livraison internationale des achats en ligne vers l'Afrique</h4>
                            <p class="text-muted para-desc mx-auto mb-0">Vous avez trouvé ce qu'il vous faut en ligne, mais le magasin ne livre pas en Afrique ?

Nous comprenons votre frustration et nous pouvons vous aider.  <span class="text-primary fw-bold">Faites vos achats sur vos sites préférés ,</span> 
                            et nous vous livrerons directement chez vous. </p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <div class="col-md-4 mt-4 pt-2">
                        <div class="card features feature-clean work-process bg-transparent process-arrow border-0 text-center">
                            <div class="icons text-primary text-center mx-auto">
                                <i class="uil uil-presentation-edit d-block rounded h3 mb-0"></i>
                            </div>

                            <div class="card-body">
                                <h5 class="text-dark">Obtenez votre adresse virtuelle Monrespro</h5>
                                <p class="text-muted mb-0">Inscrivez-vous sur Monrespro pour obtenir votre adresse virtuelle  puis faites vos achats en ligne dans vos boutiques en ligne préférées.</p>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-md-4 mt-md-5 pt-md-3 mt-4 pt-2">
                        <div class="card features feature-clean work-process bg-transparent process-arrow border-0 text-center">
                            <div class="icons text-primary text-center mx-auto">
                                <i class="uil uil-airplay d-block rounded h3 mb-0"></i>
                            </div>

                            <div class="card-body">
                                <h5 class="text-dark">Achetez et faites-vous livrer chez nous</h5>
                                <p class="text-muted mb-0">Au moment de régler vos achats sur les boutiques en ligne, choisissez de faire livrer les articles à votre adresse unique de Monrespro.</p>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-md-4 mt-md-5 pt-md-5 mt-4 pt-2">
                        <div class="card features feature-clean work-process bg-transparent d-none-arrow border-0 text-center">
                            <div class="icons text-primary text-center mx-auto">
                                <i class="uil uil-image-check d-block rounded h3 mb-0"></i>
                            </div>

                            <div class="card-body">
                                <h5 class="text-dark">Payez et recevez votre commande</h5>
                                <p class="text-muted mb-0">Connectez-vous à votre compte Monrespro, indiquez-nous vos achats et payez les frais de livraison internationale. Nous expédions les articles, nous nous occupons du dédouanement et nous vous les livrons à domicile.</p>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->

        </section><!--end section-->
        
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


        


<section class="bottome-banner bg-half-150 d-table w-100">
    <div class="container">
		<div class="row justify-content-center">

			<div class="col-lg-8 col-md-8 order-1 order-md-2">
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

		</div>
	 </div><!--end container--> 
</section><!--end section-->
<!-- Hero End -->

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
            <div class="col-lg-7 col-md-7 order-2 order-md-1">
                <div class="title-headingbg mt-2 ms-lg-5">
                    <h3 class="headingbg mb-3">Achetez dans les principaux magasins en Europe : Belgique, France et autres <span class="heading text-warning"><strong>ET RECEVEZ-LE À LA PORTE DE VOTRE MAISON</strong></span></h3>
                    
                </div>
            </div><!--end col-->
            <div class="col-lg-5 col-md-5 order-1 order-md-2 mt-0 pt-0 mt-sm-0 pt-sm-0">
                <img src="assets/theme_monrespro/images/phone_store.png" class="img-fluid" alt="">
            </div>
        </div><!--end row-->
    </div><!--end container--> 
</section><!--end section-->
<!-- Hero End -->

<!-- Hero End -->




<!-- Back to top -->
<!--<a href="#" onclick="topFunction()" class="back-to-top rounded text-center" id="back-to-top"> 
    <i class="mdi mdi-chevron-up d-block"> </i> 
</a> -->
<!-- Back to top -->

<?php include("assets/templates/footer.php");?>
