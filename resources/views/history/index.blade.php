@extends('layout/app')
@section('page-content')

<div class="main-content">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Historique</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Historique</a></li>
                            <li class="breadcrumb-item active">Liste</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Historique</h4>
                        <p class="card-title-desc">Liste des operations</p>

                        <table id="datatable" class="table table-bordered  table-sm fs--1 mb-0" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr style="background-color:#82E0AA">
                            <th >Fonction</th>
                            <th >Operation</th>
                            <th >User</th>
                            <th >Link</th>
                          </tr>
                            </thead>


                            <tbody>
                            @foreach ($data as $rs)
                              <tr>
                              <td>{{ ucfirst($rs->fonction) }} </td>
                              <td>{{ ucfirst($rs->operation) }} </td>
                              <td>{{ ucfirst($rs->user) }} </td>
                              <td>{{ ucfirst($rs->updated_at) }} </td>
                              </tr>
                            @endforeach
                           
                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
        
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->



</div>





  @endsection