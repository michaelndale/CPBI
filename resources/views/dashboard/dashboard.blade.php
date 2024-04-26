@extends('layout/app')
@section('page-content')
@php
 $documentacce= DB::table('febs')
 ->Where('acce', Auth::id() )
 ->Where('acce_signe',  0)
 ->get()
 ->count();
 
 $documentcompte = DB::table('febs')
 ->Where('comptable', Auth::id() )
 ->Where('comptable_signe',  0)
 ->get()
 ->count();
 
 $documentchefcomposent= DB::table('febs')
 ->Where('chefcomposante', Auth::id() )
 ->Where('chef_signe',  0)
 ->get()
 ->count();
 
 $documentNombre= $documentacce + $documentcompte + $documentchefcomposent;
 
 @endphp

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Tableau de bord des projets <BR> COMMUNAUTÉ DES EGLISES DE PENTECÔTE AU BURUNDI “CEPBU” </h4>
                        <div class="page-title-right">
                            <e class="form-control ps-6 "> @include('dashboard.time')</e>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap pb-3 gap-3">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-truncate mb-2">Projets</p>
                                            <h4 class="mt-2 mb-0">{{ $project->count(); }} <span class="badge bg-subtle-primary text-primary font-size-10 ms-1"><i class="mdi mdi-arrow-up"></i> {{ $project->count(); }}%</sup></h4>
                                        </div>
                                        <div class="text-primary">
                                            <div id="chart-mini1" class="apex-chart"></div>
                                        </div>
                                    </div>
                                    <p class="mb-0 font-size-14 fw-bold mt-2 "> <span class="text-muted fw-normal"> ~ Tout les projets</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap pb-3 gap-3">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-truncate mb-2">Personnel</p>
                                            <h4 class="mt-2 mb-0">{{ $user->count(); }}<span class="badge bg-subtle-danger text-danger font-size-10 ms-1"><i class="mdi mdi-arrow-down"></i> {{ $user->count(); }}%</sup></h4>
                                        </div>
                                        <div class="text-primary">
                                            <div id="chart-mini2" class="apex-chart"></div>
                                        </div>
                                    </div>
                                    <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate"><span class="text-muted fw-normal"> ~ Tous les personnels</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap pb-3 gap-3">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-truncate mb-2">Activités</p>
                                            <h4 class="mt-2 mb-0">{{ $activite->count(); }} <span class="badge bg-subtle-primary text-primary font-size-10 ms-1"><i class="mdi mdi-arrow-up"></i> {{ $activite->count(); }}%</sup></h4>
                                        </div>
                                        <div class="text-primary">
                                            <div id="chart-mini3" class="apex-chart"></div>
                                        </div>
                                    </div>
                                    <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate"><span class="text-muted fw-normal"> ~ Tout les activités </span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap pb-3 gap-3">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-truncate mb-2">Projets</p>
                                            <h4 class="mt-2 mb-0">{{ $encours }} <span class="badge bg-subtle-danger text-danger font-size-10 ms-1"><i class="mdi mdi-arrow-down"></i> {{ $encours }}%</sup></h4>
                                        </div>
                                        <div class="text-primary">
                                            <div id="chart-mini4" class="apex-chart"></div>
                                        </div>
                                    </div>
                                    <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate"><span class="text-muted fw-normal"> ~ Encours d'exécution</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
        @if (session()->has('id'))
            <div class="px-lg-2">
                <div class="row g-0">
                  <div class="col">
                    <a class="dropdown-icon-item" href="#">
                      <i class="fa fa-folder-open" size='5'></i>
                      <span>Projets</span>
                    </a>
                  </div>
                  <div class="col">
                    <a class="dropdown-icon-item" href="#">
                      <i class="fa fa-folder-open" size='5'></i>
                      <span>Activités</span>
                    </a>
                  </div>
                  <div class="col">
                    <a class="dropdown-icon-item" href="#">
                      <i class="fa fa-users" size='5'></i>
                      <span>RH</span>
                    </a>
                  </div>
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
                      <span>Infos</span>
                    </a>
                  </div>

                  <div class="col">
                    <a class="dropdown-icon-item" href="#">
                      <i class="fa fa-info-circle" size='5'></i>
                      <span>Infos</span>
                    </a>
                  </div>
                  <div class="col">
                    <a class="dropdown-icon-item" href="#">
                      <i class="fa fa-info-circle" size='5'></i>
                      <span>Infos</span>
                    </a>
                  </div>
                </div>

              
              </div>
        @endif


                    <!-- end row -->

                    @if (!session()->has('id'))



                    <div class="row">
                        <div class="col-xl-3">
                            <div class="card">
                                <div class="card-body">


                                    <h4 class="card-title"><i class="fa fa-search"></i> Recherche projet</h4>
                                    <div class="mt-4">


                                        <div class="mt-4 text-center">
                                            <select class="form-select classcategory" id="classcategory">
                                                <option disabled="true" selected="true">--Dossier--</option>
                                                @foreach ($folder as $folders)
                                                <option value="{{ $folders->id }}">{{ ucfirst($folders->title) }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mt-4 text-center">

                                            <select class="form-select annee" id="annee">
                                                <option value="0" disabled="true" selected="true">--Année--</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-9">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title mb-3"><i class="fa fa-list"></i> Bref résumé de tous les projets en recherche</h4>


                                    <div class="table-responsive">
                                        <table class="table table-centered align-middle table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20px;" class="align-middle">
                                                        <div class="form-check font-size-15">
                                                            <input class="form-check-input" type="checkbox" id="checkAll">
                                                            <label class="form-check-label" for="checkAll"> Numéro</label>
                                                        </div>
                                                    </th>
                                                    <th>Titre du projet</th>
                                                    <th>Date début</th>
                                                    <th>Date fin</th>
                                                    <th>Statut</th>
                                                    <th>Année</th>
                                                </tr>
                                            </thead>
                                            <tbody class="show_all_projet tableviewsclass" id="show_all_projet">
                                                <tr>
                                                    <td colspan="6">
                                                        <h6 style="margin-top:1% ;color:#c0c0c0">
                                                            <center>
                                                                <font size="5px"><i class="fa fa-search"></i> </font><br><br>
                                                                Sélectionner le dossier et l'année
                                                            </center>
                                                        </h6>
                                                    </td>

                                                </tr>



                                            </tbody>
                                        </table>
                                        <br>
                                        <a class="fw-bold fs--1 mt-4" href="{{ route('new_project') }}"><span class="fas fa-plus-circle"></span> Ajouter nouveau projet </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    @endif
                    <!-- end row -->

                </div>


            </div>
            <!-- end row -->



        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->


@if ($documentNombre != 0)
<div class="modal fade" id="monNotification" tabindex="-1" role="dialog" aria-labelledby="monNotificationLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myLargeModalLabel"><i class="fa fa-folder-open"></i> Tâches à faire en attente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" >


      <div id="tableExample2" >
              <div class="table-responsive">
                <table class="table table-striped table-sm fs--1 mb-0" >
                  <thead>
                    <tr>
                      <th class="sort border-top "><b>ID </b></center></th>
                      <th class="sort border-top" data-sort="date"><b>Document</b></th>
                      <th class="sort border-top" data-sort="febnum"><b>N<sup>o</sup> Doc </b></th>
                      <th class="sort border-top" data-sort="date"><b>Date Doc</b></th>
                      <th class="sort border-top" data-sort="date"><b>Date creation</b></th>
                    </tr>
                  </thead>


                  <tbody id="allnotification" >
                  </tbody>
                </table>
              </div>
      </div>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog --> 
</div>
@endif

<script>
  $(document).ready(function(){
    // Sélectionnez votre modal et utilisez la méthode modal('show') pour l'ouvrir
    $('#monNotification').modal('show');
  });
</script>





    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on('change', '.classcategory', function() {
                var cat_id = $(this).val();
                var div = $(this).parent();
                var op = " ";
                $.ajax({
                    type: 'get',
                    url: "{{ route ('findClaseur') }}",
                    data: {
                        'id': cat_id
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.length == 0) {
                            op += '<option value="0" selected disabled>--Année--</option>';
                            op += '<option value="0" selected disabled>Aucun </option>';
                            document.getElementById("annee").innerHTML = op



                            toastr.error("Attention!!\n le dossier n'a pas de projet", "Information");


                        } else {
                            op += '<option value="0" selected disabled>--Année--</option>';
                            for (var i = 0; i < data.length; i++) {
                                op += '<option value="' + data[i].annee + '">' + data[i].annee + '</option>';
                                document.getElementById("annee").innerHTML = op
                            }
                        }

                    },
                    error: function() {

                        toastr.error("Erreur de connexion a la base de donnee ,\n verifier votre connection", "Attention");
                    }
                });
            });

            $(document).on('change', '.annee', function() {
                var ann_id = $(this).val();
                var classcategory = document.getElementById('classcategory').value;
                var a = $(this).parent();
                var op = "";
                $.ajax({
                    type: 'get',
                    url: "{{ route ('findAnnee') }}",
                    data: {
                        'id': ann_id,
                        'docid': classcategory
                    },
                    dataType: 'json',
                    success: function(data) 
                    {
                        $("#show_all_projet").html(data);
                        
                    },
                    error: function() {
                    }
                });
            });
        });
    </script>

    @endsection