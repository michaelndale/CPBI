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
                            <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Le details de la FEB (N°
                                {{ $dataFeb->numerofeb }} ) </h4>
                            <div class="page-title-right">
                                @if ($dataFeb->signale == 1)
                                    <div class="spinner-grow text-danger " role="status"
                                        style=" 
                                    width: 0.9rem; /* Définissez la largeur */
                                    height: 0.9rem; /* Définissez la hauteur */">
                                        <span class="sr-only">Loading...</span>
                                    </div> &nbsp; &nbsp;
                                @endif
                                <button type="button" class="btn btn-danger waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#composemodal"
                                    data-febid="{{ $dataFeb->id ? $dataFeb->id : '' }}"
                                    title="Signaler un FEB en cas de probleme">
                                    <i class="fab fa-telegram-plane ms-1"></i> Signalé FEB
                                </button>
                                @include('document.feb.message')
                                <div class="btn-toolbar float-end" role="toolbar">
                                    <div class="btn-group me-2 mb-2 mb-sm-0">
                                        <a href="{{ route('generate-pdf-feb', $dataFeb->id) }}"
                                            class="btn btn-primary waves-light waves-effect" title="Générer PDF"><i
                                                class="fa fa-print"></i> </a>
                                        <a href="{{ route('showannex', $cryptedId) }}"
                                            class="btn btn-primary waves-light waves-effect" title="Attacher le document"><i
                                                class="fas fa-paperclip"></i> </a>
                                        <a href="{{ route('showfeb', $cryptedId) }}"
                                            class="btn btn-primary waves-light waves-effect" title="Modifier le FEB"><i
                                                class="fa fa-edit"></i> </a>
                                        <a href="{{ route('listfeb') }}" class="btn btn-primary waves-light waves-effect"
                                            title="Liste de FEB"><i class="fa fa-list"></i></a>
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
                                                    Date : {{ date('d-m-Y', strtotime($dataFeb->datefeb)) }} ;

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    Code: {{ $dataLigne->numero }} <br>
                                                    Ligne budgétaire: {{ $dataLigne->libelle }}
                                                </td>


                                                <td>
                                                    Document en annexe : <br>
                                                
                                                @if ($getDocument->isNotEmpty()) 
                                                    @foreach ($getDocument as $doc) 
                                                        @if ($doc->urldoc === NULL)
                                                                <i class="fa fa-times-circle" style="color: red;" title="Aucun document disponible"></i> 
                                                                {{ $doc->abreviation }} ,
                                                        @else
                                                        <a href="#" onclick="viewDocument('{{ asset($doc->urldoc) }}'); return false;" title="{{ $doc->abreviation }}">
                                                            <i class="fa fa-link"></i>  {{ $doc->libelle }}
                                                        </a>
                                                         ,
                                                            @endif
                                                    @endforeach
                                                @else 
                                                    Pas de document disponible
                                                @endif
                                                
                                                
                                                




                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:50%">
                                                    Activité:
                                                    {{ $dataFeb->descriptionf }}
                                                </td>
                                                <td><label
                                                        title="le calcul du taux  progressif en fonction des numéros de FEB de cette ligne et sous ligne (Formulaire d'Engagement Budgétaire) qui est inférieur ou égal au numéro de FEB en cours.">Taux
                                                        d’exécution de la ligne et de ses sous-lignes budgétaires:
                                                        {{ $sommelignpourcentage }}% </label><br>
                                                    <label
                                                        title="le calcul du taux progressif en fonction des numéros de FEB de tout le projet encours (Formulaire d'Engagement Budgétaire) qui est inférieur ou égal au numéro de FEB en cours.">Taux
                                                        d’exécution global du projet: {{ $POURCENTAGE_GLOGALE }} % </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Créé par : {{ $createur->nom }} {{ $createur->prenom }} </td>
                                                <td>
                                                    Bénéficiaire :
                                                    @if (isset($onebeneficaire->libelle) && !empty($onebeneficaire->libelle))
                                                        {{ $onebeneficaire->libelle }}
                                                    @else
                                                        @if (isset($dataFeb->autresBeneficiaire) && !empty($dataFeb->autresBeneficiaire))
                                                            {{ $dataFeb->autresBeneficiaire }}
                                                        @else
                                                            Pas de bénéficiaire disponible.
                                                        @endif
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
                                                    <th style="  color:white"> <b>Designation des activités de la ligne</b>
                                                    </th>
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
                                                            <center>Prix Unitaire ({{ ucfirst($dataprojets->devise) }})
                                                            </center>
                                                        </b></th>
                                                    <th style="  color:white"> <b>
                                                            <center>Prix total ({{ ucfirst($dataprojets->devise) }})
                                                            </center>
                                                        </b> </th>
                                                </tr>
                                            </thead><!-- end thead -->
                                            <tbody>
                                                @php
                                                    $n = 1;
                                                @endphp

                                                @foreach ($datElement as $datElements)
                                                    <tr>
                                                        <td style="width:3%">{{ $n }} </td>
                                                        <td style="width:25%">
                                                            @php
                                                                $activite = DB::table('activities')
                                                                    ->orderby('id', 'DESC')
                                                                    ->Where('id', $datElements->libellee)
                                                                    ->get();
                                                                $activites = $activite->first(); // Récupère le premier élément, sinon null
                                                            @endphp
                                                            {{ $activites ? ucfirst($activites->titre) : '' }}
                                                            @if (!$activites)
                                                                <small class="text-danger">Erreur: Propriété 'titre'
                                                                    introuvable , Il se peut que l'utilisateur ait supprimé
                                                                    cet élément</small>
                                                            @endif
                                                        </td>

                                                        <td style="width:15%">
                                                            {{ ucfirst($datElements->libelle_description) }}
                                                        </td>
                                                        <td style="width:10%" align="center">{{ $datElements->unite }}
                                                        </td>
                                                        <td style="width:10%" align="center">{{ $datElements->quantite }}
                                                        </td>
                                                        <td style="width:10%" align="center">{{ $datElements->frequence }}
                                                        </td>
                                                        <td style="width:15%" align="right">
                                                            {{ number_format($datElements->pu, 0, ',', ' ') }}
                                                        </td>
                                                        <td style="width:20%" align="right">
                                                            {{ number_format($datElements->montant, 0, ',', ' ') }} </td>
                                                    </tr>
                                                    @php
                                                        $n++;
                                                    @endphp
                                                @endforeach

                                                <tr>
                                                    <td colspan="7" align="center"><b>
                                                            Total général</font>
                                                        </b></td>
                                                    <td align="right"><b>
                                                            {{ number_format($sommefeb, 0, ',', ' ') }} </font>
                                                        </b></h5>
                                                    </td>

                                                </tr>
                                            </tbody>

                                        </table>
                                        <br>

                                        <form method="POST" action="{{ route('updatefeb') }}">
                                            @method('post')
                                            @csrf
                                            <input type="hidden" name="febid" id="febid"
                                                value="{{ $dataFeb->id }}">

                                            <table>
                                                <table style="width:100%; margin:auto">
                                                    <tr>
                                                        <td>
                                                            <center>
                                                                <u>Etablie par (AC/CE/CS)</u> :
                                                                <br>
                                                                {{ ucfirst($etablienom->nom) }}
                                                                {{ ucfirst($etablienom->prenom) }}
                                                                <br>
                                                                @if (Auth::user()->id == $dataFeb->acce)
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="accesignature" id="accesignature"
                                                                        {{ $dataFeb->acce_signe == '1' ? 'checked' : '' }}
                                                                        style="border:2px solid red"> <small>Cochez pour
                                                                        Poser la signature</small>
                                                                @endif
                                                                <input type="hidden" name="clone_accesignature"
                                                                    value="{{ $dataFeb->acce_signe }}" />



                                                            </center>

                                                        </td>
                                                        <td>

                                                            <center>
                                                                <u>Vérifiée par (Comptable)</u> :
                                                                <br>
                                                                {{ $comptable_nom->nom }} {{ $comptable_nom->prenom }}
                                                                <br>

                                                                @if (Auth::user()->id == $dataFeb->comptable)
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="comptablesignature" id="comptablesignature"
                                                                        {{ $dataFeb->comptable_signe == '1' ? 'checked' : '' }}
                                                                        style="border:2px solid red"> <small>Cochez pour
                                                                        Poser la signature</small>
                                                                @endif
                                                                <input type="hidden" name="clone_comptablesignature"
                                                                    value="{{ $dataFeb->comptable_signe }}" />


                                                            </center>

                                                        </td>

                                                        <td>
                                                            <center>
                                                                <u>Approuvée par (Chef de Composante/Projet/Section)</u>:
                                                                <br>
                                                                {{ $checcomposant_nom->nom }}
                                                                {{ $checcomposant_nom->prenom }}
                                                                <br>

                                                                @if (Auth::user()->id == $dataFeb->chefcomposante)
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="chefsignature" name="chefsignature"
                                                                        {{ $dataFeb->chef_signe == '1' ? 'checked' : '' }}
                                                                        style="border:2px solid red"> <small>Cochez pour
                                                                        Poser la signature</small>
                                                                @endif
                                                                <input type="hidden" name="clone_chefsignature"
                                                                    value="{{ $dataFeb->chef_signe }}" />


                                                            </center>

                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td>
                                                            <center>
                                                                @if ($dataFeb->acce_signe == 1)
                                                                    <img src="{{ asset($etablienom->signature) }}"
                                                                        width="150px" />
                                                                @endif
                                                            </center>
                                                        </td>
                                                        <td>
                                                            <center>
                                                                @if ($dataFeb->comptable_signe == 1)
                                                                    <img src="{{ asset($comptable_nom->signature) }}"
                                                                        width="150px" />
                                                                @endif
                                                            </center>
                                                        </td>

                                                        <td>
                                                            <center>
                                                                @if ($dataFeb->chef_signe == 1)
                                                                    <img src="{{ asset($checcomposant_nom->signature) }}"
                                                                        width="150px" />
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
                                            @if (Auth::user()->id == $dataFeb->acce ||
                                                    Auth::user()->id == $dataFeb->comptable ||
                                                    Auth::user()->id == $dataFeb->chefcomposante)
                                                <div class="float-end">
                                                    <button type="submit" name="save" id="dave"
                                                        class="btn btn-primary w-md"> <i
                                                            class="fas fa-cloud-download-alt"> </i> Sauvegarder la
                                                        sinatgure </button>
                                                    <br>
                                                    <br>


                                                    <small>
                                                        <center> <i class="fa fa-info-circle"></i><br> Cochez la case
                                                            située en dessous <br> de votre nom si vous êtes accrédité <br>
                                                            pour apposer votre signature <br> puis cliquez sur le boutton
                                                            <br> sauvegarder la signature</center>
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

            <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="documentModalLabel">Visualisation du Document</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <iframe id="documentFrame" style="width: 100%; height: 500px;" frameborder="0"></iframe>
                            <div id="noDocumentMessage" style="color: red; display: none;">Il n'existe pas de document.</div>
                        </div>
                    </div>
                </div>
            </div>



            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
               
                function viewDocument(url) {
                    const documentFrame = document.getElementById('documentFrame');
                    const noDocumentMessage = document.getElementById('noDocumentMessage');
            
                    // Clear previous message
                    noDocumentMessage.style.display = 'none';
            
                    // AJAX request to check if the document exists
                    fetch(url)
                        .then(response => {
                            if (response.ok) {
                                documentFrame.src = url; // Load the PDF in the iframe
                                $('#documentModal').modal('show'); // Show the modal
                            } else {
                                noDocumentMessage.style.display = 'block'; // Show error message
                            }
                        })
                        .catch(error => {
                            console.error('Error checking document:', error);
                            noDocumentMessage.style.display = 'block'; // Show error message
                        });
                }
            </script>
            
            <!-- Include Bootstrap JS and CSS (needed for modal functionality) -->
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
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
                    var options = 'width=' + width + ',height=' + height + ',top=' + top + ',left=' + left +
                        ',resizable=yes,scrollbars=yes';

                    // Ouvrir la fenêtre popup
                    window.open(documentUrl, 'Document', options);
                }
            </script>
        @endsection
