@extends('layout/app')
@section('page-content')

<div class="content px-0 pt-9">
        <div class="row g-0">
          <div class="col-12 col-xxl-8 px-0 bg-soft">
            <div class="px-4 px-lg-6 pt-6 pb-9">
              <div class="mb-5">
                <div class="d-flex justify-content-between">
                  <h2 class="text-black fw-bolder mb-2">{{ $dataProject->title }}
                    <!--  {{ Session::get('id') }}  -->
                  </h2>
                  <div class="font-sans-serif btn-reveal-trigger"><button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h"></span></button>
                    <div class="dropdown-menu dropdown-menu-end py-2">
                      <a class="dropdown-item" href="#!"><i class="fas fa-random"></i> Affectation</a>
                      <a class="dropdown-item" href="#!"><i class="fas fa-edit"></i>  Detail du projet</a>
                      <a class="dropdown-item" href="#!"><i class="fas fa-file-alt"></i> FEB</a>
                      <a class="dropdown-item" href="#!"><i class="fas fa-file-alt"></i> BPC</a>
                      <a class="dropdown-item" href="#!"><i class="fas fa-file-alt"></i> DAP</a>
                      <a class="dropdown-item" href="#!"><i class="fas fa-file-alt"></i> DJA</a>
                      <a class="dropdown-item" href="#!"><i class="fas fa-file-alt"></i> SQR</a>
                      <a class="dropdown-item" href="#!"><i class="fas fa-file-alt"></i> FDT</a>
                      <a class="dropdown-item text-danger" href="#!">Supprimer</a>
                      <a class="dropdown-item" href="#!">Telecharger</a>
                    </div>
                  </div>
                </div>
                
                <b>Statut du projet :</b> <span class="badge badge-phoenix badge-phoenix-primary">

                @if ($dataProject->statut==0)
                  Encours
                @else
                    Terminer
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
                                <div class="d-flex"><span class="fa-solid fa-user me-2 text-700 fs--1"></span>
                                  <h5 class="text-900 mb-0 text-nowrap">Responsable :</h5>
                                </div>
                              </td>
                              <td class="ps-1 py-1"><a class="fw-semi-bold d-block lh-sm" href="#!">{{  $responsable->name }} {{  $responsable->lastname }}</a></td>
                            </tr>
                            <tr>
                              <td class="align-top py-1">
                                <div class="d-flex"><span class="fa-regular fa-credit-card me-2 text-700 fs--1"></span>
                                  <h5 class="text-900 mb-0 text-nowrap">Budget : </h5>
                                </div>
                              </td>
                              <td class="fw-bold ps-1 py-1 text-1000">{{ $dataProject->budget }} {{ $dataProject->devise }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-12 col-sm-auto">
                        <table class="lh-sm">
                          <tbody>
                            <tr>
                              <td class="align-top py-1 text-900 text-nowrap fw-bold">Numéro projet : </td>
                              <td class="text-600 fw-semi-bold ps-3">#{{ $dataProject->numeroprojet }}</td>
                            </tr>

                            <tr>
                              <td class="align-top py-1 text-900 text-nowrap fw-bold">Début du projet : </td>
                              <td class="text-600 fw-semi-bold ps-3">{{  date('d.m.Y', strtotime($dataProject->start_date))  }}</td>
                            </tr>


                            <tr>
                              <td class="align-top py-1 text-900 text-nowrap fw-bold">Fin du projet :</td>
                              <td class="text-600 fw-semi-bold ps-3">{{  date('d.m.Y', strtotime($dataProject->deadline))  }}</td>
                            </tr>
                            <tr>
                              <td class="align-top py-1 text-900 text-nowrap fw-bold">Progression du projet:</td>
                              <td class="text-warning fw-semi-bold ps-3">80%</td>
                            </tr>
                            <tr>
                              <td class="align-top py-1 text-900 text-nowrap fw-bold">Date de creation projet :</td>
                              <td class="text-warning fw-semi-bold ps-3">{{  date('d.m.Y', strtotime($dataProject->created_at))  }}</td>
                            </tr>
                          </tbody>
                        </table>

                        <table class="lh-sm">
                          <tbody>
                            <tr>
                              <td class="align-top py-1 text-900 text-nowrap fw-bold">Region  : </td>
                              <td class="text-600 fw-semi-bold ps-3">{{ $dataProject->region }}</td>
                            </tr>
                            <tr>
                              <td class="align-top py-1 text-900 text-nowrap fw-bold">Lieu:</td>
                              <td class="text-600 fw-semi-bold ps-3">{{ $dataProject->lieuprojet }}</td>
                            </tr>
                            <tr>
                              <td class="align-top py-1 text-900 text-nowrap fw-bold">Progression :</td>
                              <td class="text-warning fw-semi-bold ps-3">80%</td>
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
                      <p class="text-800 mb-4">{{ $dataProject->description }}  </p>
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

       
          <div class="col-12 col-xxl-4 px-0 border-start-xxl border-300 border-top-sm">
            <div class="h-100">
              <div class="bg-light dark__bg-1100 h-100">
                <div class="p-4 p-lg-6">
                  <h3 class="text-1000 mb-4 fw-bold">Activité récente</h3>
                  <div class="timeline-vertical timeline-with-details">

                  @forelse ($activite as $activites)
                  <div class="timeline-item position-relative">
                      <div class="row g-md-3">
                        <div class="col-12 col-md-auto d-flex">
                          <div class="timeline-item-date order-1 order-md-0 me-md-4">
                            <p class="fs--2 fw-semi-bold text-600 text-end"> {{ date('d.m.Y', strtotime($activites->created_at)) }}<br class="d-none d-md-block" /> 7h30 </p>
                          </div>
                          <div class="timeline-item-bar position-md-relative me-3 me-md-0 border-400">
                            <div class="icon-item icon-item-sm rounded-7 shadow-none bg-primary-100"><span class="fa-solid fa-chess text-primary-600 fs--2 dark__text-primary-300"></span></div><span class="timeline-bar border-end border-dashed border-400"></span>
                          </div>
                        </div>
                        <div class="col">
                          <div class="timeline-item-content ps-6 ps-md-3">
                            <h5 class="fs--1 lh-sm">{{ ucfirst($activites->titre) }}</h5>
                            <p class="fs--1">Region : {{  ucfirst($activites->pays ) }} <br>
                             Montant : {{ $activites->montantbudget }} </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                  @empty

                  <h4> Pas d'activité disponible 
                  <a class="fw-bold fs--1" href="{{ route('activity') }}"><span class="fas fa-plus me-1"></span>Ajouter l'activité</a>
                  
                  </h4>
                    
                  @endforelse

                   
                  </div>
                </div>
                
               
                <div class="px-5 px-md-6 mt-3 mb-9"><a class="fw-bold fs--1" href="{{ route('activity') }}"><span class="fas fa-plus me-1"></span>Ajouter l'activité</a></div>
              </div>
            </div>
          </div>
        </div>
        


@endsection