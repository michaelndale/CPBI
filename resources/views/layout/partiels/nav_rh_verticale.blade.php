<body data-sidebar="colored" id="contenu">
    @php

    // Récupérer les données du profil de l'utilisateur
    $personnelData = DB::table('personnels')
    ->where('id',Auth::user()->personnelid)
    ->first();

    $avatar = Auth::user()->avatar;



    @endphp
    <div id="layout-wrapper">

        <div class="pace-progress"></div>
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">

                    <button type="button" class="btn btn-sm px-3 font-size-20 header-item waves-effect" id="vertical-menu-btn">
                        <b><i class="ri-menu-2-line align-middle"></i> CEPBU</b>
                    </button>

                 
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
                                <br> <small> {{ ucfirst($personnelData->prenom ) }} </small>
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


                        <li>
                            <a href="{{ route('rh') }}" class="waves-effect">
                                <i class="fas fa-home"></i>
                                <span>Tableau de bord {{ Session::get('menu') }} </span>
                            </a>
                        </li>




                        <li class="menu-title">RH</li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-users"></i>
                                <span>Personnel</span>
                            </a>
                           
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{ route('personnel') }}">Tous les employés</a></li>
                                        <li><a href="{{ route('user') }}">Utilisateurs</a></li>
                                        <li><a href="{{ route('fonction')}}">Fonctions</a></li>
                                    </ul>
                                
                        </li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fa fa-calendar-alt"></i>

                                <span>Emploi du temps</span>
                            </a>
                            
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{ route('feuilletemps') }}">FTD</a></li>
                                        <li><a href=" route('rft') ">FTM</a></li>

                                   

                              

                            </ul>
                        </li>




                        <li>
                            <a href="{{ route('service')}}">
                            <i class="fa fa-network-wired"></i>


                                <span>Service</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('department')}}">
                            <i class="fa fa-building"></i>

                                <span>Departements</span>
                            </a>
                        </li>


                        <li>
                            <a href="{{ route('start') }}">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Quitter le service</span>
                            </a>
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