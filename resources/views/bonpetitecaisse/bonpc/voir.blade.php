@extends('layout/app')
@section('page-content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8" style="margin:auto">
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
                                <center>BON DE PETITE CAISSE N° {{ $dataPetiteCaisse->numero }}</center> <br>
                            </H5>
                            <font size="3px">
                                <p>

                                    Je soussigné (nom complet) &nbsp; &nbsp; {{ $dataPetiteCaisse->nom_sousigne }} <br>
                                    <small> (I undersigned (full name) </small>


                                    <br> <br>




                                    Titre (+ nom de l’organisation si différente de la CEPBU): <br>
                                    <small> (I undersigned (full name) </small>
                                    <br>{{ $dataPetiteCaisse->titre }} ,

                                    <br>

                                    <br>

                                    Type de carte d'identite : {{ $dataPetiteCaisse->type_identite }}

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Numéro de la pièce d’identité : {{ $dataPetiteCaisse->numero_piece }}

                                    ,

                                    <br>

                                    Adresse : {{ $dataPetiteCaisse->adresse }}

                                    ,


                                    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;Téléphone/Email : {{ $dataPetiteCaisse->telephone_email }}



                                    <br><br>



                                    Reconnais avoir reçu de CEPBU un montant de {{   number_format($dataPetiteCaisse->total_montant, 0, ',', ' ') }}

                                    <br> <br>


                                    Motif :
                                        @if($element_petite_caisse)
                                        

                                        @foreach ($element_petite_caisse as $key => $element_petite_caisses)
                                            {{ $element_petite_caisses->motifs }}

                                            @if ($loop->remaining > 1)
                                                , 
                                            @elseif ($loop->remaining == 1)
                                                ,  
                                            @else
                                                .  
                                            @endif
                                        @endforeach



                                        @endif

                                    <br>

                                    <form method="POST" action="{{ route('update_signature_bpc') }}">
                                    @method('post')
                                    @csrf
                                 

                                    <center>
                                        <tabble >
                                            <tr>
                                            <td style="width:20%"> Fait à &nbsp;&nbsp; </td>
                                            <td style="width:50%">
                                            <input type="text" value="{{ $dataPetiteCaisse->faita }}" name="lieu" id="lieu" placeholder=" lieu " style="width:15%; border:none; border-bottom: 2px dotted #000;" />

                                                </td>
                                            <td style="width:30%">, le  

                                            <input type="date" value="{{ $dataPetiteCaisse->date }}" name="date" id="lieu" placeholder="date" style="width:10%; border:none; border-bottom: 2px dotted #000;"  />

                                                
                                            </td>
                                            </tr>
                                        </tabble> 
                                        

                                        

                                    </center>
                                    <br><br>

                                
                                    <input type="hidden" name="bonid" value="{{ $dataPetiteCaisse->id }} ">
                                    <input type="hidden" name="numBon" value="{{ $dataPetiteCaisse->numero }} ">
                                    <input type="hidden" name="febid" id="febid" value="{{ $dataPetiteCaisse->id }}">
                                    <input type="hidden" name="projetid" value="{{ $dataPetiteCaisse->projetid }}" />
                                    <input type="hidden" name="compteid" value="{{ $dataPetiteCaisse->compteid }}" />
                                   
                             <!--       @if($element_petite_caisse)
                                        
                                        @foreach ($element_petite_caisse  as $element_petite_caisses)

                                       <input type="hidden" name="motif[]" id="motif[]" value="{{ $element_petite_caisses->motifs }}" />
                                       <input type="hidden" name="montant[]" id="montant[]" value="{{ $element_petite_caisses->montant }}" />
                                       <input type="hidden" name="input[]" id="input[]" value="{{ $element_petite_caisses->input }}" />
                                    
                                            
                                        @endforeach

                                    @endif -->





                                    <table style="width:100%">
                                        <tr>
                                            <td align="center">

                                                Nom et signature du Bénéficiaire <br> <small>(Receiver name and signature) </small> <br>
                                             

                                                @if($etablienom)
                                                {{ ucfirst($etablienom->nom) }} {{ ucfirst($etablienom->prenom) }}  <br>

                                                @if(Auth::user()->id == $dataPetiteCaisse->etabli_par)
                                                <input class="form-check-input" type="checkbox" name="accesignature" id="accesignature" {{ $dataPetiteCaisse->etabli_par_signature=="1"? 'checked':'' }} style="border:2px solid red"> <small>Cochez pour Poser la signature</small>
                                                @endif
                                                <input type="hidden" name="clone_accesignature" value="{{ $dataPetiteCaisse->etabli_par_signature }}" />


                                                @else
                                                <!-- Handle the case when $etablienom is null, e.g., show a default message -->
                                                <input type="hidden" name="clone_accesignature" value="{{ $dataPetiteCaisse->etabli_par_signature }}" />


                                                <input type="text"  value="{{ $dataPetiteCaisse->beneficiaire }}" name="beneficiaire" id="beneficiaire" class="form-control form-control-sm"  placeholder="Entrer le Nom & Prenom du Bénéficiaire "/>
                                                @endif
                                                <br>

                                                @if($etablienom)
                                                @if ($dataPetiteCaisse->etabli_par_signature==1)
                                                <img src="{{ asset($etablienom->signature) }}" width="150px" />
                                                @endif
                                                @endif

                                            </td>

                                            <td align="center">
                                                Nom et signature du Distributeur <br>
                                                <small>(Distributor name and signature)</small> <br>

                                                
                                                {{ $verifie_par->nom }} {{ $verifie_par->prenom }}
                                                <br>

                                                @if(Auth::user()->id == $dataPetiteCaisse->verifie_par)
                                                    <input class="form-check-input" type="checkbox" name="verifier" id="verifier"
                                                        {{ $dataPetiteCaisse->verifie_par_signature=="1"? 'checked':'' }} style="border:2px solid red"> <small>Cochez pour Poser la signature</small>
                                                @endif
                                                <input type="hidden" name="clone_verifier" value="{{ $dataPetiteCaisse->verifie_par_signature }}" />


                                                <br>

                                                @if($verifie_par)
                                                    @if ($dataPetiteCaisse->verifie_par_signature==1)
                                                        <img src="{{ asset($verifie_par->signature) }}" width="150px" />
                                                    @endif
                                                @endif


                                            </td>

                                            <td align="center">
                                                Nom et signature pour approbation <br>
                                                <small>(Distributor name for approval)</small> <br>
                                                  {{ $approuver_par->nom }} {{ $approuver_par->prenom }}
                                                            <br>

                                                            @if(Auth::user()->id == $dataPetiteCaisse->	approuve_par)
                                                            <input class="form-check-input" type="checkbox" id="approver" name="approver" 
                                                            {{ $dataPetiteCaisse->approuve_par_signature=="1"? 'checked':'' }} style="border:2px solid red"> <small>Cochez pour Poser la signature</small>
                                                            @endif
                                                            <input type="hidden" name="clone_approver" value="{{ $dataPetiteCaisse->approuve_par_signature  }}" />
                                                        
                                                            
                                                <br>

                                                @if($approuver_par)
                                                    @if ($dataPetiteCaisse->approuve_par_signature==1)
                                                        <img src="{{ asset($approuver_par->signature) }}" width="150px" />
                                                    @endif
                                                @endif

                                            </td>
                                        </tr>

                                    </table>

                                    <p align="center">
                                        <br><br><br><br>
                                        <small>{{ $dateinfo->piedpage }}</small>
                                    </p>
                                    <br>
                                    @if(Auth::user()->id == $dataPetiteCaisse->verifie_par || Auth::user()->id == $dataPetiteCaisse->approuve_par )
                                    <div class="float-end">
                                        <button type="submit" name="save" id="dave" class="btn btn-primary w-md"> <i class="fas fa-cloud-download-alt"> </i> Sauvegarder la sinatgure </button>
                                        <br>
                                        <br><small>
                                            <center> <i class="fa fa-info-circle"></i><br> Cochez la case située en dessous <br> de votre nom si vous êtes accrédité <br> pour apposer votre signature <br> puis cliquez sur le boutton <br> sauvegarder la signature</center>
                                        </small>
                                    </div>

                                    @endif

                                </form>

                            </font>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection