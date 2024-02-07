


<nav class="navbar navbar-vertical navbar-expand-lg" style="display:none; ">
  <div class="collapse navbar-collapse" id="navbarVerticalCollapse" > 
          <div class="navbar-vertical-content">
            
            <ul class="navbar-nav" id="navbarVerticalNav">
              <li class="nav-item">
                <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-home" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="nv-home">
                    <div class="d-flex align-items-center">
                      <div class="dropdown-indicator-icon">
                        <span class="fas fa-caret-right"></span></div><span class="nav-link-icon"><span data-feather="home"></span></span><span class="nav-link-text">Tableau de bord</span>
                    </div>
                  </a>
                  <div class="parent-wrapper label-1">
                    <ul class="nav collapse parent @if ($active=='Dashboard') show @endif" data-bs-parent="#navbarVerticalCollapse" id="nv-home">
                      <li class="collapsed-nav-item-title d-none"><a hre="{{ route('dashboard') }}" > Tableau de bord</a></li>
                     
                      <li class="nav-item"><a class="nav-link @if ($title=='Dashboard') active @endif " href="{{ route('dashboard') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Accueil </span></div>
                        </a>
                      </li>
                      <li class="nav-item"><a class="nav-link @if ($title=='Login') active @endif " href="project-management.html" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Statistic Projet </span></div>
                        </a>
                      </li>
                      <li class="nav-item"><a class="nav-link" href="crm.html" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Statistic personnel</span></div>
                        </a>
                      </li>
                      <li class="nav-item"><a class="nav-link @if ($title=='Folder') active @endif " href="{{ route('folder') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Dossier</span></div>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </li>

              <li class="nav-item">
                <hr class="navbar-vertical-line" />

               

          @if (session()->has('id'))

          <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-project-management" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-project-management">
                    <div class="d-flex align-items-center">
                      <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div><span class="nav-link-icon"><span data-feather="clipboard"></span></span><span class="nav-link-text">Gestion projet</span>
                    </div>
                  </a>
                  <div class="parent-wrapper label-1">
                    <ul class="nav collapse parent @if ($active=='Project') show @endif" data-bs-parent="#navbarVerticalCollapse" id="nv-project-management">
                      <li class="collapsed-nav-item-title d-none">Projet management</li>

                     

                      <li class="nav-item"><a class="nav-link @if ($title=='FEB') active @endif" href="{{ route('listfeb') }}" title="Fiche de transmission de dossier" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text"> <i class="fa fa-list"></i> FEB</span></div>
                        </a>
                      </li>

                      <li class="nav-item"><a class="nav-link @if ($title=='DAP') active @endif" href="{{ route('listdap') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text"> <i class="fa fa-list"></i> DAP</span></div>
                        </a>
                      </li>
                      <li class="nav-item"><a class="nav-link @if ($title=='DJA') active @endif" href="{{ route('listdja') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text"> <i class="fa fa-list"></i> DJA</span></div>
                        </a>
                      </li>

                         
                    <li class="nav-item"><a class="nav-link @if ($title=='BPC') active @endif" href="{{ route('listbpc') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text"> <i class="fa fa-list"></i> BPC</span></div>
                        </a>
                      </li>

                     

                    
                    

                      <li class="nav-item"><a class="nav-link @if ($title=='SQR') active @endif" href="{{ route('listsqr') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text"> <i class="fa fa-list"></i> SQR</span></div>
                        </a>
                      </li>

                      <li class="nav-item"><a class="nav-link @if ($title=='FTD') active @endif" href="{{ route('listftd') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text"> <i class="fa fa-list"></i> FDT</span></div>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link @if ($title=='Affectation project') active @endif" href="{{ route('affectation') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text"> <i class="fa fa-plus-circle"></i> Affectation projet</span></div>
                        </a>
                      </li>
                      
                      <li class="nav-item"><a class="nav-link @if ($title=='Show project') active @endif" href="{{ route('key.viewProject', Session::get('id') ) }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text"> <i class="fa fa-edit"></i> Detail du projet </span></div>
                        </a>
                      </li>

                      <li class="nav-item"><a class="nav-link @if ($title=='Rapport ') active @endif" href="{{ route('listftd') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text"> <i class="fa fa-list"></i> Rapport </span></div>
                        </a>
                      </li>

                      <li class="nav-item"><a class="nav-link @if ($title=='Compte & Ligne') active @endif" href="{{ route('gestioncompte') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text"> <i class="fa fa-link"></i> Ligne compte </span></div>
                        </a>
                      </li>



                    
                    

                    </ul>
                  </div>
          </div>

          <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-rapport" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-activite">
                    <div class="d-flex align-items-center">
                      <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div><span class="nav-link-icon"><span data-feather="bookmark"></span></span><span class="nav-link-text">Budgetisation</span>
                    </div>
                  </a>
                  <div class="parent-wrapper label-1">
                    <ul class="nav collapse parent @if ($active=='Budgetisation') show @endif " data-bs-parent="#navbarVerticalCollapse" id="nv-rapport">
                    
                      <li class="nav-item"><a class="nav-link @if ($title=='Budgetisation') active @endif" href="{{ route('rallongebudget') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Rallonge budgetaire</span></div>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>

      

                <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-activite" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-activite">
                    <div class="d-flex align-items-center">
                      <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div><span class="nav-link-icon"><span data-feather="edit"></span></span><span class="nav-link-text">Activité</span>
                    </div>
                  </a>
                  <div class="parent-wrapper label-1">
                    <ul class="nav collapse parent @if ($active=='Activite') show @endif " data-bs-parent="#navbarVerticalCollapse" id="nv-activite">
                    
                      <li class="nav-item"><a class="nav-link @if ($title=='Activite') active @endif" href="{{ route('activity') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Activite</span></div>
                        </a>
                      </li>

                      <li class="nav-item"><a class="nav-link @if ($title=='Category') active @endif" href="{{ route('catActivity') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Categorie </span></div>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>

        
                



          <div class="nav-item-wrapper">
                  <a class="nav-link dropdown-indicator label-1" href="#nv-rh" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-rh">
                    <div class="d-flex align-items-center">
                      <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div><span class="nav-link-icon"><span data-feather="users"></span></span><span class="nav-link-text">RH</span>
                    </div>
                  </a>
                  <div class="parent-wrapper label-1">
                    <ul class="nav collapse parent @if ($active=='RH') show @endif " data-bs-parent="#navbarVerticalCollapse" id="nv-rh">
                      <li class="nav-item"><a class="nav-link @if ($title=='Recherche vehicule') active @endif" href="" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Tableau de bord</span></div>
                        </a>
                      </li>

                      <li class="nav-item"><a class="nav-link dropdown-indicator" href="#nv-personnele" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-simple">
                          <div class="d-flex align-items-center">
                            <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div><span class="nav-link-text">Personnelle </span><span class="fa-solid fa-circle text-info ms-1 new-page-indicator" style="font-size: 6px"></span>
                          </div>
                        </a><!-- more inner pages-->
                        <div class="parent-wrapper">
                          <ul class="nav collapse parent  @if ($title=='Personnel') show @endif  " data-bs-parent="#vehicule" id="nv-personnele">
                            <li class="nav-item"><a class="nav-link  @if ($title=='Personnel') active @endif  " href="{{ route('personnel')}}" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text">Tous les employés</span></div>
                              </a><!-- more inner pages-->
                            </li>
                            <li class="nav-item"><a class="nav-link" href="" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text">Achats</span></div>
                              </a><!-- more inner pages-->
                            </li>
                          
                          </ul>
                        </div>
                      </li>
                    </ul>
                </div>
            </div>


                <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-archivage" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-archivage">
                    <div class="d-flex align-items-center">
                      <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div><span class="nav-link-icon"><span data-feather="server"></span></span><span class="nav-link-text">Archivage</span>
                    </div>
                  </a>
                  <div class="parent-wrapper label-1">
                    <ul class="nav collapse parent @if ($active=='Archivage') show @endif " data-bs-parent="#navbarVerticalCollapse" id="nv-archivage">
                      <li class="nav-item"><a class="nav-link @if ($title=='Archivage') active @endif" href="{{ route('archivage') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Archivage</span></div>
                        </a>
                      </li>

                      <li class="nav-item"><a class="nav-link @if ($title=='Classeur') active @endif" href="{{ route('classeur') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Classeur</span></div>
                        </a>
                      </li>
                     
                     
                     
                    </ul>
                  </div>
                </div>

                <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-parc" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-parc">
                    <div class="d-flex align-items-center">
                      <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div><span class="nav-link-icon"><span data-feather="truck"></span></span><span class="nav-link-text">Parc automobile</span>
                    </div>
                  </a>
                  <div class="parent-wrapper label-1">
                    <ul class="nav collapse parent @if ($active=='Parc') show @endif " data-bs-parent="#navbarVerticalCollapse" id="nv-parc">
                      <li class="nav-item"><a class="nav-link @if ($title=='Recherche vehicule') active @endif" href="" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Recherche</span></div>
                        </a>
                      </li>

                      <li class="nav-item"><a class="nav-link dropdown-indicator" href="#nv-simple" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-simple">
                          <div class="d-flex align-items-center">
                            <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div><span class="nav-link-text">Vehicules</span><span class="fa-solid fa-circle text-info ms-1 new-page-indicator" style="font-size: 6px"></span>
                          </div>
                        </a><!-- more inner pages-->
                        <div class="parent-wrapper">
                          <ul class="nav collapse parent" data-bs-parent="#vehicule" id="nv-simple">
                            <li class="nav-item"><a class="nav-link" href="{{ route('vehicule')}}" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text">Vehicules</span></div>
                              </a><!-- more inner pages-->
                            </li>
                            <li class="nav-item"><a class="nav-link" href="../../pages/authentication/simple/sign-up.html" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text">Achats / Locations</span></div>
                              </a><!-- more inner pages-->
                            </li>
                            <li class="nav-item"><a class="nav-link" href="../../pages/authentication/simple/sign-up.html" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text">Assurences/Taxes/Visites</span></div>
                              </a><!-- more inner pages-->
                            </li>
      
                          </ul>
                        </div>
                      </li>
                      <li class="nav-item"><a class="nav-link @if ($title=='Conducteur') active @endif" href="{{ route('conducteur') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Conducteurs</span></div>
                        </a>
                      </li>

                    

                      <li class="nav-item"><a class="nav-link @if ($title=='Entretiens') active @endif" href="#" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Entretiens</span></div>
                        </a>
                      </li>

                      <li class="nav-item"><a class="nav-link @if ($title=='Reparation') active @endif" href="#" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Reparation</span></div>
                        </a>
                      </li>

                      <li class="nav-item"><a class="nav-link @if ($title=='Carburent') active @endif" href="#" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Carburent</span></div>
                        </a>
                      </li>

                      <li class="nav-item"><a class="nav-link @if ($title=='Piece') active @endif" href="#" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Piece</span></div>
                        </a>
                      </li>
                     
                     
                     
                    </ul>
                  </div>
                </div>

               


                
                <!-- Portier -->
                <div class="nav-item-wrapper"><a class="nav-link label-1 @if ($active=='Portier') active @endif" href="{{ route('portier') }}" role="button" data-bs-toggle="" aria-expanded="false">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span data-feather="columns"></span></span><span class="nav-link-text-wrapper"><span class="nav-link-text"> Portier </span></span></div>
                  </a>
                </div>
                <!-- FIn portier -->

                

             

                <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-customization" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-customization">
                    <div class="d-flex align-items-center">
                      <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div><span class="nav-link-icon"><span data-feather="settings"></span></span><span class="nav-link-text">Paramètre</span>
                    </div>
                  </a>
                  <div class="parent-wrapper label-1">
                    <ul class="nav collapse parent @if ($active=='Parameter') show @endif "" data-bs-parent="#navbarVerticalCollapse" id="nv-customization">
                      <li class="collapsed-nav-item-title d-none">Customization</li>

                      <li class="nav-item"><a class="nav-link @if ($title=='Utilisateur') active @endif" href="{{ route('user') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Utilisateur</span></div>
                        </a>
                      </li>
                      
                      <li class="nav-item"><a class="nav-link @if ($title=='New Indetification' || $title=='Edit Identification') active @endif" href="{{ route('info') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Identification</span></div>
                        </a>
                      </li>

                      <li class="nav-item"><a class="nav-link @if ($title=='Service') active @endif" href="{{ route('service') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Service</span></div>
                        </a>
                      </li>
                      <li class="nav-item"><a class="nav-link @if ($title=='Function') active @endif" href="{{ route('fonction') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Fonction</span></div>
                        </a>
                      </li>
                      <li class="nav-item"><a class="nav-link @if ($title=='Profile') active @endif" href="{{ route('profile') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Profil</span></div>
                        </a>
                      </li>
                      <li class="nav-item"><a class="nav-link @if ($title=='Depatment') active @endif" href="{{ route('department') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Departement</span></div>
                        </a>
                      </li>

                      <li class="nav-item"><a class="nav-link @if ($title=='History') active @endif" href="{{ route('history') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Historique</span></div>
                        </a>
                      </li>

                      <li class="nav-item"><a class="nav-link @if ($title=='Notifications') active @endif" href="{{ route('notis') }}" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Notification</span></div>
                        </a>
                      </li>
                    </ul>
                  </div>

                  <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-CRM" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-CRM">
                    <div class="d-flex align-items-center">
                      <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div><span class="nav-link-icon"><span data-feather="trash-2"></span></span><span class="nav-link-text">Trash</span><span class="fa-solid fa-circle text-info ms-1 new-page-indicator" style="font-size: 6px"></span>
                    </div>
                  </a>
                  <div class="parent-wrapper label-1">
                    <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-CRM">
                      <li class="collapsed-nav-item-title d-none">CRM</li>
                      <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Analytics</span></div>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>

                </div>
                <br>
                <div class="nav-item-wrapper"><a class="nav-link label-1" href="#"  data-bs-toggle="modal" data-bs-target="#deconnecterModalLabel" role="button"  aria-expanded="false">
                    <div class="d-flex align-items-center"><i class="fas fa-sign-out-alt"></i><span class="nav-link-text-wrapper"><span class="nav-link-text" title="Déconnectez-vous en cliquant sur l'icône."> &nbsp; 
                      Déconnexion </span></span>
                    </div>
                  </a>
                </div>
              </li>

          
            </ul>
          </div>
        </div>
        <div class="navbar-vertical-footer">
          <button class="btn navbar-vertical-toggle border-0 fw-semi-bold w-100 white-space-nowrap d-flex align-items-center"> 
            <span class="uil uil-left-arrow-to-left fs-0"></span>
            <span class="uil uil-arrow-from-right fs-0"></span>
            <span class="navbar-vertical-footer-text ms-2">Vue réduite</span></button></div>
      </nav> 




      <nav class="navbar navbar-top fixed-top navbar-expand" id="navbarDefault" style="display:none;">
        <div class="collapse navbar-collapse justify-content-between">
          <div class="navbar-logo">
        
            <a class="navbar-brand me-1 me-sm-3" href="{{ route('dashboard') }}">
              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center">
                  <p class="logo-text ms-2 d-none d-sm-block"><i class="far fa-chart-bar"></i>  CEPBU </p>
                 
                </div>
              </div>
            </a>
          </div>
          
        <div class="search-box navbar-top-search-box d-none d-lg-block" data-list='{"valueNames":["title"]}' style="width:43rem;">
            @if (session()->has('id'))   
                <div class="callout callout-info">
                  <br>
                  <p><b>Projet encours de traitement : </b>{{ Session::get('title') }} </p>
                 
                </div>
            @else  
        
            <form class="position-relative" data-bs-toggle="search" data-bs-display="static" style="width:50%; margin:auto">   
              <input class="form-control search-input fuzzy-search rounded-pill form-control-sm" type="search" placeholder="Recherche..." aria-label="Recherche"  />
              <span class="fas fa-search search-box-icon"></span>
            </form> 
            
            <div class="btn-close position-absolute end-0 top-50 translate-middle cursor-pointer shadow-none" data-bs-dismiss="search"><button class="btn btn-link btn-close-falcon p-0" aria-label="Close"></button></div>
            <div class="dropdown-menu border border-300 font-base start-0 py-0 overflow-hidden w-100">
              <div class="scrollbar-overlay" style="max-height: 30rem;">
                <div class="list pb-3">
                  <h6 class="dropdown-header text-1000 fs--2 py-2">24 <span class="text-500">results</span></h6>
                  <hr class="text-200 my-0" />
                  <h6 class="dropdown-header text-1000 fs--1 border-bottom border-200 py-2 lh-sm">Recently Searched </h6>
                
                  
                </div>
                <div class="text-center">
                  <p class="fallback fw-bold fs-1 d-none">No Result Found.</p>
                </div>
              </div>
            </div> 

          @endif
          </div>
          <ul class="navbar-nav navbar-nav-icons flex-row">
            <li class="nav-item">
            @if (session()->has('id'))
            <a href="{{ route('closeproject') }}" class="btn btn-outline-danger rounded-pill me-1 mb-1" type="button" data-bs-toggle="modal" data-bs-target="#verticallyCentered"><i class="fas fa-sign-out-alt"></i> Quitter le projet</a>
            @else
            <a href="{{ route('new_project') }}" class="btn btn-outline-primary rounded-pill me-1 mb-1" type="button"><i class="fa fa-plus-circle"></i> Nouveau projet</a>
            @endif

              <div class="theme-control-toggle fa-icon-wait px-2"><input class="form-check-input ms-0 theme-control-toggle-input" type="checkbox" data-theme-control="phoenixTheme" value="dark" id="themeControlToggle" /><label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch theme"><span class="icon" data-feather="moon"></span></label><label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch theme"><span class="icon" data-feather="sun"></span></label></div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" style="min-width: 2.5rem" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-auto-close="outside"><span data-feather="bell" style="height:20px;width:20px;"></span></a>
              <div class="dropdown-menu dropdown-menu-end notification-dropdown-menu py-0 shadow border border-300 navbar-dropdown-caret" id="navbarDropdownNotfication" aria-labelledby="navbarDropdownNotfication">
                <div class="card position-relative border-0">
                  <div class="card-header p-2">
                    <div class="d-flex justify-content-between">
                      <h5 class="text-black mb-0">Notificatons</h5><button class="btn btn-link p-0 fs--1 fw-normal" type="button">Mark all as read</button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="scrollbar-overlay" style="height: 27rem;">
                      <div class="border-300">
                        <div class="px-2 px-sm-3 py-3 border-300 notification-card position-relative read border-bottom">
                          <div class="d-flex align-items-center justify-content-between position-relative">
                            <div class="d-flex">
                              <div class="avatar avatar-m status-online me-3"></div>
                              <div class="flex-1 me-sm-3">
                                <h4 class="fs--1 text-black">Jessie Samson</h4>
                                <p class="fs--1 text-1000 mb-2 mb-sm-3 fw-normal"><span class='me-1 fs--2'>💬</span>Mentioned you in a comment.<span class="ms-2 text-400 fw-bold fs--2">10m</span></p>
                                <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:41 AM </span>August 7,2021</p>
                              </div>
                            </div>
                            <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                              <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                            </div>
                          </div>
                        </div>
                       
                      </div>
                     
                    </div>
                  </div>
                  <div class="card-footer p-0 border-top border-0">
                    <div class="my-2 text-center fw-bold fs--2 text-600"><a class="fw-bolder" href="../pages/notifications.html">Notification history</a></div>
                  </div>
                </div>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" id="navbarDropdownNindeDots" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" data-bs-auto-close="outside" aria-expanded="false"><svg width="16" height="16" viewbox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
                  <circle cx="2" cy="8" r="2" fill="currentColor"></circle>
                  <circle cx="2" cy="14" r="2" fill="currentColor"></circle>
                  <circle cx="8" cy="8" r="2" fill="currentColor"></circle>
                  <circle cx="8" cy="14" r="2" fill="currentColor"></circle>
                  <circle cx="14" cy="8" r="2" fill="currentColor"></circle>
                  <circle cx="14" cy="14" r="2" fill="currentColor"></circle>
                  <circle cx="8" cy="2" r="2" fill="currentColor"></circle>
                  <circle cx="14" cy="2" r="2" fill="currentColor"></circle>
                </svg></a>
              <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-nide-dots shadow border border-300" aria-labelledby="navbarDropdownNindeDots">
                <div class="card bg-white position-relative border-0">
                  <div class="card-body pt-3 px-3 pb-0 overflow-auto scrollbar" style="height: 20rem;">
                    <div class="row text-center align-items-center gx-0 gy-0">
                      
                      <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><font size="5"><i class="far fa-folder-open" alt=""></i></font>
                          <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Project</p>
                        </a></div>

                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><font size="5"><i class="far fa-folder-open" alt=""></i></font>
                          <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Activité</p>
                        </a></div>

                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><font size="5"><i class="far fa-folder-open" alt=""></i></font>
                          <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Comptability</p>
                        </a></div>

                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><font size="5"><i class="far fa-folder-open" alt=""></i></font>
                          <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">RH</p>
                        </a></div>

                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><font size="5"><i class="far fa-folder-open" alt=""></i></font>
                          <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Reponting</p>
                        </a></div>
                      
                    </div>
                  </div>
                </div>
              </div>
            </li>



            <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-l ">
                  <img class="rounded-circle " src=" {{ Session::get('avatar')  }}" alt="" />
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border border-300" aria-labelledby="navbarDropdownUser">
                <div class="card position-relative border-0">
                  <div class="card-body p-0">
                    <div class="text-center pt-4 pb-3">
                      <div class="avatar avatar-xl ">
                       
                        <a class="d-flex align-items-center text-900 text-hover-1000" href="">
                          <div class="avatar avatar-m">
                            @php
                              $session_nom = Session::get('nomauth') 
                            @endphp
                              <div class="avatar-name rounded-circle"><span> {{ ucfirst(substr($session_nom,0,1)) }} </span></div>
                          </div>
                      </a>
                      </div>
                      <h6 class="mt-2 text-black">{{ ucfirst(Session::get('prenomauth')) }}  {{ ucfirst($session_nom) }} <br>  <br> [ {{ ucfirst(Session::get('fonction')) }} ]  </h6>
                    </div>
                    <div class="mb-3 mx-3"><hr></div>
                  </div>
                  <div class="overflow-auto scrollbar" style="height: 10rem;">
                    <ul class="nav d-flex flex-column mb-2 pb-1">
                      <li class="nav-item"><a class="nav-link px-3 editpersonnel" href="javascript:voide()"  id="{{ Auth::id() }}"    data-bs-toggle="modal" data-bs-target="#EditPersonnelModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user"></span><span>Profile</span></a></li>
                       <li class="nav-item"><a class="nav-link px-3 editpersonnelpasseword" href="javascript:voide()" id="{{ Auth::id() }}"  data-bs-toggle="modal" data-bs-target="#EditMotdepasseModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="me-2 text-900" data-feather="edit"></span>Changer mot de passe</a></li>
                      <li class="nav-item"><a class="nav-link px-3" href="javascript:voide()"  id="{{ Auth::id() }}"> <span class="me-2 text-900" data-feather="globe"></span>Language</a></li>
                    </ul>
                  </div>
                  <div class="card-footer p-0 border-top">
                    <br>
                    <div class="px-3"> <a class="btn btn-phoenix-secondary d-flex flex-center w-100" title="Déconnectez-vous en cliquant sur l'icône." href="#"  data-bs-toggle="modal" data-bs-target="#deconnecterModalLabel" role="button"  aria-expanded="false"> <span class="me-2" data-feather="log-out" title="Déconnectez-vous en cliquant sur l'icône."> </span>Déconnexion</a></div>
                   <br>
                  </div>
                </div>
              </div>
            </li>


          </ul>
        </div>
      </nav>



      <nav class="navbar navbar-top navbar-slim fixed-top navbar-expand" id="topNavSlim" style="display:none;">
        <div class="collapse navbar-collapse justify-content-between">
          <div class="navbar-logo">
            <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
            <a class="navbar-brand navbar-brand" href="../index.html">GoProject <span class="text-1000 d-none d-sm-inline">slim</span></a>
          </div>
          <ul class="navbar-nav navbar-nav-icons flex-row">
            <li class="nav-item">
              <div class="theme-control-toggle fa-ion-wait pe-2 theme-control-toggle-slim"><input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle" type="checkbox" data-theme-control="phoenixTheme" value="dark" /><label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch theme"><span class="icon me-1 d-none d-sm-block" data-feather="moon"></span><span class="fs--1 fw-bold">Dark</span></label><label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch theme"><span class="icon me-1 d-none d-sm-block" data-feather="sun"></span><span class="fs--1 fw-bold">Light</span></label></div>
            </li>
            <li class="nav-item"> <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#searchBoxModal"><span data-feather="search" style="height:12px;width:12px;"></span></a></li>
            <li class="nav-item dropdown">
              <a class="nav-link" id="navbarDropdownNotification" href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false"><span data-feather="bell" style="height:12px;width:12px;"></span></a>
              <div class="dropdown-menu dropdown-menu-end notification-dropdown-menu py-0 shadow border border-300 navbar-dropdown-caret" id="navbarDropdownNotfication" aria-labelledby="navbarDropdownNotfication">
                <div class="card position-relative border-0">
                  <div class="card-header p-2">
                    <div class="d-flex justify-content-between">
                      <h5 class="text-black mb-0">Notificatons</h5><button class="btn btn-link p-0 fs--1 fw-normal" type="button">Mark all as read</button>
                    </div>
                  </div>
                  
                  <div class="card-footer p-0 border-top border-0">
                    <div class="my-2 text-center fw-bold fs--2 text-600"><a class="fw-bolder" href="../pages/notifications.html">Notification history</a></div>
                  </div>
                </div>
              </div>
            </li>
            
            <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0 white-space-nowrap" id="navbarDropdownUser" href="#!" role="button" data-bs-toggle="dropdown" aria-haspopup="true" data-bs-auto-close="outside" aria-expanded="false">Olivia <span class="fa-solid fa-chevron-down fs--2"></span></a>
              <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border border-300" aria-labelledby="navbarDropdownUser">
                <div class="card position-relative border-0">
                  <div class="card-body p-0">
                    <div class="text-center pt-4 pb-3">
                      <div class="avatar avatar-xl ">
                        <img class="rounded-circle " src="elements/assets/img/avatar.webp" alt="" />
                      </div>
                      <h6 class="mt-2 text-black">{{ ucfirst(Auth::user()->lastname) }}  {{ ucfirst(Auth::user()->name) }}  </h6>
                    </div>
                    <div class="mb-3 mx-3"><input class="form-control form-control-sm" id="statusUpdateInput" type="text" placeholder="Update your status" /></div>
                  </div>
                  <div class="overflow-auto scrollbar" style="height: 10rem;">
                    <ul class="nav d-flex flex-column mb-2 pb-1">
                      <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="user"></span><span>Profile</span></a></li>
                      <li class="nav-item"><a class="nav-link px-3" href="{{ route('dashboard') }}"><span class="me-2 text-900" data-feather="pie-chart"></span>Dashboard</a></li>
                      <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="lock"></span>Posts &amp; Activity</a></li>
                      <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="settings"></span>Settings &amp; Privacy </a></li>
                      <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="help-circle"></span>Help Center</a></li>
                      <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="globe"></span>Language</a></li>
                    </ul>
                  </div>
                  <div class="card-footer p-0 border-top">
                    <ul class="nav d-flex flex-column my-3">
                      <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="user-plus"></span>Add another account</a></li>
                    </ul>
                    <hr />
                    <div class="px-3"> <a class="btn btn-phoenix-secondary d-flex flex-center w-100" href="#!"> <span class="me-2" data-feather="log-out"> </span>Sign out</a></div>
                    <div class="my-2 text-center fw-bold fs--2 text-600"><a class="text-600 me-1" href="#!">Privacy policy</a>&bull;<a class="text-600 mx-1" href="#!">Terms</a>&bull;<a class="text-600 ms-1" href="#!">Cookies</a></div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </nav>
      <nav class="navbar navbar-top fixed-top navbar-expand-lg" id="navbarTop" style="display:none;">
        <div class="navbar-logo">
          <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTopCollapse" aria-controls="navbarTopCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
          <a class="navbar-brand me-1 me-sm-3" href="/">
            <div class="d-flex align-items-center">
              <div class="d-flex align-items-center"><i class="far fa-chart-bar"></i>
                <p class="logo-text ms-2 d-none d-sm-block">GoProject</p>
              </div>
            </div>
          </a>
        </div>
        <div class="collapse navbar-collapse navbar-top-collapse order-1 order-lg-0 justify-content-center" id="navbarTopCollapse">
          <ul class="navbar-nav navbar-nav-top" data-dropdown-on-hover="data-dropdown-on-hover">
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle lh-1" href="{{ route('dashboard') }}" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false"><span class="uil fs-0 me-2 uil-chart-pie"></span>Dashboard</a>
             
            </li>
          </ul>
        </div>
       
      </nav>
      <nav class="navbar navbar-top navbar-slim justify-content-between fixed-top navbar-expand-lg" id="navbarTopSlim" style="display:none;">
        <div class="navbar-logo">
          <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTopCollapse" aria-controls="navbarTopCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
          <a class="navbar-brand navbar-brand" href="">GoProject</a>
        </div>
        <div class="collapse navbar-collapse navbar-top-collapse order-1 order-lg-0 justify-content-center" id="navbarTopCollapse">
          <ul class="navbar-nav navbar-nav-top" data-dropdown-on-hover="data-dropdown-on-hover">
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle lh-1" href="{{ route('dashboard') }}" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false"><span class="uil fs-0 me-2 uil-chart-pie"></span>Dashboard</a>
            </li>
          </ul>
        </div>

      </nav>
      <nav class="navbar navbar-top fixed-top navbar-expand-lg" id="navbarCombo" data-navbar-top="combo" data-move-target="#navbarVerticalNav" style="display:none;">
        <div class="navbar-logo">
          <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
          <a class="navbar-brand me-1 me-sm-3" href="/">
            <div class="d-flex align-items-center">
              <div class="d-flex align-items-center"><i class="far fa-chart-bar"></i>
                <p class="logo-text ms-2 d-none d-sm-block">GoProject</p>
              </div>
            </div>
          </a>
        </div>
        <div class="collapse navbar-collapse navbar-top-collapse order-1 order-lg-0 justify-content-center" id="navbarTopCollapse">
          
        </div>
        <ul class="navbar-nav navbar-nav-icons flex-row">
          <li class="nav-item">
            <div class="theme-control-toggle fa-icon-wait px-2"><input class="form-check-input ms-0 theme-control-toggle-input" type="checkbox" data-theme-control="phoenixTheme" value="dark" id="themeControlToggle" /><label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch theme"><span class="icon" data-feather="moon"></span></label><label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch theme"><span class="icon" data-feather="sun"></span></label></div>
          </li>
          <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#searchBoxModal"><span data-feather="search" style="height:19px;width:19px;margin-bottom: 2px;"></span></a></li>
         
          <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
              <div class="avatar avatar-l ">
                <img class="rounded-circle " src="elements/assets/img/avatar.webp" alt="" />
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border border-300" aria-labelledby="navbarDropdownUser">
              <div class="card position-relative border-0">
                <div class="card-body p-0">
                  <div class="text-center pt-4 pb-3">
                    <div class="avatar avatar-xl ">
                      <img class="rounded-circle " src="elements/assets/img/avatar.webp" alt="" />
                    </div>
                    <h6 class="mt-2 text-black">{{ ucfirst(Auth::user()->lastname) }}  {{ ucfirst(Auth::user()->name) }}  </h6>
                  </div>
                  <div class="mb-3 mx-3"><input class="form-control form-control-sm" id="statusUpdateInput" type="text" placeholder="Update your status" /></div>
                </div>
                <div class="overflow-auto scrollbar" style="height: 10rem;">
                  <ul class="nav d-flex flex-column mb-2 pb-1">
                    <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="user"></span><span>Profile</span></a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('dashboard') }}"><span class="me-2 text-900" data-feather="pie-chart"></span>Dashboard</a></li>
                   
                  </ul>
                </div>
               
              </div>
            </div>
          </li>
        </ul>
      </nav>
     
     
      <nav class="navbar navbar-top fixed-top navbar-slim justify-content-between navbar-expand-lg" id="navbarComboSlim" data-navbar-top="combo" data-move-target="#navbarVerticalNav" style="display:none;">
        <div class="navbar-logo">
          <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
          <a class="navbar-brand navbar-brand" href="/">GoProject <span class="text-1000 d-none d-sm-inline">GoProject</span></a>
        </div>
      
      </nav>
      
    
