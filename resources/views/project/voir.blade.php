@extends('layout/app')
@section('page-content')
@foreach ($responsable as $responsables)
@endforeach
<div class="main-content">

<div class="page-content">
    <div class="container-fluid">

       
    
    <div class="row g-0">
      <div class="col-12 col-xxl-8 px-0 bg-soft">
        <div class="px-4 px-lg-6 pt-6 pb-9">
          <div class="mb-5">
            <div class="d-flex justify-content-between">
              <h2 class="text-black fw-bolder mb-2">{{ $dataProject->title }}
                <!--  {{ Session::get('id') }}  -->
              </h2>

              <div class="dropdown">
                <button class="btn btn-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Action <i class="mdi mdi-dots-vertical align-middle font-size-16"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('key.editProject', Session::get('id') ) }}"><i class="fas fa-edit font-size-16 align-middle me-2 text-muted"></i>
                      Modifier le projet</a>
                  </li>

                 <!-- <li>
                    <button class="dropdown-item" href="{{ route('listfeb') }}"><i class=" fas fa-times-circle  font-size-16 align-middle me-2 text-muted"></i>
                      Bloquer la modification</button>
                  </li>

                  <li>
                    <button class="dropdown-item" href="{{ route('listfeb') }}"><i class=" mdi mdi-check-circle font-size-16 align-middle me-2 text-muted"></i> Autoriser la modification</button>
                  </li> -->
                 
                  <li>
                    <a class="dropdown-item" href="{{ route('gestioncompte') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                    Ligne budgetaire</a>
                  </li>
                 
                  <li>
                    <a class="dropdown-item" href="{{ route('rallongebudget') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                      Budget</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="{{ route('activity') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                      Activites</a>
                  </li>

                  <li>
                    <a class="dropdown-item" href="{{ route('listfeb') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                      FEB</a>
                  </li>
                  
                  <li>
                    <a class="dropdown-item" href="{{ route('listdap') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                      DAP</a>
                  </li>
                  
                  <li>
                    <a class="dropdown-item" href="{{ route('listdja') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                      DJA</a>
                  </li>
                
                  <li>
                    <a class="dropdown-item" href="{{ route('affectation') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                      Affectation</a>
                  </li>
                
                  <li>
                    <a class="dropdown-item" href="{{ route('rapportcumule') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                      Rapport cummulatif</a>
                  </li>

                  <li>
                    <a class="dropdown-item" href="{{ route('planoperationnel') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                      Plan d'action</a>
                  </li>

                
                 
                </ul>
              </div>

            </div>

            <b><i class="fa fa-info-circle"></i> Statut du projet :</b> <span class="badge rounded-pill bg-success" >  {{ $dataProject->statut }} </span>  <br>

            <b><i class="fa fa-edit"></i> Autorisation de modification :</b>  
            @if($dataProject->autorisation==1)
              <span class="badge rounded-pill bg-primary" > Projet Ouvert </span>
              @else
              <span class="badge rounded-pill bg-danger" > Fermer </span>
            @endif
              

              <span class="ms-1 uil uil-stopwatch"></span></span>
          </div>
          <div class="row gx-0 gx-sm-5 gy-8 mb-8">
            <div class="col-12 col-xl-5 col-xxl-4 pe-xl-0">
              <div class="mb-4 mb-xl-7">
                <div class="row gx-0 gx-sm-7">
                  <div class="col-12 col-sm-auto">
                    <table class="lh-sm mb-4 mb-sm-0 mb-xl-5">
                      <tbody>
                        <tr>
                          <td class="align-top py-1">
                            <div class="d-flex">
                              <h5 class="text-900 mb-0 text-nowrap"><i class="fa fa-user-circle"></i> Responsable  :</h5>
                            </div>
                          </td>
                          <td class="ps-1 py-1"><a class="fw-semi-bold d-block lh-sm" href="#!"> {{ ucfirst($responsables->nom) }} {{ ucfirst($responsables->prenom) }}</a></td>
                        </tr>
                        <tr>
                          <td class="align-top py-1">
                            <div class="d-flex">
                              <h5 class="text-900 mb-0 text-nowrap"> <span class="fas fa-money-check-alt"></span> Budget : </h5>
                            </div>
                          </td>
                          <td class="fw-bold ps-1 py-1 text-1000"> {{ number_format($dataProject->budget,0, ',', ' ') }} {{ $dataProject->devise }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-12 col-sm-auto">
                    <table class="lh-sm">
                      <tbody>
                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Numéro projet : </td>
                          <td class="text-600 fw-semi-bold ps-3">{{ $dataProject->numeroprojet }}</td>
                        </tr>

                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Début du projet : </td>
                          <td class="text-600 fw-semi-bold ps-3">{{ date('d.m.Y', strtotime($dataProject->start_date))  }}</td>
                        </tr>


                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Fin du projet :</td>
                          <td class="text-600 fw-semi-bold ps-3">{{ date('d.m.Y', strtotime($dataProject->deadline))  }}</td>
                        </tr>
                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Progression du projet:</td>
                            @php
                             $pourcentage = round(($sommerepartie*100)/$dataProject->budget) ;
                             if($pourcentage < 50){
                                $color= 'primary';
                             }elseif($pourcentage >=50 AND $pourcentage < 80){
                                $color= 'success';
                             }elseif($pourcentage <= 80 AND $pourcentage >= 100){
                                $color= 'danger';
                             }else{
                              $color= 'warning';
                             }
                           @endphp 
                           <td class="text-{{ $color }} fw-semi-bold ps-3">  {{ $pourcentage }} %
                            </td> 
                        </tr>
                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Date de creation projet :</td>
                          <td class="text-600 fw-semi-bold ps-3">{{ date('d.m.Y', strtotime($dataProject->created_at))  }}</td>
                        </tr>
                      
                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Region : </td>
                          <td class="text-600 fw-semi-bold ps-3">{{ $dataProject->region }}</td>
                        </tr>
                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Lieu:</td>
                          <td class="text-600 fw-semi-bold ps-3">{{ $dataProject->lieuprojet }}</td>
                        </tr>

                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Notre en periode:</td>
                          <td class="text-600 fw-semi-bold ps-3">{{ $dataProject->periode }}</td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>
            <div class="col-12 col-xl-6 col-xxl-8">
              <div class="row flex-between-center mb-3 g-3">
                <div class="col-auto">
                  <h4 class="text-black">Description</h4>
                  <p class="text-800 mb-4">{{ $dataProject->description }} </p>
                </div>

              </div>

            </div>

            <!--             
                <div class="col-12 col-sm-5 col-lg-4 col-xl-3 col-xxl-4">
                  <div class="mb-5">
                    <h4 class="text-black">Work loads</h4>
                    <h6 class="text-700">Last 7 days</h6>
                  </div>
                  <div class="echart-top-coupons mb-5" style="height:115px;width:100%;"></div>
                  <div class="row justify-content-center">
                    <div class="col-auto col-sm-12">
                      <div class="row justify-content-center justify-content-sm-between g-5 g-sm-0 mb-2">
                        <div class="col">
                          <div class="d-flex align-items-center">
                            <div class="bullet-item me-2 bg-primary"></div>
                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Shantinan Mekalan</h6>
                          </div>
                        </div>
                        <div class="col-auto">
                          <h6 class="text-900 fw-semi-bold mb-0">72%</h6>
                        </div>
                      </div>
                      <div class="row justify-content-center justify-content-sm-between g-5 g-sm-0 mb-2">
                        <div class="col">
                          <div class="d-flex align-items-center">
                            <div class="bullet-item me-2 bg-primary-200"></div>
                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Makena Zikonn</h6>
                          </div>
                        </div>
                        <div class="col-auto">
                          <h6 class="text-900 fw-semi-bold mb-0">18%</h6>
                        </div>
                      </div>
                      <div class="row justify-content-center justify-content-sm-between g-5 g-sm-0 mb-2">
                        <div class="col">
                          <div class="d-flex align-items-center">
                            <div class="bullet-item me-2 bg-info"></div>
                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Meena Kumari</h6>
                          </div>
                        </div>
                        <div class="col-auto">
                          <h6 class="text-900 fw-semi-bold mb-0">10%</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-sm-7 col-lg-8 col-xl-5">
                  <h4 class="text-1100 mb-4">Team members</h4>
                  <div class="d-flex mb-8">
                    <div class="dropdown"><a class="dropdown-toggle dropdown-caret-none d-inline-block outline-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        <div class="avatar avatar-xl  me-1">
                          <img class="rounded-circle " src="../../assets/img/team/33.webp" alt="" />
                        </div>
                      </a>
                      <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                        <div class="position-relative">
                          <div class="bg-holder z-index--1" style="background-image:url(../../assets/img/bg/bg-32.png);background-size: auto;"></div>
                       
                          <div class="p-3">
                            <div class="text-end"><button class="btn p-0 me-2"><span class="fa-solid fa-user-plus text-white light"></span></button><button class="btn p-0"><span class="fa-solid fa-ellipsis text-white light"></span></button></div>
                            <div class="text-center">
                              <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-white" src="../../assets/img/team/33.webp" alt="" /></div>
                              <h6 class="text-white light">Tyrion Lannister</h6>
                              <p class="text-600 fw-semi-bold fs--2 mb-2">@tyrion222</p>
                              <div class="d-flex flex-center mb-3">
                                <h6 class="text-white light mb-0">224 <span class="fw-normal text-300">connections</span></h6><span class="fa-solid fa-circle text-700 mx-1" data-fa-transform="shrink-10 up-2"></span>
                                <h6 class="text-white light mb-0">23 <span class="fw-normal text-300">mutual</span></h6>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="bg-white">
                          <div class="p-3 border-bottom">
                            <div class="d-flex justify-content-between">
                              <div class="d-flex"><button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-phone"></span></button><button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-message"></span></button><button class="btn btn-phoenix-secondary btn-icon btn-icon-lg"><span class="fa-solid fa-video"></span></button></div><button class="btn btn-phoenix-primary"><span class="fa-solid fa-envelope me-2"></span>Send Email</button>
                            </div>
                          </div>
                          <ul class="nav d-flex flex-column py-3 border-bottom">
                            <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-900 d-inline-block" data-feather="clipboard"></span><span class="text-1000 flex-1">Assigned Projects</span><span class="fa-solid fa-chevron-right fs--3"></span></a></li>
                            <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-900" data-feather="pie-chart"></span><span class="text-1000 flex-1">View activiy</span><span class="fa-solid fa-chevron-right fs--3"></span></a></li>
                          </ul>
                        </div>
                        <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="#!">Unassign </a></div>
                      </div>
                    </div>
                    <div class="dropdown"><a class="dropdown-toggle dropdown-caret-none d-inline-block outline-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        <div class="avatar avatar-xl  me-1">
                          <img class="rounded-circle " src="../../assets/img/team/30.webp" alt="" />
                        </div>
                      </a>
                      <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                        <div class="position-relative">
                          <div class="bg-holder z-index--1" style="background-image:url(../../assets/img/bg/bg-32.png);background-size: auto;"></div>
                        
                          <div class="p-3">
                            <div class="text-end"><button class="btn p-0 me-2"><span class="fa-solid fa-user-plus text-white light"></span></button><button class="btn p-0"><span class="fa-solid fa-ellipsis text-white light"></span></button></div>
                            <div class="text-center">
                              <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-white" src="../../assets/img/team/30.webp" alt="" /></div>
                              <h6 class="text-white light">Milind Mikuja</h6>
                              <p class="text-600 fw-semi-bold fs--2 mb-2">@tyrion222</p>
                              <div class="d-flex flex-center mb-3">
                                <h6 class="text-white light mb-0">224 <span class="fw-normal text-300">connections</span></h6><span class="fa-solid fa-circle text-700 mx-1" data-fa-transform="shrink-10 up-2"></span>
                                <h6 class="text-white light mb-0">23 <span class="fw-normal text-300">mutual</span></h6>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="bg-white">
                          <div class="p-3 border-bottom">
                            <div class="d-flex justify-content-between">
                              <div class="d-flex"><button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-phone"></span></button><button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-message"></span></button><button class="btn btn-phoenix-secondary btn-icon btn-icon-lg"><span class="fa-solid fa-video"></span></button></div><button class="btn btn-phoenix-primary"><span class="fa-solid fa-envelope me-2"></span>Send Email</button>
                            </div>
                          </div>
                          <ul class="nav d-flex flex-column py-3 border-bottom">
                            <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-900 d-inline-block" data-feather="clipboard"></span><span class="text-1000 flex-1">Assigned Projects</span><span class="fa-solid fa-chevron-right fs--3"></span></a></li>
                            <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-900" data-feather="pie-chart"></span><span class="text-1000 flex-1">View activiy</span><span class="fa-solid fa-chevron-right fs--3"></span></a></li>
                          </ul>
                        </div>
                        <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="#!">Unassign </a></div>
                      </div>
                    </div>
                    <div class="dropdown"><a class="dropdown-toggle dropdown-caret-none d-inline-block outline-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        <div class="avatar avatar-xl  me-1">
                          <img class="rounded-circle " src="../../assets/img/team/31.webp" alt="" />
                        </div>
                      </a>
                      <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                        <div class="position-relative">
                          <div class="bg-holder z-index--1" style="background-image:url(../../assets/img/bg/bg-32.png);background-size: auto;"></div>
                        
                          <div class="p-3">
                            <div class="text-end"><button class="btn p-0 me-2"><span class="fa-solid fa-user-plus text-white light"></span></button><button class="btn p-0"><span class="fa-solid fa-ellipsis text-white light"></span></button></div>
                            <div class="text-center">
                              <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-white" src="../../assets/img/team/31.webp" alt="" /></div>
                              <h6 class="text-white light">Stanly Drinkwater</h6>
                              <p class="text-600 fw-semi-bold fs--2 mb-2">@tyrion222</p>
                              <div class="d-flex flex-center mb-3">
                                <h6 class="text-white light mb-0">224 <span class="fw-normal text-300">connections</span></h6><span class="fa-solid fa-circle text-700 mx-1" data-fa-transform="shrink-10 up-2"></span>
                                <h6 class="text-white light mb-0">23 <span class="fw-normal text-300">mutual</span></h6>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="bg-white">
                          <div class="p-3 border-bottom">
                            <div class="d-flex justify-content-between">
                              <div class="d-flex"><button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-phone"></span></button><button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-message"></span></button><button class="btn btn-phoenix-secondary btn-icon btn-icon-lg"><span class="fa-solid fa-video"></span></button></div><button class="btn btn-phoenix-primary"><span class="fa-solid fa-envelope me-2"></span>Send Email</button>
                            </div>
                          </div>
                          <ul class="nav d-flex flex-column py-3 border-bottom">
                            <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-900 d-inline-block" data-feather="clipboard"></span><span class="text-1000 flex-1">Assigned Projects</span><span class="fa-solid fa-chevron-right fs--3"></span></a></li>
                            <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-900" data-feather="pie-chart"></span><span class="text-1000 flex-1">View activiy</span><span class="fa-solid fa-chevron-right fs--3"></span></a></li>
                          </ul>
                        </div>
                        <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="#!">Unassign </a></div>
                      </div>
                    </div>
                    <div class="dropdown"><a class="dropdown-toggle dropdown-caret-none d-inline-block outline-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        <div class="avatar avatar-xl  me-1">
                          <img class="rounded-circle " src="../../assets/img/team/60.webp" alt="" />
                        </div>
                      </a>
                      <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                        <div class="position-relative">
                          <div class="bg-holder z-index--1" style="background-image:url(../../assets/img/bg/bg-32.png);background-size: auto;"></div>
                        
                          <div class="p-3">
                            <div class="text-end"><button class="btn p-0 me-2"><span class="fa-solid fa-user-plus text-white light"></span></button><button class="btn p-0"><span class="fa-solid fa-ellipsis text-white light"></span></button></div>
                            <div class="text-center">
                              <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-white" src="../../assets/img/team/60.webp" alt="" /></div>
                              <h6 class="text-white light">Josef Stravinsky</h6>
                              <p class="text-600 fw-semi-bold fs--2 mb-2">@tyrion222</p>
                              <div class="d-flex flex-center mb-3">
                                <h6 class="text-white light mb-0">224 <span class="fw-normal text-300">connections</span></h6><span class="fa-solid fa-circle text-700 mx-1" data-fa-transform="shrink-10 up-2"></span>
                                <h6 class="text-white light mb-0">23 <span class="fw-normal text-300">mutual</span></h6>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="bg-white">
                          <div class="p-3 border-bottom">
                            <div class="d-flex justify-content-between">
                              <div class="d-flex"><button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-phone"></span></button><button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-message"></span></button><button class="btn btn-phoenix-secondary btn-icon btn-icon-lg"><span class="fa-solid fa-video"></span></button></div><button class="btn btn-phoenix-primary"><span class="fa-solid fa-envelope me-2"></span>Send Email</button>
                            </div>
                          </div>
                          <ul class="nav d-flex flex-column py-3 border-bottom">
                            <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-900 d-inline-block" data-feather="clipboard"></span><span class="text-1000 flex-1">Assigned Projects</span><span class="fa-solid fa-chevron-right fs--3"></span></a></li>
                            <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-900" data-feather="pie-chart"></span><span class="text-1000 flex-1">View activiy</span><span class="fa-solid fa-chevron-right fs--3"></span></a></li>
                          </ul>
                        </div>
                        <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="#!">Unassign </a></div>
                      </div>
                    </div>
                    <div class="dropdown"><a class="dropdown-toggle dropdown-caret-none d-inline-block outline-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        <div class="avatar avatar-xl  me-1">
                          <img class="rounded-circle " src="../../assets/img/team/65.webp" alt="" />
                        </div>
                      </a>
                      <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                        <div class="position-relative">
                          <div class="bg-holder z-index--1" style="background-image:url(../../assets/img/bg/bg-32.png);background-size: auto;"></div>
                        
                          <div class="p-3">
                            <div class="text-end"><button class="btn p-0 me-2"><span class="fa-solid fa-user-plus text-white light"></span></button><button class="btn p-0"><span class="fa-solid fa-ellipsis text-white light"></span></button></div>
                            <div class="text-center">
                              <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-white" src="../../assets/img/team/65.webp" alt="" /></div>
                              <h6 class="text-white light">Igor Borvibson</h6>
                              <p class="text-600 fw-semi-bold fs--2 mb-2">@tyrion222</p>
                              <div class="d-flex flex-center mb-3">
                                <h6 class="text-white light mb-0">224 <span class="fw-normal text-300">connections</span></h6><span class="fa-solid fa-circle text-700 mx-1" data-fa-transform="shrink-10 up-2"></span>
                                <h6 class="text-white light mb-0">23 <span class="fw-normal text-300">mutual</span></h6>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="bg-white">
                          <div class="p-3 border-bottom">
                            <div class="d-flex justify-content-between">
                              <div class="d-flex"><button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-phone"></span></button><button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-message"></span></button><button class="btn btn-phoenix-secondary btn-icon btn-icon-lg"><span class="fa-solid fa-video"></span></button></div><button class="btn btn-phoenix-primary"><span class="fa-solid fa-envelope me-2"></span>Send Email</button>
                            </div>
                          </div>
                          <ul class="nav d-flex flex-column py-3 border-bottom">
                            <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-900 d-inline-block" data-feather="clipboard"></span><span class="text-1000 flex-1">Assigned Projects</span><span class="fa-solid fa-chevron-right fs--3"></span></a></li>
                            <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-900" data-feather="pie-chart"></span><span class="text-1000 flex-1">View activiy</span><span class="fa-solid fa-chevron-right fs--3"></span></a></li>
                          </ul>
                        </div>
                        <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="#!">Unassign </a></div>
                      </div>
                    </div>
                  </div>
                  <h4 class="text-1100 mb-4">Tags</h4><span class="badge badge-tag me-2 mb-1">Unused_brain</span><span class="badge badge-tag me-2 mb-1">Machine</span><span class="badge badge-tag me-2 mb-1">Coding</span><span class="badge badge-tag me-2 mb-1">Meseeks</span><span class="badge badge-tag me-2 mb-1">Smithpeople</span><span class="badge badge-tag me-2 mb-1">Rick</span><span class="badge badge-tag me-2 mb-1">Biology</span><span class="badge badge-tag me-2 mb-1">Neurology</span><span class="badge badge-tag me-2 mb-1">Brainlessness</span><span class="badge badge-tag me-2 mb-1">Stupidity</span><span class="badge badge-tag me-2 mb-1">Jerry</span><span class="badge badge-tag me-2 mb-1">Not _the_mouse</span>
                </div>
                -->

          </div>

        </div>
      </div>


    </div>


    @endsection