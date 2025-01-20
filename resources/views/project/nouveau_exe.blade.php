@extends('layout/app')
@section('page-content')
 
    <form action="{{ route('store.exe') }}" method="POST">
        @method('post')
        @csrf
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-9" style="margin:auto">

                            <div class="card">

                                <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"
                                    style="padding: 0.3rem 1rem;">

                                    <h4 class="mb-sm-0"><i class="mdi mdi-plus-circle"></i> Nouvelle Exercice annulle
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

                                                    <div class="row">


                                                        <div class="row gx-4 gy-4 mb-4">
                                                            <!-- Colonne 1 -->
                                                            <div class="col-12 col-md-4">
                                                             

                                                                <div class="mb-3">
                                                                    <label for="budget" class="form-label">Budget
                                                                        :</label>
                                                                    <input type="text" name="montant" id="budget"
                                                                        class="form-control form-control-sm" 
                                                                      >
                                                                </div>


                                                                <div class="mb-3">
                                                                    <label for="datedebut" class="form-label">Début du
                                                                        projet :</label>
                                                                    <input type="date" name="datedebut" id="datedebut"
                                                                       
                                                                        class="form-control form-control-sm">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="datefin" class="form-label">Fin du projet
                                                                        :</label>
                                                                    <input type="date" name="datefin" id="datefin"
                                                                      
                                                                        class="form-control form-control-sm">
                                                                </div>

                                                               
                                                            </div>

                                                            <!-- Colonne 2 -->
                                                            <div class="col-12 col-md-4">
                                                                <div class="mb-3">
                                                                    <label for="numero" class="form-label">Periode
                                                                        :</label>
                                                                    <input name="periode" id="periode"
                                                                      
                                                                        class="form-control form-control-sm">
                                                                </div>

                                                              
                                                              
                                                            </div>

                                                         
                                                           
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


   
@endsection
