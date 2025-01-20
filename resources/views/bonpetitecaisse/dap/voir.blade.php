@extends('layout/app')
@section('page-content')
@php
$cryptedId = Crypt::encrypt($data->id);
@endphp
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Le details de la DAP (N° {{ $data->numerodap  }} ) </h4>
                        @if (session()->has('id'))
                            <div class="page-title-right">
                                &nbsp; &nbsp;
                                <div class="btn-toolbar float-end" role="toolbar">
                                    <div class="btn-group me-2 mb-2 mb-sm-0">
                                        <a href="{{ route('showdappc', $cryptedId ) }}" class="btn btn-primary waves-light waves-effect" title="Modifier le DAP"><i class="fa fa-edit"></i> </a>
                                        <a href="{{ route('dappc') }}" class="btn btn-primary waves-light waves-effect" title="Liste de DAP "><i class="fa fa-list"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                                        <img src="{{ asset('element/logo/logo.png') }}" alt="logo" height="50" />
                                    </td>
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
                            <center>
                                Demande d'Autorisation de Paiement (DAP) N° {{ $data->numerodap  }}/{{ date('Y', strtotime($data->created_at)) }}
                            </center>
                        </H5>

                        <div class="col-sm-12">
                            <table class="table table-striped table-sm fs--1 mb-0 table-bordered  ">
                                <tr>
                                    <td style="width:55%"> Service: {{ $data->titres }}</td>
                                    <td>
                                        Référence: FEB n<sup>o</sup>:
                                        @php
                                        foreach ($datafebElement as $key => $datafebElements) {
                                        echo '['.$datafebElements->referencefeb.']';

                                        if ($key < count($datafebElement) - 1) { echo ',' ; } } @endphp </td>
                                </tr>
                                <tr>
                                    <td> Composante/ Projet/Section: {{ $data->projettitle }}</td>
                                    <td> Lieu: {{ $data->lieu }} </td>
                                </tr>

                                <tr>
                                    <td>
                                        <table>
                                            <td>
                                                <label title="OV"> &nbsp; Moyen de Paiement : OV </label>
                                            </td>
                                            <td>
                                                <input class="form-check-input" type="checkbox" readonly @if($data->ov==1) checked @else @endif />
                                            </td>
                                            <td> &nbsp; &nbsp; &nbsp; &nbsp; Cheque: {{ $data->cho }} ; Etabli au nom : {{ $data->etablie_aunom}}</td>
                                        </table>
                                    </td>
                                    <td> Compte bancaire : {{ $data->comptebanque }} ; Banque : {{ $data->banque }}</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>


                                <tr>
                                    <td>
                                        Créé le {{ date('d-m-Y', strtotime($data->created_at))  }}
                                    </td>
                                    <td>
                                        Taux d’exécution globale du projet: {{ $POURCENTAGE_GLOGALE }}%
                                    </td>
                                </tr>

                            </table>
                            <br>

                            <font size="2px"> <u>Synthese sur l'utilisation des fonds demandes(Vr details sur FB en annexe)</u></font>

                            <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th>Numéro du F.E.B</th>
                                        <th style="width:30%">Description de la demande </th>
                                        <th><center>AC/CE/CS </center> </th>
                                        <th><center>Comptable </center> </th>
                                        <th><center>Chef de Composante/Projet/Section </center> </th>
                                        <th><center>Montant du F.E.B P.C</center></th>
                                        </tr>'

                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach ($datafebElement as $datafebElements)
                                        @php
                                            $acc = $datafebElements->etabli_par_signature == 1 
                                                ? '<i class="fa fa-check-circle text-primary"></i>' 
                                                : '<i class="fa fa-times-circle text-danger"></i>';
                                            
                                            $Comptable = $datafebElements->verifie_par_signature == 1 
                                                ? '<i class="fa fa-check-circle text-primary"></i>' 
                                                : '<i class="fa fa-times-circle text-danger"></i>';
                                            
                                            $Chef = $datafebElements->approuve_par_signature == 1 
                                                ? '<i class="fa fa-check-circle text-primary"></i>' 
                                                : '<i class="fa fa-times-circle text-danger"></i>';
                                        @endphp 

                                        <tr>
                                            <td> {{ $datafebElements->numero }}</td>
                                            <td> {{ $datafebElements->description }}</td>
                                            <td align="center"> {!! $acc !!} </td>
                                            <td align="center"> {!! $Comptable !!} </td>
                                            <td align="center"> {!! $Chef !!} </td>
                                            <td align="right"> {{ number_format($datafebElements->montant , 0, ',', ' ') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>


                            </table>

                            <br>

                            <form method="POST" action="{{ route('updatesignaturedappc') }}">
                                @method('post')
                                @csrf
                                <input type="hidden" name="dapid" value="{{ $data->id }}">

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

                                                @if(Auth::user()->id == $data->demande_etablie )
                                                <input class="form-check-input" type="checkbox" name="demandeetabliesignature" {{ $data->demande_etablie_signe=="1"? 'checked':'' }} style="border:2px solid red">
                                                @endif
                                                <small> Cochez pour Poser la signature</small> 
                                                <input type="hidden" name="clone_demandeetabliesignature" value="{{ $data->demande_etablie_signe }}" />

                                                <br>



                                                @if ($data->demande_etablie_signe==1)
                                                <img src="{{ asset($Demandeetablie->signature) }}" width="120px" />
                                                @endif


                                            </center>
                                        </td>
                                        <td width="15%">Date
                                            @if(Auth::user()->id == $data->demande_etablie )
                                            <input type="text" value="{{ $data->demande_etablie_date }}" name="dated" style="width:45%; border:none; border-bottom: 2px dotted #000;" >
                                            @else

                                            <input type="hidden" value="{{ $data->demande_etablie_date }}" name="dated_an">
                                            {{ $data->demande_etablie_date }}
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Vérifiée par : (<small> Chef de Comptable </small> )
                                            <br>
                                            Noms: {{ ucfirst($verifierpar->nom) }} {{ ucfirst($verifierpar->prenom) }}
                                        </td>

                                        <td>
                                            <center>
                                                <!-- poser signature -->
                                                @if(Auth::user()->id == $data->verifier )
                                                <input class="form-check-input" type="checkbox" name="verifierparsignature" {{ $data->verifier_signe=="1"? 'checked':'' }} style="border:2px solid red">
                                                @endif

                                                <small> Cochez pour Poser la signature</small> 
                                                <br>

                                                <input type="hidden" name="clone_verifierparsignature" value="{{ $data->verifier_signe }}" />

                                                @if ($data->verifier_signe==1)
                                                <img src="{{  asset($verifierpar->signature) }}" width="120px" />
                                                @endif
                                            </center>

                                        </td>
                                        <td>Date :
                                            @if(Auth::user()->id == $data->verifier )
                                            <input type="hidde" value="{{ $data->verifier_date }}"  name="datev" style="width:45%; border:none; border-bottom: 2px dotted #000;" >

                                            @else

                                            <input type="hidden" value="{{ $data->verifier_date }}" name="datev_an">
                                            {{ $data->verifier_date }}
                                            @endif

                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Approuveee par : <small> (Chef de Service)</small> <br>

                                            Noms: {{ ucfirst($approuverpar->nom) }} {{ ucfirst($approuverpar->prenom) }} </td>

                                        <td>
                                            <center>
                                                
                                                <!-- poser signature -->
                                                @if(Auth::user()->id == $data->approuver)
                                                <input class="form-check-input" type="checkbox" name="approuverparsignature" {{ $data->approuver_signe=="1"? 'checked':'' }} style="border:2px solid red">
                                                @endif
                                                <small> Cochez pour Poser la signature</small> 
                                                <input type="hidden" name="clone_approuverparsignature" value="{{ $data->approuver_signe }}" />

                                                <br>

                                                @if ($data->approuver_signe==1)
                                                <img src="{{ asset( $approuverpar->signature) }}" width="120px" />
                                                @endif
                                            </center>


                                        </td>
                                        <td>Date :
                                            @if(Auth::user()->id == $data->approuver)
                                            <input type="hidde" value="{{ $data->approuver_date }}" name="datea" style="width:45%; border:none; border-bottom: 2px dotted #000;" >
                                        </td>
                                        @else
                                        {{ $data->approuver_date }}
                                        <input type="hidden" value="{{ $data->approuver_date }}" name="datea_an">
                                        {{ $data->approuver_date }}
                                        @endif
                                        </td>


                                    </tr>


                                </table>

                                <br>

                                <table class="table table-bordered  table-sm">
                                    <tr>
                                        <td colspan="3">Autorisation de Paiement</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">

                                        Autorise le :    <input type="hidde" value="{{ date('d-m-Y', strtotime($data->dateautorisation))  }}" name="dateautorisation" style="width:7%; border:none; border-bottom: 2px dotted #000;" >
                                          
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <center>
                                                Responsable Administratif et Financier

                                                <br>
                                                {{ ucfirst($responsable->nom) }} {{ ucfirst($responsable->prenom) }}
                                               <br>
                                                <!-- poser signature -->
                                                @if(Auth::user()->id == $data->autoriser)
                                                <input class="form-check-input" type="checkbox" name="responsablesignature" {{ $data->autoriser_signe=="1"? 'checked':'' }} style="border:2px solid red">
                                                @endif
                                                
                                               
                                                <small>Cochez pour Poser la signature</small> <input type="hidden" name="clone_responsablesignature" value="{{ $data->autoriser_signe }}" />



                                                @if ($data->autoriser_signe==1)
                                                <br>

                                                <img src="{{  asset($responsable->signature) }}" width="120px" />
                                            </center>
                                            @endif


                                        </td>
                                        <td>
                                            <center>
                                                Chef des Programmes

                                                <br>@if($chefprogramme)
                                                {{ ucfirst($chefprogramme->nom) }} {{ ucfirst($chefprogramme->prenom) }}
                                                @else
                                                <!-- Code alternatif si $chefprogramme est null -->
                                                <p>Le chef de programme n'a pas été trouvé.</p>
                                                @endif
                                                <!-- POser signature -->
                                                 <br>
                                                @if(Auth::user()->id == $data-> chefprogramme)
                                                <input class="form-check-input" type="checkbox" name="chefprogrammesignature" {{ $data->chefprogramme_signe=="1"? 'checked':'' }} style="border:2px solid red">
                                                @endif
                                                <input type="hidden" name="clone_chefprogrammesignature" value="{{ $data->chefprogramme_signe }}" />

                                                <small>Cochez pour Poser la signature</small> 

                                                

                                                @if ($data->chefprogramme_signe==1)
                                                <br>

                                                <img src="{{ asset($chefprogramme->signature) }}" width="120px" />
                                            </center>
                                            @endif

                                        </td>

                                        <td align="center">Secretaire General de la CEPBU

                                            

                                            <input type="hidden" name="clone_secretairesignature" value="{{ $data->secretaire_signe }}" />
                                            <input type="hidden" name="ancient_date_autorisation" value="{{ $data->dateautorisation }}" />
                                            <br>

                                            {{ ucfirst($secretaire->nom) }} {{ ucfirst($secretaire->prenom) }}

                                            <br>

                                            @if(Auth::user()->id == $data->secretaire)
                                            <input class="form-check-input" type="checkbox" name="secretairesignature" {{ $data->secretaire_signe=="1"? 'checked':'' }} style="border:2px solid red">
                                            <small>Cochez pour Poser la signature</small> 

                                            @endif
                                            <br>

                                            @if ($data->secretaire_signe==1)

                                            <center>
                                                <img src="{{  asset($secretaire->signature) }}" width="120px" />
                                            </center>
                                            @endif

                                        </td>
                                    </tr>

                                 <!--   <tr>
                                        <td colspan="4">Observation/Instructions du SG <br>


                                            @if (is_null($data->observation))

                                            @else
                                            {{ $data->observation  }}
                                            @endif

                                            <br> <a href="javascript:void(0);" class="dropdown-item notify-item" data-bs-toggle="modal" data-bs-target="#EditobservationModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <span class="me-2 text-900" data-feather="user">
                                                    <small>( <i class="fa fa-edit"></i> Modifier l'observstion )</small>
                                            </a>

                                        </td>
                                    </tr>  -->
                                </table>

                                <input type="hidden" name="montantsFeb" value="{{  $datafebElems->montants }}">
                                <input type="hidden" name="compteidsFeb" value="{{ $datafebElems->compteids }}">

                                <hr>
                                <center>

                                    <small>{{ $dateinfo->piedpage }}</small>

                                </center>

                                <br>



                                <div class="float-end">
                                    <!-- <a href="{{ route('generate-pdf-feb', $data->id) }}" class="btn btn-primary">Générer PDF</a> n-->


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
        <br>
        <br>
    </div>
</div>

<!-- ici -->


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