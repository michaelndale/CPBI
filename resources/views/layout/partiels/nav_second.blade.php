
<body data-topbar="colored" data-layout="horizontal">
@php

// Récupérer les données du profil de l'utilisateur
$personnelData = DB::table('personnels')
                  ->where('id',Auth::user()->personnelid)
                  ->first();

  $avatar = Auth::user()->avatar;
 
$documentacce= DB::table('febs')
->Where('acce', Auth::id() )
->Where('acce_signe',  0)
->get()
->count();

$documentcompte = DB::table('febs')
->Where('comptable', Auth::id() )
->Where('comptable_signe',  0)
->get()
->count();

$documentchefcomposent= DB::table('febs')
->Where('chefcomposante', Auth::id() )
->Where('chef_signe',  0)
->get()
->count();



$dap_demandeetablie= DB::table('daps')
->Where('demandeetablie', Auth::id() )
->Where('demandeetablie_signe',  0)
->get()
->count();



$dap_verifier= DB::table('daps')
->Where('verifierpar', Auth::id() )
->Where('verifierpar_signe',  0)
->get()
->count();

$dap_approuverpar= DB::table('daps')
->Where('approuverpar', Auth::id() )
->Where('approuverpar_signe',  0)
->get()
->count();

$dap_responsable= DB::table('daps')
->Where('responsable', Auth::id() )
->Where('responsable_signe',  0)
->get()
->count();

$dap_secretaire= DB::table('daps')
->Where('secretaire', Auth::id() )
->Where('secretaure_general_signe',  0)
->get()
->count();

$dap_chefprogramme= DB::table('daps')
->Where('chefprogramme', Auth::id() )
->Where('chefprogramme_signe',  0)
->get()
->count();


$dap_nombre= $dap_demandeetablie + $dap_verifier + $dap_approuverpar + $dap_responsable + $dap_secretaire + $dap_chefprogramme ;
$fab_nombre= $documentacce + $documentcompte + $documentchefcomposent;

$documentNombre = $dap_nombre + $fab_nombre ;

@endphp
<!-- Begin page -->
<div id="layout-wrapper">

    <div class="pace-progress"></div>
    <header id="page-topbar">
        <div class="navbar-header">
        <div class="d-flex">
          <!-- LOGO -->
          <div class="navbar-brand-box">
            <a href="{{ route('dashboard') }}" class="logo logo-dark">
              <span class="logo-sm">
                <img src="{{ asset('element/assets/images/logo-sm-dark.png') }}" alt="logo-sm-dark" height="24">
              </span>
              <span class="logo-lg">
                <img src="{{ asset('element/assets/images/logo-dark.png') }}" alt="logo-dark" height="25">
              </span>
            </a>

            <a href="{{ route('dashboard') }}" class="logo logo-light">
              <span class="logo-sm">
                <img src="{{ asset('element/assets/images/logo-sm-light.png') }}" alt="logo-sm-light" height="24">
              </span>
              <span class="logo-lg">
                <img src="{{ asset('element/assets/images/logo-light.png') }}" alt="logo-light" height="25">
              </span>
            </a>
          </div>

          <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
            <i class="ri-menu-2-line align-middle"></i>
          </button>

          <!-- Projet session et recherche-->

          @if (session()->has('id'))
          <div class="callout callout-info" style="color:white">
            <br> 
            @php
            $titprojet = Session::get('title');
            @endphp
            <p> <b>Projet encours : </b>{{ strlen($titprojet) > 60 ? substr($titprojet, 0, 60) . '...' : $titprojet }} </p>

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
  <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="ri-search-line"></i>
  </button>
  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">

    <form class="p-3">
      <div class="mb-3 m-0">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search ...">
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit"><i class="ri-search-line"></i></button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="dropdown d-none d-sm-inline-block">
  <button type="button" class="btn header-item ">
    @if (session()->has('id'))
    <a href="{{ route('closeproject') }}" class="btn btn-outline-warning rounded-pill me-1 mb-1" type="button" data-bs-toggle="modal" data-bs-target="#verticallyCentered"><i class="fas fa-sign-out-alt"></i> Quitter le projet</a>
    @else
    <a href="{{ route('new_project') }}" class="btn btn-outline-primary rounded-pill me-1 mb-1" type="button"><i class="fa fa-plus-circle"></i> Nouveau projet</a>
    @endif
  </button>

</div>

