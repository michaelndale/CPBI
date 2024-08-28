@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12" style="margin:auto">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Le details de la FEB PETIT CAISSE (N° {{ $febData->numero }} ) </h4>
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
                                    <center> FICHE D’EXPRESSION DES BESOINS DE LA  PETITE CAISSE (FEB) N° {{ $febData->numero }} </center>
                                </H5>
                            </div>
                            <div class="col-sm-12">
                                    <table class="table table-bordered  table-sm fs--1 mb-0">
                                        <tr>
                                            <td>Composante/ Projet/Section: {{ ucfirst($febData->titles_projet ) }} </td>
                                            <td>   Date du dossier FEB : {{ date('d-m-Y', strtotime($febData->date_dossier))  }} ; Date limite : {{ date('d-m-Y', strtotime($febData->date_limite))  }}  </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                Compte caisse : {{ $febData->codes }} <br>
                                                Description : {{ $febData->libelle_compte }}
                                             
                                            </td>
                                            <td>
                                                  <label title="le calcul du taux progressif en fonction des numéros de FEB de tout le projet encours (Formulaire d'Engagement Budgétaire) qui est inférieur ou égal au numéro de FEB en cours.">Taux d’exécution global du projet: % </label>
                                          
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:50%">
                                                Description de la demande :
                                                {{ $febData->description }}
                                            </td>
                                            <td>
                                                Montant de la demande : {{ $febData->montant }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Créé par : {{ $febData->nom }} {{ $febData->prenom }} </td>
                                        </tr>



                                    </table>


                                    <form method="POST" action="{{ route('updatesignaturefebpetit') }}">
                                        @method('post')
                                        @csrf
                                        <input type="hidden" name="febid" id="febid" value="{{ $febData->id }}">


                                        <table>
                                            <table style="width:100%; margin:auto">
                                                <tr>
                                                    <td>
                                                        <center>
                                                            <u>Etablie par (AC/CE/CS)</u> :
                                                            <br>
                                                            {{ ucfirst($etablie_par->nom) }} {{ ucfirst($etablie_par->prenom) }}
                                                            <br>
                                                            @if(Auth::user()->id == $febData->etabli_par)
                                                            <input class="form-check-input" type="checkbox" name="etabli_par" {{ $febData->etabli_par_signature=="1"? 'checked':'' }} style="border:2px solid red"> <small>Cochez pour Poser la signature</small>
                                                            @endif
                                                            <input type="hidden" name="clone_etabli_par" value="{{ $febData->etabli_par_signature }}" />



                                                        </center>

                                                    </td>
                                                    <td>

                                                        <center>
                                                            <u>Vérifiée par (Comptable)</u> :
                                                            <br>
                                                            {{ $verifie_par->nom }} {{ $verifie_par->prenom }}
                                                            <br>

                                                            @if(Auth::user()->id == $febData->verifie_par)
                                                            <input class="form-check-input" type="checkbox" name="verifie_par" {{ $febData->verifie_par_signature=="1"? 'checked':'' }} style="border:2px solid red"> <small>Cochez pour Poser la signature</small>
                                                            @endif
                                                            <input type="hidden" name="clone_verifie_par" value="{{ $febData->verifie_par }}" />
                                                           

                                                        </center>

                                                    </td>

                                                    <td>
                                                        <center>
                                                            <u>Approuvée par (Chef de Composante/Projet/Section)</u>:
                                                            <br>
                                                            {{ $approuver_par->nom }} {{ $approuver_par->prenom }}
                                                            <br>

                                                            @if(Auth::user()->id == $febData->approuve_par)
                                                            <input class="form-check-input" type="checkbox"  name="approuve_par" {{ $febData->approuve_par_signature	=="1"? 'checked':'' }} style="border:2px solid red"> <small>Cochez pour Poser la signature</small>
                                                            @endif
                                                            <input type="hidden" name="clone_approuve_par" value="{{ $febData->approuve_par_signature }}" />
                                                           
                                                          
                                                        </center>

                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td>
                                                        <center>
                                                            @if ($febData->etabli_par_signature==1)
                                                            <img src="{{ asset($etablie_par->signature) }}" width="150px" />
                                                            @endif
                                                        </center>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            @if ($febData->verifie_par_signature==1)
                                                            <img src="{{ asset($verifie_par->signature) }}" width="150px" />
                                                            @endif
                                                        </center>
                                                    </td>

                                                    <td>
                                                        <center>
                                                            @if ($febData->approuve_par_signature	==1)
                                                            <img src="{{  asset($approuver_par->signature) }}" width="150px" />
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
                                        @if(Auth::user()->id == $febData->etabli_par || Auth::user()->id == $febData->	verifie_par || Auth::user()->id == $febData ->approuve_par )
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
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br> <br>

@endsection