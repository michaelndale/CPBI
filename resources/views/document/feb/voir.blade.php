@extends('layout/app')
@section('page-content')

@foreach ($dateinfo as $dateinfo)
@endforeach

<div class="main-content">
    <br>
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="invoice-title">
                    <center>
                        <!--  <a href="{{ route('listfeb')}}" class="btn btn-info"> <i class="fas fa-long-arrow-alt-left"></i> Retour en arrière.</a>
                        <a href="{{ route('generate-pdf-feb', $dataFeb->id) }}" class="btn btn-success"><i class="fa fa-print"> </i> Générer document PDF</a>
                      <a href="{{ route('generate.word.feb', $dataFeb->id) }}" class="btn btn-primary">Download Word Document</a> -->
                        <div class="text-muted">
                            <table style=" width:100%">
                                <tr>
                                    <td style=" width:10% ;"> <center>  <img src="{{ asset('element/logo/logo.png') }}" alt="logo" height="70" />  </center></td>

                                    <td>
                                        <center>
                                            <p class="mb-1">
                                            <h3>{{ $dateinfo->entete }}</h3>
                                        </center>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
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

                                @if (isset($onebeneficaire->libelle) && !empty($onebeneficaire->libelle)) 
                                    Bénéficiaire : {{ $onebeneficaire->libelle }} 
                                @endif
                                    
                            </td>
                            </tr>
                            <tr>
                                <td style="width:50%">
                                Activité:
                                    {{ $dataFeb->descriptionf }}
                                </td>
                                <td>
                                    Date : {{ date('d-m-Y', strtotime($dataFeb->datefeb))  }} 
                                </td>
                            </tr>
                            <tr>
                                <td>Ligne budgétaire: {{ $dataLigne->libelle }} </td>
                                <td>Source de creation : {{ $createur->nom }}  {{ $createur->prenom }} </td>
                            </tr>
                            <tr>
                                <td> Taux d’exécution de la ligne budgetaire: {{ $sommelignpourcentage }} %</td>
                                <td> Taux d’exécution globale du projet: {{ $POURCENTAGE_GLOGALE }} %</td>
                            </tr>
                            <tr>

                                <td>
                                    BC : <input type="checkbox"  class="form-check-input" readonly @if ($dataFeb->bc==1)
                                    checked value="{{ $dataFeb->bc }}"
                                    @else
                                    value="{{ $dataFeb->bc }}"
                                    @endif /> &nbsp; &nbsp;&nbsp; Facture:

                                    <input type="checkbox"  class="form-check-input" readonly @if($dataFeb->facture==1)
                                    checked value="{{ $dataFeb->facture }}"
                                    @else
                                    value="{{ $dataFeb->facture }}"
                                    @endif
                                    />
                                    

                                    &nbsp;&nbsp;&nbsp;O.M : <input type="checkbox" name="om" id="om" class="form-check-input" readonly @if($dataFeb->om==1)
                                    checked value="{{ $dataFeb->om }}"
                                    @else
                                    value="{{ $dataFeb->om }}"
                                    @endif
                                    />
                                    &nbsp;&nbsp;&nbsp;FP/Devis : <input type="checkbox" class="form-check-input" readonly @if($dataFeb->fpdevis==1)
                                    checked value="{{ $dataFeb->fpdevis }}"
                                    @else
                                    value="{{ $dataFeb->fpdevis }}"
                                    @endif
                                    />
                                    &nbsp;&nbsp;&nbsp;NEC : <input type="checkbox" class="form-check-input" readonly @if($dataFeb->nec==1)
                                    checked value="{{ $dataFeb->nec }}"
                                    @else
                                    value="{{ $dataFeb->nec }}"
                                    @endif

                                    />
                                </td>

                                <td> Bénéficiaire : {{ $dataFeb->beneficiaire }} </td>
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
                            <thead>
                                <tr>
                                    <th>N<sup>o</sup></th>
                                    <th>Designation de la ligne</th>
                                     <th>Description</th>
                                    <th>
                                        <center>Unité</center>
                                    </th>
                                    <th>
                                        <center>Quantité </center>
                                    </th>
                                    <th>
                                        <center>Frequence </center>
                                    </th>
                                    <th>
                                        <center>Prix Unitaire </center>
                                    </th>
                                    <th>
                                        <center>Prix total </center>
                                    </th>
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

                                        </h5>
                                    <td style="width:15%">{{ ucfirst($datElements->libelle_description) }}</h5>
                                    </td>
                                    <td style="width:10%">{{ $datElements->unite }}</h5>
                                    </td>
                                    <td style="width:10%" align="center">{{ $datElements->quantite }}</h5>
                                    </td>
                                    <td style="width:10%" align="center">{{ $datElements->frequence }}</h5>
                                    </td>
                                    <td style="width:15%" align="center">{{ number_format($datElements->pu,0, ',', ' ') }} {{ Session::get('devise') }}</h5>
                                    </td>
                                    <td style="width:20%" align="center"> {{ number_format($datElements->montant,0, ',', ' ') }} {{ Session::get('devise') }} </td>
                                </tr>
                                @php
                                $n++
                                @endphp
                                @endforeach

                                <tr style=" background-color: #040895;">
                                    <td colspan="7"><b><font color="white"> Total général</font></b></td>
                                    <td align="center"><b><font color="white"> {{ number_format($sommefeb,0, ',', ' ') }} {{ Session::get('devise') }}</font></b></h5>
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
                                                    <input   class="form-check-input" type="checkbox" name="accesignature" id="accesignature" {{ $dataFeb->acce_signe=="1"? 'checked':'' }}> <small>Cochez pour Poser la signature</small> 
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
                                                     <input  class="form-check-input" type="checkbox" name="comptablesignature" id="comptablesignature" {{ $dataFeb->comptable_signe=="1"? 'checked':'' }}> <small>Cochez pour Poser la signature</small> 
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
                                                    <input   class="form-check-input" type="checkbox" id="chefsignature" name="chefsignature" {{ $dataFeb->chef_signe=="1"? 'checked':'' }}>  <small>Cochez pour Poser la signature</small> 
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
                            <a href="{{ route('generate-pdf-feb', $dataFeb->id) }}" class="btn btn-success"><i class="fa fa-print"> </i> Générer document PDF</a>
                            <div class="float-end">
                               
                               <!-- <a href="javascript:window.print()" class="btn btn-success me-1"><i class="fa fa-print"> Imprimer</i></a> -->
                               
                                
                                    <button type="submit" name="save" id="dave" class="btn btn-primary w-md" > <i class="fas fa-cloud-download-alt"> </i>  Sauvegarder la sinatgure </button>
                                    <br>
                                    <br><small><center> <i class="fa fa-info-circle"></i><br> Cochez la case située en dessous <br> de votre nom si vous êtes accrédité <br>  pour apposer votre signature <br> puis cliquez sur le boutton <br> sauvegarder la signature</center> </small>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
           
            <br>
        </div>
    </div>
    <br> <br>
    @endsection