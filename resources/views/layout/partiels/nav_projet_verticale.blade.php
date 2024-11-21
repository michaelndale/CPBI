<body data-sidebar="colored" id="contenu">
@php
        // Récupérer les données du profil de l'utilisateur
$personnelData = DB::table('personnels')
    ->where('id', Auth::user()->personnelid)
    ->first();

$avatar = Auth::user()->avatar ;
$defaultAvatar = '../../element/profile/default.png'; // Chemin vers votre image par défaut
$imagePath = public_path($avatar);

// DOCUMENT GENERALE
$feb_counts = DB::table('febs')
    ->selectRaw(
        "
        SUM(CASE WHEN acce = ? AND acce_signe = 0 THEN 1 ELSE 0 END) AS acce_count,
        SUM(CASE WHEN comptable = ? AND comptable_signe = 0 THEN 1 ELSE 0 END) AS comptable_count,
        SUM(CASE WHEN chefcomposante = ? AND chef_signe = 0 THEN 1 ELSE 0 END) AS chefcomposante_count
    ",
        [Auth::id(), Auth::id(), Auth::id()],
    )
    ->first();

// Calcul du total
$feb = $feb_counts->acce_count + $feb_counts->comptable_count + $feb_counts->chefcomposante_count;

$dap_counts = DB::table('daps')
    ->selectRaw(
        "
        SUM(CASE WHEN demandeetablie = ? AND demandeetablie_signe = 0 THEN 1 ELSE 0 END) AS demandeetablie_count,
        SUM(CASE WHEN verifierpar = ? AND verifierpar_signe = 0 THEN 1 ELSE 0 END) AS verifierpar_count,
        SUM(CASE WHEN approuverpar = ? AND approuverpar_signe = 0 THEN 1 ELSE 0 END) AS approuverpar_count,
        SUM(CASE WHEN responsable = ? AND responsable_signe = 0 THEN 1 ELSE 0 END) AS responsable_count,
        SUM(CASE WHEN secretaire = ? AND secretaure_general_signe = 0 THEN 1 ELSE 0 END) AS secretaire_count,
        SUM(CASE WHEN chefprogramme = ? AND chefprogramme_signe = 0 THEN 1 ELSE 0 END) AS chefprogramme_count
    ",
        [Auth::id(), Auth::id(), Auth::id(), Auth::id(), Auth::id(), Auth::id()],
    )
    ->first();

// Calcul total
$dap =
    $dap_counts->demandeetablie_count +
    $dap_counts->verifierpar_count +
    $dap_counts->approuverpar_count +
    $dap_counts->responsable_count +
    $dap_counts->secretaire_count +
    $dap_counts->chefprogramme_count;

$FEB_PTC_counts = DB::table('febpetitcaisses')
    ->selectRaw(
        "
        SUM(CASE WHEN etabli_par = ? AND etabli_par_signature = 0 THEN 1 ELSE 0 END) AS etabli_count,
        SUM(CASE WHEN verifie_par = ? AND verifie_par_signature = 0 THEN 1 ELSE 0 END) AS verifie_count,
        SUM(CASE WHEN approuve_par = ? AND approuve_par_signature = 0 THEN 1 ELSE 0 END) AS approuve_count
    ",
        [Auth::id(), Auth::id(), Auth::id()],
    )
    ->first();

// Calcul total
$FEB_PTC = $FEB_PTC_counts->etabli_count + $FEB_PTC_counts->verifie_count + $FEB_PTC_counts->approuve_count;

$DAP_PTC_counts = DB::table('dapbpcs')
    ->selectRaw(
        "
        SUM(CASE WHEN demande_etablie = ? AND demande_etablie_signe = 0 THEN 1 ELSE 0 END) AS demande_etablie_count,
        SUM(CASE WHEN verifier = ? AND verifier_signe = 0 THEN 1 ELSE 0 END) AS verifier_count,
        SUM(CASE WHEN approuver = ? AND approuver_signe = 0 THEN 1 ELSE 0 END) AS approuver_count,
        SUM(CASE WHEN autoriser = ? AND autoriser_signe = 0 THEN 1 ELSE 0 END) AS autoriser_count,
        SUM(CASE WHEN secretaire = ? AND secretaire_signe = 0 THEN 1 ELSE 0 END) AS secretaire_count,
        SUM(CASE WHEN chefprogramme = ? AND chefprogramme_signe = 0 THEN 1 ELSE 0 END) AS chefprogramme_count
    ",
        [Auth::id(), Auth::id(), Auth::id(), Auth::id(), Auth::id(), Auth::id()],
    )
    ->first();

