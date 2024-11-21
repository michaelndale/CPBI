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
                <div class="card shadow-none border border-300 mb-3" style="margin:auto">
                    <div class="card-header p-4 border-bottom border-300 bg-soft">
                        <h4 class="text-center">
                            <i class="mdi mdi-book-open-page-variant-outline"></i> 
                            RAPPORT DE RAPPROCHEMENT DES AVANCES, Nº {{ $rapport->numero }}/{{ date('Y', strtotime($rapport->created_at)) }}
                          

                            <button onclick="printWithHeader('table-container')" class="btn btn-primary btn-sm"> <i class="fa fa-print"></i>  Imprimer </button>

                            
                        </h4>
                    </div>

                    <div class="card-body p-0" id="table-container" style="overflow-y: auto;">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                    <tbody>
                                        <tr>
                                            <td>Service : {{ $rapport->title_service }}</td>
                                            <td>Programme Projet : {{ Session::get('title') }}</td>
                                            <td>Periode {{ date('d-m-Y', strtotime($rapport->datede)) }} Au {{ date('d-m-Y', strtotime($rapport->dateau)) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nombre d'avances émises : {{ $datailrapport->count() }}</td>
                                            <td>Nombre d’avances justifiées : {{ $datailrapport->where('dapjustifier', '1')->count() }}</td>
                                            <td>Avances non justifiées : {{ $datailrapport->where('dapjustifier', '0')->count() }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Nom du Bénéficiaire</th>
                                            <th class="text-center">Nº DJA</th>
                                            <th>Compte Bancaire</th>
                                            <th>Ov/Cheque</th>
                                            <th class="text-center">Montant de l’avance</th>
                                            <th class="text-center">Montant justifié</th>
                                            <th class="text-center">Montant non justifié</th>
                                            <th class="text-center">Retard (J)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalMontantAvance = 0;
                                            $totalMontantJustifie = 0;
                                            $totalMontantNonJustifie = 0;
                                            $totalRetardJours = 0;
                                        @endphp
                                        @forelse ($datailrapport as $datailrapports)
                                        @php
                                            $montantAvance = $datailrapports->montant_avance ?? 0;
                                            $montantJustifie = $datailrapports->montant_utiliser ?? 0;
                                            $montantNonJustifie = $montantAvance - $montantJustifie;
                                            $totalMontantAvance += $montantAvance;
                                            $totalMontantJustifie += $montantJustifie;
                                            $totalMontantNonJustifie += $montantNonJustifie;
                                            $nombreJour = $datailrapports->duree_avance;
                                    
                                            $retard = '-';
                                            if (!empty($datailrapports->date_fond_debourser_par) && !empty($datailrapports->date_reception_pieces_justificatives)) {
                                                $dateFondDebourserPar = new DateTime($datailrapports->date_fond_debourser_par); // A
                                                $dateFondsDemandePar = new DateTime($datailrapports->date_reception_pieces_justificatives); // B
                                                
                                                $diffDays = $dateFondDebourserPar->diff($dateFondsDemandePar)->days; // B - A
                                                $retard = $diffDays - $nombreJour; // (B - A) - C
                                                $totalRetardJours += $retard;
                                            }
                                        @endphp
                                        
                                        <tr>
                                            <td>{{ !empty($datailrapports->created_at) ? date('d-m-Y', strtotime($datailrapports->created_at)) : '-' }}</td>
                                            <td>{{ $datailrapports->benef_nom }} {{ $datailrapports->benef_prenom }}</td>
                                            <td class="text-center">{{ $datailrapports->numerodjas }}</td>
                                            <td>{{ $datailrapports->comptabiliteb }}</td>
                                            <td>{{ $datailrapports->cheque }}</td>
                                            <td align="right">{{ number_format($montantAvance, 0, ',', ' ') }}</td>
                                            <td align="right">{{ number_format($montantJustifie, 0, ',', ' ') }}</td>
                                            <td align="right">{{ number_format($montantNonJustifie, 0, ',', ' ') }}</td>
                                            <td align="center" style="color: {{ is_numeric($retard) && $retard < 0 ? 'red' : 'black' }};">
                                                {{ is_numeric($retard) ? abs($retard) . ' jours' : '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Ceci est vide</td>
                                        </tr>
                                    @endforelse
                            
                                     
                                
                                        <tr>
                                            <td colspan="5"><strong>Total</strong></td>
                                            <td align="right"><strong>{{ number_format($totalMontantAvance, 0, ',', ' ') }}</strong></td>
                                            <td align="right"><strong>{{ number_format($totalMontantJustifie, 0, ',', ' ') }}</strong></td>
                                            <td align="right"><strong>{{ number_format($totalMontantNonJustifie, 0, ',', ' ') }}</strong></td>
                                            <td class="text-center"><strong>{{ abs($totalRetardJours) }} jours</strong></td>
                                        </tr>
                                
                                        <tr>
                                            <td colspan="9">Observations :</td>
                                        </tr>
                                    </tbody>
                                </table>
                                

                                <table style="width:100%; margin-top: 10px;">
                                    <tr>
                                        <td class="text-center">Etabli par : <br> {{ $rapport->estab_nom }}</td>
                                        <td class="text-center">Vérifié par : <br> {{ $rapport->estab_prenom }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card-body">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-alert-outline me-2"></i>Erreur lors de la récupération des données. Aucun classement trouvé pour les critères spécifiés de votre recherche.
                        <a href="{{ route('rapprochement') }}">Retour <i class="fa fa-link"></i></a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script>
        function printWithHeader(contentId, options = {}) {
            // Définir les options par défaut
            const defaultOptions = {
                title: 'RAPPORT DE RAPPROCHEMENT DES AVANCES',
                logoSrc: "{{ asset('element/logo/logo.png') }}",
                showLogo: true,
                headerText: "{{ $dateinfo->entete }}",
                subHeaderText: "{{ $dateinfo->sousentete }}",
                reportNumber: "{{ $rapport->numero }}/{{ date('Y', strtotime($rapport->created_at)) }}",
                footerText: "{{ $dateinfo->piedpage }}",
                backgroundColor: "white",
                textColor: "black",
                logoHeight: 60
            };
    
            // Fusionner les options fournies avec les options par défaut
            const settings = {...defaultOptions, ...options};
    
            // Récupérer le contenu à imprimer
            const printContents = document.getElementById(contentId).innerHTML;
    
            // Construire l'en-tête avec des options personnalisées
            const headerHTML = `
                <html>
                <head>
                    <title>${settings.title}, Nº ${settings.reportNumber}</title>
                </head>
                <body style="background-color: ${settings.backgroundColor}; color: ${settings.textColor}; padding: 10px;">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 5px;">
                        ${settings.showLogo ? `<img src="${settings.logoSrc}" alt="logo" height="${settings.logoHeight}" />` : ''}
                        <h2 style="margin: 0;">${settings.headerText}</h2>
                    </div>
                    <p style="text-align: center; margin: 0;">${settings.subHeaderText}</p>
                    <hr>
                    <h4 style="text-align: center;">${settings.title}, Nº ${settings.reportNumber}</h4>
                `;
    
            // Construire le pied de page avec des options personnalisées
            const footerHTML = `
                <hr style="width:100%; margin-top: 20px; border-color:#c0c0c0;" />
                <center><small>${settings.footerText}</small></center>
                </body>
                </html>
            `;
    
            // Sauvegarder le contenu original de la page
            const originalContents = document.body.innerHTML;
    
            // Injecter l'en-tête, le contenu à imprimer et le pied de page dans le corps de la page avec le style de fond et couleur de texte
            document.body.innerHTML = `
                <div style="background-color: ${settings.backgroundColor}; color: ${settings.textColor}; padding: 10px;">
                    ${headerHTML}
                    ${printContents}
                    ${footerHTML}
                </div>
            `;
    
            // Lancer la boîte de dialogue d'impression
            window.print();
    
            // Rétablir le contenu original
            document.body.innerHTML = originalContents;
    
            // Recharger la page pour s'assurer que tout est réinitialisé
            window.location.reload();
        }
    </script>
    
    
    
    

@endsection
