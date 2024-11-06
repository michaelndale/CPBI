@extends('layout/app')
@section('page-content')
    <style type="text/css">
        .has-error {
            border: 1px solid red;
        }
    </style>
        

        
    <div class="main-content">
        <div class="page-content">
            @if(isset($datailrapport) && !$datailrapport->isEmpty())
       
            <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style="margin:auto">
                <div class="card-header p-4 border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-end">
                        <div class="col-12 col-md">
                            <h3>
                                <center> <i class="mdi mdi-book-open-page-variant-outline"></i> RAPPORT DE RAPPROCHEMENT DES
                                    AVANCES, Nº {{ $rapport->numero }}/{{ date('Y', strtotime($rapport->created_at)) }}
                                </center>
                            </h3>
                        </div>
                    </div>
                </div>

         
                <div class="card-body p-0" id="table-container" style="overflow-y: auto;">
                    <div class="card">
                        <div class="table-responsive">
                            <div class="table-responsive" id="table-container" style="overflow-y: auto;">
                                <table class="table table-bordered table-striped table-sm fs--1 mb-0"
                                    id="show_all_activite">
                                    <tbody>
                                        <tr>
                                            <td>Service : {{ $rapport->title_service }} </td>
                                            <td>Programme Projet : {{ Session::get('title') }} </td>
                                            <td>Periode {{ date('d-m-Y', strtotime($rapport->datede)) }} Au
                                                {{ date('d-m-Y', strtotime($rapport->dateau)) }} </td>
                                        </tr>

                                        <tr>
                                            <td>Nombre d'avances emises : {{ $datailrapport->count() }} </td>
                                            <td>Nombre d’avances justifiées :
                                                {{ $datailrapport->where('dapjustifier', '=', '1')->count() }} </td>
                                            <td>#Avances non justifiées :
                                                {{ $datailrapport->where('dapjustifier', '=', '0')->count() }} </td>
                                        </tr>


                                    </tbody>
                                </table>

                                <table class="table table-bordered table-striped table-sm fs--1 mb-0" id="show_all_activite">
                                    <tbody>
                                        <tr>
                                            <th>Date </th>
                                            <th>Nom du Bénéficiaire </th>
                                            <th><center>Nº DJA</center></th>
                                            <th>Compte Bancaire </th>
                                            <th>Ov/Cheque</th>
                                            <th><center>Montant <br> de l’avance</center></th>
                                            <th><center>Montant <br>justifié</center> </th>
                                            <th><center>Montant non <br> justifié</center> </th>
                                            <th><center>Retard (J)</center> </th>
                                        </tr>
                                
                                        @php
                                            // Initialiser les totaux
                                            $totalMontantAvance = 0;
                                            $totalMontantJustifie = 0;
                                            $totalMontantNonJustifie = 0;
                                        @endphp
                                
                                        @forelse ($datailrapport as $datailrapports)
                                            <tr>
                                                <td>
                                                    @if (!empty($datailrapports->created_at))
                                                        {{ date('d-m-Y', strtotime($datailrapports->created_at)) }}
                                                    @endif
                                                </td>
                                                <td> {{ $datailrapports->benef_nom }} {{ $datailrapports->benef_prenom }} </td>
                                                <td align="center"> {{ $datailrapports->numerodjas }} </td>
                                                <td>{{ $datailrapports->comptabiliteb }} </td>
                                                <td>{{ $datailrapports->cheque }} </td>
                                
                                               
                                                <td align="right">{{ $datailrapports->montant_avance_un }}</td>
                                
                                                <td align="right">
                                                    {{ $datailrapports->montant_utiliser}}
                                                </td>
                                
                                                <td align="right">
                                                    {{ $datailrapports->montant_avance_un - $datailrapports->montant_utiliser }}
                                                </td>
                                
                                                <td align="center">
                                                    @php
                                                        // Convertir la date de création en objet DateTime
                                                        $dateCreation = new DateTime($datailrapports->datecreation);
                                
                                                        // Vérifier si la date d'autorisation est vide, sinon utiliser la date du jour
                                                        $dateAutorisation = $datailrapports->dateautorisations ? new DateTime($datailrapports->dateautorisations) : new DateTime();
                                
                                                        // Calculer la différence entre les deux dates
                                                        $difference = $dateCreation->diff($dateAutorisation);
                                
                                                        // Extraire la différence en jours
                                                        $differenceEnJours = $difference->days;

                                                        

                                
                                                        // Vérifier si la date d'autorisation est vide
                                                        $dateAutorisationVide = empty($datailrapports->dateautorisations);
                                                    @endphp
                                
                                                    <!-- Afficher la différence en jours, en rouge si la deuxième date n'est pas définie -->
                                                    <p style="color: {{ $dateAutorisationVide ? 'red' : 'black' }};">
                                                        {{ $differenceEnJours -> $datailrapports->duree_avance}} jours
                                                    </p>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9">Ceci est vide</td>
                                            </tr>
                                        @endforelse
                                
                                        <!-- Afficher les totaux -->
                                        <tr>
                                            <td colspan="5">Total</td>
                                            <td align="right">{{ $totalMontantAvance }}</td>
                                            <td align="right">{{ $totalMontantJustifie }}</td>
                                            <td align="right">{{ $totalMontantNonJustifie }}</td>
                                            <td></td>
                                        </tr>
                                
                                        <tr>
                                            <td colspan="8">
                                                Observations :
                                            </td>
                                        </tr>
                                
                                        <table style="width:100%">
                                            <tr>
                                                <td align="center">Etabli par: <br> {{ $rapport->estab_nom }}</td>
                                                <td align="center">Vérifié par : <br> {{ $rapport->estab_prenom }}</td>
                                            </tr>
                                        </table>
                                    </tbody>
                                </table>
                                


                            </div>
                        </div>
                    </div>
                </div>
                @else

                <div class="card-body"><div class=""><div class="alert alert-warning alert-dismissible fade show" role="alert"> <i class="mdi mdi-alert-outline me-2"></i>Erreur lors de la récupération des données , Aucun classement trouvé pour les critères spécifiés a votre recherche 
                    . <a href="{{ route('rapprochement') }}">Retour <i class="fa fa-link"></i> </a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div></div> </div>
                @endif
                    </div> <!-- container-fluid -->
        </div
      
    </div>
@endsection
