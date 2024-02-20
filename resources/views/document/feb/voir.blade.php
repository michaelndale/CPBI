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
                            <table style=" width:80%">
                                <td> <img src="{{ asset('element/logo/logo.png') }}" alt="logo" height="100" /> </td>
                                <td>
                                    <center>
                                        <p class="mb-1">
                                        <h4> COMMUNAUTE DES EGLISES DE  PENTECOTE <br>AU BURUNDI "CEPBU"</h4>
                                        <center>Paix et Réconciliation ; Education, Santé, Eau potable, Programmes humanitaires, Environnement</center>
                                        </p>
                                    </center>
                                </td>
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
                                <td>Composante/ Projet/Section: <br> {{ ucfirst(Session::get('title')) }} </td>
                                <td>Période: {{ $dataFeb->periode }} </td>
                            </tr>
                            <tr>
                                <td>Activité: <br> {{ ucfirst($dataActivite->titre) }}</td>
                                <td>Date : {{ $dataFeb->datefeb }} </td>
                            </tr>
                            <tr>
                                <td>Ligne budgétaire: {{ $dataLigne->libelle }} <br>
                                    Taux d’exécution: {{ $sommelignpourcentage }} %</td>
                                <td rowspan="2">
                                    Références : <br>

                                    B.C: {{ $dataFeb->bc }} &nbsp; &nbsp;&nbsp; Facture: {{ $dataFeb->facture }} &nbsp;&nbsp;&nbsp;O.M : {{ $dataFeb->om }}

                                </td>
                            </tr>
                            <tr>
                                <td>Bénéficiaire :

                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

                <div class="py-2">
                  
                    <h5 class="font-size-15">Détails sur l’utilisation des fonds demandés :</h5>

                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>N<sup>o</sup></th>
                                    <th>Designation</th>
                                    <th>Montant</th>
                                </tr>
                            </thead><!-- end thead -->
                            <tbody>
                              @php
                                  $n=1;
                              @endphp
                                @foreach ($datElement as $datElements)
                                <tr>
                                    <td>{{$n }} </td>
                                    <td><h5 class="text-truncate font-size-14 mb-1">{{ $datElements->libellee }}</h5></td>
                                    <td> {{ number_format($datElements->montant,0, ',', ' ') }}</td>
                                </tr>
                                @php
                                    $n++
                                @endphp
                                @endforeach

                                <tr>
                                    <td colspan="2">Total</td>
                                    <td><h5 class="text-truncate font-size-14 mb-1">  {{ number_format($sommefeb,0, ',', ' ') }} </h5></td>
                                  
                                </tr>
                            </tbody>
                            
                        </table>
                        
                        <table>
                            <table style="width:80%; margin:auto">
                                <tr>
                                    <td><u><center>Etablie par (AC/CE/CS) :<br>  </u> {{ $etablienom->nom }} {{ $etablienom->prenom }}
                                    <br>
                                    <cente> 
                                        @php
                                            $imagefeb = Auth::user()->signature;
                                        @endphp
                                    
                                        @if ($dataFeb->acce_signe==1)
                                            <img src="{{  asset($imagefeb) }}" width="150px" />
                                        @endif
                                    </center> 
                                    </td>
                                    <td>
                                    <u>
                                        <center>
                                            Vérifiée par (Comptable) : <br>  </u> {{ $comptable_nom->nom }} {{ $comptable_nom->prenom }} <br>
                                            @php
                                                $imagefeb = Auth::user()->signature;
                                            @endphp
                                    
                                            @if ($dataFeb->comptable_signe==1)
                                                <img src="{{  asset($imagefeb) }}" width="150px" />
                                            @endif
                                    </center>
                                     </td>
                                </tr>

                                <tr>
                                    <td colspan="2"><center><u>Approuvée par (Chef de Composante/Projet/Section):<br>  </u> {{ $checcomposant_nom->nom }} {{ $checcomposant_nom->prenom }}<br></center> 
                                
                                        <center>
                                            @php
                                                $imagefeb = Auth::user()->signature;
                                            @endphp
                                        
                                            @if ($dataFeb->chef_signe==1)
                                                <img src="{{  asset($imagefeb) }}" width="150px" />
                                            @endif
                                        </center>
                                
                                </td>
                                </tr>
                                   
                            </table>
                        </table>
                        <hr>
                        <p><center>Paix et Réconciliation ; Education, Santé, Eau potable, Programmes humanitaires, Environnement</center></p>
                    </div>
                    <div class="d-print-none mt-4">

                        <form method="POST" action="{{ route('updatefeb') }}" > 

                            @method('post')
                            @csrf

                            <input type="hidden" name="febid" id="febid" value="{{ $dataFeb->id }}" >

                            @if(Auth::id() ==  $dataFeb->acce)
                            <input type="checkbox" name="accesignature" id="accesignature"  {{ $dataFeb->acce_signe=="1"? 'checked':'' }}> Poser la signature  
                            @endif

                            @if(Auth::id() ==  $dataFeb->comptable)
                            <input type="checkbox" name="comptablesignature" id="comptablesignature" {{ $dataFeb->comptable_signe=="1"? 'checked':'' }}> Poser la signature  
                            @endif

                            @if(Auth::id() ==  $dataFeb->chefcomposante)
                            <input type="checkbox" id="chefsignature" name="chefsignature"  {{ $dataFeb->chef_signe=="1"? 'checked':'' }}> Poser la signature  
                            @endif
                            
                            <div class="float-end">

                                <a href="javascript:window.print()" class="btn btn-success me-1"><i class="fa fa-print"> Imprimer</i></a>
                                <input type="submit"  name="save" id="dave" class="btn btn-primary w-md" value="Sauvegarder" />

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
@endsection