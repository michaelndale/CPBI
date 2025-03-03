@extends('layout/app')
@section('page-content')
   
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-11" style="margin:auto">

                            <form  method="POST" action="{{ route('storeProject') }}">
                                @method('post')
                                @csrf

                            <div class="card">

                                
                                <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"
                                    style="padding: 0.3rem 1rem;">

                                    <h4 class="mb-sm-0"><i class="mdi mdi-plus-circle"></i> Creaction du projet </h4>
                                  
                                </div>

                               

                                <div class="card-body">
                                    <div class="col-12 col-xl-12 col-xxl-12 pe-xl-0">
                                        <div class="mb-12 mb-xl-12">
                                            <div class="row gx-0 gx-sm-12">
                                                <div class="col-12">

                                                    <div class="row">

                                                        <div class="col-12 col-md-9">
                                                        <label><b><i class="fa fa-info-circle"></i> Dénomination du projet:
                                                            </b></label>

                                                        <input class="form-control" name="title" id="title"
                                                            type="text" placeholder="Titre du Projet" required />
                                                    </div>

                                                    <div class="col-12 col-md-3">
                                                        <label><b><i class="fa fa-info-circle"></i> Budget:
                                                            </b></label>

                                                        <input class="form-control" id="budget" name="budget" type="number" placeholder="Budget" required />
                                                    </div>

                                                    </div>
                                                </br>

                                                    <div class="row">



                                             

                                                  

                                                        
                                                        <div class="col-12 col-md-3">
                                                            <div class="mb-3">
                                                                <label for="numero" class="form-label">Numéro </label>
                                                                    <input value="{{ $newNumero }}" class="form-control form-control-sm" name="numeroProjet" id="numeroProjet" type="text" placeholder="Numero " required  readonly style='background-color:#c0c0c0'/>

                                                            </div>
                                                        </div>


                                                        <div class="col-12 col-md-3">
                                                            <div class="mb-3">
                                                                <label for="numero" class="form-label">Reponsable  </label>
                                                                <select class="form-control form-control-sm" id="leader" name="leader" required>
                                                                    <option disabled="true" selected="true" value="">Options </option>
                                                                      @foreach ($dataMember as $dataMembers)
                                                                      <option value="{{ $dataMembers->id }}">{{ ucfirst($dataMembers->nom) }} {{ ucfirst($dataMembers->prenom) }}</option>
                                                                      @endforeach
                                                                    </select>
                                                            </div>
                                                        </div>



                                                        <div class="col-12 col-md-3">
                                                            <div class="mb-3">
                                                                <label for="numero" class="form-label">Pays </label>
                                                                <select class="form-control form-control-sm" id="region" name="region" required>
                                                                    <option disabled="true" selected="true" value="">Options</option>
                                                                      @foreach ($pays as $pay)
                                                                      <option value="{{ $pay->id }}">{{ $pay->name }} </option>
                                                                      @endforeach
                                                                    </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-3">
                                                            <div class="mb-3">
                                                                <label for="numero" class="form-label">Devise</label>
                                                                <select class="form-control form-control-sm" id="devise" name="devise" required>
                                                                    <option disabled="true" selected="true" value="">Options</option>
                                                                      @foreach ($devise as $devises)
                                                                      <option value="{{ $devises->libelle }}">{{ $devises->libelle }} </option>
                                                                      @endforeach
                                                    
                                                                    </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-3">
                                                            <div class="mb-3">
                                                                <label for="numero" class="form-label">Dossier</label>
                                                                <select class="form-control form-control-sm" id="numeroDossier" name="numeroDossier" required>
                                                                    <option disabled="true" selected="true" value="">Options</option>
                                                                      @foreach ($dataFolder as $dataFolders)
                                                                      <option value="{{ $dataFolders->id }}">{{ $dataFolders->title }} </option>
                                                                      @endforeach
                                                                    </select>
                                                            </div>
                                                        </div>



                                                        <div class="col-12 col-md-3">
                                                            <div class="mb-3">
                                                                <label for="numero" class="form-label">Période</label>
                                                                <input class="form-control form-control-sm" name="periode" id="periode" type="number" max="12" min="1" placeholder="Periode (Moi)" required />
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-3">
                                                            <div class="mb-3">
                                                                <label for="numero" class="form-label">Date début</label>
                                                                <input class="form-control form-control-sm" name="startdate" id="startdate" type="date"   required />
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-3">
                                                            <div class="mb-3">
                                                                <label for="numero" class="form-label">Date fin</label>
                                                                <input class="form-control form-control-sm" name="deadline" id="deadline" type="date"   required />
                                                            </div>
                                                        </div>

                                                        

                                                       

                                                    
                                                    </div>

                                                    <div class="row gx-0 gx-sm-12 gy-12 mb-12">
                                                        <label><b><i class="fa fa-info-circle"></i> Description:
                                                            </b></label>
                                                        <textarea name="description" class="form-control form-control-sm" rows="5"></textarea>

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

                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
@endsection
