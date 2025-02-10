<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FICHE D’EXPRESSION DES BESOINS (FEB)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>RAPPORT D'UTILISATION DE L'AVANCE (FEB) N° {{ $dataFeb->numerofeb }}</h1>
    <input type="hidden" value="{{ $dataFeb->id }}" name="febid">
    <input type="hidden" value="{{ $dataFeb->periode }}" name="periode">
    <input type="hidden" value="{{ $dataFeb->descriptionf }}" name="description">
    <input type="hidden" value="{{ $dataFeb->datefeb }}" name="datefeb">
    <input type="hidden" value="{{ $dataFeb->ligne_bugdetaire }}" name="ligne_budgetaire">
    <input type="hidden" value="{{ $dataFeb->sous_ligne_bugdetaire }}" name="sous_ligne_budgetaire">
    <input type="hidden" value="{{ $dataFeb->beneficiaire }}" name="beneficiaire">
    <input type="hidden" value="{{ $dataFeb->autrebeneficiare }}" name="autrebenefiaire">

    <!-- Tableau des informations générales -->
    <table class="table-sm fs--1 mb-0">
        <thead>
            <tr>
                <th colspan="4">Informations Générales</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Composante/ Projet/Section :</strong></td>
                <td>{{ ucfirst($project->title ?? '') }}</td>
                <td><strong>Période :</strong></td>
                <td>{{ $dataFeb->periode }}</td>
            </tr>
            <tr>
                <td><strong>Activité :</strong></td>
                <td>{{ $dataFeb->descriptionf }}</td>
                <td><strong>Date FEB :</strong></td>
                <td>{{ date('d-m-Y', strtotime($dataFeb->datefeb)) }}</td>
            </tr>
            <tr>
                <td><strong>Code :</strong></td>
                <td>{{ $dataLigne->numero ?? '' }}  {{ $dataLigne->libelle ?? '' }}</td>
                <td><strong>Documents attachés :</strong></td>
                <td>
                    @if ($documents->isNotEmpty())
                        @foreach ($documents as $doc)
                            @if ($doc->urldoc)
                                <a href="{{ $doc->urldoc }}" target="_blank">{{ $doc->abreviation }}</a>,
                            @else
                                <span style="color:red;">{{ $doc->abreviation }}</span>,
                            @endif
                        @endforeach
                        {{-- Supprimer la dernière virgule --}}
                        {{ $loop->last ? '' : ',' }}
                    @else
                        Aucun document attaché
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Taux d’exécution globale de la ligne et sous-ligne budgétaire :</strong></td>
                <td>{{ $sommelignpourcentage }} %</td>
                <td><strong>Taux d’exécution globale sur le projet :</strong></td>
                <td>{{ $POURCENTAGE_GLOGALE }} %</td>
            </tr>
            <tr>
                <td><strong>Créé par :</strong></td>
                <td>{{ $createur->nom ?? '' }} {{ $createur->prenom ?? '' }}</td>
                <td><strong>Bénéficiaire :</strong></td>
                <td>{{ $onebeneficaire->libelle ?? 'Non spécifié' }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Tableau des détails -->
    <table class="table-sm fs--1 mb-0">
        <thead>
            <tr>
                <th>No</th>
                <th>Désignation des activités</th>
                <th>Description</th>
                <th>Unité</th>
                <th>Quantité</th>
                <th>Fréquence</th>
                <th>Prix Unitaire</th>
                <th>Prix Total</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($elementsFeb as $element)
                @php
                    $activite = \App\Models\Activity::find($element->libellee);
                    $titreActivite = $activite ? ucfirst($activite->titre) : '';
                    $total += $element->montant;
                @endphp
                <tr>
                    <td style="width:3%"> <input type="hidden" name="numerodetail[]" value="{{ $loop->iteration }}">{{ $loop->iteration }} </td>
                    <td><input type="hidden" value="{{ $activite->id }}" name="activiteid[]">  {{ $titreActivite }}</td>
                    <td>{{ ucfirst($element->libelle_description) }} <input type="hidden" value="{{  ucfirst($element->libelle_description)  }}" name="libelle[]"></td>
                    <td>{{ ucfirst($element->unite) }} <input type="hidden" name="unite[]" value="{{ $element->unite}}" > </td>
                    <td style="width:3%"><input type="number" class="quantity" name="quantity[]" value="{{ $element->quantite }}" data-id="{{ $loop->index }}"></td>
                    <td style="width:7%"><input type="number" class="frequency" name="frequency[]" value="{{ $element->frequence }}" data-id="{{ $loop->index }}"></td>
                    <td style="width:7%"><input type="number" class="unit-price" name="unitprice[]" value="{{ $element->pu }}" data-id="{{ $loop->index }}"></td>
                    <td style="width:8%" align="right"><span class="total-price" data-id="{{ $loop->index }}">{{ rtrim(rtrim(number_format($element->montant, 2, ',', ' '), '0'), ',') }}</span></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" style="text-align:right;">Total général</th>
                <th id="grand-total"> {{ rtrim(rtrim(number_format($total, 2, ',', ' '), '0'), ',') }}</th>
            </tr>
        </tfoot>
    </table>

    <!-- Champ caché pour stocker le grand total -->
    <input type="hidden" id="hidden-grand-total" name="GrandTotal" value="{{ $total }}">

    <br>
    <p><strong>Signature :</strong> ___________________________</p>
    <p><strong>Date :</strong> {{ date('d-m-Y') }}</p>
    <br>

    <script>
        // Fonction pour recalculer le prix total d'une ligne
        function calculateRowTotal(index) {
            const quantity = parseFloat(document.querySelector(`.quantity[data-id="${index}"]`).value) || 0;
            const frequency = parseFloat(document.querySelector(`.frequency[data-id="${index}"]`).value) || 0;
            const unitPrice = parseFloat(document.querySelector(`.unit-price[data-id="${index}"]`).value) || 0;

            // Calcul du prix total pour la ligne
            const totalPrice = quantity * frequency * unitPrice;

            // Afficher le prix total sans espaces
            document.querySelector(`.total-price[data-id="${index}"]`).textContent = totalPrice.toFixed(0);

            // Recalcul du total général
            calculateGrandTotal();
        }

        // Fonction pour recalculer le total général
        function calculateGrandTotal() {
            let grandTotal = 0;

            // Parcourir tous les éléments .total-price
            document.querySelectorAll('.total-price').forEach((totalPriceElement) => {
                // Supprimer les espaces et convertir en nombre
                const cleanedValue = parseFloat(totalPriceElement.textContent.replace(/\s/g, '')) || 0;

                // Ajouter à la somme totale
                grandTotal += cleanedValue;
            });

            // Mettre à jour le total général affiché
            document.getElementById('grand-total').textContent = grandTotal.toFixed(0);

            // Mettre à jour le champ caché avec le total général
            document.getElementById('hidden-grand-total').value = grandTotal.toFixed(0);
        }

        // Ajout d'événements aux champs input
        document.querySelectorAll('.quantity, .frequency, .unit-price').forEach((inputField) => {
            inputField.addEventListener('input', () => {
                const index = inputField.dataset.id;
                calculateRowTotal(index);
            });
        });

        // Initialisation du calcul du total général au chargement de la page
        calculateGrandTotal();
    </script>
</body>
</html>