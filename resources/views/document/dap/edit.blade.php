@extends('layout/app')
@section('page-content')
    @php
        $cryptedId = Crypt::encrypt($datadap->id);
        $idpro = Session::get('id');
    @endphp

    <div class="main-content">
        <div class="page-content">
            <div class="row">

                <div class="col-12" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><i class="fa fa-edit"></i> Modification de la Demande d'Autorisation de Paiement
                            (DAP) (N° {{ $datadap->numerodp }} ) </h4>
                        <div class="page-title-right">
                            <div class="btn-toolbar float-end" role="toolbar">
                                <div class="btn-group me-2 mb-2 mb-sm-0">
                                    <a href="{{ route('generate-pdf-dap', $cryptedId) }}"
                                        class="btn btn-warning waves-light waves-effect"><i class="fa fa-print"></i> </a>
                                    <a href="{{ route('viewdap', $cryptedId) }}"
                                        class="btn btn-primary waves-light waves-effect" title="Voir le DAP"><i
                                            class="fa fa-eye"></i> </a>
                                    <a href="{{ route('listdap') }}" type="button"
                                        class="btn btn-primary waves-light waves-effect"><i class="fa fa-list"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <form class="row g-3 mb-6" method="POST" id="updatdap" action="{{ route('updatdap') }}">
                            @method('PUT')
                            @csrf
                            <div id="tableExample2">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm fs--1 mb-0">
                                        <tbody class="list">
                                            <tr>
                                                <td style="width:120px"> Numéro dap </br>
                                                    <input type="hidden" value="{{ $datadap->iddape }}" id="dapid"
                                                        name="dapid" class="form-control form-control-sm" required>
                                                    <input type="hidden" value="{{ $datadap->numerodp }}"
                                                        id="anciant_numerodjas" name="anciant_numerodjas"
                                                        class="form-control form-control-sm"
                                                        style="background-color:#c0c0c0">
                                                    <input type="text" value="{{ $datadap->numerodp }}" id="numerodap"
                                                        name="numerodap" class="form-control form-control-sm">
                                                </td>
                                                <td style="width:300px"> Service <br>
                                                    <select type="text" name="serviceid" id="serviceid"
                                                        style="width: 100%" class="form-control form-control-sm" required>
                                                        <option value="{{ $datadap->idss }}">{{ $datadap->titres }}</option>
                                                        @forelse ($service as $services)
                                                            <option value="{{ $services->id }}"> {{ $services->title }}
                                                            </option>
                                                        @empty
                                                            <option value="">--Aucun service trouver--</option>
                                                        @endforelse
                                                    </select>
                                                </td>

                                                <td>
                                                    <b>Composante/ Projet/Section </b><br>
                                                    <input value="{{ Session::get('id') }}" type="hidden" name="projetid"
                                                        id="projetid" required>
                                                    <input value="{{ Session::get('title') }}"
                                                        class="form-control form-control-sm" disabled>
                                                </td>


                                    </table>
                                    <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
                                        <tr>

                                            <td> Lieu
                                                <input type="text" value="{{ $datadap->lieu }}" name="lieu"
                                                    id="lieu" style="width: 100%" class="form-control form-control-sm"
                                                    required />
                                            </td>

                                            <td> Compte bancaire
                                                <input type="text" value="{{ $datadap->comptabiliteb }}"
                                                    class="form-control form-control-sm" name="comptebanque"
                                                    id="comptebanque" style="width: 100%">
                                            </td>

                                            <td> OV/Cheque:
                                                <input type="text" name="ch" id="ch"
                                                    value="{{ $datadap->cho }}" class="form-control form-control-sm">
                                            </td>



                                            <td> Etabli au nom de:
                                                <input type="text" name="paretablie" value="{{ $datadap->paretablie }}"
                                                    id="paretablie" class="form-control form-control-sm">
                                            </td>

                                            <td> Banque :
                                                <select type="text" class="form-control form-control-sm" name="banque"
                                                    id="banque">
                                                    <option value="{{ $datadap->banque }}"> {{ $datadap->banque }}
                                                    </option>
                                                    @foreach ($banque as $banques)
                                                        <option value="{{ $banques->libelle }}">
                                                            {{ ucfirst($banques->libelle) }}</option>
                                                    @endforeach
                                                </select>

                                            </td>


                                        </tr>

                                    </table>
                                    <hr>
                                    <h6> &nbsp;&nbsp; <u>Synthese sur l'utilisation de fonds demandes(Vr details sur FB en
                                            avance)</u></h6>
                                    <table class="table table-striped table-sm fs--1 mb-0 table-bordered  ">
                                        <thead>
                                            <tr style="background-color:#3CB371; color:white">
                                                <th width="13%" style="color:white">Numéro du FEB </th>
                                                <th width="60%" style="color:white">Activité </th>
                                                <th style="color:white">Montant total </th>
                                                <th style="color:white">
                                                    <center>T.E/projet</center>
                                                </th>
                                                <th></th>
                                            </tr>
                                        </thead><!-- end thead -->
                                        <tbody>
                                            @php

                                                $totoglobale = 0; // Initialiser le total global à zéro
                                                $pourcentage_total = 0; // Initialiser le pourcentage total à zéro

                                            @endphp
                                            @foreach ($datafeb as $datafebElements)
                                                @php

                                                    $totoSUM = DB::table('elementfebs')
                                                        ->orderBy('id', 'DESC')
                                                        ->where('febid', $datafebElements->fid)
                                                        ->sum('montant');

                                                    $totoglobale += $totoSUM;
                                                    $pourcentage = round(($totoSUM * 100) / $datadap->montantprojet, 2);
                                                    // Ajouter le pourcentage de cette itération au pourcentage total
                                                    $pourcentage_total += $pourcentage;

                                                @endphp
                                                <tr>
                                                    <td>{{ $datafebElements->numerofeb }}</td>
                                                    <td>{{ $datafebElements->descriptionf }}</td>

                                                    <td align="right">
                                                        @php
                                                            $totoSUM = DB::table('elementfebs')
                                                                ->orderBy('id', 'DESC')
                                                                ->where('febid', $datafebElements->fid)
                                                                ->sum('montant');
                                                        @endphp
                                                        {{ number_format($totoSUM, 0, ',', ' ') }}

                                                    </td>
                                                    <td align="center">{{ $pourcentage }} </td>
                                                    <td style="width:3%;"> <a
                                                            href="{{ route('deleteelementsdap', $datafebElements->referencefeb) }}"
                                                            id="{{ $datafebElements->referencefeb }}"
                                                            class="text-danger font-18 deleteIcon"
                                                            title="Supprimer la ligne"><i
                                                                class="far fa-trash-alt"></i></a></td>
                                                </tr>
                                            @endforeach
                                            <tr style="background-color:#8FBC8F">
                                                <td style="color:white" colspan="2"> Total </td>
                                                <td align="right" style="color:white">
                                                    {{ number_format($totoglobale, 0, ',', ' ') }}</td>
                                                <td style="color:white" align="center"> {{ $pourcentage_total }} %</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <br>

                                    &nbsp;&nbsp; <u>Synthese sur les avances  </u>

                                    <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
                                        <tr>
                                            <td colspan="5"> Ce montant est-il une avance ?
                                                &nbsp; &nbsp; &nbsp;
                                                <label>
                                                    Oui
                                                    <input type="checkbox" name="justifierChoice" id="justifier" 
                                                           class="form-check-input" value="1" 
                                                           @if ($datadap->justifier == 1) checked @endif
                                                           onchange="handleCheckboxToggle(this)">
                                                </label>
                                                &nbsp; &nbsp; &nbsp;
                                                <label>
                                                    Non
                                                    <input type="checkbox" name="nonjustifierChoice" id="nonjustifier" 
                                                           class="form-check-input" value="0" 
                                                           @if ($datadap->justifier == 0) checked @endif
                                                           onchange="handleCheckboxToggle(this)">
                                                </label>
                                            </td>
                                        </tr>
                                    </table>
                                        
                                       

                                        <table id="advanceTable" style="display: none;"
                                            class="table table-striped table-sm fs--1 mb-0 table-bordered">
                                            <tr>
                                                <td style="width:15%"> Montant de l'Avance : <br>
                                                    <input type="hidden" name="iddjass" value="@if ($dajshow) {{ $dajshow->id }}  @endif" />
                                                    <input type="text" class="form-control form-control-sm" min="0" name="montantavance" value="@if ($dajshow) {{ $dajshow->montant_avance }}  @endif" />
                                                </td>
                                                <td style="width:15%"> Durée avance (Jour) : <br>
                                                    <input type="text" class="form-control form-control-sm"   min="0" name="duree_avance" value="@if ($dajshow) {{ $dajshow->duree_avance }} @endif" />
                                                </td>
                                                <td style="width:30%"> Description : <br>
                                                    <input type="text" class="form-control form-control-sm"  name="descriptionel" style="width:100%" value="@if ($dajshow) {{ $dajshow->description_avance }} @endif" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">Fonds reçus par :
                                                    <select class="form-control form-control-sm" name="beneficiaire" id="beneficiaire" onchange="checkFunds()">
                                                        @if ($fond_reussi)
                                                            <option value="{{ $fond_reussi->userid }}">{{ ucfirst($fond_reussi->nom) }} {{ ucfirst($fond_reussi->prenom) }}</option>
                                                        @else
                                                            <option value="">Sélectionnez un bénéficiaire</option>
                                                        @endif
                                                    
                                                        @foreach ($personnel as $personnels)
                                                            <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                        @endforeach
                                                    </select>
                                                    
                                                </td>
                                                <td style="width:30%">
                                                    Flash info : <br>
                                                    <!-- Utilisation d'un div pour le message -->
                                                    <div id="flash-info" class="form-control form-control-sm" style="width:100%; display:none; color:Red ; background-color: rgba(255, 0, 0, 0.1); border:1px solid red"></div>
                                                </td>
                                            </tr>
                                            
                                        </table>
                                   
                                   


                                    <hr>
                                    <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
                                        <tr>
                                            <td colspan="3"><b> Vérification et Approbation de la Demande de paiement
                                                </b></td>

                                        </tr>
                                        <tr>
                                            <td> <b> Demande établie par </b> <br>
                                                <small> Chef de Composante/Projet/Section </small>
                                            </td>

                                            <td> <b> Vérifiée par :</b> <br>
                                                <small> Chef Comptable</small>

                                            </td>

                                            <td> <b> Approuvée par : </b> <br>
                                                <small>Chef de Service</small>

                                            </td>


                                        </tr>
                                        <tr>

                                            <td>
                                                <select type="text" class="form-control form-control-sm"
                                                    name="demandeetablie" id="demandeetablie" required>
                                                    <option value="{{ $chefcomposant->idus }}">
                                                        {{ ucfirst($chefcomposant->nom) }}
                                                        {{ ucfirst($chefcomposant->prenom) }}</option>
                                                    @foreach ($personnel as $personnels)
                                                        <option value="{{ $personnels->userid }}">{{ $personnels->nom }}
                                                            {{ $personnels->prenom }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="demandeetablie_signe"
                                                    id="demandeetablie_signe"
                                                    value="{{ $datadap->demandeetablie_signe }}" />
                                                <input type="hidden" name="ancien_demandeetablie"
                                                    id="ancien_demandeetablie" value="{{ $datadap->demandeetablie }}" />
                                            </td>
                                            <td>
                                                <select type="text" class="form-control form-control-sm"
                                                    name="verifier" id="verifier" required>
                                                    <option value="{{ $chefcomptable->idus }}">
                                                        {{ ucfirst($chefcomptable->nom) }}
                                                        {{ ucfirst($chefcomptable->prenom) }}</option>
                                                    @foreach ($personnel as $personnels)
                                                        <option value="{{ $personnels->userid }}">{{ $personnels->nom }}
                                                            {{ $personnels->prenom }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="verifierpar_signe" id="verifierpar_signe"
                                                    value="{{ $datadap->verifierpar_signe }}" />
                                                <input type="hidden" name="ancien_verifierpar" id="ancien_verifierpar"
                                                    value="{{ $datadap->verifierpar }}" />
                                            </td>


                                            <td>
                                                <select type="text" class="form-control form-control-sm"
                                                    name="approuver" id="approuver" required>
                                                    <option value="{{ $chefservice->idus }}">
                                                        {{ ucfirst($chefservice->nom) }}
                                                        {{ ucfirst($chefservice->prenom) }}</option>
                                                    @foreach ($personnel as $personnels)
                                                        <option value="{{ $personnels->userid }}">{{ $personnels->nom }}
                                                            {{ $personnels->prenom }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="approuverpar_signe" id="approuverpar_signe"
                                                    value="{{ $datadap->approuverpar_signe }}" />
                                                <input type="hidden" name="ancien_approuverpar" id="ancien_approuverpar"
                                                    value="{{ $datadap->approuverpar }}" />
                                            </td>
                                        </tr>


                                        <tr>
                                            <td colspan="3">
                                                <div id="flash-info" style="display:none;"></div> <!-- Div pour afficher le message d'info -->
                                            </td>
                                        </tr>
                                        

                                        </tr>

                                        <tr>

                                            <td>
                                                Responsable Administratif et Financier : <br>
                                                <select type="text" class="form-control form-control-sm"
                                                    name="resposablefinancier" id="resposablefinancier" required>
                                                    <option value="{{ $responsable->idus }}">
                                                        {{ ucfirst($responsable->nom) }}
                                                        {{ ucfirst($responsable->prenom) }}</option>
                                                    @foreach ($personnel as $personnels)
                                                        <option value="{{ $personnels->userid }}">{{ $personnels->nom }}
                                                            {{ $personnels->prenom }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="responsable_signe" id="responsable_signe"
                                                    value="{{ $datadap->responsable_signe }}" />
                                                <input type="hidden" name="ancien_responsable" id="ancien_responsable"
                                                    value="{{ $datadap->responsable }}" />
                                            </td>
                                            <td>
                                                Secrétaire Général de la CEPBU : <br>
                                                <select type="text" class="form-control form-control-sm"
                                                    name="secretairegenerale" id="secretairegenerale" required>
                                                    <option value="{{ $secretaire->idus }}">
                                                        {{ ucfirst($secretaire->nom) }} {{ ucfirst($secretaire->prenom) }}
                                                    </option>
                                                    @foreach ($personnel as $personnels)
                                                        <option value="{{ $personnels->userid }}">{{ $personnels->nom }}
                                                            {{ $personnels->prenom }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="secretaire_signe" id="secretaire_signe"
                                                    value="{{ $datadap->secretaure_general_signe }}" />
                                                <input type="hidden" name="ancien_secretaire" id="ancien_secretaire"
                                                    value="{{ $datadap->secretaire }}" />
                                            </td>


                                            <td>
                                                Chef des Programmes </br>
                                                <select type="text" class="form-control form-control-sm"
                                                    name="chefprogramme" id="chefprogramme" required>
                                                    <option value="{{ $chefprogramme->idus }}">
                                                        {{ ucfirst($chefprogramme->nom) }}
                                                        {{ ucfirst($chefprogramme->prenom) }}</option>
                                                    @foreach ($personnel as $personnels)
                                                        <option value="{{ $personnels->userid }}">{{ $personnels->nom }}
                                                            {{ $personnels->prenom }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="chefprogramme_signe" id="chefprogramme_signe"
                                                    value="{{ $datadap->chefprogramme_signe }}" />
                                                <input type="hidden" name="ancien_chefprogramme"
                                                    id="ancien_chefprogramme" value="{{ $datadap->chefprogramme }}" />
                                            </td>
                                        </tr>


                                        <tr>
                                            <td colspan="3"><b>Observations/Instructions du SG : </b> <br>
                                                <textarea class="form-control form-control-sm" name="observation" id="observation">{{ $datadap->observation }}</textarea>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <br> <br>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                            Sauvegarder</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <br> <br>

    <script>
       document.getElementById('beneficiaire').addEventListener('change', function () {
    var userId = this.value; // Récupérer l'ID de l'utilisateur sélectionné
    var flashInfoDiv = document.getElementById('flash-info'); // Le div qui affichera l'info

    // Vérifier si le div existe avant de manipuler ses propriétés
    if (flashInfoDiv) {
        // Masquer le message de flash info initialement
        flashInfoDiv.style.display = 'none';  

        if (userId) {
            // Faire l'appel AJAX pour vérifier les fonds non justifiés
            fetch('/check-unverified-funds?user_id=' + userId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors de la récupération des données');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'error') {
                        flashInfoDiv.classList.add('alert-success'); // Message d'erreur
                        flashInfoDiv.classList.remove('alert-success'); // Retirer la classe de succès
                    } else {
                        flashInfoDiv.classList.add('alert-success'); // Message de succès
                        flashInfoDiv.classList.remove('alert-success'); // Retirer la classe d'erreur
                    }

                    flashInfoDiv.textContent = data.message; // Mettre à jour le message
                    flashInfoDiv.style.display = 'block'; // Afficher le message
                })
                .catch(error => {
                    console.log('Erreur:', error);
                });
        } else {
            flashInfoDiv.style.display = 'none'; // Masquer le message si aucun utilisateur sélectionné
        }
    } else {
        console.error('Le div flash-info n\'a pas été trouvé');
    }
});

    </script>
    
    



    <script>
         function handleCheckboxToggle(checkbox) {
        const justifier = document.getElementById('justifier');
        const nonjustifier = document.getElementById('nonjustifier');
        const advanceTable = document.getElementById('advanceTable');

        // Désactiver la deuxième case si la première est cochée, et vice versa
        if (checkbox.id === 'justifier') {
            nonjustifier.checked = false;
        } else if (checkbox.id === 'nonjustifier') {
            justifier.checked = false;
        }

        // Afficher ou cacher la table en fonction de l'état de "justifier"
        advanceTable.style.display = justifier.checked ? 'table' : 'none';
    }

    // Assurez-vous que l'état initial est correct au chargement de la page
    window.onload = function() {
        const justifier = document.getElementById('justifier');
        const advanceTable = document.getElementById('advanceTable');
        advanceTable.style.display = justifier.checked ? 'table' : 'none';
    };
    </script>


    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on('click', '.deleteIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';

                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Un élément du DAP est sur le point d'être détruit ! Faut-il vraiment exécuter « la suppression » ? ",
                    showCancelButton: true,
                    confirmButtonColor: 'green',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer !',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('deleteelementsdap') }}",
                            method: 'delete',
                            data: {
                                id: id,
                                _token: csrf
                            },
                            success: function(response) {
                                if (response.status == 200) {
                                    window.location.reload();
                                    toastr.success("Élément FEB supprimé avec succès !",
                                        "Suppression");
                                } else if (response.status == 205) {
                                    toastr.error(
                                        "Vous n'avez pas l'accréditation pour supprimer cet élément de la FEB !",
                                        "Erreur");
                                } else {
                                    toastr.error(
                                        "Erreur lors de l'exécution de la suppression : " +
                                        response.error, "Erreur");
                                }
                            },
                            error: function(xhr, status, error) {
                                toastr.error("Erreur lors de la requête AJAX : " +
                                    error, "Erreur AJAX");
                                console.error("Erreur AJAX :", status, error);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
