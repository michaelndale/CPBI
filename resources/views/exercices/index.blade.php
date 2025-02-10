@extends('layout/app')
@section('page-content')
@php
    $IDPJ = Session::get('id');
    $exercice_id = Session::get('exercice_id');
    $cryptedProjectId = Crypt::encrypt($IDPJ);
@endphp
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-10" style="margin:auto">
                    <div class="card">
                      <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">
                                <h4 class="mb-sm-0"><i class="fa fa-list"></i> Liste des Exercices du projet : {{  Session::get('title') }}</h4>
                                <div class="page-title-right">
                                    <a href="{{ route('new.exercice',  $cryptedProjectId) }}" type="button"  class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"  aria-haspopup="true" aria-expanded="false">
                                      <i class="fa fa-plus-circle"></i> Créer </a>
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-0 pb-3">
                            <div id="overview-chart" data-colors='["#1f58c7"]' class="apex-charts" dir="ltr"></div>
                            <div class="table-responsive">

                                <table class="table table-striped table-sm fs--1 mb-0">
                                  <thead>
                                    <tr>
                                        <th>Numéro</th>
                                        <th>Budget</th>
                                        <th>Statut</th>
                                        <th>Date Début</th>
                                        <th>Date Fin</th>
                                        <th>Créé le</th>
                                        <th><center>Actions</center></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($exercices as $exercice)
                                        @php
                                            $cryptedExecId =  Crypt::encrypt($exercice->id);
                                        @endphp
                                        <tr>
                                            <td>{{ $exercice->numero_e }}/{{ date('Y', strtotime($exercice->created_at)) }}</td>
                                            <td>{{ number_format($exercice->budget, 0, ',', ' ') }}</td>
                                            <td>
                                                @if ($exercice->status === 'Actif')
                                                    <span class="badge rounded-pill bg-subtle-primary text-primary font-size-11">Active</span>
                                                @else
                                                    <span class="badge rounded-pill bg-subtle-danger text-danger font-size-11">Archiver</span>
                                                @endif
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($exercice->estart_date)) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($exercice->edeadline)) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($exercice->created_at)) }} </td>
                                            <td>
                                                <center>
                                                    <div class="btn-group me-2 mb-2 mb-sm-0">
                                                        <a  data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="mdi mdi-dots-vertical ms-2"></i> Options
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item text-primary mx-1" href="{{ route('exercices.show', $cryptedExecId) }}"   title="Modifier"><i class="far fa-edit"></i> Modifier l'exercice</a>
                                                           
                                                        </div>
                                                    </div>
                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                                <br><br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <form method="POST" id="editform">
              @method('post')
              @csrf
              <div class="modal-header">
                  <h5 class="modal-title" id="addDealModalTitle"><i class="fa fa-edit"></i> Modification  terme de refference</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <label class="text-1000 fw-bold mb-2">Abreviation</label>
                <input class="form-control" id="a_id" name="a_id" type="hidden" placeholder="Entrer abreviation" required /> <br>
                <input class="form-control" id="a_abreviation" name="a_abreviation" type="text" placeholder="Entrer abreviation" required /> <br>
              
                <label class="text-1000 fw-bold mb-2">Nom </label>
                <input class="form-control" id="a_libelle" name="a_libelle" type="text" placeholder="Entrer nom" required /> <br>
                  
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                  <button type="submit" name="editbtn" id="editbtn" class="btn btn-primary waves-effect waves-light"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
              </div>

            </form>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div>

   
@endsection