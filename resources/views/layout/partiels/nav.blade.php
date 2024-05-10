<body data-sidebar="colored" id="contenu">

  @php
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

$documentNombre= $documentacce + $documentcompte + $documentchefcomposent;

@endphp
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
          <div class="callout callout-info">
            <br>
            @php
            $titprojet = Session::get('title');
            @endphp
            <p><b>Projet encours : </b>{{ strlen($titprojet) > 60 ? substr($titprojet, 0, 60) . '...' : $titprojet }} </p>

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
              <a href="{{ route('closeproject') }}" class="btn btn-outline-danger rounded-pill me-1 mb-1" type="button" data-bs-toggle="modal" data-bs-target="#verticallyCentered"><i class="fas fa-sign-out-alt"></i> Quitter le projet</a>
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
          @if ( $documentNombre != 0)
          <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="ri-notification-3-line"></i>
              <span class="noti-dot"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
              <div class="p-3">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="m-0"> Documents en attentes </h6>
                  </div>
                 
                </div>
              </div>
              <div data-simplebar style="max-height: 230px;" id="navallnotification">




                

                


              </div>
              <div class="p-2 border-top">
                <div class="d-grid">
                  <a class=" waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" href="javascript:void(0)">
                  <center> <i class="mdi mdi-arrow-right-circle me-1"></i>Voir plus..</center>
                  </a>
                </div>
              </div>
            </div>
          </div>
          @endif


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
                  <br> <small> {{ ucfirst(Session::get('prenomauth')) }} </small>
                  @else
                  <img class="rounded-circle header-profile-user" src="{{ $defaultAvatar }}" alt="{{ ucfirst(Auth::user()->identifiant) }}"  style="width: 30px; height: 30px; border: 1px solid green; border-radius: 50%;">
                  <br> <small> {{ ucfirst(Session::get('prenomauth')) }} </small>
                  @endif



              </a>


            </button>
            <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 72px);" data-popper-placement="bottom-end">

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

              <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                <i class="fa fa-edit"></i> Fermer la session
              </a> -->

              <a href="javascript:void(0);" class="dropdown-item notify-item" data-bs-toggle="modal" data-bs-target="#deconnecterModalLabel" role="button" aria-expanded="false"> <span class="me-2" data-feather="log-out" title="Déconnectez-vous en cliquant sur l'icône.">
                  <i class="fas fa-sign-out-alt"></i> Déconnexion
              </a>

              <!-- item-->



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
    <!-- ========== Left Sidebar Start ========== -->

    <div class="vertical-menu">
      <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
          <!-- Left Menu Start -->
          <ul class="metismenu list-unstyled" id="side-menu">
            <li class="menu-title">Menu</li>

            <li>
             

              @if ( $documentNombre != 0)

              <audio autoplay>
              <source src="{{ asset('notification/son.mp3') }}" type="audio/mpeg">
                Votre navigateur ne supporte pas l'élément audio.
            </audio>

           

              <a href="#" class="waves-effect" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">
                <i class="ri-dashboard-2-line"></i><span class="badge rounded-pill bg-danger float-end">{{ $documentNombre }}</span>
                <span>Documents</span>
              </a>
            </li>
            @endif

            <li>
              <a href="{{ route('dashboard') }}" class="waves-effect">
                <i class="ri-dashboard-2-line"></i>
                <span>Tableau de bord</span>
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
                $IDPJ= Session::get('id');
                $cryptedId = Crypt::encrypt($IDPJ);

                @endphp
                <li><a href="{{ route('key.viewProject', $cryptedId ) }}">Voir le projet</a></li>
                <li><a href="{{ route('gestioncompte') }}">Ligne budgétaire</a></li>
                <li><a href="{{ route('rallongebudget') }}">Budget</a></li>
                <li><a href="{{ route('activity') }}">Activités</a></li>
                <li><a href="{{ route('listfeb') }}">FEB</a></li>
                <li><a href="{{ route('listdap') }}">DAP</a></li>
                <li><a href="{{ route('listdja') }}">DJA</a></li>  
                <li><a href="{{ route('affectation') }}">Intervenants</a></li>
                <li><a href="{{ route('rapportcumule') }}">Rapport commulatif</a></li>
                <li><a href="{{ route('planoperationnel') }}">Plan d'action</a></li>
                <!--<li><a href="{{ route('listbpc') }}">BPC</a></li>
                <li><a href="{{ route('listsqr') }}">SQR</a></li>
                <li><a href="{{ route('listftd') }}">FTD</a></li> -
               
                -->
              </ul>
            </li>

            @endif

            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="ri-projector-line"></i>
                <span>Outils projets</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">

                <li><a href="{{ route('folder') }}">Dossier</a></li>
                <li><a href="{{ route('typebudget') }}">Type budget</a></li>
                <li><a href="{{ route('devise') }}">Devise</a></li>
                <li><a href="{{ route('beneficiaire') }}">Bénéficiaire</a></li>
                <li><a href="{{ route('list_project') }}">Tout les projets</a></li>

                

              </ul>
            </li>



            <li class="menu-title">RH</li>

            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="ri-projector-line"></i>
                <span>RH</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <!--<li><a href="email-inbox.html">Tableau de bord</a></li>-->

                <li><a href="javascript: void(0);" class="has-arrow">Feuille de temps</a>
                  <ul class="sub-menu" aria-expanded="true">
                    <li><a href="{{ route('feuilletemps') }}">Mon FT</a></li>
                   
                    <!--<li><a href="javascript: void(0);">Level 2.2</a></li>  -->
                  </ul>
                </li>
      
                <li><a href="javascript: void(0);" class="has-arrow">Personnel</a>
                  <ul class="sub-menu" aria-expanded="true">
                    <li><a href="{{ route('personnel') }}">Tous les employés</a></li>
                    <!--<li><a href="javascript: void(0);">Level 2.2</a></li>  -->
                  </ul>
                </li>

              

              </ul>
            </li>


            <li class="menu-title">Archivage</li>

            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="ri-projector-line"></i>
                <span>Archivage</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('archivage') }}">Archive</a></li>
                <li><a href="{{ route('classeur') }}">Classeur</a></li>
              </ul>
            </li>


            <li class="menu-title">Parc Automobile</li>

            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="ri-taxi-fill "></i>
                <span>Parc automobile</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('parc') }}">Accueil</a></li>
              
                <li><a href="{{ route('vehicule') }}">Véhicule</a></li>
                <li><a href="#">Carburents</a></li>
                <li><a href="#">Entretiens</a></li>
                <li><a href="#">Réparations</a></li>
                <li><a href="#">Editions</a></li>
                <li><a href="{{ route('outilspa') }}">Outils gestions</a></li>
              </ul>
            </li>
            





            <li class="menu-title">Pages</li>

            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-cog-outline"></i>
                <span>Paramètre</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('user') }}">Utilisateurs</a></li>
                <li><a href="{{ route('info') }}">Identifications</a></li>
                <li><a href="{{ route('service') }}">Services</a></li>
                <li><a href="{{ route('fonction')}}">Fonctions</a></li>
                <li><a href="{{ route('department')}}">Departements</a></li>
              </ul>
            </li>

            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-comment-text-multiple"></i>
                <span>Autres</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('notis') }}">Notifications</a></li>
                <li><a href="{{ route('history') }}">Historiques</a></li>
              </ul>
            </li>

            <li>
              <a href="javascript:void(0);" class="dropdown-item notify-item" data-bs-toggle="modal" data-bs-target="#deconnecterModalLabel">
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