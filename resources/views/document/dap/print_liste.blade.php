<table style="width: 100%; border-collapse: collapse; font-size: 12px;">
    <thead>
        <tr>
            <td style="border: none; text-align: center; vertical-align: middle;" colspan="12">
                <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <img src="{{ asset('element/logo/logo.png') }}" alt="logo" height="50" />
                    <h1 style="margin: 0;">{{ $dateinfo->entete }}</h1>
                </div>
                <p style="margin: 0;">{{ $dateinfo->sousentete }} </p>
                <hr style="width:80%">

            </td>
        </tr>
    </thead>
    
    <thead>
        <tr>
           <td style="border: none; text-align: center; vertical-align: middle;" colspan="12"> 
            
            <h2> Liste des  Demande d'Autorisation de Paiement "DAP"</h2>
            <h3>Projet : {{ Session::get('title') }} </h3>
         
        </td> 
        </tr>
    </thead>

    <thead>
        <th style="padding: 1px; border: 1px solid #ddd;">N<sup>o</sup> DAP</th>
        <th style="padding: 1px; border: 1px solid #ddd;">N<sup>o</sup> FEB</th>
        <th style="padding: 1px; border: 1px solid #ddd;">Montant FEB</th>
        <th style="padding: 1px; border: 1px solid #ddd;">Lieu</th>
        <th style="padding: 1px; border: 1px solid #ddd;">OV/Cheque</th> <!-- Corrected to OV/Cheque -->
        <th style="padding: 1px; border: 1px solid #ddd;">Compte</th>
        <th style="padding: 1px; border: 1px solid #ddd;">Banque</th>
        <th style="padding: 1px; border: 1px solid #ddd;">Établie au nom</th> <!-- Corrected to "Établie au nom" -->
        <th style="padding: 1px; border: 1px solid #ddd;">Avance</th>
        <th style="padding: 1px; border: 1px solid #ddd;">Justifiéé</th>
        <th style="padding: 1px; border: 1px solid #ddd;">Créé le</th> <!-- Corrected to "Créé le" -->
        <th style="padding: 1px; border: 1px solid #ddd;">Créé par</th> <!-- Corrected to "Créé par" -->
    </thead>
    <tbody>
        {!! $output !!}
    </tbody>
</table>

<br><br>

<center><small>{{ $dateinfo->piedpage }}</small> </center> 

<script>
    // Appel direct de la boîte d'impression au chargement de la page
    window.onload = function() {
        window.print();
    }
</script>

<style>
    /* Styles pour l'impression */
    @media print {
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 1px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Optionnel : Réduire la taille du texte pour l'impression */
        body {
            font-size: 8px;
        }

        /* Masquer les éléments non nécessaires lors de l'impression */
        body * {
            visibility: hidden;
        }

        table, table * {
            visibility: visible;
        }

        table {
            position: absolute;
            top: 0;
        }
    }
</style>