// Calcul total
$DAP_PTC =
    $DAP_PTC_counts->demande_etablie_count +
    $DAP_PTC_counts->verifier_count +
    $DAP_PTC_counts->approuver_count +
    $DAP_PTC_counts->autoriser_count +
    $DAP_PTC_counts->secretaire_count +
    $DAP_PTC_counts->chefprogramme_count;

$BON_PTC_counts = DB::table('bonpetitcaisses')
    ->selectRaw(
        "
        SUM(CASE WHEN etabli_par = ? AND etabli_par_signature = 0 THEN 1 ELSE 0 END) AS etabli_par_count,
        SUM(CASE WHEN verifie_par = ? AND verifie_par_signature = 0 THEN 1 ELSE 0 END) AS verifie_par_count,
        SUM(CASE WHEN approuve_par = ? AND approuve_par_signature = 0 THEN 1 ELSE 0 END) AS approuve_par_count
    ",
        [Auth::id(), Auth::id(), Auth::id()],
    )
    ->first();

// Calcul total
$BON_PTC =
    $BON_PTC_counts->etabli_par_count +
    $BON_PTC_counts->verifie_par_count +
    $BON_PTC_counts->approuve_par_count;

$CAISSE_PTC_counts = DB::table('rappotages')
    ->selectRaw(
        "
        SUM(CASE WHEN verifier_par = ? AND verifier_signature = 0 THEN 1 ELSE 0 END) AS verifier_count,
        SUM(CASE WHEN approver_par = ? AND approver_signature = 0 THEN 1 ELSE 0 END) AS approver_count
    ",
        [Auth::id(), Auth::id()],
    )
    ->first();

// Calcul total
$CAISSE_PTC = $CAISSE_PTC_counts->verifier_count + $CAISSE_PTC_counts->approver_count;

$documentNombre = $feb + $dap + $FEB_PTC + $DAP_PTC + $BON_PTC + $CAISSE_PTC;

if (session()->has('id')) {
    $ProjetIdEncours = Session::get('id');
    $classement = DB::table('rappotages')->where('cloture', 0)->where('projetid', $ProjetIdEncours)->first();
}

$feb_signale = DB::table('febs')
    ->join('projects', 'febs.projetid', '=', 'projects.id')
    ->join('affectations', 'febs.projetid', '=', 'affectations.projectid')
    ->where('febs.signale', '=', 1)
    ->distinct() // Ajoute distinct pour éviter la duplication
    ->count('febs.id'); // Compter uniquement les enregistrements uniques de 'febs'

