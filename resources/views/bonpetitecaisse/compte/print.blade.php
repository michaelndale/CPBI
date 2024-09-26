<!DOCTYPE html>
<html>
<head>
    <title>Impression Rapport de Caisse</title>
    <style>
        /* Ajoutez des styles spécifiques pour l'impression ici */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Rapport de Caisse</h2>
    <p><strong>Code :</strong> {{ $historique->code }}</p>
    <p><strong>Description :</strong> {{ $historique->libelle }}</p>
    <p><strong>Solde :</strong> {{ number_format($historique->solde, 0, ',', ' ') }}</p>
    <p><strong>Créé par :</strong> {{ $historique->personnel_prenom }}</p>
    <p><strong>Créé le :</strong> {{ $historique->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Modifié le :</strong> {{ $historique->updated_at->format('d/m/Y H:i') }}</p>

    <br>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>N<sup>o</sup></th>
                <th>Libellé</th>
                <th>Imput</th>
                <th>Débit</th>
                <th>Crédit</th>
                <th>Solde</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($historiqueCompte as $transaction)
                <tr>
                    <td>{{ $transaction->date }}</td>
                    <td>{{ $transaction->numero }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td>{{ $transaction->input }}</td>
                    <td>{{ number_format($transaction->debit, 0, ',', ' ') }}</td>
                    <td>{{ number_format($transaction->credit, 0, ',', ' ') }}</td>
                    <td>{{ number_format($transaction->solde, 0, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
