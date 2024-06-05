<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'Autorisation de Paiement (DAP) N° {{ $datadap->numerodp }}</title>
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

<body>
    <!-- En-tête fixe -->
    <header id="page-header">
        <div style="display: flex; justify-content: center;">
     
            <table style="width:100%; margin-top:-40px; ">
                <tr>
                    <td  style="width:6%">
                        <img src="element/logo/logo.png" alt="logo" height="40px" />
                    </td>
                    <td>
                        <font size="29px">{{ $infoglo->entete }}</font>
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
        
       
        </div>

    </header>

    <!-- Pied de page fixe -->
    <footer id="page-footer">
        <small>{{ $infoglo->piedpage }}</small>
    </footer>

    <div class="main-content content-after-header " id="main-content">
        <H3>
            <center> Demande d'Autorisation de Paiement (DAP) N° {{ $datadap->numerodp }}/{{ date('Y')}} </center>
        </H3>
        <div class="col-sm-12">
            <table style=" width:100%" class="table table-striped table-sm fs--1 mb-0" id="mytable">
                <tr>
                    <td style="width:50%"> Service: {{ $datadap->titres }}</td>
                    <td>
                        Référence: FEB n<sup>o</sup>:
                        @php
                        foreach ($datafebElement as $key => $datafebElements) {
                        echo '['.$datafebElements->numerofeb.']';

                        if ($key < count($datafebElement) - 1) { echo ',' ; } } @endphp </td>
                </tr>
                <tr>
                    <td> Composante/ Projet/Section: {{ $datadap->projettitle }}</td>
                    <td> Lieu: {{ $datadap->lieu }} </td>
                </tr>

                <tr>
                    <td>Taux execution globale du projet: {{ $pourcetage_globale }}%  </td>
                    <td> Compte bancaire(BQ) : {{ $datadap->comptabiliteb }} ; Banque : {{ $datadap->banque }}</td>
                </tr>

                <tr>
                    <td>Créé par : {{ ucfirst($etablienom->nom) }} {{ ucfirst($etablienom->prenom) }} </td>
                    <td>Relicat budgetaire :{{ number_format($relicat, 0, ',', ' ') . ' ' }} {{ $devise }} </td>
                </tr>

             
                <tr style="margin:0px; padding:0px; border:0px; background-color:white">
                    <td >
                        <table>
                            <td style="margin:0px; padding:0px; border:0px; background-color:white; width:28%">
                                 <label title="OV"> &nbsp; Moyen de Paiement : OV </label> </td>
                            <td style="margin:0px; padding:0px; border:0px; background-color:white; width:5%">
                                <input type="checkbox"  readonly @if($datadap->ov==1) checked  @else  @endif />
                            </td>
                            <td style="margin:0px; padding:0px; border:0px; background-color:white"> &nbsp; &nbsp; &nbsp; &nbsp; Cheque: {{ $datadap->cho }}</td>
                            <td style="margin:0px; padding:0px; border:0px; background-color:white">&nbsp; &nbsp; &nbsp; &nbsp; Etabli au nom : {{ $datadap->	paretablie }}</td>
                        </table>
                    </td>
                    <td>  Devise : {{ $devise }} </td>
                </tr>
            </table>

            <h5> <u>Synthese sur l'utilisation dea fonds demandes(Vr details sur FB en avance)</u></h5>
            <table style=" width:100%" class="table table-striped table-sm fs--1 mb-0" id="mytable">
                <thead>
                    <tr>
                        <th width="13%">Numéro du FEB </th>
                        <th width="60%">Activité </th>
                        <th>Montant total </th>
                        <th> <center>T.E / L & S.L</center> </th>
                    </tr>
                </thead><!-- end thead -->
                <tbody>
                @php
                                    $totoglobale = 0; // Initialiser le total global à zéro
                                    $pourcentage_total = 0; // Initialiser le pourcentage total à zéro

                                    @endphp
                                    @foreach ($datafebElement as $datafebElements)
                                    @php

                                    $totoSUM = DB::table('elementfebs')
                                    ->orderBy('id', 'DESC')
                                    ->where('febid', $datafebElements->fid)
                                    ->sum('montant');

                                    $somme_ligne_principale = DB::table('rallongebudgets')
                                    ->where('compteid', $datafebElements->ligne_bugdetaire)
                                    ->sum('budgetactuel');

                                    $sommelign = DB::table('elementfebs')
                                    ->where('grandligne',  $datafebElements->ligne_bugdetaire)
                                    ->sum('montant');

                                    $sommelignpourcentage = round(($sommelign * 100) /  $somme_ligne_principale, 2);


                                    $totoglobale += $totoSUM;
                                    $pourcentage = round(($totoSUM * 100) / $budget, 2);
                                    // Ajouter le pourcentage de cette itération au pourcentage total
                                    $pourcentage_total += $pourcentage;

                                    @endphp
                    <tr>
                        <td>{{ $datafebElements->numerofeb }}</td>
                        <td>{{ $datafebElements->descriptionf }}</td>

                        <td align="right">
                            @php
                            $totoSUM = DB::table('elementfebs')
                            ->orderBy('id', 'DESC')
                            ->where('febid', $datafebElements->fid)
                            ->sum('montant');
                            @endphp
                            {{ number_format($totoSUM, 0, ',', ' ')  }}

                        </td>
                        <td align="center">{{ $sommelignpourcentage }} % </td>
                    </tr>
                    @endforeach
                    <tr style=" background-color: #040895;">
                        <td style="color:white" colspan="2" align="center"> Total général </td>
                        <td align="right" style="color:white"> {{ number_format($totoglobale, 0, ',', ' ')  }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <br>


            <table class="table table-striped table-sm fs--1 mb-0" id="mytable">

                <tr>
                    <td colspan="3"><b> Vérification et Approbation de la Demande de paiement </b></td>

                </tr>
                <tr>
                    <td> <b> Demande établie par</b>
                        <small>(Chef de Composante/Projet/Section) : {{ ucfirst($Demandeetablie->nom) }} {{ ucfirst($Demandeetablie->prenom) }} </small>
                        @if ($datadap->demandeetablie_signe==1) <br>
                        <center> <img src="{{  $Demandeetablie->signature }}" width="100px" /> <br>
                            {{ date('d-m-Y', strtotime($datadap->demandeetablie_signe_date)) }}
                        </center>
                        @endif 
                    </td>

                    <td> <b> Vérifiée par </b>
                        <small>(Chef Comptable) : {{ ucfirst($chefcomptable->nom) }} {{ ucfirst($chefcomptable->prenom) }} </small>
                        @if ($datadap->verifierpar_signe==1) <br>
                        <center>
                            <img src="{{  $chefcomptable->signature }}" width="100px" />
                            <br>
                            {{ date('d-m-Y', strtotime($datadap->verifierpar_signe_date)) }}
                        </center>

                        @endif 
                         
                    </td>


                    <td> <b> Approuvée par </b>
                        <small>(Chef de Service) :
                            {{ ucfirst($chefservice->nom) }} {{ ucfirst($chefservice->prenom) }} <br>
                            @if ($datadap->approuverpar_signe==1)
                            <center> <img src="{{  $chefservice->signature }}" width="100px" /><br>
                                {{ date('d-m-Y', strtotime($datadap->approuverpar_signe_date)) }}
                                @endif
                            </center>
                    </td>


                </tr>


            </table>


            <table class="table table-striped table-sm fs--1 mb-0" id="mytable">

                <tr>
                    <td colspan="2"> <b> Autorisaction de paiement</b> </td>
                    <td> Autorisé le {{ $datadap->dateautorisation }}</td>

                </tr>

                </tr>

                <tr>

                    <td>
                        Responsable Administratif et Financier :


                        {{ ucfirst($responsable->nom) }} {{ ucfirst($responsable->prenom) }} <br>
                        @if ($datadap->responsable_signe==1)
                        <center>
                            <img src="{{ $responsable->signature }}" width="100px" />
                        </center>
                        @endif

                    </td>
                    <td>
                        Chef des Programmes : {{ ucfirst($chefprogramme->nom) }} {{ ucfirst($chefprogramme->prenom) }} <br>
                        @if ($datadap->chefprogramme_signe==1)
                        <br>
                        <center>
                            <img src="{{ $chefprogramme->signature }}" width="100px" />
                        </center>
                        @endif

                    </td>
                    <td>
                        Secrétaire Général de la CEPBU : {{ ucfirst($secretaire->nom) }} {{ ucfirst($secretaire->prenom) }} <br>
                        @if ($datadap->secretaure_general_signe==1)
                        <center>
                            <img src="{{ $secretaire->signature }}" width="100px" />
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