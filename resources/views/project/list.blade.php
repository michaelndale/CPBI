@extends('layout/app')
@section('page-content')
<div class="content">
    <!--
        <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#!">Page 1</a></li>
            <li class="breadcrumb-item"><a href="#!">Page 2</a></li>
            <li class="breadcrumb-item active">Default</li>
          </ol>
        </nav>
-->
        <div class="mb-9">
          <div id="projectSummary" data-list='{"valueNames":["projectName","assigness","start","deadline","task","projectprogress","status","action"],"page":6,"pagination":true}'>
            <div class="row mb-4 gx-6 gy-3 align-items-center">
              <div class="col-auto">
                <h2 class="mb-0">Projects<span class="fw-normal text-700 ms-3">( {{ $data->count() }} )</span></h2>
              </div>
              <div class="col-auto"><a class="btn btn-primary px-5" href="{{ route('new_project') }}"><i class="fa-solid fa-plus me-2"></i>Add new project</a></div>
            </div>
            <div class="row g-3 justify-content-between align-items-end mb-4">
              <div class="col-12 col-sm-auto">
                <ul class="nav nav-links mx-n2">
                  <li class="nav-item"><a class="nav-link px-2 py-1 active" aria-current="page" href="#"><span>All</span><span class="text-700 fw-semi-bold">(32)</span></a></li>
                  <li class="nav-item"><a class="nav-link px-2 py-1" href="#"><span>Ongoing</span><span class="text-700 fw-semi-bold">(14)</span></a></li>
                  <li class="nav-item"><a class="nav-link px-2 py-1" href="#"><span>Cancelled</span><span class="text-700 fw-semi-bold">(2)</span></a></li>
                  <li class="nav-item"><a class="nav-link px-2 py-1" href="#"><span>Finished</span><span class="text-700 fw-semi-bold">(14)</span></a></li>
                  <li class="nav-item"><a class="nav-link px-2 py-1" href="#"><span>Postponed</span><span class="text-700 fw-semi-bold">(2)</span></a></li>
                </ul>
              </div>
              <div class="col-12 col-sm-auto">
                <div class="d-flex align-items-center">
                  <div class="search-box me-3">
                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input class="form-control search-input search" type="search" placeholder="Search projects" aria-label="Search" />
                      <span class="fas fa-search search-box-icon"></span>
                    </form>
                  </div><a class="btn btn-phoenix-primary px-3 me-1 border-0 text-900" href="project-list-view.html" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="List view"><span class="fa-solid fa-list fs--2"></span></a><a class="btn btn-phoenix-primary px-3 me-1" href="project-board-view.html" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Board view"><svg width="9" height="9" viewbox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M0 0.5C0 0.223857 0.223858 0 0.5 0H1.83333C2.10948 0 2.33333 0.223858 2.33333 0.5V1.83333C2.33333 2.10948 2.10948 2.33333 1.83333 2.33333H0.5C0.223857 2.33333 0 2.10948 0 1.83333V0.5Z" fill="currentColor"></path>
                      <path d="M3.33333 0.5C3.33333 0.223857 3.55719 0 3.83333 0H5.16667C5.44281 0 5.66667 0.223858 5.66667 0.5V1.83333C5.66667 2.10948 5.44281 2.33333 5.16667 2.33333H3.83333C3.55719 2.33333 3.33333 2.10948 3.33333 1.83333V0.5Z" fill="currentColor"></path>
                      <path d="M6.66667 0.5C6.66667 0.223857 6.89052 0 7.16667 0H8.5C8.77614 0 9 0.223858 9 0.5V1.83333C9 2.10948 8.77614 2.33333 8.5 2.33333H7.16667C6.89052 2.33333 6.66667 2.10948 6.66667 1.83333V0.5Z" fill="currentColor"></path>
                      <path d="M0 3.83333C0 3.55719 0.223858 3.33333 0.5 3.33333H1.83333C2.10948 3.33333 2.33333 3.55719 2.33333 3.83333V5.16667C2.33333 5.44281 2.10948 5.66667 1.83333 5.66667H0.5C0.223857 5.66667 0 5.44281 0 5.16667V3.83333Z" fill="currentColor"></path>
                      <path d="M3.33333 3.83333C3.33333 3.55719 3.55719 3.33333 3.83333 3.33333H5.16667C5.44281 3.33333 5.66667 3.55719 5.66667 3.83333V5.16667C5.66667 5.44281 5.44281 5.66667 5.16667 5.66667H3.83333C3.55719 5.66667 3.33333 5.44281 3.33333 5.16667V3.83333Z" fill="currentColor"></path>
                      <path d="M6.66667 3.83333C6.66667 3.55719 6.89052 3.33333 7.16667 3.33333H8.5C8.77614 3.33333 9 3.55719 9 3.83333V5.16667C9 5.44281 8.77614 5.66667 8.5 5.66667H7.16667C6.89052 5.66667 6.66667 5.44281 6.66667 5.16667V3.83333Z" fill="currentColor"></path>
                      <path d="M0 7.16667C0 6.89052 0.223858 6.66667 0.5 6.66667H1.83333C2.10948 6.66667 2.33333 6.89052 2.33333 7.16667V8.5C2.33333 8.77614 2.10948 9 1.83333 9H0.5C0.223857 9 0 8.77614 0 8.5V7.16667Z" fill="currentColor"></path>
                      <path d="M3.33333 7.16667C3.33333 6.89052 3.55719 6.66667 3.83333 6.66667H5.16667C5.44281 6.66667 5.66667 6.89052 5.66667 7.16667V8.5C5.66667 8.77614 5.44281 9 5.16667 9H3.83333C3.55719 9 3.33333 8.77614 3.33333 8.5V7.16667Z" fill="currentColor"></path>
                      <path d="M6.66667 7.16667C6.66667 6.89052 6.89052 6.66667 7.16667 6.66667H8.5C8.77614 6.66667 9 6.89052 9 7.16667V8.5C9 8.77614 8.77614 9 8.5 9H7.16667C6.89052 9 6.66667 8.77614 6.66667 8.5V7.16667Z" fill="currentColor"></path>
                    </svg></a><a class="btn btn-phoenix-primary px-3" href="project-card-view.html" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Card view"><svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M0 0.5C0 0.223858 0.223858 0 0.5 0H3.5C3.77614 0 4 0.223858 4 0.5V3.5C4 3.77614 3.77614 4 3.5 4H0.5C0.223858 4 0 3.77614 0 3.5V0.5Z" fill="currentColor"></path>
                      <path d="M0 5.5C0 5.22386 0.223858 5 0.5 5H3.5C3.77614 5 4 5.22386 4 5.5V8.5C4 8.77614 3.77614 9 3.5 9H0.5C0.223858 9 0 8.77614 0 8.5V5.5Z" fill="currentColor"></path>
                      <path d="M5 0.5C5 0.223858 5.22386 0 5.5 0H8.5C8.77614 0 9 0.223858 9 0.5V3.5C9 3.77614 8.77614 4 8.5 4H5.5C5.22386 4 5 3.77614 5 3.5V0.5Z" fill="currentColor"></path>
                      <path d="M5 5.5C5 5.22386 5.22386 5 5.5 5H8.5C8.77614 5 9 5.22386 9 5.5V8.5C9 8.77614 8.77614 9 8.5 9H5.5C5.22386 9 5 8.77614 5 8.5V5.5Z" fill="currentColor"></path>
                    </svg></a>
                </div>
              </div>
            </div>
            <div class="table-responsive scrollbar">
              <table class="table fs--1 mb-0 border-top border-200">
                <thead>
                  <tr>
                    <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="projectName" style="width:30%;">PROJECT NAME</th>
                   <!-- <th class="sort align-middle ps-3" scope="col" data-sort="assigness" style="width:10%;">ASSIGNESS</th> -->
                    <th class="sort align-middle ps-3" scope="col" data-sort="start" style="width:10%;">START DATE</th>
                    <th class="sort align-middle ps-3" scope="col" data-sort="deadline" style="width:15%;">DEADLINE</th>
                    <!-- <th class="sort align-middle ps-3" scope="col" data-sort="task" style="width:12%;">TASK</th> -->
                    <th class="sort align-middle ps-3" scope="col" data-sort="projectprogress" style="width:5%;">PROGRESS</th>
                    <th class="sort align-middle text-end" scope="col" data-sort="statuses" style="width:10%;">STATUS</th>
                    <th class="sort align-middle text-end" scope="col" style="width:10%;"></th>
                  </tr>
                </thead>
                <tbody class="list" id="project-list-table-body">

                @foreach ($data as $datas)
                
                  <tr class="position-static">
                    <td class="align-middle time white-space-nowrap ps-0 projectName py-4"><a class="fw-bold fs-0" href="{{ route('key.viewProject', $datas->id) }}">{{ $datas->title }}</a></td>
                    <!-- <td class="align-middle white-space-nowrap assigness ps-3 py-4">
                      <div class="avatar-group avatar-group-dense"><a class="dropdown-toggle dropdown-caret-none d-inline-block" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                          <div class="avatar avatar-s  rounded-circle">
                            <img class="rounded-circle " src="elements/assets/img/team/34.webp" alt="" />
                          </div>
                        </a>
                        <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                          <div class="position-relative">
                            <div class="bg-holder z-index--1" style="background-image:url(elements/assets/img/bg/bg-32.png);background-size: auto;"></div>
                          
                            <div class="p-3">
                              <div class="text-end"><button class="btn p-0 me-2"><span class="fa-solid fa-user-plus text-white light"></span></button><button class="btn p-0"><span class="fa-solid fa-ellipsis text-white light"></span></button></div>
                              <div class="text-center">
                                <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-white" src="elements/assets/img/team/34.webp" alt="" /></div>
                                <h6 class="text-white light">Jean Renoir</h6>
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
                        </div><a class="dropdown-toggle dropdown-caret-none d-inline-block" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                          <div class="avatar avatar-s  rounded-circle">
                            <img class="rounded-circle " src="elements/assets/img/team/59.webp" alt="" />
                          </div>
                        </a>
                        <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                          <div class="position-relative">
                            <div class="bg-holder z-index--1" style="background-image:url(elements/assets/img/bg/bg-32.png);background-size: auto;"></div>
                         
                            <div class="p-3">
                              <div class="text-end"><button class="btn p-0 me-2"><span class="fa-solid fa-user-plus text-white light"></span></button><button class="btn p-0"><span class="fa-solid fa-ellipsis text-white light"></span></button></div>
                              <div class="text-center">
                                <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-white" src="elements/assets/img/team/59.webp" alt="" /></div>
                                <h6 class="text-white light">Katerina Karenin</h6>
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
                        </div><a class="dropdown-toggle dropdown-caret-none d-inline-block" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                          <div class="avatar avatar-s  rounded-circle">
                            <img class="rounded-circle " src="elements/assets/img/team/35.webp" alt="" />
                          </div>
                        </a>
                        <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                          <div class="position-relative">
                            <div class="bg-holder z-index--1" style="background-image:url(elements/assets/img/bg/bg-32.png);background-size: auto;"></div>
                          
                            <div class="p-3">
                              <div class="text-end"><button class="btn p-0 me-2"><span class="fa-solid fa-user-plus text-white light"></span></button><button class="btn p-0"><span class="fa-solid fa-ellipsis text-white light"></span></button></div>
                              <div class="text-center">
                                <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-white" src="elements/assets/img/team/35.webp" alt="" /></div>
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
                        </div><a class="dropdown-toggle dropdown-caret-none d-inline-block" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                          <div class="avatar avatar-s  rounded-circle">
                            <img class="rounded-circle " src="elements/assets/img/team/58.webp" alt="" />
                          </div>
                        </a>
                        <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                          <div class="position-relative">
                            <div class="bg-holder z-index--1" style="background-image:url(elements/assets/img/bg/bg-32.png);background-size: auto;"></div>
                         
                            <div class="p-3">
                              <div class="text-end"><button class="btn p-0 me-2"><span class="fa-solid fa-user-plus text-white light"></span></button><button class="btn p-0"><span class="fa-solid fa-ellipsis text-white light"></span></button></div>
                              <div class="text-center">
                                <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-white" src="elements/assets/img/team/58.webp" alt="" /></div>
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
                        <div class="avatar avatar-s  rounded-circle">
                          <div class="avatar-name rounded-circle "><span>+2</span></div>
                        </div>
                      </div>
                    </td> -->
                    <td class="align-middle white-space-nowrap start ps-3 py-4">
                      <p class="mb-0 fs--1 text-900">{{ $datas->start_date }}</p>
                    </td>
                    <td class="align-middle white-space-nowrap deadline ps-3 py-4">
                      <p class="mb-0 fs--1 text-900">{{ $datas->deadline }}</p>
                    </td>
                   <!-- <td class="align-middle white-space-nowrap task ps-3 py-4">
                      <p class="fw-bo text-900 fs--1 mb-0">287</p>
                    </td>
-->
                    <td class="align-middle white-space-nowrap ps-3 projectprogress">
                      <p class="text-800 fs--2 mb-0">145 / 145</p>
                      <div class="progress" style="height:3px;">
                        <div class="progress-bar bg-success" style="width: 100%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </td>
                    <td class="align-middle white-space-nowrap text-end statuses"><span class="badge badge-phoenix fs--2 badge-phoenix-success">completed</span></td>
                    <td class="align-middle text-end white-space-nowrap pe-0 action">
                      <div class="font-sans-serif btn-reveal-trigger position-static"><button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                          <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                        </div>
                      </div>
                    </td>
                  </tr>

                @endforeach

                </tbody>
              </table>
            </div>
            <div class="d-flex flex-wrap align-items-center justify-content-between py-3 pe-0 fs--1 border-bottom border-200">
              <div class="d-flex">
                <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info"></p><a class="fw-semi-bold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
              </div>
              <div class="d-flex"><button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                <ul class="mb-0 pagination"></ul><button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
              </div>
            </div>
          </div>
        </div>

@endsection