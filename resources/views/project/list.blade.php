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
                <h2 class="mb-0">Projets<span class="fw-normal text-700 ms-3">( {{ $data->count() }} )</span></h2>
              </div>
              <div class="col-auto"><a class="btn btn-primary px-5" href="{{ route('new_project') }}"><i class="fa-solid fa-plus me-2"></i>Ajouter nouveau projet</a></div>
            </div>
            <div class="row g-3 justify-content-between align-items-end mb-4">
              <div class="col-12 col-sm-auto">
                <ul class="nav nav-links mx-n2">
                  <li class="nav-item"><a class="nav-link px-2 py-1 active" aria-current="page" href="#"><span>Tous</span><span class="text-700 fw-semi-bold"> ( {{ $data->count() }} )</span></a></li>
                  <li class="nav-item"><a class="nav-link px-2 py-1" href="#"><span>Encours</span><span class="text-700 fw-semi-bold">(14)</span></a></li>
                  <li class="nav-item"><a class="nav-link px-2 py-1" href="#"><span>Annuller</span><span class="text-700 fw-semi-bold">(2)</span></a></li>
                  <li class="nav-item"><a class="nav-link px-2 py-1" href="#"><span>Terminer</span><span class="text-700 fw-semi-bold">(14)</span></a></li>
                  <li class="nav-item"><a class="nav-link px-2 py-1" href="#"><span>Nouveau</span><span class="text-700 fw-semi-bold">(2)</span></a></li>
                </ul>
              </div>
              <div class="col-12 col-sm-auto">
                <div class="d-flex align-items-center">
                  <div class="search-box me-3">
                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input class="form-control search-input search" type="search" placeholder="Search projects" aria-label="Search" />
                      <span class="fas fa-search search-box-icon"></span>
                    </form>
                  </div>
                </div>
             
            </div>
            <div class="table-responsive scrollbar">
              <table class="table fs--1 mb-0 border-top border-200">
                <thead>
                  <tr>
                    <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="projectName" style="width:30%;">PROJECT NAME</th>
                 
                    <th class="sort align-middle ps-3" scope="col" data-sort="start" style="width:10%;">START DATE</th>
                    <th class="sort align-middle ps-3" scope="col" data-sort="deadline" style="width:15%;">DEADLINE</th>
              
                    <th class="sort align-middle ps-3" scope="col" data-sort="projectprogress" style="width:5%;">PROGRESS</th>
                    <th class="sort align-middle text-end" scope="col" data-sort="statuses" style="width:10%;">STATUS</th>
                    <th class="sort align-middle text-end" scope="col" style="width:10%;"></th>
                  </tr>
                </thead>
                <tbody class="list" id="project-list-table-body">

                @foreach ($data as $datas)
                
                  <tr class="position-static">
                    <td class="align-middle time white-space-nowrap ps-0 projectName py-4"><a class="fw-bold fs-0" href="{{ route('key.viewProject', $datas->id) }}">{{ $datas->title }}</a></td>
                
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