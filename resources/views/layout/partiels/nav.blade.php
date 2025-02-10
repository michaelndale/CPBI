@php
$avatar = Auth::user()->avatar;
$personnelData = DB::table('personnels')
    ->where('id', Auth::user()->personnelid)
    ->first();
@endphp

<body data-sidebar="colored" id="contenu">
    <!--
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <i class="ri-loader-line spin-icon"></i>
            </div>
        </div>
    </div>  -->


    <div id="layout-wrapper">

        <div class="pace-progress"></div>
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">

                    <button type="button" class="btn btn-sm px-3 font-size-20 header-item waves-effect"
                        id="vertical-menu-btn">
                        <b> <i class="ri-menu-2-line align-middle"></i> CEPBU</b>
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
                                    class="btn btn-outline-danger rounded-pill me-1 mb-1 btn-sm" type="button"
                                    data-bs-toggle="modal" data-bs-target="#verticallyCentered"><i
                                        class="fas fa-sign-out-alt"></i> Quitter le projet</a>
                            @else
                                <a href="{{ route('new_project') }}"
                                    class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" type="button"><i
                                        class=" mdi mdi-plus-circle-multiple"></i> Nouveau projet</a>
                            @endif
                        </button>

                    </div>

                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ri-apps-2-line"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <div class="px-lg-2">
                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <i class="fa fa-folder-open" size='5'></i>
                                            <span>Projet</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <i class="fa fa-folder-open" size='5'></i>
                                            <span>Activité</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <i class="fa fa-users" size='5'></i>
                                            <span>RH</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <i class="fa fa-car" size='5'></i>
                                            <span>ParcAuto</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <i class="fa fa-users" size='5'></i>
                                            <span>Archivage</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <i class="fa fa-info-circle" size='5'></i>
                                            <span>Info</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>


                    @php
                        $avatar = Auth::user()->avatar;
                    @endphp

                    <div class="dropdown d-none d-sm-inline-block">
                        <button type="button" class="btn header-item waves-effect show" data-bs-toggle="dropdown"
                            aria-haspopup="false" aria-expanded="false">

                            <a href="#" class="btn header-item" aria-haspopup="true" aria-expanded="false">

                                @php
                                    // Définir l'avatar par défaut
                                    $defaultAvatar = asset('element/profile/default.png'); // Chemin vers votre image par défaut
                                    $imagePath = public_path($avatar); // Chemin absolu pour vérifier l'existence de l'image
                                @endphp

                                @if (file_exists($imagePath))
                                    <img class="rounded-circle header-profile-user" src="{{ asset($avatar) }}"
                                        alt="{{ ucfirst(Auth::user()->identifiant) }}"
                                        style="width: 30px; height: 30px; border: 1px solid green; border-radius: 50%;">
                                    <br>
                                    <small>{{ ucfirst($personnelData->prenom) }}</small>
                                @else
                                    <img class="rounded-circle header-profile-user" src="{{ $defaultAvatar }}"
                                        alt="{{ ucfirst(Auth::user()->identifiant) }}"
                                        style="width: 30px; height: 30px; border: 1px solid green; border-radius: 50%;">
                                    <br>
                                    <small>{{ ucfirst($personnelData->prenom) }}</small>
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
                        <li class="menu-title">Menu</li>
                        <li>
                            <a href="{{ route('dashboard') }}" class="waves-effect">
                                <i class="fas fa-home"></i>
                                <span>Tableau de bord {{ Session::get('menu') }} </span>
                            </a>
                        </li>

                        @if (session()->has('id'))
                            <li class="menu-title">Projet</li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-projector-line"></i>
                                    <span>Projet</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    @php
                                        $IDPJ = Session::get('id');
                                        $cryptedId = Crypt::encrypt($IDPJ);

                                    @endphp
                                    <li><a href="{{ route('key.viewProject', $cryptedId) }}">Voir le projet</a></li>
                                    <li><a href="{{ route('gestioncompte') }}">Ligne budgétaire</a></li>
                                    <li><a href="{{ route('rallongebudget') }}">Budget</a></li>
                                    <li><a href="{{ route('activity') }}">Activités</a></li>
                                    <li><a href="{{ route('listfeb') }}">FEB</a></li>
                                    <li><a href="{{ route('listdap') }}">DAP</a></li>
                                    <li><a href="{{ route('listdja') }}">DJA</a></li>
                                    <li><a href="{{ route('bpc') }}">Bon de Petite Caisse</a></li>
                                    <li><a href="{{ route('affectation') }}">Intervenants</a></li>
                                    <li><a href="{{ route('rapportcumule') }}">Rapport commulatif</a></li>
                                    <li><a href="{{ route('planoperationnel') }}">Plan d'action</a></li>
                                   
                                </ul>
                            </li>
                        @endif

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-feather"></i>
                                <span>Outils généraux</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">

                                <li><a href="{{ route('folder') }}">Dossier</a></li>
                                <li><a href="{{ route('typebudget') }}">Type budget</a></li>
                                <li><a href="{{ route('devise') }}">Devise</a></li>
                                <li><a href="{{ route('beneficiaire') }}">Bénéficiaire</a></li>
                                <li><a href="{{ route('banque') }}">Banque</a></li>
                                <li><a href="{{ route('termes') }}">Termes de refference</a></li>
                                <li><a href="{{ route('list_project') }}">Tout les projets</a></li>

                            </ul>
                        </li>

                        <li class="menu-title">RH</li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-users"></i>
                                <span>RH</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                              
                                <li><a href="javascript: void(0);" class="has-arrow">Emploi du temps</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{ route('feuilletemps') }}">FTD</a></li>
                                        <li><a href=" route('rft') ">FTM</a></li>
                                    </ul>
                                </li>

                                <li><a href="javascript: void(0);" class="has-arrow">Personnel</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{ route('personnel') }}">Tous les employés</a></li>
                                        <li><a href="{{ route('user') }}">Utilisateurs</a></li>
                                        <li><a href="{{ route('fonction') }}">Fonctions</a></li>
                                    </ul>
                                </li>

                                <li><a href="{{ route('service') }}">Services</a></li>

                                <li><a href="{{ route('department') }}">Departements</a></li>

                            </ul>
                        </li>


                        <li class="menu-title">Archivage</li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa fa-archive"></i>
                                <span>Archivage</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('archivage') }}">Document</a></li>
                                <li><a href="{{ route('classeur') }}">Classeur</a></li>
                                <li><a href="{{ route('etiquette') }}">Etiquette</a></li>
                            </ul>
                        </li>

                        <li class="menu-title">Parc Automobile</li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-taxi"></i>
                                <span>Parc automobile</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('parc') }}">Accueil</a></li>

                                <li><a href="{{ route('vehicule') }}">Véhicules</a></li>
                                <li><a href="{{ route('carburents') }}">Carburants</a></li>
                                <li><a href="{{ route('entretient') }}">Entretiens & Réparations</a></li>
                                <li><a href="{{ route('carnet_bord') }}">Carnet de bord</a></li>
                                <li><a href="{{ route('outilspa') }}">Outils gestions</a></li>
                            </ul>
                        </li>

                        <li class="menu-title">Pages</li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-cogs"></i>
                                <span>Paramètre</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('info') }}">Identifications</a></li>
                                <li><a href="{{ route('notis') }}">Notifications</a></li>
                                <li><a href="{{ route('history') }}">Historiques</a></li>
                                <li><a href="{{ route('active-users') }}">Qui est connecter ?</a></li>
                            </ul>
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
