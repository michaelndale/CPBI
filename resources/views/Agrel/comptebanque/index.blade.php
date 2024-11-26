@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-7" style="margin:auto">
                    <div class="card">
                        <div class="card-header">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0"><i class="fa fa-university"></i> Listes des Comptes</h4>
                                <div class="page-title-right">
                                    <a href="javascript:;" class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#addModal"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-plus-circle"></i> Nouveau comptes
                                 </a>
                                 
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0 pb-3">
                            <div id="overview-chart" data-colors='["#1f58c7"]' class="apex-charts" dir="ltr"></div>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm fs--1 mb-0">
                                    <thead>
                                        <tr>
                                            <th><b>Banque</b></th>
                                            <th><b>Numéro de compte</b></th>
                                            <th><b>Solde</b></th>
                                            <th><b>Devise</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($comptes as $compte)
                                            <tr>
                                                <td>{{ $compte->banque_name }}</td>
                                                <td>{{ $compte->numero_compte }}</td>
                                                <td>{{ $compte->solde }}</td>
                                                <td>{{ $compte->devise }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">Ceci est vide</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>





            <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="{{ route('store.compte.banque') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-university"></i> Nouveau Compte</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <label class="text-1000 fw-bold mb-2">Banque</label>
                                        <select class="form-control" name="banque_id" id="banque_id" required>
                                            <option value="">Sélectionner une banque</option>
                                            @foreach ($banques as $banque)
                                                <option value="{{ $banque->id }}">{{ $banque->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
            
                                    <div class="col-sm-12 col-md-12">
                                        <label class="text-1000 fw-bold mb-2">Numéro de compte</label>
                                        <input class="form-control" name="numero_compte" id="numero_compte" type="text"
                                               placeholder="Entrer le numéro de compte" required />
                                    </div>
            
                                    <div class="col-sm-12 col-md-12">
                                        <label class="text-1000 fw-bold mb-2">Devise</label>
                                        <select class="form-control" name="devise" id="devise" required>
                                            <option value="">Sélectionner une devise</option>
                                            @foreach ($devises as $devise)
                                                <option value="{{ $devise->libelle }}">{{ $devise->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="saveData" id="saveData" class="btn btn-primary">
                                    <i class="fa fa-cloud-upload-alt"></i> Sauvegarder
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            



            {{-- Edit banque modal --}}

            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" style="display: none;"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="POST" id="editform">
                            @method('post')
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticallyCenteredModalLabel">Modification banque </h5><button
                                    class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg
                                        class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false"
                                        data-prefix="fas" data-icon="xmark" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z">
                                        </path>
                                    </svg></button>
                            </div>
                            <div class="modal-body">
                                <label class="text-1000 fw-bold mb-2">Abriation </label>
                                <input type="hidden" name="bid" id="bid">
                                <input class="form-control" name="blibelle" id="blibelle" type="text"
                                    placeholder="Entrer function" name="blibelle" required />
                            </div>

                            <div class="modal-body">
                                <label class="text-1000 fw-bold mb-2">Nom affiché </label>
                                <input type="hidden" name="bid" id="bid">
                                <input class="form-control" name="blibelle" id="blibelle" type="text"
                                    placeholder="Entrer function" name="blibelle" required />
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="editbtn" class="btn btn-primary"
                                    type="button">Modifier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endsection
