<style>
  /* Réduire l'espacement entre les éléments de la liste */
  .navbar-nav  {
    margin-right: -20px; /* Ajuste la marge droite entre les éléments */
  }

  /* Réduire le padding à l'intérieur des liens */
  .navbar-nav .dropdown {
    margin-right: -20px /* Ajuste le padding vertical et horizontal */
  }
</style>

<body data-topbar="colored" data-layout="horizontal">
@php

// Récupérer les données du profil de l'utilisateur
$personnelData = DB::table('personnels')
                  ->where('id',Auth::user()->personnelid)
                  ->first();

$avatar = Auth::user()->avatar;

// DOCUMENT GENERALE
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

// DOCUMENT PETITE CAISSE ETABLIE
$FEB_PETIT_CAISSE_ETABLIE_PAR= DB::table('febpetitcaisses')
->Where('etabli_par', Auth::id() )
->Where('etabli_par_signature',  0)
->get()
->count();

// DOCUMENT PETITE CAISSE VERIFIER 
$FEB_PETIT_CAISSE_VERIFIER_PAR= DB::table('febpetitcaisses')
->Where('verifie_par', Auth::id() )
->Where('verifie_par_signature',  0)
->get()
->count();

// DOCUMENT PETITE CAISSE APPROUVER 
$FEB_PETIT_CAISSE_APPROUVER_PAR= DB::table('febpetitcaisses')
->Where('approuve_par', Auth::id() )
->Where('approuve_par_signature',  0)
->get()
->count();

//1 DOCUMENT PETITE CAISSE DAP ETABLIE 
$DAP_PETIT_CAISSE_ETABLIE = DB::table('dapbpcs')
->Where('demande_etablie', Auth::id() )
->Where('demande_etablie_signe',  0)
->get()
->count();

//2 DOCUMENT PETITE CAISSE DAP VERIFIER 
$DAP_PETIT_CAISSE_VERIFIER = DB::table('dapbpcs')
->Where('verifier', Auth::id() )
->Where('verifier_signe',  0)
->get()
->count();

//3 DOCUMENT PETITE CAISSE DAP APPROUVER 
$DAP_PETIT_CAISSE_APPROUVER= DB::table('dapbpcs')
->Where('approuver', Auth::id() )
->Where('approuver_signe',  0)
->get()
->count();

//4 DOCUMENT PETITE CAISSE DAP AUTORISER 
$DAP_PETIT_CAISSE_AUTORISER = DB::table('dapbpcs')
->Where('autoriser', Auth::id() )
->Where('autoriser_signe',  0)
->get()
->count();

//5 DOCUMENT PETITE CAISSE DAP SECRETAIRE 
$DAP_PETIT_CAISSE_SECRETAIRE = DB::table('dapbpcs')
->Where('secretaire', Auth::id() )
->Where('secretaire_signe',  0)
->get()
->count();

//6 DOCUMENT PETITE CAISSE DAP CHEF PROGRAMME
$DAP_PETIT_CAISSE_CHEF_PROGRAMME = DB::table('dapbpcs')
->Where('chefprogramme', Auth::id() )
->Where('chefprogramme_signe',  0)
->get()
->count();

//1 BON PETITE CAISSE ETABLIE
$BON_PETIT_CAISSE_ETABLIE_PAR= DB::table('bonpetitcaisses')
->Where('etabli_par', Auth::id() )
->Where('etabli_par_signature',  0)
->get()
->count();

//2 BON PETITE CAISSE VERIFIER 
$BON_PETIT_CAISSE_VERIFIER_PAR= DB::table('bonpetitcaisses')
->Where('verifie_par', Auth::id() )
->Where('verifie_par_signature',  0)
->get()
->count();

//3 BON  PETITE CAISSE APPROUVER 
$BON_PETIT_CAISSE_APPROUVER_PAR = DB::table('bonpetitcaisses')
->Where('approuve_par', Auth::id() )
->Where('approuve_par_signature',  0)
->get()
->count();


