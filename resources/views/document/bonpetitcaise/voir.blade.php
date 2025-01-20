@extends('layout/app')
@section('page-content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Le details du BON DE LA PETITE CAISSE (N° {{ $dataFeb->numerofeb }} ) </h4>
                        <div class="page-title-right">
                            @if($dataFeb->signale==1)
                            <div class="spinner-grow text-danger " role="status" style=" 
                        width: 0.9rem; /* Définissez la largeur */
                        height: 0.9rem; /* Définissez la hauteur */">
                                <span class="sr-only">Loading...</span>
                            </div> &nbsp; &nbsp;
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="invoice-title">
                                <center>
                                    <div class="text-muted">
                                        <table style=" width:100%">
                                            <tr>
                                                <td style=" width:10% ; margin:0px;padding:0px;">
                                                    <center> <img src="{{ asset('element/logo/logo.png') }}" alt="logo" height="50" /> </center>
                                                </td>

                                                <td style="margin:0px;padding:0px;">
                                                    <center>

                                                        <h4>{{ $dateinfo->entete }}</h4>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="margin:0px;padding:0px;">
                                                    <hr>
                                                    <center>
                                                        {{ $dateinfo->sousentete }}

                                                    </center>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                            </div>
                            <hr class="my-4">
                            <div class="row">
                                <H5>
                                    <center> FICHE D’EXPRESSION DES BESOINS (FEB) N° {{ $dataFeb->numerofeb }} </center>
                                </H5>
                                <div class="col-sm-12">
                                    <table class="table table-bordered  table-sm fs--1 mb-0">
                                        <tr>
                                            <td>Composante/ Projet/Section: {{ ucfirst($dataprojets->title) }} </td>
                                            <td>Période: {{ $dataFeb->periode }}

                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:50%">
                                                Activité:
                                                {{ $dataFeb->descriptionf }}
                                            </td>
                                            <td>
                                                Date  FEB: {{ date('d-m-Y', strtotime($dataFeb->datefeb))  }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Code : {{ $dataLigne->numero }} ; Ligne budgétaire: {{ $dataLigne->libelle }}
                                            </td>

                                            <td>
                                                <label title="Bon de commande"> BC:</label>
                                                <input type="checkbox" class="form-check-input" disabled @if ($dataFeb->bc==1) checked @endif /> &nbsp;&nbsp;

                                                <label> Facture:</label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->facture==1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Ordre de mission"> O.M :</label>
                                                <input type="checkbox" name="om" id="om" class="form-check-input" disabled @if($dataFeb->om==1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Procès-verbal d'analyse"> P.V.A :</label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->nec==1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Facture proformat"> FP/Dévis/Liste :</label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->fpdevis==1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Rapport de mission"> R.M :</label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->rm==1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Termes de Référence"> T.D.R :</label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->tdr==1) checked @endif /> <br>

                                                <label title="Bordereau de versement"> B.V :</label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->bv==1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Reçu"> Reçu :</label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->recu==1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Accussé de reception"> A.R :</label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->ar==1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Bordereau d'expédition"> B.E :</label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->be==1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Appel a la participation a la construction au CFK"> A.P.C :</label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->apc==1) checked @endif />
                                            </td>


                                        </tr>
                                        <tr>
                                            <td> Taux d’exécution globale de la ligne et sous ligne budgétaire:: {{ $sommelignpourcentage }} %</td>
                                            <td> Taux d’exécution globale sur le projet: {{ $POURCENTAGE_GLOGALE }} %</td>
                                        </tr>
                                        <tr>

                                            <td>Créé par : {{ $createur->nom }} {{ $createur->prenom }} </td>

                                            <td>
                                                Bénéficiaire :
                                                @if (isset($onebeneficaire->libelle) && !empty($onebeneficaire->libelle))
                                                {{ $onebeneficaire->libelle }}
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="py-2">

                                <h5 class="font-size-15"><b>Détails sur l’utilisation des fonds demandés : </b></h5>

                                <div class="table-responsive">
                                    <table class="table table-striped table-sm fs--1 mb-0 table-bordered  ">
                                        <thead style="background-color:#3CB371; color:white">
                                            <tr>
                                                <th style="  color:white"> <b>N<sup>o</sup></b></th>
                                                <th style="  color:white"> <b>Designation des activités de la ligne</b></th>
                                                <th style="  color:white"> <b>Description</b></th>
                                                <th style="  color:white"> <b>
                                                        <center>Unité</center>
                                                    </b></th>
                                                <th style="  color:white"> <b>
                                                        <center>Quantité </center>
                                                    </b></th>
                                                <th style="  color:white"> <b>
                                                        <center>Frequence </center>
                                                    </b> </th>
                                                <th style="  color:white"> <b>
                                                        <center>Prix Unitaire ({{ ucfirst($dataprojets->devise) }}) </center>
                                                    </b></th>
                                                <th style="  color:white"> <b>
                                                        <center>Prix total ({{ ucfirst($dataprojets->devise) }}) </center>
                                                    </b> </th>
                                            </tr>
                                        </thead><!-- end thead -->
                                        <tbody>
                                            @php
                                            $n=1;
                                            @endphp
                                            @foreach ($datElement as $datElements)
                                            <tr>
                                                <td style="width:3%">{{$n }} </td>
                                                <td style="width:25%">
                                                    @php
                                                    $activite = DB::table('activities')
                                                    ->orderby('id', 'DESC')
                                                    ->Where('id', $datElements->libellee)
                                                    ->get();
                                                    foreach($activite as $activites){}
                                                    @endphp
                                                    {{ ucfirst($activites->titre) }}

                                                </td>
                                                <td style="width:15%">{{ ucfirst($datElements->libelle_description) }}
                                                </td>
                                                <td style="width:10%" align="center">{{ $datElements->unite }}
                                                </td>
                                                <td style="width:10%" align="center">{{ $datElements->quantite }}
                                                </td>
                                                <td style="width:10%" align="center">{{ $datElements->frequence }}
                                                </td>
                                                <td style="width:15%" align="center">{{ number_format($datElements->pu,0, ',', ' ') }}
                                                </td>
                                                <td style="width:20%" align="center"> {{ number_format($datElements->montant,0, ',', ' ') }} </td>
                                            </tr>
                                            @php
                                            $n++
                                            @endphp
                                            @endforeach

                                            <tr>
                                                <td colspan="7"><b>
                                                        Total général</font>
                                                    </b></td>
                                                <td align="center"><b>
                                                        {{ number_format($sommefeb,0, ',', ' ') }} </font>
                                                    </b></h5>
                                                </td>

                                            </tr>
                                        </tbody>

                                    </table>
                                    <br>

                                    <form method="POST" action="{{ route('updatefeb') }}">
                                        @method('post')
                                        @csrf
                                        <input type="hidden" name="febid" id="febid" value="{{ $dataFeb->id }}">


                                        <table>
                                            <table style="width:100%; margin:auto">
                                                <tr>
                                                    <td>
                                                        <center>
                                                            <u>Etablie par (AC/CE/CS)</u> :
                                                            <br>
                                                            {{ ucfirst($etablienom->nom) }} {{ ucfirst($etablienom->prenom) }}
                                                            <br>
                                                            @if(Auth::user()->id == $dataFeb->acce)
                                                            <input class="form-check-input" type="checkbox" name="accesignature" id="accesignature" {{ $dataFeb->acce_signe=="1"? 'checked':'' }}> <small>Cochez pour Poser la signature</small>
                                                            @endif
                                                            <input type="hidden" name="clone_accesignature" value="{{ $dataFeb->acce_signe }}" />



                                                            @if ($dataFeb->acce_signe==1)
                                                            <br>
                                                            <img src="{{ asset($etablienom->signature) }}" width="200px" />
                                                            @endif
                                                        </center>

                                                    </td>
                                                    <td>

                                                        <center>
                                                            <u>Vérifiée par (Comptable)</u> :
                                                            <br>
                                                            {{ $comptable_nom->nom }} {{ $comptable_nom->prenom }}
                                                            <br>

                                                            @if(Auth::user()->id == $dataFeb->comptable)
                                                            <input class="form-check-input" type="checkbox" name="comptablesignature" id="comptablesignature" {{ $dataFeb->comptable_signe=="1"? 'checked':'' }}> <small>Cochez pour Poser la signature</small>
                                                            @endif
                                                            <input type="hidden" name="clone_comptablesignature" value="{{ $dataFeb->comptable_signe }}" />
                                                            <br>

                                                            @if ($dataFeb->comptable_signe==1)
                                                            <img src="{{ asset($comptable_nom->signature) }}" width="200px" />
                                                            @endif
                                                        </center>

                                                    </td>

                                                    <td>
                                                        <center>
                                                            <u>Approuvée par (Chef de Composante/Projet/Section)</u>:
                                                            <br>
                                                            {{ $checcomposant_nom->nom }} {{ $checcomposant_nom->prenom }}
                                                            <br>

                                                            @if(Auth::user()->id == $dataFeb->chefcomposante)
                                                            <input class="form-check-input" type="checkbox" id="chefsignature" name="chefsignature" {{ $dataFeb->chef_signe=="1"? 'checked':'' }}> <small>Cochez pour Poser la signature</small>
                                                            @endif
                                                            <input type="hidden" name="clone_chefsignature" value="{{ $dataFeb->chef_signe }}" />
                                                            <br>
                                                            @if ($dataFeb->chef_signe==1)
                                                            <img src="{{  asset($checcomposant_nom->signature) }}" width="200px" />
                                                            @endif
                                                        </center>

                                                    </td>
                                                </tr>
                                            </table>
                                        </table>
                                        <hr>
                                        <p align="center">
                                            {{ $dateinfo->piedpage }}
                                        </p>
                                        <br>
                                        @if(Auth::user()->id == $dataFeb->acce || Auth::user()->id == $dataFeb->comptable || Auth::user()->id == $dataFeb->chefcomposante )
                                        <div class="float-end">
                                            <button type="submit" name="save" id="dave" class="btn btn-primary w-md"> <i class="fas fa-cloud-download-alt"> </i> Sauvegarder la sinatgure </button>
                                            <br>
                                            <br><small>
                                                <center> <i class="fa fa-info-circle"></i><br> Cochez la case située en dessous <br> de votre nom si vous êtes accrédité <br> pour apposer votre signature <br> puis cliquez sur le boutton <br> sauvegarder la signature</center>
                                            </small>
                                        </div>

                                        @endif

                                    </form>
                                </div>
                            </div>
                        </div>

                        <br>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        @endsection