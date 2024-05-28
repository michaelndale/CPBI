@extends('layout/app')
@section('page-content')
 <style>
        /* Styles pour l'en-tête de la première page */

        body {
            font-size: 80%;
            /* taille de police de base */
        }

        h1 {
            font-size: 2em;
            /* taille de la police pour les titres */
        }

        p {
            font-size: 1em;
            /* taille de la police pour les paragraphes */
        }

        .small-text {
            font-size: 0.8em;
            /* taille de la police pour les textes de petite taille */
        }

        /* Exemple de CSS */
      

        h1,
        h2,
        h3 {
            font-family: 'Open Sans', sans-serif;
            /* Utilisation d'une autre police web légère pour les titres */
        }
    </style>
<div class="main-content">
    <br>
    <div class="content">
        <a href="{{ route('listdap') }}"> <i class="fas fa-long-arrow-alt-left"></i> Retour en arrière.</a>
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-sm-12">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"> <i class="far fa-edit "></i> Modification de la Demande  d'Autorisation de Paiement (DAP) </h5> <br> <br>
                            </div>
                            <div class="modal-body">

                                <form class="row g-3 mb-6" method="POST" id="updatdap" action="{{ route('updatdap') }}">
                                @method('PUT')
                                @csrf

                                    <div id="tableExample2">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-sm fs--1 mb-0">
                                                <tbody class="list">

                                                    <tr>
                                                        <td style="width:120px"> Numéro dap </br>
                                                        <input type="hidden" value="{{ $datadap->iddape }}" id="dapid" name="dapid" class="form-control form-control-sm" required>
                                                            <input type="text" value="{{ $datadap->numerodp }}" id="numerodap" name="numerodap" class="form-control form-control-sm" readonly style="background-color:#c0c0c0" >
                                                        </td>
                                                        <td style="width:300px"> Service <br>
                                                            <select type="text" name="serviceid" id="serviceid" style="width: 100%" class="form-control form-control-sm" required>
                                                                <option value="{{ $datadap->idss }}">{{ $datadap->titres }}</option>
                                                                @forelse ($service as $services)
                                                                <option value="{{ $services->id }}"> {{ $services->title }} </option>
                                                                @empty
                                                                <option value="">--Aucun service trouver--</option>
                                                                @endforelse
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <b>Composante/ Projet/Section </b><br>
                                                            <input value="{{ Session::get('id') }}" type="hidden" name="projetid" id="projetid" required>
                                                            <input value="{{ Session::get('title') }}" class="form-control form-control-sm" disabled>
                                                        </td>


                                                        <td class="align-middle" style="width:20%">
                                                            <b>FEB ID: </b> <br>
                                                        

                                                        </td>

                                            </table>

                                            <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
                                                <tr>

                                                    <td> Lieu
                                                        <input type="text" value="{{ $datadap->lieu }}" name="lieu" id="lieu" style="width: 100%" class="form-control form-control-sm" required />
                                                    </td>

                                                    <td> Compte bancaire (BQ):
                                                        <input type="text" value="{{ $datadap->comptabiliteb }}" class="form-control form-control-sm" name="comptebanque" id="comptebanque" style="width: 100%" required>
                                                    </td>

                                                    <td> Solde comptable (Sc):
                                                        <input type="text" class="form-control form-control-sm" name="soldecompte" value="{{ $datadap->soldecompte }}"  style="background-color:#c0c0c0" required>
                                                    </td>

                                                    <td> CHQ nº:
                                                        <input type="text" id="cho" name="cho" class="form-control form-control-sm" value="{{ $datadap->cho }}">
                                                    </td>

                                                    <td align="center"> OV nº : <br>
                                                        <input type="checkbox" class="form-check-input" name="ov" id="ov" @if($datadap->ov==1)
                                                        checked value="{{ $datadap->ov }}"
                                                        @else
                                                        value="{{ $datadap->ov }}"
                                                        @endif
                                                        />
                                                    </td>

                                                  
                                                </tr>

                                            </table>

                                            <hr>

                                            <div id="Showpoll" class="Showpoll">
                                                <input type="hidden" name="febid" id="febid" value="'.$datas->id.'" />
                                                <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
                                                    <tr>
                                                        <td colspan="3"> Ligne bugetaire : <b> {{ $datafeb->libelle }}</b> </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Etablie par : <b> {{ ucfirst($initiateur->nom) }} {{ ucfirst($initiateur->prenom)  }}</b> </td>
                                                        <td> Activité : {{ $datafeb->descriptionf }}</td>
                                                        <td> Montant globale feb : {{ $sommefebs }}</td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <hr>
                                            <table class="table table-striped table-sm fs--1 mb-0 table-bordered">

                                                <tr>
                                                    <td colspan="3"><b> Vérification et Approbation de la Demande de paiement </b></td>

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
                                                        <select type="text" class="form-control form-control-sm" name="demandeetablie" id="demandeetablie" required>
                                                            <option value="{{ $chefcomposant->idus }}">{{ ucfirst($chefcomposant->nom) }} {{ ucfirst($chefcomposant->prenom) }}</option>
                                                            @foreach ($personnel as $personnels)
                                                            <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select type="text" class="form-control form-control-sm" name="verifier" id="verifier" required>
                                                            <option value="{{ $chefcomptable->idus }}">{{ ucfirst($chefcomptable->nom) }} {{ ucfirst($chefcomptable->prenom) }}</option>
                                                            @foreach ($personnel as $personnels)
                                                            <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>


                                                    <td>
                                                        <select type="text" class="form-control form-control-sm" name="approuver" id="approuver" required>
                                                            <option value="{{  $chefservice->idus }}">{{ ucfirst( $chefservice->nom) }} {{ ucfirst( $chefservice->prenom) }}</option>
                                                            @foreach ($personnel as $personnels)
                                                            <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                            </table>

                                            <hr>

                                            <table class="table table-striped table-sm fs--1 mb-0 table-bordered">

                                                <tr>
                                                    <td colspan="4"><b> Autorisaction de paiement</b></td>

                                                </tr>

                                                </tr>

                                                <tr>
                                                    <td aligne="center">Autorisé le <center> <input class="form-control form-control-sm" type="date" id="datesecretairegenerale" name="datesecretairegenerale" value="{{ $datadap->dateautorisation }}" /></center>
                                                    </td>
                                                    <td>
                                                        Responsable Administratif et Financier : <br>
                                                        <select type="text" class="form-control form-control-sm" name="resposablefinancier" id="resposablefinancier" required>
                                                            <option value="{{ $chefservice->idus }}">{{ ucfirst($chefservice->nom) }} {{ ucfirst($chefservice->prenom) }}</option>
                                                            @foreach ($personnel as $personnels)
                                                            <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        Secrétaire Général de la CEPBU : <br>
                                                        <select type="text" class="form-control form-control-sm" name="secretairegenerale" id="secretairegenerale" required>
                                                            <option value="{{ $secretaire->idus }}">{{ ucfirst($secretaire->nom) }} {{ ucfirst($secretaire->prenom) }}</option>
                                                            @foreach ($personnel as $personnels)
                                                            <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>


                                                    <td>
                                                        Chef des Programmes </br>
                                                        <select type="text" class="form-control form-control-sm" name="chefprogramme" id="chefprogramme" required>
                                                            <option value="{{ $chefprogramme->idus }}">{{ ucfirst($chefprogramme->nom) }} {{ ucfirst($chefprogramme->prenom) }}</option>
                                                            @foreach ($personnel as $personnels)
                                                            <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td colspan="4"><b>Observations/Instructions du SG : </b> <br>
                                                        <textarea class="form-control form-control-sm" name="observation" id="observation">{{ $datadap->observation }}</textarea>
                                                    </td>
                                                </tr>
                                            </table>



                                        </div>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <br> <br>
                                <button type="submit" class="btn btn-primary" ><i class="fa fa-check-circle"></i> Sauvegarder</button>
                                <br> <br> <br> <br>
                            </div>
                            </form>
                        </div>



                    </div>

                </div>

            </div>
        </div>
    </div>
    <br> <br>

    @endsection


    <script>
        const checkbox1 = document.getElementById('ch');
        const checkbox2 = document.getElementById('ov');

        checkbox1.addEventListener('change', function() {
            if (this.checked) {
                checkbox2.checked = false;
            }
        });

        checkbox2.addEventListener('change', function() {
            if (this.checked) {
                checkbox1.checked = false;
            }
        });
    </script>