//1 CAISSE REPORT PETITE CAISSE VERIFIER 
$CAISSE_PETIT_CAISSE_VERIFIER_PAR= DB::table('rappotages')
->Where('verifier_par', Auth::id() )
->Where('verifier_signature',  0)
->get()
->count();

//2 CAISSE REPORT  PETITE CAISSE APPROUVER 
$CAISSE_PETIT_CAISSE_APPROUVER_PAR = DB::table('rappotages')
->Where('approver_par', Auth::id() )
->Where('approver_signature',  0)
->get()
->count();


$dap_nombre= $dap_demandeetablie + $dap_verifier + $dap_approuverpar + $dap_responsable + $dap_secretaire + $dap_chefprogramme ;
$fab_nombre= $documentacce + $documentcompte + $documentchefcomposent;
$FEB_PET_CAISSE = $FEB_PETIT_CAISSE_ETABLIE_PAR + $FEB_PETIT_CAISSE_VERIFIER_PAR + $FEB_PETIT_CAISSE_APPROUVER_PAR;
$DAP_PETITE_CAISSE = $DAP_PETIT_CAISSE_ETABLIE +  $DAP_PETIT_CAISSE_VERIFIER + $DAP_PETIT_CAISSE_APPROUVER + $DAP_PETIT_CAISSE_AUTORISER + $DAP_PETIT_CAISSE_SECRETAIRE + $DAP_PETIT_CAISSE_CHEF_PROGRAMME ;
$BON_PTC = $BON_PETIT_CAISSE_ETABLIE_PAR + $BON_PETIT_CAISSE_VERIFIER_PAR + $BON_PETIT_CAISSE_APPROUVER_PAR ;
$CAISSE_PTC = $CAISSE_PETIT_CAISSE_VERIFIER_PAR + $CAISSE_PETIT_CAISSE_APPROUVER_PAR ; 

$documentNombre = $dap_nombre + $fab_nombre + $FEB_PET_CAISSE + $DAP_PETITE_CAISSE + $BON_PTC + $CAISSE_PTC;

if(session()->has('id')){

  $ProjetIdEncours = Session::get('id');
  $classement =  DB::table('rappotages')
                    ->where('cloture', 0)
                    ->where('projetid', $ProjetIdEncours)
                    ->first();


}



