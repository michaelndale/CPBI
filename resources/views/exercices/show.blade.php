@extends('layout/app')
@section('page-content')


    <form action="{{ route('exercice.update') }}" method="POST">
        @method('put')
        @csrf
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-9" style="margin:auto">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="card">

                                <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"
                                    style="padding: 0.3rem 1rem;">

                                    <h4 class="mb-sm-0"><i class="mdi mdi-plus-circle"></i> Modifier l'exercice annulle
                                        projet </h4>
                                    <div class="page-title-right">

                                        <a href="javascript:void(0);"
                                            class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" title="Actualiser"
                                            onclick="window.location.reload();">
                                            <i class="fas fa-sync-alt"></i>
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
                                                        <input name="exe_id" type="hidden"  value="{{ $exercice->id }}" />

                                                        <input class="form-control form-control-sm"  value="{{  Session::get('title'); }}" readonly  style="background-color:aliceblue" />

                                                    </div>

                                                    <div class="row gx-0 gx-sm-12 gy-12 mb-12">

                                                        <label><b><i class="fa fa-info-circle"></i> Titre: </b></label>
                                                        <input type="text" name="pexercice"  class="form-control form-control-sm" maxlength="50" value="{{ $exercice->pexercice }}" />
                                                    </div>

                                                    <div class="row">


                                                        <div class="row gx-4 gy-4 mb-4">

                                                            <!-- Colonne 1 -->
                                                            <div class="col-12 col-md-3">
                                                                <label for="budget" class="form-label">Budget :</label>
                                                                <input type="text" name="montant" id="budget" class="form-control form-control-sm" value="{{ $exercice->budget }}">
                                                            </div>


                                                            <div class="col-12 col-md-3">
                                                                <label for="datedebut" class="form-label">Début du projet
                                                                    :</label>
                                                                <input type="date" name="datedebut" id="datedebut"  class="form-control form-control-sm" value="{{ $exercice->estart_date }}">
                                                            </div>

                                                            <div class="col-12 col-md-3">
                                                                <label for="datefin" class="form-label">Fin du projet
                                                                    :</label>
                                                                <input type="date" name="datefin" id="datefin" class="form-control form-control-sm" value="{{ $exercice->edeadline }}">
                                                            </div>
                                                            <!-- Colonne 2 -->
                                                            <div class="col-12 col-md-3">
                                                                <label for="numero" class="form-label">Période :</label>
                                                                <input type="number" name="periode" id="periode" class="form-control form-control-sm" value="{{ $exercice->eperiode }}">
                                                            </div>

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
                                            <button type="submit" class="btn btn-primary" id="addfebbtn" name="save"> <i
                                                    class="fa fa-cloud-upload-alt"></i>
                                                Sauvegarder</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </form>
@endsection
