<body data-sidebar="colored" id="contenu">
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
  <div id="layout-wrapper">

    <div class="pace-progress"></div>
    <header id="page-topbar">
      <div class="navbar-header">
        <div class="d-flex">
         
          <button type="button" class="btn btn-sm px-3 font-size-20 header-item waves-effect" id="vertical-menu-btn">
           <b><i class="ri-menu-2-line align-middle"></i> CEPBU</b> 
          </button>

          <!-- Projet session et recherche-->

          @if (session()->has('id'))
          <div class="callout callout-info">
            <br>
            @php
            $titprojet = Session::get('title');
            @endphp
            <p><b>Projet encours : </b>{{ strlen($titprojet) > 70 ? substr($titprojet, 0, 70) . '...' : $titprojet }} </p>

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
                  <br> <small> {{ ucfirst($personnelData->prenom ) }}  </small>
                  @endif



              </a>


            </button>
          <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 72px); " data-popper-placement="bottom-end">
          <a href="javascript:void(0);" class="dropdown-item notify-item editpersonnel" id="{{ Auth::id() }}" data-bs-toggle="modal" data-bs-target="#EditPersonnelModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
                  <i class="ri-user-settings-line "></i> Moi
              </a>
              <a href="javascript:void(0);" class="dropdown-item notify-item" id="{{ Auth::id() }}" data-bs-toggle="modal" data-bs-target="#editMotdepasseModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
                  <i class="ri-user-follow-line "></i> Modifier le mot de passe
              </a>
              <a href="javascript:void(0);" class="dropdown-item notify-item" id="{{ Auth::id() }}" data-bs-toggle="modal" data-bs-target="#editprofileModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
                  <i class="ri-user-received-2-line "></i> Modifier profile
              </a>
              <a href="javascript:void(0);" class="dropdown-item notify-item" id="{{ Auth::id() }}" data-bs-toggle="modal" data-bs-target="#editsignatureModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
                  <i class="ri-pen-nib-fill "></i> Modifier signature
              </a>
              <a href="javascript:void(0);" class="dropdown-item notify-item" id="{{ Auth::id() }}" data-bs-toggle="modal" data-bs-target="#editthemeModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
                  <i class="ri-contrast-fill"></i> Preference menu
              </a>
              <!--<a href="javascript:void(0);" class="dropdown-item notify-item" id="{{ Auth::id() }}" data-bs-toggle="modal" data-bs-target="#editsignatureModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
                      <i class="fa fa-edit"></i> Donne FeedBack
                  </a> <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="fa fa-edit"></i> Fermer la session
                  </a> 
              -->
              <a href="javascript:void(0);" class="dropdown-item notify-item" data-bs-toggle="modal" data-bs-target="#deconnecterModalLabel" role="button" aria-expanded="false"> <span class="me-2" data-feather="log-out" title="Déconnectez-vous en cliquant sur l'icône.">
                  <i class="fas fa-sign-out-alt"></i> Déconnexion
              </a>
             

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
            
              @if ( $documentNombre != 0)
              <audio autoplay>
                    <source src="{{ asset('notification/son.mp3') }}" type="audio/mpeg">
                    Votre navigateur ne supporte pas l'élément audio.
                </audio>
              <li class="nav-item">
                <a href="#" class="waves-effect" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">
                <i class="fas fa-file-signature"></i><span class="badge rounded-pill bg-danger float-end">{{ $documentNombre }}</span>
                <span>Documents</span>
              </a>
              </li>
            @endif

            <li>
              <a href="{{ route('dashboard') }}" class="waves-effect">
                <i class="fas fa-home"></i>
                <span>Tableau de bord {{ Session::get('menu') }} </span>
              </a>
            </li>
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
                <li><a href="{{ route('termes') }}">Termes de  refference</a></li>
              </ul>
            </li>


            <li>
              <a href="{{ route('list_project') }}" >
              <i class="fa fa-list"></i>

                <span>Tout les projets</span>
              </a>
            </li>




            @if (session()->has('id'))
            @php
                $IDPJ= Session::get('id');
                $cryptedId = Crypt::encrypt($IDPJ);

                @endphp
            <li class="menu-title">Projet</li>

            <li>
              <a href="{{ route('key.viewProject', $cryptedId ) }}" >
                <i class="fa fa-eye"></i>
                <span>Voir le projet</span>
              </a>
            </li>

            <li>
              <a href="{{ route('gestioncompte') }}" >
                <i class="fa fa-chart-line"></i>
                <span>Ligne budgétaire</span>
              </a>
            </li>

            <li>
              <a href="{{ route('rallongebudget') }}" >
                <i class="fa fa-chart-bar"></i>
                <span>Budget</span>
              </a>
            </li>

              <li>
              <a href="{{ route('activity') }}" >
                <i class="fa fa-running"></i>
                <span>Activités</span>
              </a>
            </li>
            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
              <i class="fa fa-folder-open"></i>
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
              <i class="fa fa-folder-open"></i>
                <span>Petit caisse</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
               
              
     
              <li> <a href="{{ route('bpc') }}" class="dropdown-item"> Petite Caisse </a></li>
                <li> <a href="{{ route('cpc') }}" class="dropdown-item">Compte </a></li>
                <li> <a href="{{ route('febpc') }}" class="dropdown-item">F.E.B </a></li>
                <li> <a href="{{ route('dappc') }}" class="dropdown-item">D.A.P </a></li>
              
            
             
              </ul>
            </li>

            <li>
              <a href="{{ route('affectation') }}" >
                <i class="fa fa-users"></i>
                <span>Intervenants</span>
              </a>
            </li>

            <li>
              <a href="{{ route('rapportcumule') }}" >
              <i class="fa fa-chart-pie"></i>

                <span>Rapport commulatif</span>
              </a>
            </li>

            <li>
              <a href="{{ route('planoperationnel') }}" >
              <i class="fa fa-tasks"></i>

                <span>Plan d'action</span>
              </a>
            </li>



            @else


            <li>
              <a href="{{ route('start') }}" >
              <i class="fas fa-sign-out-alt"></i>
                <span>Quitter le service</span>
              </a>
            </li>
        

            @endif

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