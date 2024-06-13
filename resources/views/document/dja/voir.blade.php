@extends('layout/app')
@section('page-content')
<div class="main-content">
    <br>
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="invoice-title">
                    <center>
                        <div class="text-muted">
                            <table style=" width:100%">
                                <tr>
                                    <td style=" width:10% ;"> <img src="{{ asset('element/logo/logo.png') }}" alt="logo" height="50" /> </td>

                                    <td>
                                        <center>
                                            <h3>{{ $dateinfo->entete }}</h3>
                                        </center>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <hr>
                                        <center>{{ $dateinfo->sousentete }}</center>
                                    </td>
                                </tr>
                            </table>
                        </div>
                </div>
                <hr class="my-4">
                <div class="row">
                    <H5>
                        <center> DEMANDE DE JUSTIFICATION D'AVANCE (DJA) N° {{ $datadap->numerodap }}/{{ date('Y')}} </center>
                    </H5>
                    <div class="col-sm-12">
                        <table class="table table-bordered  table-sm">
                            <tr>
                                <td width="55%">
                                    Service: {{ $datadap->titres }} <BR>
                                    Composante/ Projet/Section: {{ ucfirst(Session::get('title')) }} <br>
                                    Moyen de Paiement :

                                    OV : <input type="checkbox" class="form-check-input" readonly @if ( $datadap->ov==1)
                                    checked value="{{ $datadap->ov }}"
                                    @else
                                    value="{{ $datadap->ov }}"
                                    @endif /> &nbsp; &nbsp;&nbsp;

                                    Cheque :{{ $datadap->cho }}
                                    <br>
                                    Devise : {{ Session::get('devise') }} <br>


                                    Source de creation : {{ ucfirst($etablienom->nom) }} {{ ucfirst($etablienom->prenom) }} <br>


                                </td>
                                <td>
                                    Référence: FEB n<sup>o</sup>:
                                    @php
                                    foreach ($datafebElement as $key => $datafebElements) {
                                    echo '['.$datafebElements->numerofeb.']';

                                    if ($key < count($datafebElement) - 1) { echo ',' ; } } @endphp <BR>
                                        Lieu: {{ $datadap->lieu }} <br>

                                        Compte bancaire(BQ) : {{ $datadap->comptabiliteb }} <br>
                                       
                                        Taux execution globale : {{ $pourcetage_globale }}% <br>

                                        Relicat budgetaire: {{ number_format($solde_comptable, 0, ',', ' ')  }}

                                </td>
                            </tr>
                        </table>



                        <h6> <u>Synthese sur l'utilisation des fonds demandes(Vr details sur FB en avance)</u></h6>

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
                                @foreach ($datafebElement as $datafebElements)
                                @php

                                $totoSUM = DB::table('elementfebs')
                                ->orderBy('id', 'DESC')
                                ->where('febid', $datafebElements->fid)
                                ->sum('montant');


                                $totoglobale += $totoSUM;
                                $pourcentage = round(($totoSUM * 100) / $budget, 2);
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
                                    <td align="center">{{ $pourcentage }} %</td>
                                </tr>
                                @endforeach
                                <tr style=" background-color: #040895;">
                                    <td style="color:white" colspan="2" align="center"> Total </td>
                                    <td align="right" style="color:white"> {{ number_format($totoglobale, 0, ',', ' ')  }}</td>
                                    <td style="color:white" align="center"> {{ $pourcentage_total }} %</td>
                                </tr>
                            </tbody>
                        </table>

                        <br>

                        <p> C'est montant est une avance ? &nbsp; &nbsp;&nbsp;
                            Oui : <input type="checkbox" class="form-check-input" readonly @if ( $datadap->justifier==1)
                            checked
                            @endif /> &nbsp; &nbsp;&nbsp;

                            Non : <input type="checkbox" class="form-check-input" readonly @if ( $datadap->justifier==0)
                            checked
                            @endif /> &nbsp; &nbsp;&nbsp;
                            <br>

                        </p>

                        @if ( $datadap->justifier==1)

                        <table class="table table-striped table-sm fs--1 mb-0 table-bordered  ">
                            <thead>
                                <tr>
                                    <th>F.E.B </th>
                                    <th>Facture </th>
                                    <th>Montant de l'Avance </th>
                                    <th>Montant utilisé*</th>
                                    <th>Surplus/Manque*</th>
                                    <th>Montant retourné</th>
                                    <th>Bordereau</th>
                                    <th>Duré avance</th>
                                    <th>Date du</th>
                                    <th>Description</th>
                                    <th>Véhicule</th>
                                </tr>
                            </thead><!-- end thead -->
                            <tbody>
                                @foreach ($liste_justification as $liste_justifications)
                                <tr>
                                    <td>{{ $liste_justifications->numerodap }}</td>
                                    <td>{{ $liste_justifications->numfacture }}</td>
                                    <td>{{ $liste_justifications->montantavance }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $liste_justifications->duree_avance }}</td>
                                    <td></td>
                                    <td>{{ $liste_justifications->descriptionn }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>


                        @endif
                        <br>





                        <table class="table table-bordered  table-sm">
                            <tr>
                                <td colspan="3"> Verification et Approbation de Demande de paiement</td>
                            </tr>

                            <tr>
                                <td width="60%">Demande etablie par : {{ ucfirst($etablienom->nom) }} {{ ucfirst($etablienom->prenom) }} <br>
                                    Chef de Composante/Projet/Section <br>
                                    Noms: {{ ucfirst($Demandeetablie->nom) }} {{ ucfirst($Demandeetablie->prenom) }}


                                </td>

                                <td width="25%">
                                    <center>

                                        Signature
                                        <!-- poser signature -->


                                        @if(Auth::user()->id == $datadap->demandeetablie )
                                        <input class="form-check-input" type="checkbox" name="demandeetabliesignature" {{ $datadap->demandeetablie_signe=="1"? 'checked':'' }}>
                                        @endif

                                        <input type="hidden" name="clone_demandeetabliesignature" value="{{ $datadap->demandeetablie_signe }}" />

                                        <br>



                                        @if ($datadap->demandeetablie_signe==1)
                                        <img src="{{ asset($Demandeetablie->signature) }}" width="120px" />
                                        @endif


                                    </center>
                                </td>
                                <td width="15%">Date : {{ $datadap->demandeetablie_signe_date }}
                                    <input type="hidden" value="{{ $datadap->demandeetablie_signe_date }}" name="dated">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    Vérifiée par : <br>
                                    Chef de Comptable <br>
                                    Noms: {{ ucfirst($verifierpar->nom) }} {{ ucfirst($verifierpar->prenom) }}


                                </td>

                                <td>
                                    <center>Signature
                                        <!-- poser signature -->
                                        @if(Auth::user()->id == $datadap->verifierpar )
                                        <input class="form-check-input" type="checkbox" name="verifierparsignature" {{ $datadap->verifierpar_signe=="1"? 'checked':'' }}>
                                        @endif
                                        <br>

                                        <input type="hidden" name="clone_verifierparsignature" value="{{ $datadap->verifierpar_signe }}" />

                                        @if ($datadap->verifierpar_signe==1)
                                        <img src="{{  asset($verifierpar->signature) }}" width="120px" />
                                        @endif
                                    </center>

                                </td>
                                <td>Date : {{ $datadap->verifierpar_signe_date }}
                                    <input type="hidden" value="{{ $datadap->verifierpar_signe_date }}" name="datev">
                                </td>
                            </tr>

                            <tr>
                                <td>Approuveee par : <br>
                                    Chef de Service <br>
                                    Noms: {{ ucfirst($approuverpar->nom) }} {{ ucfirst($approuverpar->prenom) }} </td>

                                <td>
                                    <center>
                                        Signature
                                        <!-- poser signature -->
                                        @if(Auth::user()->id == $datadap->approuverpar)
                                        <input class="form-check-input" type="checkbox" name="approuverparsignature" {{ $datadap->approuverpar_signe=="1"? 'checked':'' }}>
                                        @endif

                                        <input type="hidden" name="clone_approuverparsignature" value="{{ $datadap->approuverpar_signe }}" />

                                        <br>

                                        @if ($datadap->approuverpar_signe==1)
                                        <img src="{{ asset( $approuverpar->signature) }}" width="120px" />
                                        @endif
                                    </center>


                                </td>
                                <td>Date : {{ $datadap->approuverpar_signe_date }} <input type="hidden" value="{{ $datadap->approuverpar_signe_date }}" name="datea"></td>
                            </tr>

                        </table>


                        <table class="table table-bordered  table-sm">
                            <tr>
                                <td colspan="3">Autorisation de Paiement</td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center">

                                    @if (is_null($datadap->dateautorisation))
                                    Autorise le ....../...../....
                                    @else
                                    Autorise le : {{ date('d-m-Y', strtotime($datadap->dateautorisation))  }}
                                    @endif



                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center>
                                        Responsable Administratif et Financier
                                        <!-- poser signature -->
                                      
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
                                        

                                        <br> {{ ucfirst($chefprogramme->nom) }} {{ ucfirst($chefprogramme->prenom) }}

                                        @if ($datadap->chefprogramme_signe==1)
                                        <br>

                                        <img src="{{ asset($chefprogramme->signature) }}" width="120px" />
                                    </center>
                                    @endif

                                </td>

                                <td align="center">Secretaire General de la CEPBU

                                  
                                    <br>



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



@endsection