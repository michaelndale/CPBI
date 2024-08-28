<!DOCTYPE html>
<html lang="fr">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FICHE D’EXPRESSION DES BESOINS (FEB) N° {{ $datafeb->numero }}</title>
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

        body {
            font-size: 85%;
            /* taille de police de base */
        }

        h1 {
            font-size: 2em;
            /* taille de la police pour les titres */
        }

        p {
            font-size: 1em;
            /* taille de la police pour les paragraphes */
        }

        .small-text {
            font-size: 0.5em;
            /* taille de la police pour les textes de petite taille */
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
    </style>
</head>
</head>

<body>
    <!-- En-tête fixe -->
    <header id="page-header">
    <table style="width:90%; margin-top:-35px; " align="center">
                <tr>
                    <td  style="width:6%"align="right">
                        <img src="element/logo/logo.png" alt="logo" height="40px" />
                    </td>
                    <td align ="center">
                        <font size="25px">{{ $infoglo->entete }}</font>
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
            <center> FICHE D’EXPRESSION DES BESOINS (FEB) : N° {{ $datafeb->numero }} </center>
        </H3>

        
       
    </div>

</body>

</html>