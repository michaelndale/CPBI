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
        
       
        </div>

    </header>

    <!-- Pied de page fixe -->
    <footer id="page-footer">
        <small>{{ $infoglo->piedpage }}</small>
    </footer>

    <div class="main-content content-after-header " id="main-content">
        <H3>
            <center> Demande d'Autorisation de Paiement (DAP) N° {{ $datadap->numerodp }}</center>
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
                    <td> 
                    <table style="margin:0px; padding:0px;">
                            <td style="margin:0px; padding:0px; border:0px; background-color:white; width:28%">
                                 <label title="OV"> &nbsp; Moyen de Paiement : OV </label> </td>
                            <td style="margin:0px; padding:0px; border:0px; background-color:white; width:10%">
                                <input type="checkbox" class="form-check-input"   @if($datadap->ov==1) checked  @else  @endif />
                            </td>
                            <td style="margin:0px; padding:0px; border:0px; background-color:white"> &nbsp; &nbsp; &nbsp; &nbsp; Cheque: {{ $datadap->cho }}</td>
                            <td style="margin:0px; padding:0px; border:0px; background-color:white">&nbsp; &nbsp; &nbsp; &nbsp; Etabli au nom : {{ $datadap->	paretablie }}</td>
                        </table>
                    </td>
                    <td> Compte bancaire: {{ $datadap->comptabiliteb }} ; Banque : {{ $datadap->banque }}</td>
                </tr>

                <tr>
                    <td>Créé par : {{ ucfirst($etablienom->nom) }} {{ ucfirst($etablienom->prenom) }} </td>
                    <td> Budgét initial  : {{ number_format($budget, 0, ',', ' ') . ' ' }} {{ $devise }}  | Relicat budgetaire :{{ number_format($relicat, 0, ',', ' ') . ' ' }} {{ $devise }} </td>
                </tr>

             
                <tr style="margin:0px; padding:0px; border:0px; background-color:white">
                    <td >
                    Créé le {{ date('d-m-Y', strtotime($datadap->created_at))  }}
                    </td>
                    <td> Taux d’exécution global du projet: {{ $pourcetage_globale }}%  </td>
                </tr>
            </table>

            <font size="12px"> <u>Synthese sur l'utilisation de fonds demandes(Vr details sur FB en annexe)</u></font>
            <table style=" width:100%" class="table table-striped table-sm fs--1 mb-0" id="mytable">
                <thead>
                    <tr>
                        <th width="13%">Numéro du FEB </th>
                        <th width="60%">Activité </th>
                        <th>  <center>Montant total  </center> </th>
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
                                    ->where('numero', '<=', $datafebElements->numerofeb)
                                    
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

                        <td style="text-align: right;">
                        
                            @php
                            $totoSUM = DB::table('elementfebs')
                            ->orderBy('id', 'DESC')
                            ->where('febid', $datafebElements->fid)
                            ->sum('montant');
                            @endphp
                            {{ number_format($totoSUM, 0, ',', ' ')  }}
                       
                        </td>
                        <td style="text-align: center;">{{ $sommelignpourcentage }} % </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td  colspan="2" style="text-align: center;"><b> Total général </b>  </td>
                        <td style="text-align: right;"><b>{{ number_format($totoglobale, 0, ',', ' ')  }} </b>  </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

          

            @if($datadap->justifier==1)
                           

                            <u>Synthese sur les avances </u>
                            <table style=" width:100%" class="table table-striped table-sm fs--1 mb-0" id="mytable">
                                <tr>
                                    <td colspan="4"> Ce montant est-il une avance ? 
                                                    &nbsp; &nbsp; &nbsp; Oui <input type="checkbox" class="form-check-input" @if($datadap->justifier==1) checked  @endif > 
                                                    &nbsp; &nbsp; &nbsp; Non <input type="checkbox" class="form-check-input" @if($datadap->justifier==0) checked  @endif ></td>
                                </tr>
                                @foreach ($datafebElement as $datafebElements)
                                    
                              
                                <tr>
                                    <td> Numéro FEB : {{ $datafebElements->numerofeb }} </td>
                                    <td> Montant de l'Avance : {{ number_format($datafebElements->montantavance, 0, ',', ' ');  }} </td>
                                    <td> Durée avance : {{ $datafebElements->duree_avance }}   Jours</td>
                                    <td> Description : {{ $datafebElements->descriptionn }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4"> Fonds reçus par : {{ ucfirst($fond_reussi->nom) }}  {{ ucfirst($fond_reussi->prenom) }} </td>
                                </tr>
                            </table>

                            @endif

                            <br>


            <table class="table table-striped table-sm fs--1 mb-0" id="mytable">

                <tr>
                    <td colspan="3"><b> Vérification et Approbation de la Demande de paiement </b></td>
                </tr>
                <tr>
                    <td> <b> Demande établie par</b>
                        <small>(Chef de Composante/Projet/Section) : {{ ucfirst($Demandeetablie->nom) }} {{ ucfirst($Demandeetablie->prenom) }} </small>
                    </td>

                    <td> <b> Vérifiée par </b>
                        <small>(Chef Comptable) : {{ ucfirst($chefcomptable->nom) }} {{ ucfirst($chefcomptable->prenom) }} </small>
                    </td>


                    <td> <b> Approuvée par </b>
                        <small>(Chef de Service) :
                        {{ ucfirst($chefservice->nom) }} {{ ucfirst($chefservice->prenom) }}
                    </td>


                </tr>
                <tr>
                    <td>
                    @if ($datadap->demandeetablie_signe==1) 
                        <center> <img src="{{  $Demandeetablie->signature }}" width="100px" />
                        {{ $datadap->demandeetablie_signe_date }} 
                        </center>
                        @endif 
                    </td>
                    <td>
                        @if ($datadap->verifierpar_signe==1)
                            <center>
                                <img src="{{  $chefcomptable->signature }}" width="100px" />
                                <br>
                            {{ $datadap->verifierpar_signe_date }} 
                            </center>
                        @endif 

                    </td>
                    <td>
                        @if ($datadap->approuverpar_signe==1)
                            <center> <img src="{{  $chefservice->signature }}" width="100px" />
                                {{  $datadap->approuverpar_signe_date }}
                            </center>
                        @endif
                    </td>
                </tr>


            </table>


            <table class="table table-striped table-sm fs--1 mb-0" id="mytable">

                <tr>
                    <td colspan="2"> <b> Autorisaction de paiement</b> </td>
                    <td> Autorisé le 
                    @if(!empty($datadap->dateautorisation))
                        {{   date('d-m-Y', strtotime($datadap->dateautorisation )) }}
                    @endif
                         </td>
                </tr>
                <tr>
                    <td>
                        Responsable Administratif et Financier :
                        {{ ucfirst($responsable->nom) }} {{ ucfirst($responsable->prenom) }}
                    </td>
                    <td>
                        Chef des Programmes : {{ ucfirst($chefprogramme->nom) }} {{ ucfirst($chefprogramme->prenom) }} 
                    </td>
                    <td>
                        Secrétaire Général de la CEPBU : {{ ucfirst($secretaire->nom) }} {{ ucfirst($secretaire->prenom) }}
                    </td>
                </tr>

                <tr>
                    <td>
                    @if ($datadap->responsable_signe==1)
                        <center>
                            <img src="{{ $responsable->signature }}" width="100px" />
                        </center>
                        @endif
                    </td>
                    <td>
                    @if ($datadap->chefprogramme_signe==1)
                        <center>
                            <img src="{{ $chefprogramme->signature }}" width="100px"/>
                        </center>
                        @endif
                    </td>
                    <td>
                    @if ($datadap->secretaure_general_signe==1)
                        <center>
                            <img src="{{ $secretaire->signature }}" width="100px" />
                        </center>
                        @endif
                    </td>
                </tr>


                <tr>
                    <td colspan="3"><b>Observations/Instructions du SG : </b> <br>
                        {{ $datadap->observation }}
                    </td>
                </tr>
            </table>