<div class="dropdown d-none d-lg-inline-block ms-1">
  <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
  <button type="button" class="btn header-item waves-effect show" data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="false">

    <a href="#" class="btn header-item" aria-haspopup="true" aria-expanded="false">

    @php
    $defaultAvatar = '../../element/profile/default.png'; // Chemin vers votre image par défaut
        $imagePath = public_path($avatar);
    @endphp

    @if(file_exists($imagePath))
        <img class="rounded-circle header-profile-user" src="../../{{ $avatar }}" alt="{{ ucfirst(Auth::user()->identifiant) }}"  style="width: 30px; height: 30px; border: 1px solid green; border-radius: 50%;">
        <br> <small> {{ ucfirst($personnelData->prenom ) }} </small>
        @else
        <img class="rounded-circle header-profile-user" src="{{ $defaultAvatar }}" alt="{{ ucfirst(Auth::user()->identifiant) }}"  style="width: 30px; height: 30px; border: 1px solid green; border-radius: 50%;">
        <br> <small> {{ ucfirst($personnelData->prenom ) }}</small>
        @endif



    </a>


  </button>
  <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 72px); " data-popper-placement="bottom-end">

    <!-- item-->

 

    <a href="javascript:void(0);" class="dropdown-item notify-item editpersonnel" id="{{ Auth::id() }}" data-bs-toggle="modal" data-bs-target="#EditPersonnelModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
        <i class="fa fa-user-edit"></i> Moi
    </a>

    <a href="javascript:void(0);" class="dropdown-item notify-item" id="{{ Auth::id() }}" data-bs-toggle="modal" data-bs-target="#editMotdepasseModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
        <i class="fa fa-edit"></i> Modifier le mot de passe
    </a>

    <a href="javascript:void(0);" class="dropdown-item notify-item" id="{{ Auth::id() }}" data-bs-toggle="modal" data-bs-target="#editprofileModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
        <i class="fa fa-edit"></i> Modifier profile
    </a>

    <a href="javascript:void(0);" class="dropdown-item notify-item" id="{{ Auth::id() }}" data-bs-toggle="modal" data-bs-target="#editsignatureModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
        <i class="fa fa-edit"></i> Modifier signature
    </a>

    <a href="javascript:void(0);" class="dropdown-item notify-item" id="{{ Auth::id() }}" data-bs-toggle="modal" data-bs-target="#editthemeModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
        <i class="fa fa-edit"></i> Preference menu
    </a>
    
    <!--<a href="javascript:void(0);" class="dropdown-item notify-item" id="{{ Auth::id() }}" data-bs-toggle="modal" data-bs-target="#editsignatureModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
        <i class="fa fa-edit"></i> Donne FeedBack
    </a>-->

   

    <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
      <i class="fa fa-edit"></i> Fermer la session
    </a> -->

    <a href="javascript:void(0);" class="dropdown-item notify-item" data-bs-toggle="modal" data-bs-target="#deconnecterModalLabel" role="button" aria-expanded="false"> <span class="me-2" data-feather="log-out" title="Déconnectez-vous en cliquant sur l'icône.">
        <i class="fas fa-sign-out-alt"></i> Déconnexion
    </a>

    <!-- item-->



  </div>

</div>


<div class="dropdown d-none d-sm-inline-block">
  <button type="button" class="btn header-item " data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="false">

  <a class="dropdown-item notify-item" class="btn header-item" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-cogs"></i>
    </a>


  </button>
  <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 72px); " data-popper-placement="bottom-end">

    <!-- item-->

    <a href="{{ route('info') }}" class="dropdown-item notify-item" >
      Identifications
    </a>

    <a href="{{ route('notis') }}" class="dropdown-item notify-item" >
        Notifications
    </a>

    <a href="{{ route('history') }}" class="dropdown-item notify-item" >
         Historique
    </a>

    <a href="{{ route('active-users') }}" class="dropdown-item notify-item"  >
        Qui est connecter
    </a>



  </div>

</div>

<div class="dropdown d-none d-lg-inline-block ms-1">

  <button type="button" class="btn header-item noti-icon waves-effect">
    <a href="javascript:void(0);" class="dropdown-item notify-item" data-bs-toggle="modal" data-bs-target="#deconnecterModalLabel" role="button" aria-expanded="false"> <span class="me-2" data-feather="log-out" title="Déconnectez-vous en cliquant sur l'icône.">
        <i class="fa fa-power-off"></i>
    </a>
  </button>
</div>



