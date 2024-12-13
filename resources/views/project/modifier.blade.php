@extends('layout/app')
@section('page-content')
    @foreach ($responsable as $responsables)
    @endforeach
    <form action="{{ route('updatprojet', $dataProject->id) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-9" style="margin:auto">

                            <div class="card">

                                <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"
                                    style="padding: 0.3rem 1rem;">

                                    <h4 class="mb-sm-0"><i class="mdi mdi-plus-circle"></i> Modification Information du
                                        projet </h4>
                                    <div class="page-title-right">

                                        <a href="javascript:void(0);"
                                            class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" title="Actualiser"
                                            onclick="window.location.reload();">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>

                                        <a href="javascript:void(0);"
                                            class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#revisionModal">
                                            <span class="fa fa-edit"></span> Revision budgetaire
                                        </a>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <div class="col-12 col-xl-12 col-xxl-12 pe-xl-0">
                                        <div class="mb-12 mb-xl-12">
                                            <div class="row gx-0 gx-sm-12">
                                                <div class="col-12">

                                                    <div class="row gx-0 gx-sm-12 gy-12 mb-12">
                                                        <label><b><i class="fa fa-info-circle"></i> Dénomination du projet:
                                                            </b></label>
                                                        <input name="pid" type="hidden"
                                                            value="{{ Session::get('id') }}" />
                                                        <input name="ptitre" class="form-control form-control-sm"
                                                            value="{{ $dataProject->title }}" />
                                                    </div>

                                                    <br>

                                                    <div class="row gx-0 gx-sm-12 gy-12 mb-12">
                                                        <label><b><i class="fa fa-info-circle"></i> Description:
                                                            </b></label>
                                                        <textarea name="description" class="form-control form-control-sm" rows="5">{{ $dataProject->description }}</textarea>

                                                    </div>

                                                    <div class="row">


                                                        <div class="row gx-4 gy-4 mb-4">
                                                            <!-- Colonne 1 -->
                                                            <div class="col-12 col-md-4">
                                                                <div class="mb-3">
                                                                    <label for="responsable" class="form-label">Responsable
                                                                        :</label>
                                                                    <select name="resid" id="responsable"
                                                                        class="form-control form-control-sm">
                                                                        <option value="{{ ucfirst($responsables->id) }}">
                                                                            {{ ucfirst($responsables->nom) }}
                                                                            {{ ucfirst($responsables->prenom) }}
                                                                        </option>
                                                                        @foreach ($alluser as $allusers)
                                                                            <option value="{{ $allusers->id }}">
                                                                                {{ ucfirst($allusers->nom) }}
                                                                                {{ ucfirst($allusers->prenom) }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="budget" class="form-label">Budget
                                                                        :</label>
                                                                    <input type="text" name="montant" id="budget"
                                                                        value="{{ $dataProject->budget }}"
                                                                        class="form-control form-control-sm" readonly
                                                                        style="background-color:#c0c0c0">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="devise" class="form-label">Devise
                                                                        :</label>
                                                                    <input name="devise" id="devise"
                                                                        value="{{ $dataProject->devise }}"
                                                                        class="form-control form-control-sm">
                                                                </div>
                                                            </div>

                                                            <!-- Colonne 2 -->
                                                            <div class="col-12 col-md-4">
                                                                <div class="mb-3">
                                                                    <label for="numero" class="form-label">Numéro projet
                                                                        :</label>
                                                                    <input name="numero" id="numero"
                                                                        value="{{ $dataProject->numeroprojet }}"
                                                                        class="form-control form-control-sm">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="datedebut" class="form-label">Début du
                                                                        projet :</label>
                                                                    <input type="date" name="datedebut" id="datedebut"
                                                                        value="{{ $dataProject->start_date }}"
                                                                        class="form-control form-control-sm">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="datefin" class="form-label">Fin du projet
                                                                        :</label>
                                                                    <input type="date" name="datefin" id="datefin"
                                                                        value="{{ $dataProject->deadline }}"
                                                                        class="form-control form-control-sm">
                                                                </div>
                                                            </div>

                                                            <!-- Colonne 3 -->
                                                            <div class="col-12 col-md-4">
                                                                <div class="mb-3">
                                                                    <label for="region" class="form-label">Région
                                                                        :</label>
                                                                    <input name="region" id="region"
                                                                        value="{{ $dataProject->region }}"
                                                                        class="form-control form-control-sm">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="lieu" class="form-label">Lieu
                                                                        :</label>
                                                                    <input name="lieu" id="lieu"
                                                                        value="{{ $dataProject->lieuprojet }}"
                                                                        class="form-control form-control-sm">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="periode" class="form-label">Période
                                                                        (T1,T2,T3...) :</label>
                                                                    <input name="periode" id="periode" type="number"
                                                                        value="{{ $dataProject->periode }}"
                                                                        class="form-control form-control-sm" required>
                                                                </div>


                                                            </div>

                                                            <div class="d-flex flex-wrap align-items-start">
                                                                <!-- Premier bloc -->
                                                                <div class="col-12 col-md-4">
                                                                    <div class="mb-3">
                                                                        <label for="autorisation"
                                                                            class="form-label">Autorisation de modification
                                                                            :</label>
                                                                        <select name="autorisation" id="autorisation"
                                                                            required class="form-control form-control-sm">
                                                                            <option
                                                                                value="{{ $dataProject->autorisation }}">
                                                                                @if ($dataProject->autorisation == 0)
                                                                                    Fermer
                                                                                @else
                                                                                    Ouvert
                                                                                @endif
                                                                            </option>
                                                                            <option value="0">Fermer</option>
                                                                            <option value="1">Ouvert</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <!-- Deuxième bloc -->
                                                                <div class="col-12 col-md-4 ms-3">
                                                                    <div class="mb-3">
                                                                        <label for="statut" class="form-label">Statut du
                                                                            projet :</label>
                                                                        <select name="statut" id="statut" required
                                                                            class="form-control form-control-sm">
                                                                            <option value="{{ $dataProject->statut }}">
                                                                                {{ $dataProject->statut }}</option>
                                                                            <option value="En attente">En attente</option>
                                                                            <option value="Activé">Activé</option>
                                                                            <option value="Bloqué">Bloqué</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Bouton Enregistrer -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-header p-4 border-bottom border-300 bg-soft">
                                    <div class="row g-3 justify-content-between align-items-end">
                                        <div class="col-12 col-md" style="padding: 0.3rem 3rem;">

                                        </div>
                                        <div class="col col-md-auto">
                                            <button type="submit" class="btn btn-primary" id="addfebbtn"
                                                name="save"> <i class="fa fa-cloud-upload-alt"></i>
                                                Sauvegarder</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </form>


    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="revisionModal" tabindex="-1" aria-labelledby="revisionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="revisionModalLabel">Révision Budgétaire</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('revision.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="projet_id" value="{{ $dataProject->id }}">
    
                        <!-- Ancien Montant -->
                        <div class="mb-3">
                            <label for="ancienMontant" class="form-label">Ancien Montant</label>
                            <input type="number" class="form-control" name="ancien_montant" id="ancienMontant"
                                value="{{ $dataProject->budget }}" readonly>
                        </div>
    
                        <!-- Nouveau Montant -->
                        <div class="mb-3">
                            <label for="nouveauMontant" class="form-label">Nouveau Montant</label>
                            <input type="number" min="0" class="form-control" name="nouveau_montant" id="nouveauMontant"
                                required>
                        </div>
    
                        <!-- Justification -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Pourquoi revoir la révision ?</label>
                            <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
                        </div>
                    </div>
    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
