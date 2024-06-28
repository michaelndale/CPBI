@extends('layout/app')
@section('page-content')
@php
$cryptedId = Crypt::encrypt($datadap->id);
@endphp
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Le details de la DAP (N° {{ $datadap->numerodp  }} ) </h4>
                        <div class="page-title-right" >

                            @if($datadap->signaledap==1)
                            <div class="spinner-grow text-danger " role="status" style=" 
                        width: 0.9rem; /* Définissez la largeur */
                        height: 0.9rem; /* Définissez la hauteur */" title="Signaler le DAP en cas d'erreur ">
                                <span class="sr-only">Loading...</span>
                            </div> &nbsp; &nbsp;
                            @endif


                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#composemodal" data-dapid="{{ $datadap->id ? $datadap->id : '' }}" title="Signaler le DAP en cas d'erreur ">
                                <i class="fab fa-telegram-plane ms-1"></i> Signalé DAP
                            </button>

                            @include('document.dap.message')
                            &nbsp; &nbsp;


                            <div class="btn-toolbar float-end" role="toolbar">
                                <div class="btn-group me-2 mb-2 mb-sm-0">
                                    <a href="{{ route('generate-pdf-dap',$cryptedId  ) }}" class="btn btn-primary waves-light waves-effect" title="Générer PDF "><i class="fa fa-print"></i> </a>
                                    <a href="{{ route('showdap', $cryptedId ) }}" class="btn btn-primary waves-light waves-effect" title="Modifier le DAP"><i class="fa fa-edit"></i> </a>
                                    <a href="{{ route('listdap') }}" class="btn btn-primary waves-light waves-effect" title="Liste de DAP "><i class="fa fa-list"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                       
                            <div class="text-muted">
                            <table class="table  table-sm fs--1 mb-0 ">
                                    <tr>
                                        <td style=" width:10% ;" align="right"> 
                                            <img src="{{ asset('element/logo/logo.png') }}" alt="logo" height="50" /> </td>
                                        <td>
                                            <center>
                                            <p class="mb-1">
                                                <h3>{{ $dateinfo->entete }}</h3>
                                            </center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <center>{{ $dateinfo->sousentete }}</center>
                                        </td>
                                    </tr>
                                </table>


                            </div>
                    </div>
                  <br>
                    <div class="row">
                        <H5>
                            <center> Demande d'Autorisation de Paiement (DAP) N° {{ $datadap->numerodp }}/{{ date('Y')}} </center>
                        </H5>
                        <div class="col-sm-12">
                            <table class="table table-striped table-sm fs--1 mb-0 table-bordered  ">
                                <tr>
                                    <td style= "width:55%"> Service: {{ $datadap->titres }}</td>
                                    <td>
                                        Référence: FEB n<sup>o</sup>:
                                        @php
                                        foreach ($datafebElement as $key => $datafebElements) {
                                        echo '['.$datafebElements->numerofeb.']';

                                        if ($key < count($datafebElement) - 1) { echo ',' ; } } @endphp </td>
                                </tr>
                                <tr>
                                    <td> Composante/ Projet/Section: {{ $datadap->projettitle }}</td>
                                    <td> Lieu: {{ $datadap->lieu }} </td>
                                </tr>

                                <tr>
                                    <td> 
                                    <table>
                                            <td>
                                                <label title="OV"> &nbsp; Moyen de Paiement : OV </label>
                                            </td>
                                            <td>
                                                <input type="checkbox" readonly @if($datadap->ov==1) checked @else @endif />
                                            </td>
                                            <td> &nbsp; &nbsp; &nbsp; &nbsp; Cheque: {{ $datadap->cho }} ; Etabli au nom : {{ $datadap->	paretablie }}</td>
                                        </table>
                                    </td>
                                    <td> Compte bancaire : {{ $datadap->comptabiliteb }} ; Banque : {{ $datadap->banque }}</td>
                                </tr>

                                <tr>
                                    <td>  Créé par : {{ ucfirst($etablienom->nom) }} {{ ucfirst($etablienom->prenom) }}  </td>
                                    <td>  Budget initial  : {{ number_format( $budget, 0, ',', ' ') . ' ' }} {{ $devise }}  |
                                         Relicat budgetaire : {{ number_format( $solde_comptable, 0, ',', ' ') . ' ' }} {{ $devise }} </td>
                                </tr>

                               
                                <tr>
                                    <td>
                                    Créé le {{ date('d-m-Y', strtotime($datadap->created_at))  }}
                                    </td>
                                    <td>  Taux d’exécution globale du projet: {{ $pourcetage_globale }}%   </td>
                                </tr>

                            </table>
                            <br>
                            <font size="2px"> <u>Synthese sur l'utilisation des fonds demandes(Vr details sur FB en annexe)</u></font>
                            <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
                                <thead>
                                    <tr>
                                        <th width="13%">Numéro du FEB </th>
                                        <th width="60%">Activité </th>
                                        <th>Montant total </th>
                                        <th><center> <label title="Taux d’exécution de la ligne et ses sous lignes">T.E / L & S.L</label></center> </th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    @php
                                    $totoglobale = 0; // Initialiser le total global à zéro
                                    $pourcentage_total = 0; // Initialiser le pourcentage total à zéro

                                    @endphp
                                    @foreach ($datafebElement as $datafebElements)
                                    @php

                                    $totoSUM = DB::table('elementfebs')
                                    ->orderBy('id', 'DESC')
                                    ->where('febid', $datafebElements->fid)
                                    ->sum('montant');

                                    $somme_ligne_principale = DB::table('rallongebudgets')
                                    ->where('compteid', $datafebElements->ligne_bugdetaire)
                                    ->sum('budgetactuel');

                                    $sommelign = DB::table('elementfebs')
                                    ->where('grandligne',  $datafebElements->ligne_bugdetaire)
                                    ->where('numero', '<=', $datafebElements->numerofeb)
                                    
                                    ->sum('montant');

                                   
                                    $sommelignpourcentage =  $somme_ligne_principale ? round(($sommelign * 100) /  $somme_ligne_principale, 2) : 0;




                                    $totoglobale += $totoSUM;
                                    $pourcentage = $budget ? round(($totoSUM * 100) / $budget, 2) : 0;
                                    // Ajouter le pourcentage de cette itération au pourcentage total
                                    $pourcentage_total += $pourcentage;

                                    @endphp
                                    <tr>
                                        <td align="center"> <a href="#" data-bs-toggle="modal" data-bs-target="#febinfo" data-id="{{ $datafebElements->fid }}" class="infofeb">
                                                <b>0000{{ $datafebElements->numerofeb }}</b>
                                            </a></td>
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
                                        <td align="center">{{ $sommelignpourcentage }} </td>
                                    </tr>
                                    @endforeach
                                    <tr style=" background-color: #040895;">
                                        <td style="color:white" colspan="2">  Total général </td>
                                        <td align="right" style="color:white"> {{ number_format($totoglobale, 0, ',', ' ')  }}</td>
                                        <td style="color:white" align="center"> <!-- {{ $pourcentage_total }} % --></td> 
                                    </tr>
                                </tbody>
                            </table>

                            @if($datadap->justifier==1)
                            <br>

                            <u>Synthese sur les avances </u>
                            <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
                                <tr>
                                    <td colspan="4"> Ce montant est-il une avance ? 
                                                    &nbsp; &nbsp; &nbsp; Oui <input type="checkbox" class="form-check-input" @if($datadap->justifier==1) checked  @endif  disabled> 
                                                    &nbsp; &nbsp; &nbsp; Non <input type="checkbox" class="form-check-input" @if($datadap->justifier==0) checked  @endif  disabled ></td>
                                </tr>
                                @foreach ($datafebElement as $datafebElements)
                                    
                              
                                <tr>
                                    <td> Numéro FEB : {{ $datafebElements->numerofeb }} </td>
                                    <td> Montant de l'Avance : {{ number_format($datafebElements->montantavance, 0, ',', ' ');  }} </td>
                                    <td> Durée avance : {{ $datafebElements->duree_avance }}   Jours</td>
                                    <td> Description : {{ $datafebElements->descriptionn }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4"> Fonds reçus par : 
                                    @if(isset($fond_reussi->nom) && !empty($fond_reussi->nom) && isset($fond_reussi->prenom) && !empty($fond_reussi->prenom))
                                            {{ ucfirst($fond_reussi->nom) }} {{ ucfirst($fond_reussi->prenom) }}
                                        @endif

                                    </td>
                                </tr>
                            </table>

                            @endif

                            <br>
                            <form method="POST" action="{{ route('updatesignaturedap') }}">

                                @method('post')
                                @csrf
                                <input type="hidden" name="dapid" value="{{ $datadap->id }}">

                                <table class="table table-bordered  table-sm">
                                    <tr>
                                        <td colspan="3"> Verification et Approbation de Demande de paiement</td>
                                    </tr>

                                    <tr>
                                        <td width="60%">
                                            Demande etablie par :<small>(Chef de Composante/Projet/Section)</small>
                                             <br>
                                            Noms: {{ ucfirst($Demandeetablie->nom) }} {{ ucfirst($Demandeetablie->prenom) }}
                                        </td>

                                        <td width="25%">
                                            <center>

                                                Signature
                                                <!-- poser signature -->


                                                @if(Auth::user()->id == $datadap->demandeetablie )
                                                <input class="form-check-input" type="checkbox" name="demandeetabliesignature" {{ $datadap->demandeetablie_signe=="1"? 'checked':'' }} style="border:2px solid red">
                                                @endif

                                                <input type="hidden" name="clone_demandeetabliesignature" value="{{ $datadap->demandeetablie_signe }}" />

                                                <br>



                                                @if ($datadap->demandeetablie_signe==1)
                                                <img src="{{ asset($Demandeetablie->signature) }}" width="120px" />
                                                @endif


                                            </center>
                                        </td>
                                        <td width="15%">Date 
                                        @if(Auth::user()->id == $datadap->demandeetablie )
                                            <input type="text" value="{{ $datadap->demandeetablie_signe_date }}" name="dated" >
                                        @else
                                           
                                            <input type="hidden" value="{{ $datadap->demandeetablie_signe_date }}" name="dated_an">
                                            {{ $datadap->demandeetablie_signe_date }}
                                        @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Vérifiée par : (<small>  Chef de Comptable   </small> ) 
                                           <br>
                                            Noms: {{ ucfirst($verifierpar->nom) }} {{ ucfirst($verifierpar->prenom) }}


                                        </td>

                                        <td>
                                            <center>Signature
                                                <!-- poser signature -->
                                                @if(Auth::user()->id == $datadap->verifierpar )
                                                <input class="form-check-input" type="checkbox" name="verifierparsignature" {{ $datadap->verifierpar_signe=="1"? 'checked':'' }} style="border:2px solid red">
                                                @endif
                                                <br>

                                                <input type="hidden" name="clone_verifierparsignature" value="{{ $datadap->verifierpar_signe }}" />

                                                @if ($datadap->verifierpar_signe==1)
                                                <img src="{{  asset($verifierpar->signature) }}" width="120px" />
                                                @endif
                                            </center>

                                        </td>
                                        <td>Date :  
                                        @if(Auth::user()->id == $datadap->verifierpar )
                                            <input type="hidde" value="{{ $datadap->verifierpar_signe_date }}" name="datev" >
                                           
                                        @else
                                        
                                          <input type="hidden" value="{{ $datadap->verifierpar_signe_date }}" name="datev_an" >
                                            {{ $datadap->verifierpar_signe_date }}
                                        @endif
                                       
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Approuveee par : <small> (Chef de Service)</small> <br>
                                          
                                            Noms: {{ ucfirst($approuverpar->nom) }} {{ ucfirst($approuverpar->prenom) }} </td>

                                        <td>
                                            <center>
                                                Signature
                                                <!-- poser signature -->
                                                @if(Auth::user()->id == $datadap->approuverpar)
                                                <input class="form-check-input" type="checkbox" name="approuverparsignature" {{ $datadap->approuverpar_signe=="1"? 'checked':'' }} style="border:2px solid red">
                                                @endif

                                                <input type="hidden" name="clone_approuverparsignature" value="{{ $datadap->approuverpar_signe }}" />

                                                <br>

                                                @if ($datadap->approuverpar_signe==1)
                                                <img src="{{ asset( $approuverpar->signature) }}" width="120px" />
                                                @endif
                                            </center>


                                        </td>
                                        <td>Date : 
                                        @if(Auth::user()->id == $datadap->approuverpar)
                                            <input type="hidde" value="{{ $datadap->approuverpar_signe_date }}" name="datea" ></td>
                                        @else
                                            {{ $datadap->approuverpar_signe_date }}
                                            <input type="hidden" value="{{ $datadap->approuverpar_signe_date }}" name="datea_an" >
                                            {{ $datadap->approuverpar_signe_date }}
                                         @endif
                                        </td>
                                       
                                   
                                        </tr>

                                </table>
                                <br>

                                <table class="table table-bordered  table-sm">
                                    <tr>
                                        <td colspan="2">Autorisation de Paiement</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">

                                            @if (is_null($datadap->dateautorisation))
                                            Autorise le ....../...../....
                                            @else
                                            Autorise le : {{ date('d-m-Y', strtotime($datadap->dateautorisation))  }}
                                            @endif

                                           <!-- <a href="javascript:void(0);" class="dropdown-item notify-item editpersonnel" data-bs-toggle="modal" data-bs-target="#EditdateModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
                                                    <small><i class="fa fa-edit"></i> Modifier la date </small>
                                            </a> -->


                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <center>
                                                Responsable Administratif et Financier
                                                <!-- poser signature -->
                                                @if(Auth::user()->id == $datadap->responsable)
                                                <input class="form-check-input" type="checkbox" name="responsablesignature" {{ $datadap->responsable_signe=="1"? 'checked':'' }} style="border:2px solid red">
                                                @endif
                                                <input type="hidden" name="clone_responsablesignature" value="{{ $datadap->responsable_signe }}" />

                                                <br> {{ ucfirst($responsable->nom) }} {{ ucfirst($responsable->prenom) }}


                                                @if ($datadap->responsable_signe==1)
                                                <br>

                                                <img src="{{  asset($responsable->signature) }}" width="120px" />
                                            </center>
                                            @endif


                                        </td>
                                        <td>
                                            <center>
                                                Chef des Programmes
                                                <!-- POser signature -->
                                                @if(Auth::user()->id == $datadap->chefprogramme)
                                                <input class="form-check-input" type="checkbox" name="chefprogrammesignature" {{ $datadap->chefprogramme_signe=="1"? 'checked':'' }} style="border:2px solid red">
                                                @endif
                                                <input type="hidden" name="clone_chefprogrammesignature" value="{{ $datadap->chefprogramme_signe }}" />



                                                <br> {{ ucfirst($chefprogramme->nom) }} {{ ucfirst($chefprogramme->prenom) }}

                                                @if ($datadap->chefprogramme_signe==1)
                                                <br>

                                                <img src="{{ asset($chefprogramme->signature) }}" width="120px" />
                                            </center>
                                            @endif

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">Secretaire General de la CEPBU

                                            @if(Auth::user()->id == $datadap->secretaire)
                                            <input class="form-check-input" type="checkbox" name="secretairesignature" {{ $datadap->secretaure_general_signe=="1"? 'checked':'' }} style="border:2px solid red">

                                            @endif
                                            <br>

                                            <input type="hidden" name="clone_secretairesignature" value="{{ $datadap->secretaure_general_signe }}" />
                                            <input type="hidden" name="ancient_date_autorisation" value="{{ $datadap->dateautorisation }}" />

                                            {{ ucfirst($secretaire->nom) }} {{ ucfirst($secretaire->prenom) }}

                                            @if ($datadap->secretaure_general_signe==1)

                                            <center>
                                                <img src="{{  asset($secretaire->signature) }}" width="120px" />
                                            </center>
                                            @endif

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">Observation/Instructions du SG <br>


                                            @if (is_null($datadap->observation))

                                            @else
                                            {{ $datadap->observation  }}
                                            @endif

                                            <br> <a href="javascript:void(0);" class="dropdown-item notify-item" data-bs-toggle="modal" data-bs-target="#EditobservationModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
                                                    <small>( <i class="fa fa-edit"></i> Modifier l'observstion )</small>
                                            </a>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2"><small>FEB: Fiche d'Expression des Besoins , preparee par l'assistant de composante(Ac) ou charge d'execution (CE) ou Chef de Session (CS) ou assimilee &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BQ.Banque </small> </td>
                                    </tr>
                                </table>


                                <hr>
                                <center>

                                    <center><small>{{ $dateinfo->piedpage }}</small></center>

                                </center>

                                <br>



                                <div class="float-end">
                                    <!-- <a href="{{ route('generate-pdf-feb', $datadap->id) }}" class="btn btn-primary">Générer PDF</a> n-->


                                    <input type="submit" name="save" class="btn btn-primary w-md" value="Sauvegarder la signature" />
                                    <br>
                                    <br><small>
                                        <center> <i class="fa fa-info-circle"></i><br> Cochez la case située en dessous <br> de votre nom si vous êtes accrédité <br> pour apposer votre signature <br> puis cliquez sur le boutton <br> sauvegarder la signature</center>
                                    </small>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
</div>
</div>

<div class="modal fade" id="EditobservationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form autocomplete="off" action="{{ route('update_autorisation_dap') }}" method="POST">
            @method('post')
            @csrf
            <input type="hidden" name="dapid" value="{{ $datadap->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-edit"></i> Modifier Observation/Instructions du SG </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
                </div>
                <div class="modal-body">



                    <div class="row">
                        <div class="col-sm-12 col-md-12">

                            <label for="email">Description</label>

                            <textarea class="form-control" name="observation_text" type="text" required="required">@if (is_null($datadap->observation))@else{{ $datadap->observation  }}@endif </textarea>


                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" name="EditPersonnelbtn" id="EditPersonnelbtn" class="btn btn-primary">Sauvegarder</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- <div class="modal fade" id="EditdateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <form method="POST" action="{{ route('updateautorisactiondap') }}">

            @method('post')
            @csrf
            <input type="hidden" name="dapid" value="{{ $datadap->id }}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-calendar"></i> Autorisation</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <input id="per_id" name="per_id" type="hidden" />

                        <div class="col-sm-12 col-md-12">

                            <input class="form-control" name="dateau" type="date" required="required"  />



                        </div>

                    </div>



                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">Sauvegarder la signature</button>
                </div>
            </div>
        </form>
    </div>
</div>  -->


@include('document.dap.modale_feb')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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