@extends('layout/app')
@section('page-content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Modification de la Demande d'Autorisation de Paiement (DAP) (N° {{ $datadap->numerodp }} ) </h4>
                        <div class="page-title-right">
                            <div class="btn-toolbar float-end" role="toolbar">
                                <div class="btn-group me-2 mb-2 mb-sm-0">
                                    <a href="{{ route('generate-pdf-dap', $datadap->iddape) }}" class="btn btn-primary waves-light waves-effect"><i class="fa fa-print"></i> </a>

                                    <a href="{{ route('listdap') }}" type="button" class="btn btn-primary waves-light waves-effect"><i class="fa fa-list"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">

                    <div class="card-body">
                            <div class="invoice-title">
                                <div class="col-sm-12">
                                    <div class="modal-content">
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
                                                                        <input type="text" value="{{ $datadap->numerodp }}" id="numerodap" name="numerodap" class="form-control form-control-sm" readonly style="background-color:#c0c0c0">
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
                                                                    <input type="text" class="form-control form-control-sm" name="soldecompte" value="{{ $datadap->soldecompte }}" style="background-color:#c0c0c0" required>
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
                                                        <h6> <u>Synthese sur l'utilisation dea fonds demandes(Vr details sur FB en avance)</u></h6>



<table class="table table-striped table-sm fs--1 mb-0 table-bordered  ">
    <thead>
        <tr>
            <th width="13%">Numéro du FEB </th>
            <th width="60%">Activité </th>
            <th>Montant total </th>
            <th>
                <center>T.E/projet</center>
            </th>
        </tr>
    </thead><!-- end thead -->
    <tbody>
        @php

   
        $totoglobale = 0; // Initialiser le total global à zéro
        $pourcentage_total = 0; // Initialiser le pourcentage total à zéro

        @endphp
        @foreach ($datafeb  as $datafebElements)
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
                {{ number_format($totoSUM, 0, ',', ' ')  }}

            </td>
            <td align="center">{{ $pourcentage }} </td>
        </tr>
        @endforeach
        <tr style=" background-color: #040895;">
            <td style="color:white" colspan="2" > Total </td>
            <td align="right" style="color:white"> {{ number_format($totoglobale, 0, ',', ' ')  }}</td>
            <td style="color:white" align="center"> {{ $pourcentage_total }} %</td>
        </tr>
    </tbody>
</table>

<br>








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
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> Sauvegarder</button>
                                            <br> <br> <br> <br>
                                        </div>
                                        </form>
                                    </div>



                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                </div>
                </div>
                <br> <br>

                @endsection


             