</div>
        </div>
    </header>

        <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">

                        @if ( $documentNombre != 0)
                        <li class="nav-item">
                        <audio autoplay>
              <source src="{{ asset('notification/son.mp3') }}" type="audio/mpeg">
                Votre navigateur ne supporte pas l'élément audio.
              </audio>

                                <a class="nav-link" href="index.html">
                                <i class="fas fa-file-signature"></i>Documents <span class="badge rounded-pill bg-danger float-end">{{ $documentNombre }}</span>
                                </a>
                            </li>

                            @endif

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">
                                    <i class="ri-dashboard-2-line me-2"></i>Tableau de bord
                                </a>
                            </li>
                            @if (session()->has('id'))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-apps-2-line me-2"></i>Projets <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">

                                @php
                                $IDPJ= Session::get('id');
                                $cryptedId = Crypt::encrypt($IDPJ);
                                @endphp 
                                    <a href="{{ route('key.viewProject', $cryptedId ) }}" class="dropdown-item">Voir le projet</a>
                                    <a href="{{ route('gestioncompte') }}" class="dropdown-item">Ligne budgétaire</a>
                                    <a href="{{ route('rallongebudget') }}" class="dropdown-item">Budget</a>
                                    <a href="{{ route('activity') }}" class="dropdown-item">Activités</a>
                                    <a href="{{ route('listfeb') }}" class="dropdown-item">FEB</a>
                                    <a href="{{ route('listdap') }}" class="dropdown-item">DAP</a>
                                    <a href="{{ route('bpc') }}" class="dropdown-item">Bon de Petite Caisse</a>
                                    <a href="{{ route('affectation') }}" class="dropdown-item">Intervenants</a>
                                    <a href="{{ route('rapportcumule') }}" class="dropdown-item">Rapport commule</a>
                                    <a href="{{ route('planoperationnel') }}" class="dropdown-item">Plan d'action</a>
                                

                                </div>
                            </li>
                            @endif


                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                <i class="fas fa-feather"></i> Outils généraux <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">

                                    <a href="{{ route('folder') }}" class="dropdown-item">Dossier</a>
                                    <a href="{{ route('typebudget') }}" class="dropdown-item">Type de budget</a>
                                    <a href="{{ route('devise') }}" class="dropdown-item">Devise</a>
                                    <a href="{{ route('beneficiaire') }}" class="dropdown-item">Bénéficiaire</a>
                                    <a href="{{ route('banque') }}" class="dropdown-item">Banque</a>
                                    <a href="{{ route('termes') }}" class="dropdown-item">Termes de refference</a>
                                    <a href="{{ route('list_project') }}" class="dropdown-item">Tout les projets</a>
                                </div>
                            </li>


                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                <i class="fas fa-users"></i> R.H <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">

                                                         

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-invoice"
                                            role="button">
                                             Personnel<div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-invoice">
                                           <a href="{{ route('personnel') }}" class="dropdown-item">Tous les employés </a>
                                           <a href="{{ route('user') }}" class="dropdown-item">Utilisateurs</a>
                                           <a href="{{ route('fonction')}}" class="dropdown-item">Fonctions</a>
                                        </div>
                                    </div>

                                    <a href="{{ route('service') }}" class="dropdown-item">Service</a>
                                    <a href="{{ route('department')}}" class="dropdown-item">Departements</a>
                                 

            

                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                <i class="fa fa-archive"></i> Archivage <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <a href="{{ route('archivage') }}" class="dropdown-item">Document</a>
                                    <a href="{{ route('classeur') }}" class="dropdown-item">Classeur</a>
                                    <a href="{{ route('etiquette') }}" class="dropdown-item">Etiquette</a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                <i class="fas fa-taxi"></i> Parc Automobile<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">

                                    <a href="{{ route('parc') }}" class="dropdown-item">Accueil</a>
                                    <a href="{{ route('vehicule') }}" class="dropdown-item">Véhicules</a>
                                    <a href="{{ route('carburents') }}" class="dropdown-item">Carburants</a>
                                    <a href="{{ route('entretient') }}" class="dropdown-item">Entretiens & Réparations</a>
                                    <a href="{{ route('carnet_bord') }}" class="dropdown-item">Carnet de bord</a>
                                    <a href="{{ route('outilspa') }}" class="dropdown-item">Outils gestions</a>

                            
                                </div>
                            </li>

                           

                        </ul>
                    </div>
                </nav>
            </div>
        </div>