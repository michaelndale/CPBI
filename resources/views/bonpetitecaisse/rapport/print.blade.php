<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport de caisse : {{ $classement->codes }} : {{ $classement->libelles }} Num: {{ $classement->numero_groupe }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
            font-size: 12px
        }

        /* Styles pour le pied de page */
        footer {
            background-color: white;
            /* Couleur d'arrière-plan */
            padding: 0px;
            /* Espacement intérieur */
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        /* Styles pour le contenu */
        .main-content {

            margin-bottom: 20px;

        }

        

        /* Ajout de marge en bas pour compenser la hauteur du pied de page */
        .content-before-footer {
            padding-bottom: 0;
        }

        #mytable  {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px
        }

        #signature {
            
            font-size: 12px
        }


        #mytable th,
        #mytable td {
            border: 1px solid #ddd;
            padding: 2px;
            text-align: left;
            font-size: 0.9em;
        }

        #mytable th {
            background-color: #f2f2f2;
        }

        #mytable tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #mytable tr:hover {
            background-color: #ddd;
        }




        /* Exemple de CSS */
        body {
            font-family: 'Roboto', sans-serif;
          
            /* Utilisation d'une police web légère */
        }

        h1,
        h2,
        h3 {
            font-family: 'Open Sans', sans-serif;
            

            /* Utilisation d'une autre police web légère pour les titres */
        }
        p{
            font-size: 12px
        }
    </style>

</head>
</head>

<body>

 
        <table style="width:95%; margin-top:-30px" align="center">
            <tr>
                <td style="width:6%" align="right">
                     <img src="{{ asset('element/logo/logo.png') }}" alt="logo" height="45px" />
                </td>
                <td align="center">
                    <h2>{{ $infoglo->entete }}</h2>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center>
                        <hr style="border-width: 0.1px;"> 
                        <p>  {{ $infoglo->sousentete }}  <p>
                    </center>
                </td>
            </tr>
        </table>

    <!-- Pied de page fixe -->
    <footer id="page-footer">
        <small>{{ $infoglo->piedpage }}</small>
    </footer>



    <div class="main-content content-after-header " id="main-content" style="margin-top:-30px">
        <br>

        <center> <h4> RAPPORT DE CAISSE N<sup>o</sup> {{ $classement->numero_groupe }}  </h4></center>
        <table class="table table-bordered table-striped table-sm fs--1 mb-0" id="mytable">
        <tr>
            <td>Compte caisse : {{ $classement->codes }}: {{ $classement->libelles }}</td>
            <td>Numéro de classement : {{ $classement->numero_groupe }}</td>
            <td> Mois: {{ date('m/Y', strtotime($classement->moianne))  }} </td>
        </tr>
    </table>

    <table class="table table-bordered table-striped table-sm fs--1 mb-0" id="mytable">
        <thead>
            <tr>
                <th>Date</th>
                <th><center>N<sup>o</sup> Bon</center></th>
                <th>Libellé</th>
                <th><center>Imput</center></th>
                <th><center>Débit</center></th>
                <th><center>Crédit</center></th>
                <th><center>Solde</center></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td style="width:10%">{{ $item->date }}</td>
                <td style="width:8%"><center>{{ $item->numerobon ?? '-' }}</center></td>
                <td style="width:30%">{{ ucfirst($item->description) }}</td>
                <td style="width:6%"><center>{{ $item->input ?? '-' }}</center></td>
                <td style="text-align:right;">{{ number_format($item->debit, 0, ',', ' ') }}</td>
                <td style="text-align:right;">{{ number_format($item->credit, 0, ',', ' ') }}</td>
                <td style="text-align:right;">{{ number_format($item->solde, 0, ',', ' ') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br>


    <br>

    <table style="width:80% ; margin:auto" id="signature">
        <tr>
            <td class="signature">
                <center>
                    Etabli par: <br>
                    {{ $verifie_par->nom }} {{ $verifie_par->prenom }}<br>
                    @if($verifie_par && $classement->verifier_signature == 1)
                    <br>
                    <img src="{{  asset($verifie_par->signature) }}" width="150px" alt="Signature" />  
                    @endif
                    <br>
                    Le {{ date('d-m-Y', strtotime($classement->le_etablie))  }}
                </center>
              
            </td>
            <td class="signature">
                <center>
                Vérifié par: <br>
                {{ $approuver_par->nom }} {{ $approuver_par->prenom }}<br>
                @if($approuver_par && $classement->approver_signature == 1)
                <img src="{{ asset($approuver_par->signature) }}" width="150px" alt="Signature" />  
                @endif
                <br>
                Le {{ date('d-m-Y', strtotime($classement->le_verifier))  }}

                </center>
              
            </td>
        </tr>
    </table>

    <br> <br>

  <!--  <center>
        <p>Fait à {{ $classement->fait_a }}, le {{ date('d-m-Y', strtotime($classement->le)) }}</p>
    </center>  -->

    </div>

</body>

</html>