@endphp
  <!-- Begin page -->
  <div id="layout-wrapper">

    <div class="pace-progress"></div>
    <header id="page-topbar">
      <div class="navbar-header">



        <div class="d-flex">
          <!-- LOGO -->
          <div class="navbar-brand-box">
            <button type="button" class="btn btn-sm px-3 font-size-20  header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
              <B><i class="ri-menu-2-line align-middle"></i> CEPBU</B>
            </button>
          </div>



          <!-- App Search-->



          <!-- Projet session et recherche-->

          @if (session()->has('id'))
          
          <div class="callout callout-info" style="color:white">
            <br>
            @php
            $titprojet = Session::get('title');
            @endphp
            <p> <b>Projet encours : </b>{{ strlen($titprojet) > 35 ? substr($titprojet, 0, 35) . '...' : $titprojet }} </p>

          </div>
          @else

          <form class="app-search d-none d-lg-block">
            <div class="position-relative">
              <input type="text" class="form-control" placeholder="Recherche...">
              <span class="ri-search-line"></span>
            </div>
          </form>
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
                <img class="rounded-circle header-profile-user" src="../../{{ $avatar }}" alt="{{ ucfirst(Auth::user()->identifiant) }}" style="width: 30px; height: 30px; border: 1px solid green; border-radius: 50%;">
                <br> <small> {{ ucfirst($personnelData->prenom ) }} </small>
                @else
                <img class="rounded-circle header-profile-user" src="{{ $defaultAvatar }}" alt="{{ ucfirst(Auth::user()->identifiant) }}" style="width: 30px; height: 30px; border: 1px solid green; border-radius: 50%;">
                <br> <small> {{ ucfirst($personnelData->prenom ) }}</small>
                @endif



              </a>


            </button>
            <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 72px); " data-popper-placement="bottom-end">

              <!-- item-->
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
              @if ($documentNombre != 0)
              <audio autoplay>
                <source src="{{ asset('notification/son.mp3') }}" type="audio/mpeg">
                Votre navigateur ne supporte pas l'élément audio.
              </audio>

              <li class="nav-item">
                <a class="nav-link" href="#" class="waves-effect" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">
                  <i class="ri-apps-2-line me-1"></i> Documents <span class="badge rounded-pill bg-danger float-end">{{ $documentNombre }}</span>
                </a>
              </li>
              @endif
              <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                  <i class="ri-dashboard-2-line me-2"></i>Tableau de bord
                </a>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button">
                  <i class="ri-list-settings-fill  me-1"></i> Outils <div class="arrow-down"></div>
                </a>
                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                  <a href="{{ route('folder') }}" class="dropdown-item">Dossier</a>
                  <a href="{{ route('typebudget') }}" class="dropdown-item">Type de budget</a>
                  <a href="{{ route('devise') }}" class="dropdown-item">Devise</a>
                  <a href="{{ route('beneficiaire') }}" class="dropdown-item">Bénéficiaire</a>
                  <a href="{{ route('banque') }}" class="dropdown-item">Banque</a>
                  <a href="{{ route('termes') }}" class="dropdown-item">Termes de Reference</a>
                  <a href="{{ route('list_project') }}" class="dropdown-item">Tous les projets</a>
                </div>
              </li>


              @if (session()->has('id'))
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button">
                  <i class="ri-apps-2-line me-1"></i>Projet <div class="arrow-down"></div>
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
                      <a href="{{ route('affectation') }}" class="dropdown-item">Intervenants</a>
                      <a href="{{ route('rapportcumule') }}" class="dropdown-item">Rapport commule</a>
                      <a href="{{ route('planoperationnel') }}" class="dropdown-item">Plan d'action</a>
                </div>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button">
                  <i class="ri-apps-2-line me-1"></i>Documents <div class="arrow-down"></div>
                </a>
                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                  <a href="{{ route('listfeb') }}" class="dropdown-item">FEB</a>
                  <a href="{{ route('listdap') }}" class="dropdown-item">DAP</a>
                  <a href="{{ route('listdja') }}" class="dropdown-item">DJA</a>
                </div>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button">
                  <i class="ri-apps-2-line me-1"></i>Petite Caisse <div class="arrow-down"></div>
                </a>
                <div class="dropdown-menu" aria-labelledby="topnav-apps">

                @if(isset($classement))
                     
                <a href="{{ route('Rapport.cloture.caisse') }}" class="dropdown-item">
                      <div class="spinner-grow text-warning m-1" role="status" style="width: 0.7rem; height: 0.7rem;">
                          <span class="sr-only">Loading...</span>
                      </div>
                      <span>Cloture caisse </span>
                      
                  </a>

                @else
                    <a href="{{ route('bpc') }}" class="dropdown-item">B.P.C </a>
                    <a href="{{ route('cpc') }}" class="dropdown-item">Compte </a>
                    <a href="{{ route('febpc') }}" class="dropdown-item">F.E.B</a>
                    <a href="{{ route('dappc') }}" class="dropdown-item">D.A.P </a>

                @endif    

                 <a href="{{ route('Rapport.caisse') }}" class="dropdown-item">Rapport Caisse</a>

                
                </div>
              </li>

            



              
              @endif


              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button">
                  <i class="ri-apps-2-line me-1"></i>Rapports <div class="arrow-down"></div>
                </a>
                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                  <a href="{{ route('rapportcumule') }}" class="dropdown-item">Rapport Cummule </a>
                  <a href="{{ route('Rapport.caisse') }}" class="dropdown-item">Rapport Petite Caisse</a>
                </div>
              </li>


              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button">
                  <i class="ri-apps-2-line me-1"></i>Autres <div class="arrow-down"></div>
                </a>
                <div class="dropdown-menu" aria-labelledby="topnav-apps">

                     
                  <a href="{{ route('communique') }}" class="dropdown-item">Communique </a>
                  <a href="{{ route('start') }}" class="dropdown-item">Quitter le service</a>
                  
                </div>
              </li>


            
             

              

           

            </ul>
          </div>
        </nav>
      </div>
    </div>