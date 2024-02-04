<body data-sidebar="colored">

  <div id="layout-wrapper">

    <div class="pace-progress"></div>
    <header id="page-topbar">
      <div class="navbar-header">
        <div class="d-flex">
          <!-- LOGO -->
          <div class="navbar-brand-box">
            <a href="index.html" class="logo logo-dark">
              <span class="logo-sm">
                <img src="{{ asset('element/assets/images/logo-sm-dark.png')}}" alt="logo-sm-dark" height="24">
              </span>
              <span class="logo-lg">
                <img src="{{ asset('element/assets/images/logo-dark.png')}}" alt="logo-dark" height="25">
              </span>
            </a>

            <a href="index.html" class="logo logo-light">
              <span class="logo-sm">
                <img src="{{ asset('element/assets/images/logo-sm-light.png')}}" alt="logo-sm-light" height="24">
              </span>
              <span class="logo-lg">
                <img src="{{ asset('element/assets/images/logo-light.png')}}" alt="logo-light" height="25">
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
            <p><b>Projet encours de traitement : </b>{{ Session::get('title') }} </p>

          </div>
          @else

          <form class="app-search d-none d-lg-block">
            <div class="position-relative">
              <input type="text" class="form-control" placeholder="Search...">
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

          <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="ri-notification-3-line"></i>
              <span class="noti-dot"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
              <div class="p-3">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="m-0"> Notifications </h6>
                  </div>
                  <div class="col-auto">
                    <a href="#!" class="small"> View All</a>
                  </div>
                </div>
              </div>
              <div data-simplebar style="max-height: 230px;">




                <a href="#" class="text-reset notification-item">
                  <div class="d-flex">
                    <div class="avatar-xs me-3">
                      <span class="avatar-title bg-success rounded-circle font-size-16">
                        <i class="ri-checkbox-circle-line"></i>
                      </span>
                    </div>
                    <div class="flex-1">
                      <h6 class="mb-1">Your item is shipped</h6>
                      <div class="font-size-12 text-muted">
                        <p class="mb-1">If several languages coalesce the grammar</p>
                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                      </div>
                    </div>
                  </div>
                </a>


              </div>
              <div class="p-2 border-top">
                <div class="d-grid">
                  <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                    <i class="mdi mdi-arrow-right-circle me-1"></i> View More..
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="dropdown d-none d-sm-inline-block">
            <button type="button" class="btn header-item waves-effect show" data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="false">

              <i class="ri-user-3-line"></i>

            </button>
            <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 72px);" data-popper-placement="bottom-end">

              <!-- item-->
              <a href="javascript:void(0);" class="dropdown-item notify-item editpersonnel" id="{{ Auth::id() }}" data-bs-toggle="modal" data-bs-target="#EditPersonnelModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
                  <i class="fa fa-user-edit"></i> Mon profile
              </a>

              <a href="javascript:void(0);" class="dropdown-item notify-item editpersonnelpasseword" id="{{ Auth::id() }}" data-bs-toggle="modal" data-bs-target="#EditPersonnelModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
                  <i class="fa fa-edit"></i> Modifier le mot de passe
              </a>

              <a href="javascript:void(0);" class="dropdown-item notify-item">
                <i class="fa fa-edit"></i> Fermer la session
              </a>

              <a href="javascript:void(0);" class="dropdown-item notify-item" href="#" data-bs-toggle="modal" data-bs-target="#deconnecterModalLabel" role="button" aria-expanded="false"> <span class="me-2" data-feather="log-out" title="Déconnectez-vous en cliquant sur l'icône.">
                  <i class="fas fa-sign-out-alt"></i> Déconnexion
              </a>

              <!-- item-->



            </div>

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
                <i class="ri-dashboard-2-line"></i><span class="badge rounded-pill bg-success float-end">3</span>
                <span>Tableau de bord</span>
              </a>
            </li>



            <li class="menu-title">Projet</li>


            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="ri-projector-line"></i>
                <span>Projet</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <li><a href="email-inbox.html">Inbox</a></li>
                <li><a href="email-read.html">Read Email</a></li>
              </ul>
            </li>

            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="ri-projector-line"></i>
                <span>Activites</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <li><a href="email-inbox.html">Inbox</a></li>
                <li><a href="email-read.html">Read Email</a></li>
              </ul>
            </li>

            <li class="menu-title">RH</li>

            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="ri-projector-line"></i>
                <span>RH</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <li><a href="email-inbox.html">Tableau de bord</a></li>
                <li><a href="javascript: void(0);" class="has-arrow">Personnel</a>
                  <ul class="sub-menu" aria-expanded="true">
                    <li><a href="{{ route('personnel') }}">Tous les employés</a></li>
                    <li><a href="javascript: void(0);">Level 2.2</a></li>
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
                <li><a href="email-inbox.html">Tableau de bord</a></li>
                <li><a href="javascript: void(0);" class="has-arrow">Vehicule</a>
                  <ul class="sub-menu" aria-expanded="true">
                    <li><a href="{{ route('vehicule') }}">Vehicule</a></li>
                    <li><a href="javascript: void(0);">A.L</a></li>
                    <!--Achats / Locations -->
                    <li><a href="javascript: void(0);">A.T.V</a></li>
                    <!-- Assurences/Taxes/Visites -->
                  </ul>
                </li>
                <li><a href="email-inbox.html">Conducteurs</a></li>
                <li><a href="email-inbox.html">Entretiens</a></li>
                <li><a href="email-inbox.html">Reparation</a></li>
                <li><a href="email-inbox.html">Carburent</a></li>
                <li><a href="email-inbox.html">Piece</a></li>
              </ul>
            </li>





            <li class="menu-title">Pages</li>

            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="ri-pie-chart-line"></i>
                <span>Charts</span>
              </a>
              <ul class="sub-menu" aria-expanded="true">
                <li><a href="javascript: void(0);" class="has-arrow">Apexcharts Part 1</a>
                  <ul class="sub-menu" aria-expanded="true">
                    <li><a href="charts-line.html">Line</a></li>
                    <li><a href="charts-area.html">Area</a></li>
                    <li><a href="charts-column.html">Column</a></li>
                    <li><a href="charts-bar.html">Bar</a></li>
                    <li><a href="charts-mixed.html">Mixed</a></li>
                    <li><a href="charts-timeline.html">Timeline</a></li>
                    <li><a href="charts-candlestick.html">Candlestick</a></li>
                    <li><a href="charts-boxplot.html">Boxplot</a></li>
                  </ul>
                </li>
                <li><a href="javascript: void(0);" class="has-arrow">Apexcharts Part 2</a>
                  <ul class="sub-menu" aria-expanded="true">
                    <li><a href="charts-bubble.html">Bubble</a></li>
                    <li><a href="charts-scatter.html">Scatter</a></li>
                    <li><a href="charts-heatmap.html">Heatmap</a></li>
                    <li><a href="charts-treemap.html">Treemap</a></li>
                    <li><a href="charts-pie.html">Pie</a></li>
                    <li><a href="charts-radialbar.html">Radialbar</a></li>
                    <li><a href="charts-radar.html">Radar</a></li>
                    <li><a href="charts-polararea.html">Polararea</a></li>
                  </ul>
                </li>
                <li><a href="charts-echart.html">E Charts</a></li>
              </ul>
            </li>

            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-cog-outline"></i>
                <span>Paramètre</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('user') }}">Utilisateur</a></li>
                <li><a href="{{ route('info') }}">Identification</a></li>
                <li><a href="{{ route('service') }}">Service</a></li>
                <li><a href="{{ route('fonction')}}">Fonction</a></li>
                <li><a href="{{ route('department')}}">Departement</a></li>
              </ul>
            </li>

            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-comment-text-multiple"></i>
                <span>Autres</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('notis') }}">Notification</a></li>
                <li><a href="{{ route('history') }}">Historique</a></li>
              </ul>
            </li>

            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="ri-share-line"></i>
                <span>Multi Level</span>
              </a>
              <ul class="sub-menu" aria-expanded="true">
                <li><a href="javascript: void(0);">Level 1.1</a></li>
                <li><a href="javascript: void(0);" class="has-arrow">Level 1.2</a>
                  <ul class="sub-menu" aria-expanded="true">
                    <li><a href="javascript: void(0);">Level 2.1</a></li>
                    <li><a href="javascript: void(0);">Level 2.2</a></li>
                  </ul>
                </li>
              </ul>
            </li>

          </ul>
        </div>
        <!-- Sidebar -->
      </div>
    </div>
    <!-- Left Sidebar End -->