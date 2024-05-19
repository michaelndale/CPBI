<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FICHE D’EXPRESSION DES BESOINS (FEB) N° {{ $datafeb->numerofeb }}</title>
    <style>
        /* Styles pour l'en-tête de la première page */
        header.first-page-header {
            background-color: white;
            /* Couleur d'arrière-plan */
            padding: 10px;
            /* Espacement intérieur */
            text-align: center;
            position: absolute;
            width: 100%;
            top: 100px;
            /* Ajustez la position en haut de la page selon vos besoins */
        }

        /* Styles pour l'en-tête à partir de la deuxième page */
        header:not(.first-page-header) {
            display: none;
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
            margin-top: -70px;
            /* Réduisez la marge supérieure selon vos besoins */
            margin-bottom: 20px;
            /* Réduisez la marge inférieure selon vos besoins */
        }

        /* ici c'est bon Ajout de marge en haut pour compenser la hauteur de l'en-tête */
        .content-after-header {
            padding-top: 50px;
        }

        /* Ajout de marge en bas pour compenser la hauteur du pied de page */
        .content-before-footer {
            padding-bottom: 0;
        }

        #mytable {
            width: 100%;
            border-collapse: collapse;
        }

        #mytable th,
        #mytable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
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
        body {
    font-size: 80%; /* taille de police de base */
}

h1 {
    font-size: 2em; /* taille de la police pour les titres */
}

p {
    font-size: 1em; /* taille de la police pour les paragraphes */
}

.small-text {
    font-size: 0.8em; /* taille de la police pour les textes de petite taille */
}
/* Exemple de CSS */
body {
    font-family: 'Roboto', sans-serif; /* Utilisation d'une police web légère */
}

h1, h2, h3 {
    font-family: 'Open Sans', sans-serif; /* Utilisation d'une autre police web légère pour les titres */
}
    </style>
</head>