<div class="modal fade" id="verticallyCentered" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
     
      <div class="modal-body">
        <p class="text-700 lh-lg mb-0"> 
        <center> <br> <font size="4"> Vous voulez-vous vraiment quitter le projet ? </font>  <br> <br>

        <a href="{{ route('closeproject') }}" tabindex="-1" aria-labelledby="deconnecterModalLabel" aria-hidden="true"  class="btn btn-primary" type="button">Oui quitter  </a> &nbsp; <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"> Non , rester </button>
      
        </center></p>
      </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="deconnecterModalLabel" tabindex="-1" aria-labelledby="deconnecterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
     
      <div class="modal-body">
        <p class="text-700 lh-lg mb-0"> 
        <center> <br> <font size="4"> Voulez-vous vraiment vous déconnecter ? </font>  <br> <br>

        <a href="{{ route('logout') }}" class="btn btn-primary" type="button">Oui   </a> &nbsp; <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"> Non </button>
      
        </center></p>
      </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="EditMotdepasseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="addForm" autocomplete="off">
        @method('post')
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-plus"></i> Modifier mot de passe </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
          </div>
          <div class="modal-body">
          <div class="row" >
                  <div class="col-sm-6 col-md-12">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="nom"  name="nom"  type="text"required="required" placeholder="Identifiant" />
                      <label for="Identifiant">Anciant mot de paase</label>
                      <span id="identifiant_error" name="nom_error" class="text text-danger" > </span>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-12">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="nom"  name="nom"  type="text"required="required" placeholder="Identifiant" />
                      <label for="Identifiant">Nouveau mot de paase</label>
                      <span id="identifiant_error" name="nom_error" class="text text-danger" > </span>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-12">
                  <div class="form-floating mb-3">
                    <input class="form-control" id="prenom" type="text" name="prenom" required="required" placeholder="Password" />
                    <label for="Password">Confirmer le nouveau mot de passe</label>
                  </div>
                  </div>
                </div>

               

              
          </div>
          <div class="modal-footer">
            <button type="submit" name="addbtn" id="addbtn" class="btn btn-primary">Sauvegarder</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="EditPersonnelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="EditPersonnelForm" autocomplete="off">
        @method('post')
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-plus"></i> Modifier personnel</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
          </div>
          <div class="modal-body">
          <div class="row" >

               
                 

                 <input  id="per_id"  name="per_id"  type="hidden"/>

                  <div class="col-sm-6 col-md-6">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="per_nom"  name="per_nom"  type="text"required="required" placeholder="Identifiant" />
                      <label for="Identifiant">Nom</label>
                      <span id="identifiant_error" name="nom_error" class="text text-danger" > </span>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                  <div class="form-floating mb-3">
                    <input class="form-control" id="per_prenom" type="text" name="per_prenom" required="required" placeholder="Password" />
                    <label for="Password">Prénom </label>
                  </div>
                  </div>
                </div>

                <div class="row" >
                  <div class="col-sm-6 col-md-6">
                    <div class="form-floating mb-3">
                      <select class="form-control" id="per_sexe"  name="per_sexe"  type="text"required="required" placeholder="Identifiant">
                        <option value="">Séléctionner genre</option>
                        <option value="Femme">Femme</option>
                        <option value="Homme">Homme</option>
                      </select>
                      <label for="sexe">Sexe</label>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                  <div class="form-floating mb-3">
                    <input class="form-control" id="per_phone" type="text" name="per_phone" required="required" placeholder="Téléphone" />
                    <label for="Password">Téléphone </label>
                  </div>
                  </div>
                </div>

                <div class="row" >
                  <div class="col-sm-12 col-md-12">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="per_email"  name="per_email"  type="text" required="required" placeholder="Email" />
                      <label for="email">Email</label>
                      <span id="email_error" name="email_error" class="text text-danger" > </span>
                    </div>
                  </div>
                </div>
          </div>
          <div class="modal-footer">
            
            <button type="submit" name="EditPersonnelbtn" id="EditPersonnelbtn" class="btn btn-primary">Sauvegarder</button>
          </div>
        </div>
      </form>
    </div>
  </div>


  <script>
    $(function() {

      // Edit personnel ajax request
      $(document).on('click', '.editpersonnel', function(e) 
      {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: "{{ route('showPersonnel') }}",
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#per_id").val(response.id);
            $("#per_nom").val(response.nom);
            $("#per_prenom").val(response.prenom);
            $("#per_sexe").val(response.sexe);
            $("#per_phone").val(response.phone);
            $("#per_email").val(response.email);
          }
        });
      });

      // update personnel ajax request
      $("#EditPersonnelForm").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#EditPersonnelbtn").text('Mise à jour...');
        $.ajax({
          url:"{{ route('updatPersonnel') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) 
          {
            if (response.status == 200) {
             $.notify("Mise à jour  avec succès !", "success");
              $("#EditPersonnelModal").modal('show');
             
            }
            
            if (response.status == 202) {
             // $.notify("Erreur d'execution, verifier votre internet", "error");
              $("#EditPersonnelModal").modal('show');
            }

            $("#EditPersonnelbtn").text('Sauvegarder');

          }
        });
      });
    });
  </script>

  <script>
        var navbarTopShape = window.config.config.phoenixNavbarTopShape;
        var navbarPosition = window.config.config.phoenixNavbarPosition;
        var body = document.querySelector('body');
        var navbarDefault = document.querySelector('#navbarDefault');
        var navbarTop = document.querySelector('#navbarTop');
        var topNavSlim = document.querySelector('#topNavSlim');
        var navbarTopSlim = document.querySelector('#navbarTopSlim');
        var navbarCombo = document.querySelector('#navbarCombo');
        var navbarComboSlim = document.querySelector('#navbarComboSlim');
        var dualNav = document.querySelector('#dualNav');

        var documentElement = document.documentElement;
        var navbarVertical = document.querySelector('.navbar-vertical');

        if (navbarPosition === 'dual-nav') {
          topNavSlim.remove();
          navbarTop.remove();
          navbarVertical.remove();
          navbarTopSlim.remove();
          navbarCombo.remove();
          navbarComboSlim.remove();
          navbarDefault.remove();
          dualNav.removeAttribute('style');
          documentElement.classList.add('dual-nav');
        } else if (navbarTopShape === 'slim' && navbarPosition === 'vertical') {
          navbarDefault.remove();
          navbarTop.remove();
          navbarTopSlim.remove();
          navbarCombo.remove();
          navbarComboSlim.remove();
          topNavSlim.style.display = 'block';
          navbarVertical.style.display = 'inline-block';
          body.classList.add('nav-slim');
        } else if (navbarTopShape === 'slim' && navbarPosition === 'horizontal') {
          navbarDefault.remove();
          navbarVertical.remove();
          navbarTop.remove();
          topNavSlim.remove();
          navbarCombo.remove();
          navbarComboSlim.remove();
          navbarTopSlim.removeAttribute('style');
          body.classList.add('nav-slim');
        } else if (navbarTopShape === 'slim' && navbarPosition === 'combo') {
          navbarDefault.remove();
          //- navbarVertical.remove();
          navbarTop.remove();
          topNavSlim.remove();
          navbarCombo.remove();
          navbarTopSlim.remove();
          navbarComboSlim.removeAttribute('style');
          navbarVertical.removeAttribute('style');
          body.classList.add('nav-slim');
        } else if (navbarTopShape === 'default' && navbarPosition === 'horizontal') {
          navbarDefault.remove();
          topNavSlim.remove();
          navbarVertical.remove();
          navbarTopSlim.remove();
          navbarCombo.remove();
          navbarComboSlim.remove();
          navbarTop.removeAttribute('style');
          documentElement.classList.add('navbar-horizontal');
        } else if (navbarTopShape === 'default' && navbarPosition === 'combo') {
          topNavSlim.remove();
          navbarTop.remove();
          navbarTopSlim.remove();
          navbarDefault.remove();
          navbarComboSlim.remove();
          navbarCombo.removeAttribute('style');
          navbarVertical.removeAttribute('style');
          documentElement.classList.add('navbar-combo')

        } else {
          topNavSlim.remove();
          navbarTop.remove();
          navbarTopSlim.remove();
          navbarCombo.remove();
          navbarComboSlim.remove();
          navbarDefault.removeAttribute('style');
          navbarVertical.removeAttribute('style');
        }

        var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
        var navbarTop = document.querySelector('.navbar-top');
        if (navbarTopStyle === 'darker') {
          navbarTop.classList.add('navbar-darker');
        }

        var navbarVerticalStyle = window.config.config.phoenixNavbarVerticalStyle;
        var navbarVertical = document.querySelector('.navbar-vertical');
        if (navbarVerticalStyle === 'darker') {
          navbarVertical.classList.add('navbar-darker');
        }
  </script>