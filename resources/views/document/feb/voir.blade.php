@extends('layout/app')
@section('page-content')
@foreach ($dateinfo as $dateinfo)
@endforeach
@php
$cryptedId = Crypt::encrypt($dataFeb->id);
@endphp
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Le details de la FEB (N° {{ $dataFeb->numerofeb }} ) </h4>
                        <div class="page-title-right">
                            @if($dataFeb->signale==1)
                            <div class="spinner-grow text-danger " role="status" style=" 
                                    width: 0.9rem; /* Définissez la largeur */
                                    height: 0.9rem; /* Définissez la hauteur */">
                                <span class="sr-only">Loading...</span>
                            </div> &nbsp; &nbsp;
                            @endif
                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#composemodal" data-febid="{{ $dataFeb->id ? $dataFeb->id : '' }}" title="Signaler un FEB en cas de probleme">
                                <i class="fab fa-telegram-plane ms-1"></i> Signalé FEB
                            </button>
                            @include('document.feb.message')
                            <div class="btn-toolbar float-end" role="toolbar">
                                <div class="btn-group me-2 mb-2 mb-sm-0">
                                    <a href="{{ route('generate-pdf-feb', $dataFeb->id) }}" class="btn btn-primary waves-light waves-effect" title="Générer PDF"><i class="fa fa-print"></i> </a>
                                    <a href="{{ route('showannex', $cryptedId ) }}" class="btn btn-primary waves-light waves-effect" title="Attacher le document"><i class="fas fa-paperclip"></i> </a>
                                    <a href="{{ route('showfeb', $cryptedId ) }}" class="btn btn-primary waves-light waves-effect" title="Modifier le FEB"><i class="fa fa-edit"></i> </a>
                                    <a href="{{ route('listfeb') }}" class="btn btn-primary waves-light waves-effect" title="Liste de FEB"><i class="fa fa-list"></i></a>
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
                                <center>
                                    <div class="text-muted">
                                        <table style=" width:100%" class="table table-sm fs--1 mb-0 ">
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

                                                    <center>
                                                        {{ $dateinfo->sousentete }}

                                                    </center>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                            </div>
                            <br>
                            <div class="row">
                                <H5>
                                    <center> FICHE D’EXPRESSION DES BESOINS (FEB) N° {{ $dataFeb->numerofeb }} </center>
                                </H5>
                                <div class="col-sm-12">
                                    <table class="table table-bordered  table-sm fs--1 mb-0">
                                        <tr>
                                            <td>Composante/ Projet/Section: {{ ucfirst($dataprojets->title) }} </td>
                                            <td>
                                                Période: {{ $dataFeb->periode }} ;
                                                Date : {{ date('d-m-Y', strtotime($dataFeb->datefeb))  }} ;

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                Code: {{ $dataLigne->numero }} <br>
                                                Ligne budgétaire: {{ $dataLigne->libelle }}
                                            </td>

                                            <td>
                                                @php
                                                $errorUrl = route('errorPage'); // Assuming you have a named route for the error page
                                                @endphp

                                                <label title="Bon de commande">
                                                    @php
                                                    $bc_url = $dataFeb->url_bon_commande;
                                                    $imagePath_bc = public_path($bc_url);
                                                    @endphp
                                                    @if(file_exists($imagePath_bc))
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset($bc_url) }}" data-error-url="{{ $errorUrl }}"> BC:</a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset('') }}" data-error-url="{{ $errorUrl }}"> BC</a>
                                                    @endif
                                                </label>
                                                <input type="checkbox" class="form-check-input" disabled @if ($dataFeb->bc == 1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Facture">
                                                    @php
                                                    $facture_url = $dataFeb->url_facture;
                                                    $imagePath_facture = public_path($facture_url);
                                                    @endphp
                                                    @if(file_exists($imagePath_facture))
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset($facture_url) }}" data-error-url="{{ $errorUrl }}"> Facture:</a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset('') }}" data-error-url="{{ $errorUrl }}"> Facture</a>
                                                    @endif
                                                </label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->facture == 1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Ordre de mission">
                                                    @php
                                                    $ordre_mission_url = $dataFeb->url_ordre_mission;
                                                    $imagePath_ordre_mission = public_path($ordre_mission_url);
                                                    @endphp
                                                    @if(file_exists($imagePath_ordre_mission))
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset($ordre_mission_url) }}" data-error-url="{{ $errorUrl }}"> O.M:</a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset('') }}" data-error-url="{{ $errorUrl }}"> O.M</a>
                                                    @endif
                                                </label>
                                                <input type="checkbox" name="om" id="om" class="form-check-input" disabled @if($dataFeb->om == 1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Procès-verbal d'analyse">
                                                    @php
                                                    $pva_url = $dataFeb->url_pva;
                                                    $imagePath_pva = public_path($pva_url);
                                                    @endphp
                                                    @if(file_exists($imagePath_pva))
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset($pva_url) }}" data-error-url="{{ $errorUrl }}"> P.V.A:</a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset('') }}" data-error-url="{{ $errorUrl }}"> P.V.A:</a>
                                                    @endif
                                                </label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->nec == 1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Facture proformat">
                                                    @php
                                                    $factureProformat_url = $dataFeb->url_factureProformat;
                                                    $imagePath_factureProformat = public_path($factureProformat_url);
                                                    @endphp
                                                    @if(file_exists($imagePath_factureProformat))
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset($factureProformat_url) }}" data-error-url="{{ $errorUrl }}"> Dévis/Liste:</a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset('') }}" data-error-url="{{ $errorUrl }}"> Dévis/Liste:</a>
                                                    @endif
                                                </label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->fpdevis == 1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Facture proformat">
                                                    @php
                                                    $fp_url = $dataFeb->url_fp;
                                                    $imagePath_fp = public_path($fp_url);
                                                    @endphp
                                                    @if(file_exists($imagePath_fp))
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset($fp_url) }}" data-error-url="{{ $errorUrl }}"> F.P:</a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset('') }}" data-error-url="{{ $errorUrl }}"> F.P:</a>
                                                    @endif
                                                </label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->fp == 1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Rapport de mission">
                                                    @php
                                                    $rapport_mission_url = $dataFeb->url_rapport_mission;
                                                    $imagePath_rapport_mission = public_path($rapport_mission_url);
                                                    @endphp
                                                    @if(file_exists($imagePath_rapport_mission))
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset($rapport_mission_url) }}" data-error-url="{{ $errorUrl }}"> R.M:</a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset('') }}" data-error-url="{{ $errorUrl }}"> R.M:</a>
                                                    @endif
                                                </label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->rm == 1) checked @endif /> &nbsp;&nbsp;<br>

                                                <label title="Termes de Référence">
                                                    @php
                                                    $terme_reference_url = $dataFeb->url_terme_reference;
                                                    $imagePath_terme_reference = public_path($terme_reference_url);
                                                    @endphp
                                                    @if(file_exists($imagePath_terme_reference))
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset($terme_reference_url) }}" data-error-url="{{ $errorUrl }}"> T.D.R:</a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset('') }}" data-error-url="{{ $errorUrl }}"> T.D.R:</a>
                                                    @endif
                                                </label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->tdr == 1) checked @endif />

                                                <label title="Bordereau de versement">
                                                    @php
                                                    $bordereau_versement_url = $dataFeb->url_bordereau_versement;
                                                    $imagePath_bordereau_versement = public_path($bordereau_versement_url);
                                                    @endphp
                                                    @if(file_exists($imagePath_bordereau_versement))
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset($bordereau_versement_url) }}" data-error-url="{{ $errorUrl }}"> B.V:</a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset('') }}" data-error-url="{{ $errorUrl }}"> B.V:</a>
                                                    @endif
                                                </label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->bv == 1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Reçu">
                                                    @php
                                                    $recu_url = $dataFeb->url_recu;
                                                    $imagePath_recu = public_path($recu_url);
                                                    @endphp
                                                    @if(file_exists($imagePath_recu))
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset($recu_url) }}" data-error-url="{{ $errorUrl }}"> Reçu:</a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset('') }}" data-error-url="{{ $errorUrl }}"> Reçu:</a>
                                                    @endif
                                                </label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->recu == 1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Accusé de réception">
                                                    @php
                                                    $accusse_reception_url = $dataFeb->url_accusse_reception;
                                                    $imagePath_accusse_reception = public_path($accusse_reception_url);
                                                    @endphp
                                                    @if(file_exists($imagePath_accusse_reception))
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset($accusse_reception_url) }}" data-error-url="{{ $errorUrl }}"> A.R:</a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset('') }}" data-error-url="{{ $errorUrl }}"> A.R:</a>
                                                    @endif
                                                </label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->ar == 1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Bordereau d'expédition">
                                                    @php
                                                    $bordereau_expedition_url = $dataFeb->url_bordereau_expediction;
                                                    $imagePath_bordereau_expedition = public_path($bordereau_expedition_url);
                                                    @endphp
                                                    @if(file_exists($imagePath_bordereau_expedition))
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset($bordereau_expedition_url) }}" data-error-url="{{ $errorUrl }}"> B.E:</a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset('') }}" data-error-url="{{ $errorUrl }}"> B.E:</a>
                                                    @endif
                                                </label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->be == 1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Appel à la participation à la construction du CFK">
                                                    @php
                                                    $appel_cfk_url = $dataFeb->url_appel_cfk;
                                                    $imagePath_appel_cfk = public_path($appel_cfk_url);
                                                    @endphp
                                                    @if(file_exists($imagePath_appel_cfk))
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset($appel_cfk_url) }}" data-error-url="{{ $errorUrl }}"> A.P.C:</a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset('') }}" data-error-url="{{ $errorUrl }}"> A.P.C:</a>
                                                    @endif
                                                </label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->apc == 1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Rapport d'activités">
                                                    @php
                                                    $ra_url = $dataFeb->url_ra;
                                                    $imagePath_ra = public_path($ra_url);
                                                    @endphp
                                                    @if(file_exists($imagePath_ra))
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset($ra_url) }}" data-error-url="{{ $errorUrl }}"> R.A:</a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset('') }}" data-error-url="{{ $errorUrl }}"> R.A:</a>
                                                    @endif
                                                </label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->ra == 1) checked @endif /> &nbsp;&nbsp;

                                                <label title="Autres documents">
                                                    @php
                                                    $autres_url = $dataFeb->url_autres;
                                                    $imagePath_autres = public_path($autres_url);
                                                    @endphp
                                                    @if(file_exists($imagePath_autres))
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset($autres_url) }}" data-error-url="{{ $errorUrl }}"> Autres:</a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="{{ asset('') }}" data-error-url="{{ $errorUrl }}"> Autres:</a>
                                                    @endif
                                                </label>
                                                <input type="checkbox" class="form-check-input" disabled @if($dataFeb->autres == 1) checked @endif />


                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:50%">
                                                Activité:
                                                {{ $dataFeb->descriptionf }}
                                            </td>
                                            <td><label title="le calcul du taux  progressif en fonction des numéros de FEB de cette ligne et sous ligne (Formulaire d'Engagement Budgétaire) qui est inférieur ou égal au numéro de FEB en cours.">Taux d’exécution de la ligne et de ses sous-lignes budgétaires: {{ $sommelignpourcentage }}% </label><br>
                                                <label title="le calcul du taux progressif en fonction des numéros de FEB de tout le projet encours (Formulaire d'Engagement Budgétaire) qui est inférieur ou égal au numéro de FEB en cours.">Taux d’exécution global du projet: {{ $POURCENTAGE_GLOGALE }} % </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Créé par : {{ $createur->nom }} {{ $createur->prenom }} </td>
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
                                                    $activites = $activite->first(); // Récupère le premier élément, sinon null
                                                    @endphp
                                                    {{ $activites ? ucfirst($activites->titre) : '' }}
                                                    @if(!$activites)
                                                    <small class="text-danger">Erreur: Propriété 'titre' introuvable , Il se peut que l'utilisateur ait supprimé cet élément</small>
                                                    @endif
                                                </td>

                                                <td style="width:15%">{{ ucfirst($datElements->libelle_description) }}
                                                </td>
                                                <td style="width:10%" align="center">{{ $datElements->unite }}
                                                </td>
                                                <td style="width:10%" align="center">{{ $datElements->quantite }}
                                                </td>
                                                <td style="width:10%" align="center">{{ $datElements->frequence }}
                                                </td>
                                                <td style="width:15%" align="right">{{ number_format($datElements->pu,0, ',', ' ') }}
                                                </td>
                                                <td style="width:20%" align="right"> {{ number_format($datElements->montant,0, ',', ' ') }} </td>
                                            </tr>
                                            @php
                                            $n++
                                            @endphp
                                            @endforeach

                                            <tr>
                                                <td colspan="7" align="center"><b>
                                                        Total général</font>
                                                    </b></td>
                                                <td align="right"><b>
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
                                                            <input class="form-check-input" type="checkbox" name="accesignature" id="accesignature" {{ $dataFeb->acce_signe=="1"? 'checked':'' }} style="border:2px solid red"> <small>Cochez pour Poser la signature</small>
                                                            @endif
                                                            <input type="hidden" name="clone_accesignature" value="{{ $dataFeb->acce_signe }}" />



                                                        </center>

                                                    </td>
                                                    <td>

                                                        <center>
                                                            <u>Vérifiée par (Comptable)</u> :
                                                            <br>
                                                            {{ $comptable_nom->nom }} {{ $comptable_nom->prenom }}
                                                            <br>

                                                            @if(Auth::user()->id == $dataFeb->comptable)
                                                            <input class="form-check-input" type="checkbox" name="comptablesignature" id="comptablesignature" {{ $dataFeb->comptable_signe=="1"? 'checked':'' }} style="border:2px solid red"> <small>Cochez pour Poser la signature</small>
                                                            @endif
                                                            <input type="hidden" name="clone_comptablesignature" value="{{ $dataFeb->comptable_signe }}" />
                                                           

                                                        </center>

                                                    </td>

                                                    <td>
                                                        <center>
                                                            <u>Approuvée par (Chef de Composante/Projet/Section)</u>:
                                                            <br>
                                                            {{ $checcomposant_nom->nom }} {{ $checcomposant_nom->prenom }}
                                                            <br>

                                                            @if(Auth::user()->id == $dataFeb->chefcomposante)
                                                            <input class="form-check-input" type="checkbox" id="chefsignature" name="chefsignature" {{ $dataFeb->chef_signe=="1"? 'checked':'' }} style="border:2px solid red"> <small>Cochez pour Poser la signature</small>
                                                            @endif
                                                            <input type="hidden" name="clone_chefsignature" value="{{ $dataFeb->chef_signe }}" />
                                                           
                                                          
                                                        </center>

                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td>
                                                        <center>
                                                            @if ($dataFeb->acce_signe==1)
                                                            <img src="{{ asset($etablienom->signature) }}" width="150px" />
                                                            @endif
                                                        </center>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            @if ($dataFeb->comptable_signe==1)
                                                            <img src="{{ asset($comptable_nom->signature) }}" width="150px" />
                                                            @endif
                                                        </center>
                                                    </td>

                                                    <td>
                                                        <center>
                                                            @if ($dataFeb->chef_signe==1)
                                                            <img src="{{  asset($checcomposant_nom->signature) }}" width="150px" />
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
                                            <br>
                                            
                                            
                                            <small><center> <i class="fa fa-info-circle"></i><br> Cochez la case située en dessous <br> de votre nom si vous êtes accrédité <br> pour apposer votre signature <br> puis cliquez sur le boutton <br> sauvegarder la signature</center></small>
                                       
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

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
    function openPopup(element) {
        var documentUrl = element.getAttribute('data-document-url');
        var errorUrl = element.getAttribute('data-error-url');

        if (!documentUrl || documentUrl === "{{ asset('') }}") {
            window.open(errorUrl, '_blank');
        } else {
            window.open(documentUrl, '_blank');
        }
    }
</script>

        <script>
            function openPopup(element) {
                // Récupérer l'URL du document à ouvrir
                var documentUrl = element.getAttribute('data-document-url');

                // Définir les dimensions de la fenêtre popup
                var width = screen.width * 0.7; // 50% de la largeur de l'écran
                var height = screen.height * 0.7; // 50% de la hauteur de l'écran

                // Calculer les coordonnées pour centrer la fenêtre popup
                var left = (screen.width - width) / 2;
                var top = (screen.height - height) / 2;

                // Définir les options de la fenêtre popup
                var options = 'width=' + width + ',height=' + height + ',top=' + top + ',left=' + left + ',resizable=yes,scrollbars=yes';

                // Ouvrir la fenêtre popup
                window.open(documentUrl, 'Document', options);
            }
        </script>


        @endsection