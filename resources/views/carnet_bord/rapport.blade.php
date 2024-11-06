@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-6" style="margin:auto">
                    <div class="card">
                        <div class="card-header p-4 border-bottom border-300 bg-soft">
                            <div class="row g-3 justify-content-between align-items-end">
                                <div class="col-12 col-md">
                                    <h6 class="text-900 mb-0" data-anchor="data-anchor"><i class="fas fa-search"></i> Element
                                        de la recherche </h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" id="addrapportform">
                                @method('post')
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-4 col-lg-6 col-xl-6">
                                            <label class="text-1000 fw-bold mb-2">Vehivule </label>
                                            <div class="row g-2">
                                                <div class="col">
                                                    <select type="text" name="vehicule" id="vehiculeid"
                                                        style="width: 100%" class="form-control form-control-sm" required>
                                                        <option disabled="true" selected="true" value="">--Aucun--
                                                        </option>
                                                        @forelse ($vehicule as $vehicules)
                                                            <option value="{{ $vehicules->id }}">
                                                                {{ $vehicules->matricule }} </option>
                                                        @empty
                                                            <option disabled="true" selected="true" value="">--Aucun
                                                                vehicule
                                                                trouver--</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 col-lg-6 col-xl-3">
                                            <label class="text-1000 fw-bold mb-2">Periode du </label>
                                            <div class="row g-2">
                                                <div class="col">
                                                    <input id="datede" name="datede"
                                                        class="form-control form-control-sm" type="date" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 col-lg-6 col-xl-3">
                                            <label class="text-1000 fw-bold mb-2">Au</label>
                                            <div class="row g-2">
                                                <div class="col">
                                                    <input id="dateau" name="dateau"
                                                        class="form-control form-control-sm" type="date" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 col-lg-12 col-xl-12">
                                            <label class="text-1000 fw-bold mb-2">Projet </label>
                                            <div class="row g-2">
                                                <div class="col">
                                                    <select type="text" name="projetid" style="width: 100%"
                                                        class="form-control form-control-sm" required>
                                                        <option disabled="true" selected="true" value="">--Aucun--
                                                        </option>
                                                        @forelse ($projet as $projets)
                                                            <option value="{{ $projets->id }}"> {{ $projets->title }}
                                                            </option>
                                                        @empty
                                                            <option disabled="true" selected="true" value="">--Aucun
                                                                projet
                                                                trouver--</option>
                                                        @endforelse
                                                    </select>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 col-lg-6 col-xl-6">
                                            <label class="text-1000 fw-bold mb-2"> Fournisseur </label>
                                            <div class="row g-2">
                                                <div class="col">
                                                    <select type="text" name="fournisseurid" style="width: 100%"
                                                        class="form-control form-control-sm" required>
                                                        <option disabled="true" selected="true" value="">--Aucun--
                                                        </option>
                                                        @forelse ($founisseur as $founisseurs)
                                                            <option value="{{ $founisseurs->id }}"> {{ $founisseurs->nom }}
                                                            </option>
                                                        @empty
                                                            <option disabled="true" selected="true" value="">--Aucun
                                                                service
                                                                trouver--</option>
                                                        @endforelse
                                                    </select>

                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-sm-4 col-lg-6 col-xl-6">
                                            <label class="text-1000 fw-bold mb-2">Operation </label>
                                            <div class="row g-2">
                                                <div class="col">
                                                    <select type="text" name="fournisseurid" style="width: 100%"
                                                        class="form-control form-control-sm" required>

                                                        <option disabled="true" selected="true" value="">--Operation--
                                                        </option>
                                                        <option value="Carburants"> Consommations carburant </option>
                                                        <option value="Entretients"> Entretients </option>
                                                        <option value="Carnet de bort"> Carnet de bort </option>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="modal-footer">
                                    <button type="submit" name="sendSave" id="sendSave" class="btn btn-primary"
                                        type="button">
                                        <i class="fa fa-search"></i> Recherche </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->


            </div>

        </div>
    </div>
@endsection
