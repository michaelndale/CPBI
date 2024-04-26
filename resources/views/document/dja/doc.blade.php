<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande et Justification d'Avance "DJA"</title>
    <style>
        /* Styles pour l'en-tête de la première page */
        header.first-page-header {
            background-color: white;
            /* Couleur d'arrière-plan */
            padding: 10px;
            /* Espacement intérieur */
            text-align: center;
            position: fixed;
            width: 100%;
            top: -100px;
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
    </style>
</head>

<body>
    <!-- En-tête fixe -->
    <header id="page-header">
        <table style="width:100%">
            <tr>
                <td>
                    <center>
                        <img src="element/logo/logo.png" alt="logo" height="80px" />
                    </center>

                </td>
                <td>
                    <h2>
                        {{ $infoglo->entete }}
                    </h2>
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
    <div class="card-body">
              
                <hr class="my-4">
                <div class="row">
                    <H4>
                        <center> DEMANDE DE JUSTIFICATION D'AVANCE  (DJA)  N° {{ $Jsondja->numerodjas }} </center>
                    </H4>
                    <div class="col-sm-12">
                        <table style=" width:100%" class="table table-sm m-0" id="mytable">
                            <tr>
                                <td style="width:50%"> Présumé Bénéficiaire/Fournisseur/Prestataire à payer:  Commerciale <br>
                                {{ $Jsondja->beneficiaire }}
                            </td>
                            <td style="width:50%" >  Les fonds devront être reçus le :{{ $Jsondja->datefondrecu }}</td>
                                
                            </tr>
                            <tr>
                            <td style="width:50%">
                                Adresse:  {{ $Jsondja->adresse }}  <br>
                                Téléphone1: {{ $Jsondja->tel }}   Téléphone2: {{ $Jsondja->teld }} <br>
                                Description/Motif : {{ $Jsondja->description }}

                                </td>
                                
                                <td style="width:50%">
                                 Référence (s) : FEB Nº {{ $Jsondja->numerofeb }} ; DAP Nº {{ $Jsondja->numerodap }} ;  OV/CHQ Nº {{ $Jsondja->numeroov }}  <br>
                                 Ligne budgétaire:  {{ $Jsondja->lignebdt }} <br>
                                 Montant de l'avance  : {{ $Jsondja->montant_avance }} <br>

                                 Dévise (BIF ou USD): {{ $Jsondja->devise}} <br>
                                 Durée de l’avance:   {{ $Jsondja->duree_avence }}    jours <br>
                                 </td>
                            </tr>
                        </table>


                       

                        <table style=" width:100%" class="table table-sm m-0" id="mytable">
                            <tr>
                                <td colspan="4"> Demande/Approbation</td>
                            </tr>

                            <tr>
                                <td style="width:40%">Fonds demandes par :   <br>
                                    Noms: 
                                </td>
                               
                                <td style="width:15%"><br>Signature</td>
                                <td></td>
                                <td style="width:15%"><br>Date</td>
                            </tr>

                            <tr>
                                <td>
                                    Avance Approuvee par (2 personnes au moins): <br>
                                    Noms: 
                                
                                </td>
                                
                                <td><br>Signature</td>
                                <td>
                                    <br>Chef Comptable(Si A< 500 000 Fbu)
                                </td>
                                <td><br>Date</td>
                            </tr>

                            <tr>
                                <td> <br>
                                Noms: </td>
                               
                                <td><br>Signature</td>
                                <td><br>RAF (Si A < 1000 000Fbu)</td>
                                <td><br>Date</td>
                            </tr>

                            <tr>
                                <td> <br>
                                Noms: </td>
                                <td><br>Signature</td>
                                <td><br>SG ou SGA (Si A > 1000 000Fbu)</td>
                                <td><br>Date</td>
                            </tr>
                            <tr>
                                <td>
                                    Fonds swbourses par <br>
                                    Noms: 
                                
                                </td>
                                
                                <td><br>Signature</td>
                                <td>
                                    <br>Chef Comptable(Si A< 500 000 Fbu)
                                </td>
                                <td><br>Date</td>
                            </tr>

                            <tr>
                                <td>
                                    Fonds recus par: <br>
                                    Noms: 
                                
                                </td>
                                
                                <td><br>Signature</td>
                                <td>
                                    <br>
                                </td>
                                <td><br>Date</td>
                            </tr>


                        </table>

                        <table style=" width:100%" class="table table-sm m-0" id="mytable">
                            <tr>
                                <td colspan="2">Autorisation de Paiement</td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">Autorise le ....../...../....</td>
                            </tr>
                            <tr>
                                <td>Responsable Administratif et Financier</td>
                                <td>Chef des Programmes</td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">Secretaire General de la CEPBU</td>
                            </tr>
                            <tr>
                                <td colspan="2" >Observation/Instructions du SG</td>
                            </tr>

                            <tr>
                                <td colspan="2" ><small>FEB: Fiche d'Expression des Besoins , preparee par l'assistant de composante(Ac) ou charge d'execution (CE) ou Chef de Session (CS) ou assimilee      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BQ.Banque </small> </td>
                            </tr>
                        </table>

                            <H5> Rapport d'utilisation de l' Avance </H5>
                        <table style=" width:100%" class="table table-sm m-0" id="mytable">
                            <td>
                                Fonds payés à :  {{ $Jsondja->fondresu }}  <br><br>
                                Addresse: <br> <br>

                                Tel1 :  {{ $Jsondja->tel }} Tel2:   {{ $Jsondja->teld }}<br> <br>

                                DESCRIPTION/MOTIF:  {{ $Jsondja->description }} <br><br>
                            </td>
                        </table >
                        <hr>
                        <table style=" width:100%" class="table table-sm m-0" id="mytable">
                            <td>Montant de l'Avance  {{ $Jsondja->avance_approuver }} <br> <br>

                            Montant utilisé* ..................... *Même Montant pour pièces justificatives <br><br>
 
                            Surplus/Manque* ....................... *Si le montant n'a pas été suffisant, préparez un formulaire de demande de remboursement et le soumettre pour  approbation avec  les pièces justificatives. <br>

                            Montant retourné à la caisse ou au compte(Si Surplus) ...............
                        </td> 
                        </table>

                        <table style=" width:100%" class="table table-sm m-0" id="mytable">
                            <tr>
                            <td colspan="3">Réception des fonds retournés à la caisse par:                        (ou Borderau de versement nº___________________________du _______/_____/20_____) </td>
                            </tr>
                           <tr>
                           <td> Noms de la Caissière :  </td>
                            <td>Signature</td>
                            <td>Date</td>
                           </tr>
                            
                        </table>


                        <table style=" width:100%" class="table table-sm m-0" id="mytable">
                            <tr>
                            <td colspan="3">Réception des pièces justificatives de l'utilisation de l'avance par: </td>
                            </tr>
                           <tr>
                           <td> Noms :  </td>
                            <td>Signature</td>
                            <td>Date</td>
                           </tr>
                            
                        </table>

                        <p>
                            <small> Pour les Limites d'approbation des Avances, les montants  repris sur cette fiche ne sont que des exemples.     

                            <br>    FEB = Fiche d'Expression des Besoins                       DAP=Demande d'Autorisation de Paiement             OV/CHQ=Ordre de Virement ou Chèque       
                            </small> 
                        </p>
                        
                    </div>
                   
                </div>
            </div>

    </div>