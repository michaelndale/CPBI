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
            padding: 10px;
            text-align: center;
            position: absolute;
            width: 100%;
            top: 100px;
        }

        /* Styles pour l'en-tête à partir de la deuxième page */
        header:not(.first-page-header) {
            display: none;
        }

        /* Styles pour le pied de page */
        footer {
            background-color: white;
            padding: 0px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        /* Styles pour le contenu */
        .main-content {
            margin-top: -70px;
            margin-bottom: 20px;
        }

        .content-after-header {
            padding-top: 50px;
        }

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
        }

        h1 {
            font-size: 2em;
        }

        p {
            font-size: 1em;
        }

        .small-text {
            font-size: 0.8em;
        }

        body {
            font-family: 'Roboto', sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: 'Open Sans', sans-serif;
        }
    </style>
</head>

<body>
    <!-- En-tête fixe -->
    <header id="page-header">
        <table class="table table-striped table-sm fs--1 mb-0" style="width:100%; margin-top:-40px">
            <tr>
                <td>
                    <center>
                        <img src="element/logo/logo.png" alt="logo" height="60px" />
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

        <table style=" width:100%" class="table table-striped table-sm fs--1 mb-0" id="mytable">
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
                <td style="margin:0px;padding:0px;"> 
                    <table style="margin:0px;padding:0px; border:0px; background-color:white">
                        <tr style="margin:0px;padding:0px; border:0px; background-color:white">
                            <td style="margin:0px;padding:0px; border:0px; background-color:white"> <label title="Bon de commande"> &nbsp; BC:</label> </td>
                            <td style="margin:0px;padding:0px; border:0px; background-color:white">
                                <input type="checkbox" class="form-check-input" readonly @if ($datafeb->bc==1)
                                checked value="{{ $datafeb->bc }}"
                                @else
                                value="{{ $datafeb->bc }}"
                                @endif />
                            </td>
                            <td style="margin:0px;padding:0px; border:0px; background-color:white"><label>&nbsp; Facture:</label></td>
                            <td style="margin:0px;padding:0px; border:0px; background-color:white">
                                <input type="checkbox" class="form-check-input" readonly @if($datafeb->facture==1)
                                checked value="{{ $datafeb->facture }}"
                                @else
                                value="{{ $datafeb->facture }}"
                                @endif
                                />
                            </td>
                            <td style="margin:0px;padding:0px; border:0px; background-color:white"> <label title="Bon de commande">&nbsp; O.M: </label> </td>
                            <td style="margin:0px;padding:0px; border:0px; background-color:white">
                                <input type="checkbox" name="om" id="om" class="form-check-input" readonly @if($datafeb->om==1)
                                checked value="{{ $datafeb->om }}"
                                @else
                                value="{{ $datafeb->om }}"
                                @endif
                                />
                            </td>
                            <td style="margin:0px;padding:0px; border:0px; background-color:white"><label title="Termes de référence"> &nbsp;TDR:</label></td>
                            <td style="margin:0px;padding:0px; border:0px; background-color:white">
                                <input type="checkbox" class="form-check-input" readonly @if($datafeb->nec==1)
                                checked value="{{ $datafeb->nec }}"
                                @else
                                value="{{ $datafeb->nec }}"
                                @endif />
                            </td>

                            <td style="margin:0px;padding:0px; border:0px; background-color:white"> <label title="Facture proforma"> &nbsp;FP/Dévis/Liste: </label> </td>
                            <td style="margin:0px;padding:0px; border:0px; background-color:white">
                                <input type="checkbox" class="form-check-input" readonly @if($datafeb->fpdevis==1)
                                checked value="{{ $datafeb->fpdevis }}"
                                @else
                                value="{{ $datafeb->fpdevis }}"
                                @endif
                                />
                            </td>



                            <td style="margin:0px;padding:0px; border:0px; background-color:white"><label title="Termes de référence"> &nbsp;R.M: </label></td>
                            <td style="margin:0px;padding:0px; border:0px; background-color:white">
                                <input type="checkbox" class="form-check-input" readonly @if($datafeb->rm==1)
                                checked value="{{ $datafeb->rm }}"
                                @else
                                value="{{ $datafeb->rm }}"
                                @endif />

                            </td>
                      

                            <td style="margin:0px;padding:0px; border:0px; background-color:white"> <label title="Termes de Référence"> &nbsp;T.D.R: </label> </td>
                            <td style="margin:0px;padding:0px; border:0px; background-color:white">
                                <input type="checkbox" class="form-check-input" readonly @if($datafeb->tdr==1)
                                checked value="{{ $datafeb->tdr }}"
                                @else
                                value="{{ $datafeb->tdr }}"
                                @endif />

                            </td>

                            </tr>

