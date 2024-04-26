<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande et d'Autorisation de Paiement (DAP) N° {{ $datadap->numerodap }}</title>
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
            font-size: 80%;
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
            font-size: 0.8em;
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
            <center> Demande et Autorisation de Paiement (DAP) N° {{ $datadap->numerodap }} </center>
        </H3>
        <table style=" width:100%" class="table table-sm m-0" id="mytable">
            <tr>
                <td style="width:50%">
                    Service: {{ $datadap->titres }} <br>
                    Composante/ Projet/Section: {{ ucfirst(Session::get('title')) }} <br>
                    Activite: {{ $datadap->descriptionf }} <br>
                    Etablie par : {{ ucfirst($etablienom->nom) }} {{ ucfirst($etablienom->prenom) }} <br>
                    <!-- Ligne budgetaire <br> -->
                    Taux d'execution globale du projet {{ $pourcentage_global_b }} % <br>
                </td>

                <td> Reference: FEB N<sup>o</sup> {{ $datadap->numerofeb }} ; <br>
                   
                    Compte bancaire(BQ) : {{ $datadap->comptable }} <br>
                    Solde comptable BQ: {{ number_format($solder_dap, 0, ',', ' ') }} {{ Session::get('devise') }} <br>




                    Lieu: {{ $datadap->lieu }} <br>

                    OV nº <input type="checkbox" class="form-check-input" name="ov" id="ov" @if($datadap->ov==1)
                    checked value="{{ $datadap->ov }}"
                    @else
                    value="{{ $datadap->ov }}"
                    @endif
                    />

                    CHQ nº
                    <input type="checkbox" class="form-check-input" name="ch" id="ch" @if( $datadap->cho==1)
                    checked value="{{ $datadap->cho }}"
                    @else
                    value="{{ $datadap->cho }}"
                    @endif
                    />

                </td>
            </tr>

        </table>


        <table class="table table-sm m-0" id="mytable">
            <tr>
                <td colspan="3"> Ligne bugetaire : <b> {{ $datafeb->libelle }}</b> </td>
            </tr>
            <tr>
                <td> Etablie par : {{ ucfirst($etablienom->nom) }} {{ ucfirst($etablienom->prenom) }}</td>
                <td> Activité : {{ $datafeb->descriptionf }}</td>
                <td> Montant globale feb : {{ $sommefebs }}</td>
            </tr>
        </table>


        <table class="table table-sm m-0" id="mytable">

            <tr>
                <td colspan="3"><b> Vérification et Approbation de la Demande de paiement </b></td>

            </tr>
            <tr>
                <td> <b> Demande établie par</b> <br>
                    <small> Chef de Composante/Projet/Section : {{ ucfirst($Demandeetablie->nom) }} {{ ucfirst($Demandeetablie->prenom) }} </small> 
                        @if ($datadap->demandeetablie_signe==1) <br>
                       <center> <img src="{{  $Demandeetablie->signature }}" width="120px" /> <br>
                        {{ date('d-m-Y', strtotime($datadap->demandeetablie_signe_date)) }}
                        </center> 
                        @endif 
                </td>

                <td> <b> Vérifiée par :</b> <br>
                    <small> Chef Comptable : {{ ucfirst($chefcomptable->nom) }} {{ ucfirst($chefcomptable->prenom) }} </small>
                    @if ($datadap->verifierpar_signe==1) <br>
                    <center>
                        <img src="{{  $chefcomptable->signature }}" width="120px" />
                        <br>
                        {{ date('d-m-Y', strtotime($datadap->verifierpar_signe_date)) }}
                        </center> 

                        @endif 
                     
                </td>


                <td> <b> Approuvée par : </b> <br>
                    <small>Chef de Service :
                        {{ ucfirst($chefservice->nom) }} {{ ucfirst($chefservice->prenom) }} <br>
                        @if ($datadap->approuverpar_signe==1)
                       <center> <img src="{{  $chefservice->signature }}" width="120px" /><br>
                        {{ date('d-m-Y', strtotime($datadap->approuverpar_signe_date)) }}
                        @endif
                        </center>
                </td>


            </tr>


        </table>


        <table class="table table-sm m-0" id="mytable">

            <tr>
                <td colspan="3"><b> Autorisaction de paiement</b>  Autorisé le   {{ $datadap->dateautorisation }}</td>

            </tr>

            </tr>

            <tr>
               
                <td >
                    Responsable Administratif et Financier :


                    {{ ucfirst($responsable->nom) }} {{ ucfirst($responsable->prenom) }} <br>
                    @if ($datadap->responsable_signe==1)
                    <center>
                    <img src="{{ $responsable->signature }}" width="120px" />
                    </center>
                    @endif

                </td>
                <td>
                    Secrétaire Général de la CEPBU : {{ ucfirst($secretaire->nom) }} {{ ucfirst($secretaire->prenom) }} <br>
                    <center>
                    <img src="{{ $secretaire->signature }}" width="120px" />
                    </center>


                </td>


                <td>
                    Chef des Programmes {{ ucfirst($chefprogramme->nom) }} {{ ucfirst($chefprogramme->prenom) }} <br>
                    @if ($datadap->chefprogramme_signe==1)
                    <br> <center>
                    <img src="{{ $chefprogramme->signature }}" width="120px" />
                    </center>
                    @endif

                </td>
            </tr>


            <tr>
                <td colspan="4"><b>Observations/Instructions du SG : </b> <br>
                    {{ $datadap->observation }}
                </td>
            </tr>
        </table>