@extends('layout/app')
@section('page-content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-10" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Le details de la decaissement (N° {{ $dataPetiteCaisse->numero }} ) </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-10" style="margin:auto">
                <div class="card">
                    <div class="card-body">

                      
                                        <form class="row g-3 mb-6" method="POST" id="addbpcForm">
                                            @method('post')
                                            @csrf
                                            <div id="tableExample2">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-sm fs--1 mb-0">
                                                        <tbody class="list">
                                                            <tr>
                                                                <td class="align-middle ps-3 name" colspan="5">
                                                                    Composante/ Projet/Section <br>
                                                                    <input value="{{ Session::get('id') }}" type="hidden" name="projetid" id="projetid">
                                                                    <input value="{{ Session::get('title') }}" class="form-control form-control-sm" disabled>
                                                                </td>
                                                            </tr>
                                                            <td class="align-middle email" colspan="5">
                                                                Ligne source de consommation
                                                                <select class="form-control form-control-sm" id="lignedecaisse" name="lignedecaisse" required>
                                                                    <option disabled="true" selected="true"> Sélectionner ligne source de consommation</option>
                                                                    @foreach ($compte as $comptes)
                                                                    <optgroup label="{{ $comptes->libelle }}">
                                                                        @php
                                                                        $idc = $comptes->id;
                                                                        $res= DB::select("SELECT * FROM comptes WHERE compteid= $idc");
                                                                        @endphp
                                                                        @foreach($res as $re)
                                                                        <option value="{{ $re->id }}"> {{ $re->numero }}. {{ $re->libelle }} </option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle ps-3 name" colspan="3">Je soussigné (nom complet)
                                                                    <br>
                                                                    <input type="text" class="form-control form-control-sm" name="nom" id="nom" value="{{ $dataPetiteCaisse->nom_sousigne }}" required>
                                                                </td>
                        
                                                              
                        
                        
                                                                <td class="align-middle ps-3 name" colspan="2">
                                                                    Personne interne <br>
                                                                    Oui <input type="checkbox" class="form-check-input"  id="interneOui" value="1" name="interne">
                                                                    &nbsp; &nbsp; &nbsp;
                                                                    Non <input type="checkbox" class="form-check-input"  id="interneNon" value="0" name="interne"><br>
                                                                </td>
                        
                                                            </tr>
                        
                                                            <tr id="enleveceselement">
                                                                <td class="align-middle ps-3 name">
                                                                    Titre (+ nom de l'organisation si differente de la CEPBU)<br>
                                                                    <input type="text" class="form-control form-control-sm"  value="{{ $dataPetiteCaisse->titre }}" name="titre" id="titre" >
                                                                </td>
                                                                <td class="align-middle ps-3 name">
                                                                    Type de carte d'identité <br>
                                                                    <input type="text" class="form-control form-control-sm"  value="{{ $dataPetiteCaisse->type_identite }}" name="type_identite" id="type_identite" >
                                                                </td>
                                                                <td>
                                                                    Numéro de la piece d'identite <br>
                                                                    <input type="text" class="form-control form-control-sm"   value="{{ $dataPetiteCaisse->numero_piece }}" name="numero_piece" id="numero_piece" >
                                                                </td>
                                                                <td>
                                                                    Adresse <br>
                                                                    <input type="text" class="form-control form-control-sm"  value="{{ $dataPetiteCaisse->adresse }}"name="adresse" id="adresse" >
                                                                </td>
                                                                <td>
                                                                    Téléphone/Email<br>
                                                                    <input type="text" class="form-control form-control-sm"  value="{{ $dataPetiteCaisse->telephone_email }}" name="telephone_email" id="telephone_email">
                                                                </td>
                                                            </tr>
                        
                        
                        
                                                            <tr>
                                                                <td class="align-middle ps-3 name">
                                                                    Numéro du fiche BPC <br>
                                                                    <input type="number" name="numero" id="numero" class="form-control form-control-sm" value="{{ $dataPetiteCaisse->numero }}" style="width: 100%;">
                                                                  
                                                                </td>
                        
                                                                <td class="align-middle ps-3 name">Date du dossier BPC<br>
                                                                    <input type="date" class="form-control form-control-sm" name="date" id="date" style="width: 100%;" required>
                                                                </td>
                        
                                                                <td colspan="4"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                        
                                                    <hr>
                        
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-sm fs--1 mb-0" id="tableEstimate">
                                                            <thead style="background-color:#3CB371; color:white">
                                                                <tr>
                                                                    <th style="width:80px; color:white"><b>Num</b></th>
                                                                    <th style="color:white"><b>Designation de la ligne</b></th>
                                                                    <th style="color:white"><b>Montant</b></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr id="R1">
                                                                    <td><input style="width:100%" type="number" id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="1"></td>
                                                                    <td>
                                                                        <select class="form-control form-control-sm" id="referenceid" name="referenceid[]" required>
                                                                            <option disabled="true" selected="true">Sélectionner la ligne budgétaire</option>
                                                                            @foreach ($compte as $comptes)
                                                                            <optgroup label="{{ $comptes->libelle }}">
                                                                                @php
                                                                                $idc = $comptes->id;
                                                                                $res= DB::select("SELECT * FROM comptes WHERE compteid= $idc");
                                                                                @endphp
                                                                                @foreach($res as $re)
                                                                                <option value="{{ $re->id }}"> {{ $re->numero }}. {{ $re->libelle }} </option>
                                                                                @endforeach
                                                                            </optgroup>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td><input style="width:100%" type="number" id="montant[]" name="montant[]" class="form-control form-control-sm total" min="0" required></td>
                                                                    <td><a href="javascript:void(0)" class="text-primary font-18" title="Ajouter" id="addBtn"><i class="fa fa-plus-circle"></i></a></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                        
                                                        <table class="table table-striped table-sm fs--1 mb-0">
                                                            <tfoot style="background-color:#c0c0c0">
                                                                <tr>
                                                                    <td colspan="2">Total global</td>
                                                                    <td align="right"><span class="total-global">0.00 {{ Session::get('devise') }}</span></td>
                                                                    <td></td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                        
                                                        <hr>
                        
                                                    </div>
                        
                                                    <div class="table-responsive">
                                                        <span id="error"></span>
                        
                                                        <table class="table table-striped table-sm fs--1 mb-0">
                                                            <tr>
                                                                <td>Bénéficiaire</td>
                                                                <td>Distributeur</td>
                                                                <td>Approbation</td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <select type="text" class="form-control form-control-sm" name="ben" id="ben" required>
                                                                        <option disabled="true" selected="true" value="">--Sélectionner Bénéficiaire--</option>
                                                                        @foreach ($personnel as $personnels)
                                                                        <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select type="text" class="form-control form-control-sm" name="dist" id="dist" required>
                                                                        <option disabled="true" selected="true" value="">--Sélectionner Distributeur-</option>
                                                                        @foreach ($personnel as $personnels)
                                                                        <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select type="text" class="form-control form-control-sm" name="appr" id="appr" required>
                                                                        <option disabled="true" selected="true" value="">--Sélectionner Approbation--</option>
                                                                        @foreach ($personnel as $personnels)
                                                                        <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                    
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" id="addbpcbtn" name="addbpcbtn"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                                    </div>
                                    </form>
                                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        // Sélectionner les éléments
        const interneOui = document.getElementById('interneOui');
        const interneNon = document.getElementById('interneNon');
        const trElement = document.getElementById('enleveceselement');

        // Fonction pour afficher/masquer les éléments
        const toggleElements = () => {
            if (interneNon.checked) {
                trElement.style.display = 'none';
                interneOui.checked = false;
            } else {
                trElement.style.display = '';
                interneNon.checked = false;
            }
        };

        // Ajouter des écouteurs d'événements aux cases à cocher
        interneOui.addEventListener('change', () => {
            if (interneOui.checked) {
                interneNon.checked = false;
                trElement.style.display = '';
            } else {
                interneNon.checked = true;
                trElement.style.display = 'none';
            }
        });

        interneNon.addEventListener('change', () => {
            if (interneNon.checked) {
                interneOui.checked = false;
                trElement.style.display = 'none';
            } else {
                interneOui.checked = true;
                trElement.style.display = '';
            }
        });

        // Initialiser l'état des éléments
        toggleElements();
    });
</script>

@endsection