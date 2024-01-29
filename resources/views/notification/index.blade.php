@extends('layout/app')
@section('page-content')
<div class="content">
  <div id="members" data-list='{"valueNames":["customer","email","mobile_number","city","last_active","joined"],"page":10,"pagination":true}'>
    <div class="row align-items-center justify-content-between g-3 mb-4">
      <div class="col col-auto">
        <div class="search-box">
          <nav class="mb-1" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item active">Notification</li>
            </ol>
          </nav>
          
      </div>
      </div>
        <div class="search-box">
          <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input class="form-control search-input search" type="search" placeholder="Search members" aria-label="Search" />
            <span class="fas fa-search search-box-icon"></span>
          </form>
        </div>
      </div>
          
      <div class="mx-n4 mx-lg-n6 px-4 px-lg-6 mb-9 bg-white border-y border-10 mt-2 position-relative top-1" id="show_all">
      <table class="table table-sm fs--1 mb-0">
          <thead>
            <tr>
            <th class="sort border-top ps-1" data-sort="name">Date</th>
              <th class="sort border-top ps-1" data-sort="name">Operation</th>
              <th class="sort border-top ps-1" data-sort="name">User</th>
              <th class="sort border-top ps-1" data-sort="name">Link</th>
             
            </tr>
          </thead>
          <tbody class="list">
          @foreach ($data as $rs)
            <tr>
                <td>{{ ucfirst($rs->updated_at) }} </td>
                <td>{{ ucfirst($rs->operation) }}</td>
                <td>{{ ucfirst($rs->user) }}</td>
                <td><a href="{{ ucfirst($rs->link) }}"> Show</a></td>
            </tr>
          @endforeach
          </tbody>
      </table>
      </div>

      <div class="row align-items-center justify-content-between py-2 pe-0 fs--1">
        <div class="col-auto d-flex">
        <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info"></p><a class="fw-semi-bold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
        </div>
        <div class="col-auto d-flex"><button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
          <ul class="mb-0 pagination"></ul><button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
        </div>
      </div>
  
  @endsection