<body>
    <!-- En-tête fixe -->
    <header id="page-header">
        <table style="width:100%; margin-top:-40px">
            <tr>
                <td>
                    <center>
                        <img src="element/logo/logo.png" alt="logo" height="80px" />
                    </center>

                </td>
                <td>
                    <h1>
                        {{ $infoglo->entete }}
                    </h1>
                </td>
            </tr>

            <tr>
                <td colspan="2">

                    <center>
                        <hr style="border-width: 1px;">
                        {{ $infoglo->sousentete }}
                    </center>
                </td>
            </tr>
        </table>
    </header>

    <!-- Pied de page fixe -->
    <footer id="page-footer">
        <small>{{ $infoglo->piedpage }}</small>
    </footer>

    <div class="main-content content-after-header " id="main-content">
        <H3>
            <center> FICHE D’EXPRESSION DES BESOINS (FEB) N° {{ $datafeb->numerofeb }} </center>
        </H3>

        <table style=" width:100%" class="table table-sm m-0" id="mytable">
            <tr>
                <td style="width:50%">
                    Composante/ Projet/Section: {{ $datafeb->libelleA }}
                </td>
                <td>
                    Période: {{ $datafeb->periode }} ; Date : {{ date('d-m-Y', strtotime($datafeb->datefeb))  }} ;
                     @if (isset($onebeneficaire->libelle) && !empty($onebeneficaire->libelle)) 
                        Bénéficiaire : {{ $onebeneficaire->libelle }} 
                     @endif
                </td>
            </tr>

            <tr>
                <td>
                    Activité: {{ $datafeb->descriptionf }}
                </td>
                <td>
                    Ligne budgétaire:
                    {{ $dataLigne->libelle }}
                </td>
            </tr>

            <tr>
                <td>
                    Références :

                    BC : <input type="checkbox" name="bc" id="bc" class="form-check-input" readonly @if ($datafeb->bc==1)
                    checked value="{{ $datafeb->bc }}"
                    @else
                    value="{{ $datafeb->bc }}"
                    @endif /> &nbsp; Facture:

                    <input type="checkbox" name="facture" id="facture" class="form-check-input" readonly @if($datafeb->facture==1)
                    checked value="{{ $datafeb->facture }}"
                    @else
                    value="{{ $datafeb->facture }}"
                    @endif

                    />

                    &nbsp;O.M : <input type="checkbox" name="om" id="om" class="form-check-input" readonly @if($datafeb->om==1)
                    checked value="{{ $datafeb->om }}"
                    @else
                    value="{{ $datafeb->om }}"
                    @endif
                    />
                    &nbsp;FP/Devis : <input type="checkbox" class="form-check-input" readonly @if($datafeb->fpdevis==1)
                    checked value="{{ $datafeb->fpdevis }}"
                    @else
                    value="{{ $datafeb->fpdevis }}"
                    @endif
                    />
                    &nbsp;NEC : <input type="checkbox" class="form-check-input" readonly @if($datafeb->nec==1)
                    checked value="{{ $datafeb->nec }}"
                    @else
                    value="{{ $datafeb->nec }}"
                    @endif />
                </td>
                <td>
                    Taux d’exécution globale du projet: {{ $POURCENTAGE_GLOGALE }}% ; <br> Taux d’exécution de la ligne budgétaire: {{ $sommelignpourcentage }}%
                </td>
            </tr>



        </table>
     <br>
        <font size="15px">Détails sur l’utilisation des fonds demandés :</font>


        <table style=" width:100%" class="table table-sm m-0" id="mytable">
            <thead>
                <tr>
                    <th>N<sup>o</sup></th>
                    <th>Designation de la ligne</th>
                    <th>Description</th>
                    <th>
                        <center>Unité</center>
                    </th>
                    <th>
                        <center>Quantité </center>
                    </th>
                    <th>
                        <center>Frequence </center>
                    </th>
                    <th>
                        <center>Prix Unitaire </center>
                    </th>
                    <th>
                        <center>Prix total </center>
                    </th>
                </tr>
            </thead><!-- end thead -->
            <tbody>
                @php
                $n=1;
               
                @endphp

                @foreach ($datElement as $datelementfebs)
                <tr>
                    <td style="width:5%">{{$n }} </td>
                    <td style="width:40%;">
                        @php
                        $ida = $datelementfebs->libellee;
                        $activite = DB::table('activities')
                        ->Where('id', $ida)
                        ->limit(1)
                        ->first();

                        @endphp
                        {{ ucfirst($activite->titre) }}

                    </td>
                    <td style="width:15%">{{ ucfirst($datelementfebs->libelle_description) }}</td>
                    <td style="width:10%"><center> {{ ucfirst($datelementfebs->unite) }}</center></td>
                    <td style="width:10%">
                        <center> {{ $datelementfebs->quantite }} </center>
                    </td>
                    <td style="width:10%">
                        <center> {{ $datelementfebs->frequence }} </center>
                    </td>
                    <td style="width:15%">
                        <center> {{ number_format($datelementfebs->pu,0, ',', ' ') }} {{ Session::get('devise') }} </center>
                    </td>
                    <td style="width:20%">
                        <center> {{ number_format($datelementfebs->montant,0, ',', ' ') }} {{ Session::get('devise') }} </center>
                    </td>
                </tr>
                @php
                $n++;
                @endphp
                @endforeach
            </tbody>
            <tr style=" background-color: #040895;">
                <td colspan="7"> <font color="white"><b> Total général </b> </font></td>
                    <td><center> <font color="white"><b> {{ number_format($sommefeb,0, ',', ' ') }} {{ Session::get('devise') }} </b></font></center> </h5>
                </td>
              </tr>

        </table>
                                    
                                <table style="width:100%; margin:auto">
                                    <tr>
                                        <td>
                                            <center>
                                                <u>Etablie par (AC/CE/CS)</u> :
                                                <br>
                                                    {{ $etablienom->nom }} {{ $etablienom->prenom }} 
                                              
                                                    @if ($datafeb->acce_signe==1)
                                                     <br>
                                                    <img src="{{ $etablienom->signature }}" width="200px" />
                                                    @endif
                                            </center>
                                            
                                        </td>
                                        <td>
                                        <center>
                                            <u>Vérifiée par (Comptable)</u> : <br>
                                                {{ $comptable_nom->nom }} {{ $comptable_nom->prenom }} <br>
                                            @if ($datafeb->comptable_signe==1)
                                                <img src="{{ $comptable_nom->signature }}" width="200px" />
                                            @endif
                                        </center>
                                       
                                        </td>
                                   
                                        <td colspan="2">
                                            <center>
                                                <u>Approuvée par (Chef de Composante/Projet/Section)</u>:
                                                
                                                <br>  {{ $checcomposant_nom->nom }} {{ $checcomposant_nom->prenom }}<br>

                                                @if ($datafeb->chef_signe==1)
                                                <img src="{{ $checcomposant_nom->signature }}" width="200px" />
                                                @endif

                                            
                                                
                                            </center>

                                        </td>
                                    </tr>
                                </table>
                          
                            

    </div>

    <script>
        // Fonction pour ajuster la marge supérieure du contenu en fonction de la hauteur de l'en-tête
        function adjustContentMargin() {
            var headerHeight = document.getElementById('page-header').offsetHeight;
            document.getElementById('main-content').style.marginTop = headerHeight + 'px';
        }

        // Appeler la fonction lors du chargement de la page
        window.onload = adjustContentMargin;

        // Appeler la fonction lors du redimensionnement de la fenêtre
        window.onresize = adjustContentMargin;

        // Fonction pour masquer l'en-tête sur les pages suivantes lors de l'impression
        function hideHeaderOnSubsequentPages() {
            var header = document.getElementById('page-header');
            var originalDisplayStyle = header.style.display;

            // Masquer l'en-tête pour l'impression
            header.style.display = 'none';

            // Réafficher l'en-tête après l'impression
            setTimeout(function() {
                header.style.display = originalDisplayStyle;
            }, 1000);
        }

        // Écouter l'événement avant l'impression
        window.onbeforeprint = hideHeaderOnSubsequentPages;
    </script>

    
</body>

</html>