<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Bienvenu | GoProject</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="GoProject" name="Application des Projets , RH , ARCHIVAGE , PARC AUTOMOBILE" />
    <meta content="GoProjects" name="MICHAEL NDALE" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('element/assets/images/logo.png') }}">
    <!-- Layout Js -->
    <script src="{{ asset('element/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('element/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('element/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('element/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>
@php
// Récupérer les données du profil de l'utilisateur
$personnelData = DB::table('personnels')
->where('id',Auth::user()->personnelid)
->first();
@endphp

<body class="auth-body-bg">
    <div class="auth-maintenance d-flex align-items-center min-vh-100">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div>
                        <div class="text-center mb-4">
                            <font size="6px" color="green">
                                <strong><i class="ri-menu-2-line align-middle"></i> CEPBU</strong>

                            </font>

                            <h4 class="mt-4"> <i> {{ $greeting }} {{ ucfirst($personnelData->prenom ) }} </i> , Où voulez-vous aller ?</h4>
                            <p><i class="fa fa-info-circle"></i> Ceci est simple et rapide car vous avez quatre applications intégrées pour faciliter votre travail. <br> Vous avez le choix du service dans lequel vous souhaitez travailler maintenant.</p>

                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-3"> <br>
                                <a href="{{ route('dashboard') }}">
                                    <div class="card maintenance-box">
                                        <div class="card-body p-4">
                                            <div class="d-flex">

                                                <div class="flex-grow-1">
                                                    <center>
                                                        <img src="{{ asset('element/assets/images/1 projet.png') }}" style="width:40%" />

                                                    </center> <br>
                                                    <h5 class="font-size-16 text-uppercase">
                                                        <center><b>SUivi du projet</b></center>
                                                    </h5>
                                                    <p class="text-muted mb-0">
                                                        <center>Tableaux de bord, budgetisation,FEB,DAP, DJA, les rapports d'avancement, et les réunions de suivi...</center>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </a>

                            </div>

                            <div class="col-md-3" > <br>
                                <a href="{{ route('rh') }}">
                                    <div class="card maintenance-box">
                                        <div class="card-body p-4">
                                            <div class="d-flex">

                                                <div class="flex-grow-1">
                                                    <center>
                                                        <img src="{{ asset('element/assets/images/2 rh.png') }}" style="width:40%" />

                                                    </center> <br>
                                                    <h5 class="font-size-16 text-uppercase">
                                                        <center><b>RH</b></center>
                                                    </h5>
                                                    <p class="text-muted mb-0">
                                                        <center>
                                                            Gérer efficacement les processus, la gestion des employés, le suivi des performances et du temps ...
                                                        </center>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </a>

                            </div>

                            <div class="col-md-3"> <br>
                                <a href="{{ route('archivages') }}">
                                    <div class="card maintenance-box">
                                        <div class="card-body p-4">
                                            <div class="d-flex">

                                                <div class="flex-grow-1">
                                                    <center>
                                                        <img src="{{ asset('element/assets/images/3 arc.png') }}" style="width:40%" />

                                                    </center> <br>
                                                    <h5 class="font-size-16 text-uppercase">
                                                        <center><b>Archivage</b></center>
                                                    </h5>
                                                    <p class="text-muted mb-0">
                                                        <center>Numérique permettant de stocker Organiser et gérer efficacement des documents et des données importantes... </center>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </a>

                            </div>

                            <div class="col-md-3"> <br>
                                <a href="{{ route('parcAuto') }}">
                                    <div class="card maintenance-box">
                                        <div class="card-body p-4">
                                            <div class="d-flex">

                                                <div class="flex-grow-1">
                                                    <center>
                                                        <img src="{{ asset('element/assets/images/4 parc .png') }}" style="width:40%" />

                                                    </center> <br>
                                                    <h5 class="font-size-16 text-uppercase">
                                                        <center> <b>Parc Automobile</b></center>
                                                    </h5>
                                                    <p class="text-muted mb-0">
                                                        <center>Un outil numérique permettant de suivre, gérer et optimiser les véhicules d'une flotte de manière efficace....</center>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </a>

                            </div>

                            <center>

                                <a href="javascript:void(0);" class="dropdown-item notify-item" data-bs-toggle="modal" data-bs-target="#deconnecterModalLabel" role="button" aria-expanded="false"> <span class="me-2" data-feather="log-out" title="Déconnectez-vous en cliquant sur l'icône.">
                                        <i class="fas fa-sign-out-alt"></i> Se déconnecter
                                </a>

                                <div class="modal fade" id="deconnecterModalLabel" tabindex="-1" aria-labelledby="deconnecterModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <p class="text-700 lh-lg mb-0">
                                                    <center>
                                                        <font size="7" color="#c0c0c0"> <i class="fas fa-info-circle "></i></font> <br>
                                                        <font size="4">Voulez-vous vraiment vous déconnecter <br> de l'application ? </font> <br> <br>
                                                        <a href="{{ route('logout') }}" class="btn btn-primary" type="button"> <i class="fas fa-check-circle"></i> Oui </a> &nbsp; <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"> <i class="fa fa-times-circle"></i> Non </button>
                                                    </center>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </center>


                        </div>


                        <!--

                        @php
                        $currentDate = date('Y-m-d');
                        $limitDate = '2025-01-10';
                        $limitDateTime = new DateTime($limitDate);
                        $currentDateTime = new DateTime($currentDate);

                        // Calculer la différence en jours
                        $interval = $currentDateTime->diff($limitDateTime);
                        $daysRemaining = $interval->days;
                        $isPastLimitDate = $currentDate > $limitDate;
                        @endphp

                        @if ($isPastLimitDate)
                        <script>
                            window.location.href = "{{ url('/page-de-paiement') }}";
                        </script>
                        @elseif ($daysRemaining <= 20)

                            <div class="text-center mb-4">
                            <a href="index.html" class="">
                                <img src="assets/images/logo-dark.png" alt="" height="25" class="auth-logo logo-dark mx-auto">
                                <img src="assets/images/logo-light.png" alt="" height="25" class="auth-logo logo-light mx-auto">
                            </a>
                            <h4 class="mt-4" style="color:red">Avis de Fermeture de l'Application en Cas de Non-Respect des Termes</h4>
                            <p>Nous vous prions de bien vouloir régulariser la situation avant cette date du 25-08-2025 afin d'éviter toute interruption de service.
                                <br> Nous restons à votre disposition pour toute information complémentaire. ils vous reste que :
                            </p>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-9">
                            <div class="mt-5">
                                <div data-countdown="2024/10/30" class="counter-number"></div>
                            </div>
                        </div>
                    </div> 

                    @endif  -->

                   
                   
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="{{ asset('element/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('element/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('element/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('element/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('element/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('element/assets/libs/jquery-countdown/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('element/assets/js/pages/coming-soon.init.js') }}"></script>
    <script src="{{ asset('element/assets/js/app.js') }}"></script>
</body>

</html>