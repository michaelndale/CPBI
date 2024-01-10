@extends('layout/app')
@section('page-content')
<div class="content">
  <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" >
    <div class="card-header p-4 border-bottom border-300 bg-soft">
      <div class="row g-3 justify-content-between align-items-end">
        <div class="col-12 col-md">
          <h4 class="text-900 mb-0" data-anchor="data-anchor"> <i class="fa fa-folder-open"></i> History </h4>

        </div>
        
      </div>
    </div>
    <div class="card-body p-0">
      <div class="collapse code-collapse" id="search-example-code">
      </div>
      <div class="p-4 code-to-copy">
        <div id="tableExample3" data-list='{"valueNames":["name","email"],"page":5,"pagination":true}'>
          <div class="search-box mb-3 mx-auto">
            <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input class="form-control search-input search form-control-sm" type="search" placeholder="Search" aria-label="Search" />
              <span class="fas fa-search search-box-icon"></span>
            </form>
          </div>
          <div class="table-responsive" id="show_all">
          <table class="table table-striped table-sm fs--1 mb-0">
          <thead>
            <tr>
         
              <th class="sort border-top ps-3" data-sort="name">Function</th>
              <th class="sort border-top ps-3" data-sort="name">Operation</th>
              <th class="sort border-top ps-3" data-sort="name">User</th>
              <th class="sort border-top ps-3" data-sort="name">Date</th>
            </tr>
          </thead>
          <tbody class="list">
            @forelse ($data as  $rs)
            <tr>
              <td>{{ ucfirst($rs->fonction) }} </td>
              <td>{{ ucfirst($rs->operation) }} </td>
              <td>{{ ucfirst($rs->user) }} </td>
              <td>{{ ucfirst($rs->updated_at) }} </td>
             
            </tr>
            @empty
            <h3 class="text-center text-secondery my-5" > Aucun enregistrement dans la base de données ! </h3>
            @endforelse
          
            </tbody></table>
          </div>
          <div class="d-flex justify-content-between mt-3"><span class="d-none d-sm-inline-block" data-list-info="data-list-info"></span>
            <div class="d-flex"><button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
              <ul class="mb-0 pagination"></ul><button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  @endsection