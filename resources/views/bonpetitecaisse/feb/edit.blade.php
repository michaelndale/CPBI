@extends('layout/app')
@section('page-content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-11" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Modification du FEB PETIT CAISSE (N° {{ $febData->numero }} ) </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-11" style="margin:auto">
                <div class="card">

                <form class="row g-3 mb-6" method="POST"  action="{{ route('updatefebpetit', $febData->id )}}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="febid" name="febid" class="form-control form-control-sm" style="width: 100% ; background-color:#c0c0c0" value="{{ $febData->id }} " readonly>
                        <div id="tableExample2">
                        <div id="tableExample2">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm fs--1 mb-0">
                                    <tbody class="list">
                                        <tr>
                                            <td class="align-middle ps-3 name" style="width:20%">Composante/ Projet/Section</td>
                                            <td class="align-middle email" colspan="3">
                                            
                                                <input value="{{ Session::get('title') }} " class="form-control form-control-sm" disabled>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle ps-3 name">Compte petite caisse: <span class="text-danger">*</span></td>
                                            <td class="align-middle email">
                                                <select class="form-control  form-control-sm" id="compteid" name="compteid" required>
                                                    <option selected="true" value="{{ $febData->compte_id }}"> {{ $febData->codes }} : {{ $febData->libelle_compte }} </option>
                                                    @foreach ($compte as $comptes)
                                                    <option value="{{ $comptes->id }}"> {{ $comptes->code }} : {{ ucfirst($comptes->libelle) }} </option>
                                                    @endforeach
                                                </select>

                                            </td>

                                            <td class="align-middle ps-3 name">Description de la demande<span class="text-danger">*</span></td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" name="description" value="{{ $febData->description }}" required>
                                            </td>
                                        </tr>


                                        <tr>

                                            <td class="align-middle ps-3 name">
                                                Numéro du fiche FEB<span class="text-danger">*</span> <br>
                                                <input type="number" name="numerofeb" id="numerofeb" value="{{ $febData->numero }}" class="form-control form-control-sm" style="width: 100% ;">
                                                <smal id="numerofeb_error" name="numerofeb_error" class="text text-danger"> </smal>
                                                <smal id="numerofeb_info" class="text text-primary"> </smal>
                                            </td>

                                            <td class="align-middle ps-3 name">
                                                Montant demande FEB<span class="text-danger">*</span> <br>
                                                <input type="number" name="montant" value="{{ $febData->montant }}" class="form-control form-control-sm" style="width: 100% ;">
                                                <input type="hidden" name="ancien_montant" value="{{ $febData->montant }}" >
                                            </td>

                                            <td class="align-middle ps-3 name"> Date du dossier FEB:<span class="text-danger">*</span><br>
                                                <input type="date" class="form-control form-control-sm" value="{{ $febData->date_dossier }}" name="datefeb" id="datefeb" style="width: 100%" required>
                                            </td>
                                            <td class="align-middle ps-3 name"> Date limite:<span class="text-danger">*</span><br>
                                                <input type="date" class="form-control form-control-sm" value="{{ $febData->date_limite }}" name="datelimite" id="datelimite" style="width: 100%">
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                                <hr>

                                <div class="table-repsonsive">
                                    <span id="error"></span>
                                    <table class="table table-striped table-sm fs--1 mb-0">
                                        <tr>
                                        <tr>
                                            <td>Etablie par (AC/CE/CS) <span class="text-danger">*</span> </td>
                                            <td>Vérifiée par (Comptable) <span class="text-danger">*</span></td>
                                            <td>Approuvée par (Chef de Composante/Projet/Section): <span class="text-danger">*</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select type="text" class="form-control form-control-sm" name="acce" id="acce" required>
                                                    <option  selected="true" value="{{ $etablie_par->userid }}">{{ $etablie_par->nom }} {{ $etablie_par->prenom }}</option>
                                                    @foreach ($personnel as $personnels)
                                                    <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                    @endforeach
                                                </select>

                                                <input type="hidden" name="acce_signe" id="acce_signe" value="{{ $febData->etabli_par_signature }}" />
                                                <input type="hidden" name="ancien_acce" id="ancien_acce" value="{{ $febData->etabli_par }}" />

                                            </td>


                                            <td>
                                                <select type="text" class="form-control form-control-sm" name="comptable" id="comptable" required>
                                                    <option selected="true" value="{{ $verifie_par->userid }}">{{ $verifie_par->nom }} {{ $verifie_par->prenom }}</option>
                                                    @foreach ($personnel as $personnels)
                                                    <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                    @endforeach
                                                </select>

                                                <input type="hidden" name="comptable_signe" id="comptable_signe" value="{{ $febData->verifie_par_signature }}" />
                                                <input type="hidden" name="ancien_comptable" id="ancien_comptable" value="{{ $febData->verifie_par }}" />
                                                
                                            </td>


                                            <td>
                                                <select type="text" class="form-control form-control-sm" name="chefcomposante" id="chefcomposante" required>
                                                    <option selected="true" value="{{ $approuver_par->userid }}">{{ $approuver_par->nom }} {{ $approuver_par->prenom }}</option>
                                                    @foreach ($personnel as $personnels)
                                                    <option value="{{ $personnels->userid }}"> {{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                    @endforeach
                                                </select>

                                                <input type="hidden" name="chef_signe" id="chef_signe" value="{{ $febData->approuve_par_signature }}" />
                                                <input type="hidden" name="ancien_chefcomposante" id="ancien_chefcomposante" value="{{ $febData->approuve_par }}" />

                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                </div>
                <br>
               

                <div class="modal-footer">
                    <br><br><br>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  
                    <br>
                </div>


                </form>

            </div>
        </div>
    </div>

    <br> <br>

    @endsection