$dap_signale = DB::table('daps')
    ->join('projects', 'daps.projetiddap', '=', 'projects.id')
    ->join('affectations', 'daps.projetiddap', '=', 'affectations.projectid')
    ->where('daps.signaledap', '=', 1)
    ->distinct() // Ajoute distinct pour éviter la duplication
    ->count('daps.id'); // Compter uniquement les enregistrements uniques de 'DAPs'

        $total_signalisation = $feb_signale + $dap_signale;

    @endphp
    <div id="layout-wrapper">

        <div class="pace-progress"></div>
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">

                    <button type="button" class="btn btn-sm px-3 font-size-20 header-item waves-effect"
                        id="vertical-menu-btn">
                        <b><i class="ri-menu-2-line align-middle"></i> CEPBU</b>
                    </button>

                    <!-- Projet session et recherche-->

                    @if (session()->has('id'))
                        <div class="callout callout-info">
                            <br>
                            @php
                                $titprojet = Session::get('title');
                            @endphp
                            <p><b>Projet encours :
                                </b>{{ strlen($titprojet) > 70 ? substr($titprojet, 0, 70) . '...' : $titprojet }} </p>

                        </div>
                    @else
                        <!-- <form class="app-search d-none d-lg-block">
            <div class="position-relative">
              <input type="text" class="form-control" placeholder="Search...">
              <span class="ri-search-line"></span>
            </div>
          </form> -->
                    @endif
                </div>

                <div class="d-flex">

                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="ri-search-line"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-search-dropdown">

                            <form class="p-3">
                                <div class="mb-3 m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="ri-search-line"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dropdown d-none d-sm-inline-block">
                        <button type="button" class="btn header-item ">
                            @if (session()->has('id'))
                                <a href="{{ route('closeproject') }}"
                                    class="btn btn-outline-danger rounded-pill me-1 mb-1" type="button"
                                    data-bs-toggle="modal" data-bs-target="#verticallyCentered"><i
                                        class="fas fa-sign-out-alt"></i> Quitter le projet</a>
                            @else
                                <a href="{{ route('new_project') }}"
                                    class="btn btn-outline-primary rounded-pill me-1 mb-1" type="button"><i
                                        class="fa fa-plus-circle"></i> Nouveau projet</a>
                            @endif
                        </button>

                    </div>



                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>

                    <div class="dropdown d-none d-sm-inline-block">
                        <button type="button" class="btn header-item waves-effect show" data-bs-toggle="dropdown"
                            aria-haspopup="false" aria-expanded="false">

                            <a href="#" class="btn header-item" aria-haspopup="true" aria-expanded="false">

                                @if (file_exists($imagePath))
                                    <img class="rounded-circle header-profile-user" src="../../{{ $avatar }}"
                                        alt="{{ ucfirst(Auth::user()->identifiant) }}"
                                        style="width: 30px; height: 30px; border: 1px solid green; border-radius: 50%;">
                                    <br> <small> {{ ucfirst($personnelData->prenom) }} </small>
                                @else
                                    <img class="rounded-circle header-profile-user" src="{{ $defaultAvatar }}"
                                        alt="{{ ucfirst(Auth::user()->identifiant) }}"
                                        style="width: 30px; height: 30px; border: 1px solid green; border-radius: 50%;">
                                    <br> <small> {{ ucfirst($personnelData->prenom) }} </small>
                                @endif



                            </a>


                        </button>
                        <div class="dropdown-menu dropdown-menu-end "
                            style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 72px); "
                            data-popper-placement="bottom-end">
                            <a href="javascript:void(0);" class="dropdown-item notify-item editpersonnel"
                                id="{{ Auth::id() }}" data-bs-toggle="modal" data-bs-target="#EditPersonnelModal"
                                aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span
                                    class="me-2 text-900" data-feather="user">
                                    <i class="ri-user-settings-line "></i> Moi
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item" id="{{ Auth::id() }}"
                                data-bs-toggle="modal" data-bs-target="#editMotdepasseModal" aria-haspopup="true"
                                aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900"
                                    data-feather="user">
                                    <i class="ri-user-follow-line "></i> Modifier le mot de passe
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item" id="{{ Auth::id() }}"
                                data-bs-toggle="modal" data-bs-target="#editprofileModal" aria-haspopup="true"
                                aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900"
                                    data-feather="user">
                                    <i class="ri-user-received-2-line "></i> Modifier profile
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item" id="{{ Auth::id() }}"
                                data-bs-toggle="modal" data-bs-target="#editsignatureModal" aria-haspopup="true"
                                aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900"
                                    data-feather="user">
                                    <i class="ri-pen-nib-fill "></i> Modifier signature
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item" id="{{ Auth::id() }}"
                                data-bs-toggle="modal" data-bs-target="#editthemeModal" aria-haspopup="true"
                                aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900"
                                    data-feather="user">
                                    <i class="ri-contrast-fill"></i> Preference menu
                            </a>
                            <!--<a href="javascript:void(0);" class="dropdown-item notify-item" id="{{ Auth::id() }}" data-bs-toggle="modal" data-bs-target="#editsignatureModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
                      <i class="fa fa-edit"></i> Donne FeedBack
                  </a> <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="fa fa-edit"></i> Fermer la session
                  </a>
              -->
                            <a href="javascript:void(0);" class="dropdown-item notify-item" data-bs-toggle="modal"
                                data-bs-target="#deconnecterModalLabel" role="button" aria-expanded="false"> <span
                                    class="me-2" data-feather="log-out"
                                    title="Déconnectez-vous en cliquant sur l'icône.">
                                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                            </a>


                        </div>

                        <div class="dropdown d-none d-lg-inline-block ms-1">

                            <button type="button" class="btn header-item noti-icon waves-effect">
                                <a href="javascript:void(0);" class="dropdown-item notify-item"
                                    data-bs-toggle="modal" data-bs-target="#deconnecterModalLabel" role="button"
                                    aria-expanded="false"> <span class="me-2" data-feather="log-out"
                                        title="Déconnectez-vous en cliquant sur l'icône.">
                                        <i class="fa fa-power-off"></i>
                                </a>
                            </button>
                        </div>



                    </div>
                </div>
        </header>
        <!-- ========== Left Sidebar Start ========== -->

        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">

                        @if ($documentNombre != 0)
                            <audio autoplay>
                                <source src="{{ asset('notification/son.mp3') }}" type="audio/mpeg">
                                Votre navigateur ne supporte pas l'élément audio.
                            </audio>
                            <li class="nav-item">
                                <a href="#" class="waves-effect"
                                    class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                    data-bs-target=".bs-example-modal-lg">
                                    <i class="ri-file-edit-fill "></i><span
                                        class="badge rounded-pill bg-danger float-end">{{ $documentNombre }}</span>
                                    <span>Documents</span>
                                </a>
                            </li>
                        @endif


                        @if ($total_signalisation != 0)
                            <li class="nav-item">
                                <a href="#" class="waves-effect"
                                    class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                    data-bs-target=".bs-signalisation">
                                    <i class="ri-chat-voice-line"></i><span
                                        class="badge rounded-pill bg-danger float-end">{{ $total_signalisation }}</span>
                                    <span>Signalisation</span>
                                </a>
                            </li>
                        @endif


                        <li>
                            <a href="{{ route('dashboard') }}" class="waves-effect">
                                <i class="ri-dashboard-fill"></i>
                                <span>Tableau de bord {{ Session::get('menu') }} </span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-quill-pen-fill"></i>
                                <span>Outils Généraux</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">

                                <li><a href="{{ route('folder') }}">Dossier</a></li>
                                <li><a href="{{ route('typebudget') }}">Type budget</a></li>
                                <li><a href="{{ route('devise') }}">Devise</a></li>
                                <li><a href="{{ route('beneficiaire') }}">Bénéficiaire</a></li>
                                <li><a href="{{ route('banque') }}">Banque</a></li>
                                <li><a href="{{ route('termes') }}">Termes de Reference</a></li>
                                <li><a href="{{ route('pays') }}">Pays</a></li>
                            </ul>
                        </li>


                        <li>
                            <a href="{{ route('list_project') }}">
                                <i class="ri-list-unordered"></i>

                                <span>Tous les Projets</span>
                            </a>
                        </li>






                        @if (session()->has('id'))

                            @php
                                $IDPJ = Session::get('id');
                                $cryptedId = Crypt::encrypt($IDPJ);

                            @endphp
                            <li class="menu-title">Projet</li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-apps-2-line me-1"></i>
                                    <span>Gestion de Projet</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">


                                    <li><a href="{{ route('key.viewProject', $cryptedId) }}"><i
                                                class="fa fa-eye"></i> Voir le projet</a></li>
                                    <li><a href="{{ route('gestioncompte') }}"><i class="fa fa-chart-line"></i> Ligne
                                            budgétaire</a></li>
                                    <li><a href="{{ route('rallongebudget') }}"><i class="fa fa-chart-bar"></i>
                                            Budget</a></li>
                                    <li><a href="{{ route('activity') }}"><i class="fa fa-running"></i> Activités</a>
                                    </li>
                                    <li><a href="{{ route('affectation') }}"><i class="fa fa-users"></i>
                                            Intervenants</a></li>
                                    <li><a href="{{ route('planoperationnel') }}"><i class="fa fa-tasks"></i> Plan
                                            d'action</a></li>



                                </ul>
                            </li>



                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-file-copy-2-line"></i>
                                    <span>Document</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">


                                    <li><a href="{{ route('listfeb') }}">F.E.B</a></li>
                                    <li><a href="{{ route('listdap') }}">D.A.P</a></li>
                                    <li><a href="{{ route('listdja') }}">D.J.A</a></li>


                                </ul>
                            </li>


                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-book-3-line "></i>
                                    <span>Petite Caisse</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">





                                    @if (isset($classement))
                                        <li>
                                            <a href="{{ route('Rapport.cloture.caisse') }}" class="dropdown-item">
                                                <div class="spinner-grow text-warning m-1" role="status"
                                                    style="width: 0.7rem; height: 0.7rem;">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                <span>Cloture caisse </span>

                                            </a>
                                        </li>
                                    @else
                                        <li> <a href="{{ route('bpc') }}" class="dropdown-item"> B.P.C </a></li>
                                        <li> <a href="{{ route('cpc') }}" class="dropdown-item">Compte </a></li>
                                        <li> <a href="{{ route('febpc') }}" class="dropdown-item">F.E.B </a></li>
                                        <li> <a href="{{ route('dappc') }}" class="dropdown-item">D.A.P </a></li>
                                    @endif






                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-file-ppt-2-line "></i>
                                    <span>Rapports </span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('rapprochement') }}"><i class="fa fa-chart-pie"></i>
                                            Rapprochement</a></li>
                                    <li><a href="{{ route('rapartitiooncouts') }}"><i class="fa fa-chart-pie"></i>
                                            Répartition Coûts</a></li>
                                    <li><a href="{{ route('rapportcumule') }}"><i class="fa fa-chart-pie"></i>
                                            Cummulatif</a></li>
                                    <li><a href="{{ route('Rapport.caisse') }}"><i class="fa fa-chart-pie"></i>
                                            Petite caisse</a></li>
                                </ul>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('new_project') }}">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Nouveau Projet</span>
                                </a>
                            </li>

                        @endif

                        <li>
                            <a href="{{ route('communique') }}">
                                <i class="  ri-error-warning-line "></i>
                                <span>Communique</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('start') }}">
                                <i class=" ri-logout-circle-r-line "></i>
                                <span>Quitter le Service</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="dropdown-item notify-item" data-bs-toggle="modal"
                                data-bs-target="#deconnecterModalLabel">
                                <i class="fa fa-power-off"></i>
                                <span>Déconnexion</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->