<tr>

                           

                            <td style="margin:0px;padding:0px; border:0px; background-color:white"> <label title="Bordereau de versement"> &nbsp;B.V:</label> </td>
                            <td style="margin:0px;padding:0px; border:0px; background-color:white"> <input type="checkbox" class="form-check-input" readonly @if($datafeb->bv==1)
                                checked value="{{ $datafeb->bv }}"
                                @else
                                value="{{ $datafeb->bv }}"
                                @endif />
                            </td>
                           
                            <td style="margin:0px;padding:0px; border:0px; background-color:white"> <label title="Reçu">&nbsp; Reçu : </label> </td>
                            <td style="margin:0px;padding:0px; border:0px; background-color:white"><input type="checkbox" class="form-check-input" readonly @if($datafeb->recu==1)
                                checked value="{{ $datafeb->recu }}"
                                @else
                                value="{{ $datafeb->recu }}"
                                @endif /></td>

                            <td style="margin:0px;padding:0px; border:0px; background-color:white"><label title="Accussé de reception"> &nbsp;A.R:</label> </td>
                            <td style="margin:0px;padding:0px; border:0px; background-color:white"><input type="checkbox" class="form-check-input" readonly @if($datafeb->recu==1)
                                checked value="{{ $datafeb->recu }}"
                                @else
                                value="{{ $datafeb->recu }}"
                                @endif /> </td>

                            <td style="margin:0px;padding:0px; border:0px; background-color:white"> <label title="Bordereau d'expédition">&nbsp; B.E:</label> </td>
                            <td style="margin:0px;padding:0px; border:0px; background-color:white"> <input type="checkbox" class="form-check-input" readonly @if($datafeb->be==1)
                                checked value="{{ $datafeb->be }}"
                                @else
                                value="{{ $datafeb->be }}"
                                @endif
                                /></td>

                        </tr>

                    </table>



                </td>




                <td>
                    Taux d’exécution globale du projet: {{ $POURCENTAGE_GLOGALE }}% ; <br> Taux d’exécution de la ligne budgétaire: {{ $sommelignpourcentage }}%
                </td>
            </tr>

        </table>
        <br>
        <font size="15px">Détails sur l’utilisation des fonds demandés :</font>


        <table style=" width:100%" class="table table-striped table-sm fs--1 mb-0" id="mytable">
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
            </thead>
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
                    <td style="width:10%">
                        <center> {{ ucfirst($datelementfebs->unite) }}</center>
                    </td>
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
                <td colspan="7">
                    <font color="white"><b> Total général </b> </font>
                </td>
                <td>
                    <center>
                        <font color="white"><b> {{ number_format($sommefeb,0, ',', ' ') }} {{ Session::get('devise') }} </b></font>
                    </center>
                    </h5>
                </td>
            </tr>
        </table>
        <table style="width:100%; margin:auto" class="table table-striped table-sm fs--1 mb-0">
            <tr>
                <td>
                    <center>
                        <u>Etablie par (AC/CE/CS)</u> :
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
                        <u>Vérifiée par (Comptable)</u> : <br>
                        {{ $comptable_nom->nom }} {{ $comptable_nom->prenom }} <br>
                        @if ($datafeb->comptable_signe==1)
                        <img src="{{ $comptable_nom->signature }}" width="200px" />
                        @endif
                    </center>

                </td>

                <td colspan="2">
                    <center>
                        <u>Approuvée par (Chef de Composante/Projet/Section)</u>:

                        <br> {{ $checcomposant_nom->nom }} {{ $checcomposant_nom->prenom }}<br>

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
        window.onload = adjustContentMargin;
        window.onresize = adjustContentMargin;

        // Fonction pour masquer l'en-tête sur les pages suivantes lors de l'impression
        function hideHeaderOnSubsequentPages() {
            var header = document.getElementById('page-header');
            var originalDisplayStyle = header.style.display;
            header.style.display = 'none';
            setTimeout(function() {
                header.style.display = originalDisplayStyle;
            }, 1000);
        }
        window.onbeforeprint = hideHeaderOnSubsequentPages;
    </script>


</body>

</html>