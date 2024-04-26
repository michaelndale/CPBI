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
                                    <td style=" width:10% ;"> <img src="{{ asset('element/logo/logo.png') }}" alt="logo" height="100" /> </td>

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

                                            <center>{{ $dateinfo->sousentete }}</center>

                                        </center>
                                    </td>
                                </tr>
                            </table>
                        </div>
                </div>
                <hr class="my-4">
                <div class="row">
                    <H5>
                        <center> Demande et d'Autorisation de Paiement (DAP) N° {{ $datadap->numerodap }} </center>
                    </H5>
                    <div class="col-sm-12">
                        <table class="table table-bordered  table-sm">
                            <tr>
                                <td>
                                    Service: {{ $datadap->titres }}  <BR>
                                    Composante/ Projet/Section: {{ ucfirst(Session::get('title')) }} 
                                 </td>
                                <td>
                                Reference: FEB N<sup>o</sup> {{ $datadap->numerofeb }} <br>
                                    Source de creation : {{ ucfirst($etablienom->nom) }} {{ ucfirst($etablienom->prenom) }} <br>
                                    Ligne budgetaire  {{ $dataLigne->libelle }}<br>
                                    Taux d'execution {{ $pourcentage_global_b }} % <br>
                                    Compte bancaire(BQ) : {{ $datadap->comptable }} <br>
                                    Solde comptable BQ: {{ number_format($solder_dap, 0, ',', ' ') }} {{ Session::get('devise') }} 
                                    Lieu: {{ $datadap->lieu }} 
                                </td>
                            </tr>
                            <tr>
                                <td style="width:50%" >
                               
                                Activite: {{ $datadap->descriptionf }} </td>
                                <td>

                                
                                        Moyen de Paiement : <br>

                                        OV : <input type="checkbox"  class="form-check-input" readonly @if ( $datadap->ov==1)
                                    checked value="{{  $datadap->ov }}"
                                    @else
                                    value="{{ $datadap->ov }}"
                                    @endif /> &nbsp; &nbsp;&nbsp;

                                    OV : <input type="checkbox"  class="form-check-input" readonly @if ( $datadap->cho==1)
                                    checked value="{{  $datadap->cho }}"
                                    @else
                                    value="{{ $datadap->cho }}"
                                    @endif /> &nbsp; &nbsp;&nbsp;



                                        



                            </td>
                                    
                                </td>
                            </tr>
                        </table>
                        <h6> <u>Synthese sur l'utilisation dea fonds demandes(Vr details sur FB en avance)</u></h6>


                        <table style="width:100%">
                            <td style="width:80%">
                                <table class="table table-bordered  table-sm">




                                    <table class="table table-striped table-sm fs--1 mb-0 table-bordered  ">
                                        <thead>
                                            <tr>
                                                <th>N<sup>o</sup></th>
                                                <th>Designation</th>
                                                <th>Libellé</th>
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
                                            @foreach ($dataElementfeb as $datElements)
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
                                                <td colspan="7"> <b><font color="white">Total général </font></b></td>
                                                <td align="center"> <b><font color="white"> {{ number_format($sommefeb,0, ',', ' ') }} {{ Session::get('devise') }} </font></b></h5>
                                                </td>

                                            </tr>
                                        </tbody>

                                    </table>


                            </td>
                           
                        </table>


                        <form method="POST" action="{{ route('updatesignaturedap') }}">

                            @method('post')
                            @csrf
                            <input type="hidden" name="dapid"  value="{{ $datadap->iddape }}">

                            <table class="table table-bordered  table-sm">
                                <tr>
                                    <td colspan="3"> Verification et Approbation de Demande de paiement</td>
                                </tr>

                                <tr>
                                    <td width="60%">Demande etablie par : {{ ucfirst($etablienom->nom) }} {{ ucfirst($etablienom->prenom) }}  <br>
                                        Chef de Composante/Projet/Section <br>
                                        Noms: {{ ucfirst($Demandeetablie->nom) }} {{ ucfirst($Demandeetablie->prenom) }}


                                    </td>

                                    <td width="25%">
                                        <center> 
                                        
                                    Signature
                                        <!-- poser signature -->
                                       

                                        @if(Auth::user()->id == $datadap->demandeetablie )
                                        <input class="form-check-input" type="checkbox" name="demandeetabliesignature" {{ $datadap->demandeetablie_signe=="1"? 'checked':'' }} >
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

                                    <td><center>Signature
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

                                    <td> <center>
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
                                    <td colspan="2">Autorisation de Paiement</td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">

                                    @if (is_null($datadap->dateautorisation))
                                    Autorise le ....../...../....
                                    @else
                                    Autorise le : {{ date('d-m-Y', strtotime($datadap->dateautorisation))  }}
                                    @endif

                                    <a href="javascript:void(0);" class="dropdown-item notify-item editpersonnel"  data-bs-toggle="modal" data-bs-target="#EditdateModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
                                        <small><i class="fa fa-edit"></i> Modifier la date </small>
                                    </a>


                                    </td>
                                </tr>
                                <tr>
                                    <td><center>
                                        Responsable Administratif et Financier
                                        <!-- poser signature -->
                                        @if(Auth::user()->id == $datadap->responsable)
                                        <input class="form-check-input" type="checkbox" name="responsablesignature" {{ $datadap->responsable_signe=="1"? 'checked':'' }}>
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
                                        <input class="form-check-input" type="checkbox" name="chefprogrammesignature" {{ $datadap->chefprogramme_signe=="1"? 'checked':'' }}>
                                        @endif
                                        <input type="hidden" name="clone_chefprogrammesignature" value="{{ $datadap->chefprogramme_signe }}" />



                                        <br> {{ ucfirst($chefprogramme->nom) }} {{ ucfirst($chefprogramme->prenom) }}

                                        @if ($datadap->chefprogramme_signe==1)
                                        <br>
                                       
                                            <img src="{{ asset($responsable->signature) }}" width="120px" />
                                        </center>
                                        @endif
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">Secretaire General de la CEPBU 

                                    @if(Auth::user()->id == $datadap->secretaire)
                                        <input class="form-check-input" type="checkbox" name="secretairesignature" {{ $datadap->secretaure_general_signe=="1"? 'checked':'' }}>
                                        @endif 
                                        <br>

                                        <input type="hidden" name="clone_secretairesignature" value="{{ $datadap->secretaure_general_signe }}" />

                                    
                                    {{ ucfirst($secretaire->nom) }} {{ ucfirst($secretaire->prenom) }}

                                        @if ($datadap->secretaure_general_signe==1)
                                        
                                        <center>
                                            <img src="{{  asset($secretaire->signature) }}" width="120px" />
                                        </center>
                                        @endif
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">Observation/Instructions du SG  <br>
                                   

                                    @if (is_null($datadap->observation))
                                    
                                    @else
                                       {{ $datadap->observation  }}
                                    @endif

                                    <br> <a href="javascript:void(0);" class="dropdown-item notify-item"  data-bs-toggle="modal" data-bs-target="#EditobservationModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
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
                            
                           
                            <a href="{{ route('generate-pdf-dap', $datadap->id) }}" class="btn btn-success"><i class="fa fa-print"> </i> Générer document PDF</a>
                            <div class="float-end">
                                <!-- <a href="{{ route('generate-pdf-feb', $datadap->id) }}" class="btn btn-primary">Générer PDF</a> n-->

            
                                <input type="submit" name="save"  class="btn btn-primary w-md" value="Sauvegarder la signature" />
                                <br>
                                    <br><small><center> <i class="fa fa-info-circle"></i><br> Cochez la case située en dessous <br> de votre nom si vous êtes accrédité <br>  pour apposer votre signature <br> puis cliquez sur le boutton <br> sauvegarder la signature</center> </small>
                            </div>
                        </form>
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
         <form  autocomplete="off"action="{{ route('update_autorisation_dap') }}" method="POST">
            @method('post')
            @csrf
            <input type="hidden" name="dapid"  value="{{ $datadap->iddape }}">
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-edit"></i>  Modifier  Observation/Instructions du SG </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
             </div>
             <div class="modal-body">
              
             

               <div class="row">
                 <div class="col-sm-12 col-md-12">
                
                   <label for="email">Description</label>
                     
                     <textarea class="form-control" name="observation_text" type="text" required="required" >@if (is_null($datadap->observation))@else{{ $datadap->observation  }}@endif </textarea>
                     
              
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

<div class="modal fade" id="EditdateModal" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered modal-sm">
       <form method="POST" action="{{ route('updateautorisactiondap') }}">

        @method('post')
        @csrf
<input type="hidden" name="dapid"  value="{{ $datadap->iddape }}">

           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-calendar"></i> Autorisation</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
             </div>
             <div class="modal-body">
               <div class="row">

                 <input id="per_id" name="per_id" type="hidden" />

                 <div class="col-sm-12 col-md-12">
                  
                     <input class="form-control"  name="dateau" type="date" required="required" placeholder="Identifiant" />
                     
                     
                 
                 </div>
               
               </div>

             
            
             </div>
             <div class="modal-footer">

               <button type="submit"  class="btn btn-primary">Sauvegarder la signature</button>
             </div>
           </div>
         </form>
       </div>
     </div>


@endsection